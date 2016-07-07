<?php

namespace Athens\Core\Admin;

use Athens\Core\Etc\ORMUtils;
use Athens\Core\Etc\StringUtils;
use Athens\Core\Page\PageInterface;
use Athens\Core\Section\SectionBuilder;

use Athens\Core\Etc\ArrayUtils;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Table\TableBuilder;
use Athens\Core\Row\RowBuilder;
use Athens\Core\Row\RowInterface;
use Athens\Core\Form\FormBuilder;
use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Field\Field;
use Athens\Core\Form\FormAction\FormActionInterface;
use Athens\Core\Page\Page;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

/**
 * Class ObjectManager
 *
 * @package Athens\Core\Page
 */
class Admin extends Page
{
    const MODE_TABLE = 'table';
    const MODE_DETAIL = 'detail';
    const MODE_DELETE = 'delete';

    const MODE_FIELD = 'mode';
    const OBJECT_ID_FIELD = 'object_id';
    const QUERY_INDEX_FIELD = 'query_index';

    /** @var ModelCriteria[] */
    protected $queries;

    /** @var  {PageInterface|null}[] */
    protected $detailPages;

    /**
     * Admin constructor.
     *
     * @param string                 $id
     * @param string                 $type
     * @param string[]               $classes
     * @param string                 $title
     * @param string                 $baseHref
     * @param ModelCriteria[]        $queries
     * @param WritableInterface      $writable
     * @param {PageInterface|null}[] $detailPages
     * @throws \Exception If an invalid object manager mode is provided.
     */
    public function __construct(
        $id,
        $type,
        array $classes,
        $title,
        $baseHref,
        array $queries,
        $writable,
        array $detailPages
    ) {

        /** @var string $mode */
        $mode = ArrayUtils::findOrDefault('mode', $_GET, static::MODE_TABLE);

        $this->queries = $queries;
        $this->detailPages = $detailPages;

        switch ($mode) {
            case static::MODE_TABLE:
                $tables = $this->makeTables();

                $sectionBuilder = SectionBuilder::begin()
                    ->setId('admin-tables-container');

                foreach ($tables as $table) {
                    $sectionBuilder->addWritable($table);
                }

                $writable = $sectionBuilder->build();
                $type = static::TYPE_MULTI_PANEL;
                break;
            case static::MODE_DETAIL:
                $writable = $this->makeDetail();
                $type = static::TYPE_AJAX_PAGE;

                $header = "";
                $subHeader = "";
                break;
            case static::MODE_DELETE:
                $writable = $this->makeDelete();
                $type = static::TYPE_AJAX_ACTION;
                break;
            default:
                throw new \Exception(
                    "Invalid object manager mode '$mode' provided in URL parameters."
                );
        }

        parent::__construct(
            $id, $type, $classes, [], $title, $baseHref, $writable
        );
    }

    /**
     * @return integer|null
     */
    public static function getObjectId()
    {
        /** @var string|null $id */
        $id = ArrayUtils::findOrDefault(static::OBJECT_ID_FIELD, $_GET, null);

        return $id === null ? null : (int)$id;
    }

    /**
     * @return integer|null
     */
    protected function getQueryIndex()
    {
        /** @var string|null $id */
        $id = ArrayUtils::findOrDefault(static::QUERY_INDEX_FIELD, $_GET, null);

        return $id === null ? null : (int)$id;
    }

    /**
     * Finds an object with the given id in this ObjectManager's query.
     *
     * @return ActiveRecordInterface
     * @throws \Exception If object can not be found.
     */
    protected function getObjectOr404()
    {
        $objectId = static::getObjectId();

        /** @var boolean $idWasProvided */
        $idWasProvided = $objectId !== null;

        $query = $this->queries[$this->getQueryIndex()];

        if ($idWasProvided === true) {
            $object = $query->findOneById((int)$_GET[static::OBJECT_ID_FIELD]);
        } else {
            $class = $query->getTableMap()->getOMClass(false);
            $object = new $class();
        }

        if ($object === null) {
            http_response_code(404);
            throw new \Exception('Object not found.');
        }

        return $object;

    }

