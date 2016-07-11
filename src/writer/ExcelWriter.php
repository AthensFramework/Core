<?php

namespace Athens\Core\Writer;

use Athens\Core\Filter\DummyFilter;
use Athens\Core\Filter\SelectFilter;

use Twig_SimpleFilter;

use Athens\Core\WritableBearer\WritableBearerInterface;
use Athens\Core\Email\EmailInterface;
use Athens\Core\Etc\SafeString;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Filter\PaginationFilter;
use Athens\Core\Filter\SortFilter;
use Athens\Core\Form\FormInterface;
use Athens\Core\Form\FormAction\FormActionInterface;
use Athens\Core\PickA\PickAFormInterface;
use Athens\Core\PickA\PickAInterface;
use Athens\Core\Section\SectionInterface;
use Athens\Core\Page\PageInterface;
use Athens\Core\Row\RowInterface;
use Athens\Core\Table\TableInterface;
use Athens\Core\Settings\Settings;
use Athens\Core\Etc\StringUtils;
use Athens\Core\Link\LinkInterface;
use Athens\Core\Filter\FilterInterface;
use Athens\Core\Filter\SearchFilter;
use Athens\Core\Table\TableFormInterface;
use Athens\Core\Writable\WritableInterface;

/**
 * Class Writer is a visitor which writes Writable elements to Excel strings.
 *
 * @package Athens\Core\Writer
 */
class ExcelWriter extends AbstractWriter
{
    /** @var \Twig_Environment */
    protected $environment;

