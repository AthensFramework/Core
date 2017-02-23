<?php

namespace Athens\Core\Admin;

use Athens\Core\Etc\StringUtils;
use Athens\Core\FormAction\FormActionBuilder;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Visitor\VisitorInterface;
use Athens\Core\Etc\ArrayUtils;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Table\TableBuilder;
use Athens\Core\Row\RowBuilder;
use Athens\Core\Row\RowInterface;
use Athens\Core\Form\FormBuilder;
use Athens\Core\FormAction\FormActionInterface;
use Athens\Core\Page\Page;
use Athens\Core\WritableBearer\WritableBearerBuilder;
use Athens\Core\ORMWrapper\ObjectWrapperInterface;
use Athens\Core\ORMWrapper\QueryWrapperInterface;

/**
 * Class ObjectManager
 *
 * @package Athens\Core\Page
 */
class Admin extends Page
{
    const MODE_PAGE = 'page';
    const MODE_TABLE = 'table';
    const MODE_DETAIL = 'detail';
    const MODE_DELETE = 'delete';

    const MODE_FIELD = 'mode';
    const OBJECT_ID_FIELD = 'object_id';
    const QUERY_INDEX_FIELD = 'query_index';

    /** @var QueryWrapperInterface[] */
    protected $queries;

    /**
     * Admin constructor.
     *
     * @param string                  $id
     * @param string                  $type
     * @param string[]                $classes
     * @param array                   $data
     * @param string                  $title
     * @param string                  $baseHref
     * @param VisitorInterface        $initializer
     * @param VisitorInterface        $renderer
     * @param WritableInterface       $pageContents
     * @param QueryWrapperInterface[] $queries
     * @throws \Exception If an invalid object manager mode is provided.
     */
    public function __construct(
        $id,
        $type,
        array $classes,
        array $data,
        $title,
        $baseHref,
        VisitorInterface $initializer,
        VisitorInterface $renderer,
        WritableInterface $pageContents,
        array $queries
    ) {

        /** @var string $mode */
        $mode = $this->getParameter(static::MODE_FIELD, static::MODE_PAGE);

        $this->queries = $queries;

        switch ($mode) {
            case static::MODE_PAGE:
                $writable = $pageContents;
                $type = static::TYPE_MINI_HEADER;
                break;
            case static::MODE_TABLE:
                $sectionBuilder = SectionBuilder::begin()
                    ->setId('admin-tables-container');

                foreach ($this->makeTables() as $table) {
                    $sectionBuilder->addWritable($table);
                }

                $writable = WritableBearerBuilder::begin()
                    ->addWritable($sectionBuilder->build())
                    ->build();

                $type = static::TYPE_MINI_HEADER;
                break;
            case static::MODE_DETAIL:
                $writable = $this->makeDetail();
                $type = static::TYPE_BARE;
                break;
            case static::MODE_DELETE:
                $writable = $this->makeDelete();
                $type = static::TYPE_BARE;
                break;
            default:
                throw new \Exception(
                    "Invalid object manager mode '$mode' provided in URL parameters."
                );
        }

        parent::__construct(
            $id,
            $type,
            $classes,
            $data,
            $title,
            $baseHref,
            $initializer,
            $renderer,
            $writable
        );
    }

    /**
     * @param string $key
     * @param string $default
     * @return string
     */
    protected function getParameter($key, $default = null)
    {
        return ArrayUtils::findOrDefault($key, $_GET, $default);
    }

    /**
     * @return integer|null
     */
    protected function getObjectId()
    {
        /** @var string|null $objectId */
        $objectId = $this->getParameter(static::OBJECT_ID_FIELD);

        return is_numeric($objectId) === true ? (int)$objectId : null;
    }

    /**
     * @return integer|null
     */
    protected function getQueryIndex()
    {
        /** @var string|null $queryIndex */
        $queryIndex = $this->getParameter(static::QUERY_INDEX_FIELD);

        return is_numeric($queryIndex) === true ? (int)$queryIndex : null;
    }

    /**
     * @return QueryWrapperInterface
     */
    protected function getQuery()
    {
        return $this->queries[$this->getQueryIndex()];
    }

    /**
     * Finds an object with the given id in this ObjectManager's query.
     *
     * @param boolean $createOnNoId
     * @return ObjectWrapperInterface
     * @throws \Exception If object can not be found.
     */
    protected function getObjectOr404($createOnNoId = false)
    {
        /** @var integer|null $objectId */
        $objectId = static::getObjectId();

        /** @var ObjectWrapperInterface $object */
        $object = null;

        if ($objectId !== null) {
            $object = $this->getQuery()->findOneByPrimaryKey($objectId);
        } elseif ($createOnNoId === true) {
            $object = $this->getQuery()->createObject();
        }

        if ($object === null) {
            http_response_code(404);
            throw new \Exception('Object not found.');
        }

        return $object;
    }