    /**
     * @param ActiveRecordInterface|null $queries
     * @return WritableInterface[]
     */
    protected function makeTables($queries = null)
    {
        /** @var WritableInterface[] $tables */
        $tables = [];
        foreach ($this->queries as $queryIndex => $query) {
            /** @var ActiveRecordInterface[] $objects */
            $objects = $query->find();

            /** @var RowInterface[] $rows */
            $rows = [];

            /** @var string $tableName */
            $tableName = str_replace("_", " ", $query->getTableMap()->getName());

            foreach ($objects as $object) {

                /** @var string $detailurl */
                $detailurl = static::makeUrl(
                    $_SERVER['REQUEST_URI'],
                    [
                        static::MODE_FIELD => static::MODE_DETAIL,
                        static::QUERY_INDEX_FIELD => $queryIndex,
                        static::OBJECT_ID_FIELD => $object->getId()
                    ]
                );

                $rows[] = RowBuilder::begin()
                    ->addObject($object)
                    ->setOnClick(
                        "
                    athens.multi_panel.loadPanel(1, '$detailurl');
                    athens.multi_panel.openPanel(1);
                    "
                    )
                    ->build();
            }

            /** @var string $adderUrl */
            $adderUrl = static::makeUrl(
                $_SERVER['REQUEST_URI'],
                [
                    static::MODE_FIELD => static::MODE_DETAIL,
                    static::QUERY_INDEX_FIELD => $queryIndex,
                ]
            );

            $rows[] = RowBuilder::begin()
                ->addFields([
                    "adder" => FieldBuilder::begin()
                        ->setLabel("adder")
                        ->setType(FieldBuilder::TYPE_LITERAL)
                        ->setInitial("+ Add another")
                        ->build()
                ])
                ->setOnClick(
                    "
                    athens.multi_panel.loadPanel(1, '$adderUrl');
                    athens.multi_panel.openPanel(1);
                "
                )
                ->build();

            $tables[] = SectionBuilder::begin()
                ->setId('object-manager-table-wrapper-' . $tableName)
                ->addLabel(ucwords($tableName))
                ->addWritable(
                    TableBuilder::begin()
                        ->setId('object-manager-table-' . $tableName)
                        ->setRows($rows)
                        ->build()
                )
                ->build();
        }

        return $tables;

    }

    /**
     * @return WritableInterface
     * @throws \Exception If object id not provided, or object not found.
     */
    protected function makeDetail()
    {
        /** @var boolean $idWasProvided */
        $idWasProvided = array_key_exists(static::OBJECT_ID_FIELD, $_GET);

        /** @var ActiveRecordInterface $object */
        $object = $this->getObjectOr404();

        /** @var string $className */
        $className = join('', array_slice(explode('\\', get_class($object)), -1));

        /** @var string $tableName */
        $tableName = StringUtils::slugify($className);

        /** @var FormActionInterface $submitAction */
        $submitAction = new FormAction(
            [],
            [],
            "Submit",
            "JS",
            "
                athens.ajax.AjaxSubmitForm($(this).closest('form'), function(){
                    athens.multi_panel.closePanel(1);
                    athens.ajax_section.loadSection('object-manager-table-$tableName');
                });
                return false;
            "
        );

        /** @var FormActionInterface $deleteAction */
        $deleteAction = new FormAction(
            [],
            [],
            "Delete",
            "",
            ""
        );

        $actions = $idWasProvided === true ? [$submitAction, $deleteAction] : [$submitAction];

        $sectionBuilder = SectionBuilder::begin()
            ->setId('object-manager-detail-form-wrapper')
            ->addLabel($className)
            ->addWritable(
                FormBuilder::begin()
                    ->setId('object-manager-detail-form')
                    ->addObject($object)
                    ->setActions($actions)
                    ->build()
            );

        return $sectionBuilder->build();

    }

    /**
     * @return WritableInterface
     */
    protected function makeDelete()
    {
        return null;
    }

    /**
     * @param string   $location
     * @param string[] $data
     * @return string
     */
    protected static function makeUrl($location, array $data)
    {
        $args = http_build_query($data);

        return strpos($location, '?') === false ? "$location?$args" : "$location&$args";
    }
}