    /**
     * Render $writableBearer into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param WritableBearerInterface $writableBearer
     * @return string
     */
    public function visitWritableBearer(WritableBearerInterface $writableBearer)
    {

        $template = 'writable-bearer/' . $writableBearer->getType() . '.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $writableBearer->getId(),
                    "classes" => $writableBearer->getClasses(),
                    "data" => $writableBearer->getData(),
                    "writables" => $writableBearer->getWritables(),
                ]
            );
    }

    /**
     * Render $section into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param SectionInterface $section
     * @return string
     */
    public function visitSection(SectionInterface $section)
    {

        $template = 'section/' . $section->getType() . '.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $section->getId(),
                    "classes" => $section->getClasses(),
                    "data" => $section->getData(),
                    "writables" => $section->getWritables(),
                ]
            );
    }

    /**
     * Render $link into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param LinkInterface $link
     * @return string
     */
    public function visitLink(LinkInterface $link)
    {

        $template = 'link/' . $link->getType() . '.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $link->getId(),
                    "classes" => $link->getClasses(),
                    "data" => $link->getData(),
                    "uri" => $link->getURI(),
                    "text" => $link->getText(),
                ]
            );
    }

    /**
     * @param integer $number
     * @return string
     */
    protected static function excelRow($number)
    {
        /** @var string $index */
        $index = "";

        /** @var string $letters */
        $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $number += 1;
        while ($number > 0) {
            $remainder = $number % 25;
            $letter = substr($letters, $remainder - 1, 1);
            $index = $letter . $index;

            $number = floor($number/26);
        }

        return $index;
    }

    /**
     * Render $page into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param PageInterface $page
     * @return string
     */
    public function visitPage(PageInterface $page)
    {
        /** @var WritableInterface[] $writables */
        $writables = [$page];

        /** @var TableInterface[] $tables */
        $tables = [];

        while ($writables !== []) {
            $writable = array_pop($writables);

            if (method_exists($writable, 'getWritable') === true && $writable->getWritable() !== null) {
                $writables[] = $writable->getWritable();
            }

            if (method_exists($writable, 'getWritables') === true) {
                $writables += $writable->getWritables();
            }

            if ($writable instanceof TableInterface) {
                $tables[] = $writable;
            }
        }

        if ($tables === []) {
//            throw new Exception("No tables found in writables.");
        }

        $objPHPExcel = new \PHPExcel();

        foreach ($tables as $table) {
            // Create a sheet
            $objWorkSheet = $objPHPExcel->createSheet();

            if (sizeof($table->getRows()) > 0) {
                // Write header
                /** @var FieldInterface $field */
                foreach (array_values($table->getRows()[0]->getFieldBearer()->getVisibleFields()) as $j => $field) {
                    $cellIndex = static::excelRow($j) . "1";
                    $objWorkSheet->setCellValue($cellIndex, $field->getLabel());
                    $objWorkSheet->getStyle($cellIndex)->getFont()->setBold(true);
                }

                // Write cells
                foreach ($table->getRows() as $i => $row) {
                    foreach (array_values($row->getFieldBearer()->getVisibleFields()) as $j => $field) {
                        if ($field->getInitial() !== "") {
                            $cellIndex = static::excelRow($j) . ($i + 2);
                            $objWorkSheet->setCellValue($cellIndex, $field->getInitial());
                        }
                    }
                }
            } else {
                $objWorkSheet->setCellValue("A1", "No records found");
            }
        }

        // Remove worksheet 0; it was created with the file but we never wrote to it
        $objPHPExcel->removeSheetByIndex(0);

        // Auto size columns for each worksheet
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $objPHPExcel->setActiveSheetIndex($objPHPExcel->getIndex($worksheet));
            $sheet = $objPHPExcel->getActiveSheet();
            $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            foreach ($cellIterator as $cell) {
                $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            }
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

        ob_start();
        $objWriter->save('php://output');
        return ob_end_flush();















        $template = 'page/' . $page->getType() . '.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $page->getId(),
                    "classes" => $page->getClasses(),
                    "data" => $page->getData(),
                    "title" => $page->getTitle(),
                    "baseHref" => $page->getBaseHref(),
                    "writables" => $page->getWritables(),
                    "projectCSS" => Settings::getInstance()->getProjectCSS(),
                    "projectJS" => Settings::getInstance()->getProjectJS(),
                ]
            );
    }

    /**
     * Render $field into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FieldInterface $field
     * @return string
     */
    public function visitField(FieldInterface $field)
    {
        $template = 'field/' . $field->getType() . '.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "hash" => $field->getId(),
                    "classes" => $field->getClasses(),
                    "data" => $field->getData(),
                    "slug" => $field->getSlug(),
                    "initial" => $field->getInitial(),
                    "choices" => $field->getChoices(),
                    "label" => $field->getLabel(),
                    "required" => $field->isRequired(),
                    "size" => $field->getSize(),
                    "errors" => $field->getErrors(),
                    "helptext" => $field->getHelptext(),
                    "placeholder" => $field->getPlaceholder()
                ]
            );
    }

    /**
     * Render $row into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param RowInterface $row
     * @return string
     */
    public function visitRow(RowInterface $row)
    {
        $template = 'row/base.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "hash" => $row->getId(),
                    "classes" => $row->getClasses(),
                    "data" => $row->getData(),
                    "visibleFields" => $row->getFieldBearer()->getVisibleFields(),
                    "hiddenFields" => $row->getFieldBearer()->getHiddenFields(),
                    "highlightable" => $row->isHighlightable(),
                    "onClick" => $row->getOnClick(),
                ]
            );
    }

    /**
     * Render $table into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param TableInterface $table
     * @return string
     */
    public function visitTable(TableInterface $table)
    {
        $template = 'table/base.twig';

        $filters = [];
        for ($thisFilter = $table->getFilter(); $thisFilter !== null; $thisFilter = $thisFilter->getNextFilter()) {
            $filters[] = $thisFilter;
        }

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $table->getId(),
                    "classes" => $table->getClasses(),
                    "data" => $table->getData(),
                    "rows" => $table->getRows(),
                    "filters" => $filters,
                ]
            );
    }

    /**
     * Render FormInterface into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FormInterface $form
     * @return string
     */
    public function visitForm(FormInterface $form)
    {
        $template = "form/{$form->getType()}.twig";

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $form->getId(),
                    "classes" => $form->getClasses(),
                    "data" => $form->getData(),
                    "method" => $form->getMethod(),
                    "target" => $form->getTarget(),
                    "visibleFields" => $form->getFieldBearer()->getVisibleFields(),
                    "hiddenFields" => $form->getFieldBearer()->getHiddenFields(),
                    "actions" => $form->getActions(),
                    "errors" => $form->getErrors(),
                    "subForms" => $form->getSubForms()
                ]
            );
    }

    /**
     * Render FormActionInterface into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FormActionInterface $formAction
     * @return string
     */
    public function visitFormAction(FormActionInterface $formAction)
    {
        $template = 'form-action/base.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "label" => $formAction->getLabel(),
                    "method" => $formAction->getMethod(),
                    "target" => $formAction->getTarget(),
                ]
            );
    }

    /**
     * Render PickAInterface into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param PickAInterface $pickA
     * @return string
     */
    public function visitPickA(PickAInterface $pickA)
    {
        $template = 'pick-a/base.twig';

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $pickA->getId(),
                    "classes" => $pickA->getClasses(),
                    "data" => $pickA->getData(),
                    "manifest" => $pickA->getManifest(),
                ]
            );
    }

    /**
     * Render PickAFormInterface into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param PickAFormInterface $pickAForm
     * @return string
     */
    public function visitPickAForm(PickAFormInterface $pickAForm)
    {
        $template = "pick-a-form/{$pickAForm->getType()}.twig";

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $pickAForm->getId(),
                    "classes" => $pickAForm->getClasses(),
                    "data" => $pickAForm->getData(),
                    "method" => $pickAForm->getMethod(),
                    "target" => $pickAForm->getTarget(),
                    "manifest" => $pickAForm->getManifest(),
                    "selectedForm" => $pickAForm->getSelectedForm(),
                    "errors" => $pickAForm->getErrors()
                ]
            );
    }

    /**
     * Render TableFormInterface into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param TableFormInterface $tableForm
     * @return string
     */
    public function visitTableForm(TableFormInterface $tableForm)
    {
        $template = "table-form/{$tableForm->getType()}.twig";

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $tableForm->getId(),
                    "classes" => $tableForm->getClasses(),
                    "data" => $tableForm->getData(),
                    "method" => $tableForm->getMethod(),
                    "target" => $tableForm->getTarget(),
                    "actions" => $tableForm->getActions(),
                    "prototypicalRow" => $tableForm->getPrototypicalRow(),
                    "canRemove" => $tableForm->getCanRemove(),
                    "rows" => $tableForm->getRows(),
                ]
            );
    }

    /**
     * Helper method to render a FilterInterface to html.
     *
     * @param FilterInterface $filter
     * @return string
     */
    public function visitFilter(FilterInterface $filter)
    {
        if ($filter instanceof DummyFilter) {
            $type = 'dummy';
        } elseif ($filter instanceof SelectFilter) {
            $type = 'select';
        } elseif ($filter instanceof SearchFilter) {
            $type = 'search';
        } elseif ($filter instanceof SortFilter) {
            $type = 'sort';
        } elseif ($filter instanceof PaginationFilter) {
            $type = 'pagination';
        } else {
            $type = 'blank';
        }
        $template = "filter/$type.twig";

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $filter->getId(),
                    "options" => $filter->getOptions(),
                ]
            );
    }

    /**
     * Render an email message into an email body, given its template.
     *
     * @param EmailInterface $email
     * @return string
     */
    public function visitEmail(EmailInterface $email)
    {
        $template = "email/{$email->getType()}.twig";

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $email->getId(),
                    "classes" => $email->getClasses(),
                    "data" => $email->getData(),
                    "message" => $email->getMessage(),
                ]
            );
    }
}