    /**
     * @param QueryWrapperInterface[]|null $queries
     * @return WritableInterface[]
     */
    protected function makeTables($queries = null)
    {
        /** @var WritableInterface[] $tables */
        $tables = [];

        foreach ($this->queries as $queryIndex => $query) {
            $objects = $query->find();

            /** @var RowInterface[] $rows */
            $rows = [];

            /** @var string $tableName */
            $tableName = StringUtils::slugify($query->getTitleCasedObjectName());

            foreach ($objects as $object) {
                /** @var string $detailurl */
                $detailurl = static::makeUrl(
                    [
                        static::MODE_FIELD => static::MODE_DETAIL,
                        static::QUERY_INDEX_FIELD => $queryIndex,
                        static::OBJECT_ID_FIELD => $object->getPrimaryKey()
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
                [
                    static::MODE_FIELD => static::MODE_DETAIL,
                    static::QUERY_INDEX_FIELD => $queryIndex,
                ]
            );

            $rows[] = RowBuilder::begin()
                ->addWritable(
                    FieldBuilder::begin()
                        ->setLabel("adder")
                        ->setType(FieldBuilder::TYPE_LITERAL)
                        ->addClass('adder')
                        ->setInitial("+ Add another")
                        ->build(),
                    "adder"
                )
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
                        ->addRows($rows)
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
        $idWasProvided = static::getObjectId() !== null;

        /** @var ObjectWrapperInterface $object */
        $object = $this->getObjectOr404(true);

        /** @var string $className */
        $className = $this->getQuery()->getTitleCasedObjectName();

        /** @var string $tableName */
        $tableName = StringUtils::slugify($className);

        /** @var FormActionInterface $submitAction */
        $submitAction = FormActionBuilder::begin()
            ->setType(FormActionBuilder::TYPE_JAVASCRIPT)
            ->setLabel('Save')
            ->addClass('save')
            ->setTarget("
                athens.ajax.submitForm($(this).closest('form')[0], function(){
                        athens.multi_panel.closePanel(1);
                        athens.ajax_section.loadSection('object-manager-table-$tableName');
                    });
                return false;
            ")
            ->build();

        /** @var string $deleteUrl */
        $deleteUrl = static::makeUrl(
            [
                static::MODE_FIELD => static::MODE_DELETE,
                static::QUERY_INDEX_FIELD => $this->getQueryIndex(),
                static::OBJECT_ID_FIELD => $object->getPrimaryKey()
            ]
        );

        /** @var FormActionInterface $deleteAction */
        $deleteAction = FormActionBuilder::begin()
            ->setType(FormActionBuilder::TYPE_JAVASCRIPT)
            ->setLabel('Delete')
            ->setTarget("
                if (confirm('Are you sure you want to delete this object?')) {
                    athens.alert.makeAlert('Deleting object.', 'info');
                    athens.ajax.post(
                        '$deleteUrl',
                        {
                          csrf_token: CSRFTOKEN,
                        },
                        function() {},
                        function() {
                            athens.alert.makeAlert('Object deleted', 'success');
                            athens.multi_panel.closePanel(1);
                            athens.ajax_section.loadSection('object-manager-table-$tableName');
                        }
                    );
                }
                return false;
            ")
            ->build();

        $formBuilder = FormBuilder::begin()
            ->setId('object-manager-detail-form')
            ->addObject($object)
            ->removeWritable($object->getPascalCasedObjectName() . '.Id')
            ->addAction($submitAction);

        if ($idWasProvided === true) {
            $formBuilder->addAction($deleteAction);
        }

        $sectionBuilder = SectionBuilder::begin()
            ->setId('object-manager-detail-form-wrapper')
            ->addLabel($className)
            ->addWritable(
                $formBuilder->build()
            );

        return $sectionBuilder->build();
    }

    /**
     * @return WritableInterface
     */
    protected function makeDelete()
    {
        $this->getObjectOr404()->delete();

        return SectionBuilder::begin()
            ->addContent('Object deleted')
            ->build();
    }

    /**
     * @param string[] $data
     * @param string   $location
     * @return string
     */
    protected static function makeUrl(array $data, $location = null)
    {
        $location = $location === null ? $_SERVER['REQUEST_URI'] : $location;

        $args = http_build_query($data);

        return strpos($location, '?') === false ? "$location?$args" : "$location&$args";
    }
}
