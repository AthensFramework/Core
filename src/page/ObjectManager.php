<?php

namespace Athens\Core\Page;

use DOMPDF;

use Athens\Core\Etc\ArrayUtils;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Table\TableBuilder;
use Athens\Core\Row\RowBuilder;
use Athens\Core\Row\RowInterface;
use Athens\Core\Form\FormBuilder;
use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Field\Field;
use Athens\Core\Form\FormAction\FormActionInterface;

use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

/**
 * Class ObjectManager
 *
 * @package Athens\Core\Page
 */
class ObjectManager extends Page
{

    const MODE_TABLE = 'table';
    const MODE_DETAIL = 'detail';
    const MODE_DELETE = 'delete';

    /** @var ModelCriteria */
    protected $query;

    /**
     * Page constructor.
     *
     * @param string        $id
     * @param string        $type
     * @param string[]      $classes
     * @param string        $title
     * @param string        $baseHref
     * @param string        $header
     * @param string        $subHeader
     * @param string[]      $breadCrumbs
     * @param string[]      $returnTo
     * @param ModelCriteria $query
     * @throws \Exception If an invalid object manager mode is provided.
     */
    public function __construct(
        $id,
        $type,
        array $classes,
        $title,
        $baseHref,
        $header,
        $subHeader,
        array $breadCrumbs,
        array $returnTo,
        ModelCriteria $query
    ) {

        /** @var string $mode */
        $mode = ArrayUtils::findOrDefault('mode', $_GET, static::MODE_TABLE);

        $this->query = $query;

        switch ($mode) {
            case static::MODE_TABLE:
                $writable = $this->makeTable();
                $type = static::PAGE_TYPE_MULTI_PANEL;
                break;
            case static::MODE_DETAIL:
                $writable = $this->makeDetail();
                $type = static::PAGE_TYPE_AJAX_PAGE;

                $header = "";
                $subHeader = "";
                break;
            case static::MODE_DELETE:
                $writable = $this->makeDelete();
                $type = static::PAGE_TYPE_AJAX_ACTION;
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
            $title,
            $baseHref,
            $header,
            $subHeader,
            $breadCrumbs,
            $returnTo,
            $writable
        );
    }

    /**
     * Finds an object with the given id in this ObjectManager's query.
     *
     * @return ActiveRecordInterface
     * @throws \Exception If object can not be found.
     */
    protected function getObjectOr404()
    {
        /** @var boolean $idWasProvided */
        $idWasProvided = array_key_exists('id', $_GET);

        if ($idWasProvided === true) {
            $object = $this->query->findOneById((int)$_GET['id']);
        } else {
            $class = $this->query->getTableMap()->getOMClass(false);
            $object = new $class();
        }

        if ($object === null) {
            http_response_code(404);
            throw new \Exception('Object not found.');
        }

        return $object;

    }

    /**
     * @return WritableInterface
     */
    protected function makeTable()
    {
        /** @var ActiveRecordInterface[] $objects */
        $objects = $this->query->find();

        /** @var RowInterface[] $rows */
        $rows = [];

        foreach ($objects as $object) {

            /** @var string $detailurl */
            $detailurl = static::makeUrl($_SERVER['REQUEST_URI'], ["mode" => "detail", "id" => $object->getId()]);

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
        $adderUrl = static::makeUrl($_SERVER['REQUEST_URI'], ["mode" => "detail"]);

        $rows[] = RowBuilder::begin()
            ->addFields([
                "adder" => FieldBuilder::begin()
                    ->setLabel("adder")
                    ->setType(Field::FIELD_TYPE_LITERAL)
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

        return TableBuilder::begin()
            ->setId('object-manager-table')
            ->setRows($rows)
            ->build();
    }

    /**
     * @return WritableInterface
     * @throws \Exception If object id not provided, or object not found.
     */
    protected function makeDetail()
    {
        /** @var boolean $idWasProvided */
        $idWasProvided = array_key_exists('id', $_GET);

        /** @var ActiveRecordInterface $object */
        $object = $this->getObjectOr404();

        /** @var FormActionInterface $submitAction */
        $submitAction = new FormAction(
            [],
            "Submit",
            "JS",
            "
                athens.ajax.AjaxSubmitForm($(this).closest('form'), function(){
                    athens.multi_panel.closePanel(1);
                    athens.ajax_section.loadSection('object-manager-table');
                });
                return false;
            "
        );

        /** @var FormActionInterface $deleteAction */
        $deleteAction = new FormAction(
            [],
            "Delete",
            "",
            ""
        );

        $actions = $idWasProvided === true ? [$submitAction, $deleteAction] : [$submitAction];

        return FormBuilder::begin()
            ->setId('object-manager-detail-form')
            ->addObject($object)
            ->setActions($actions)
            ->build();

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
