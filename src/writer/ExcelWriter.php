<?php

namespace Athens\Core\Writer;

use Exception;

use Twig_SimpleFilter;

use Athens\Core\Filter\DummyFilter;
use Athens\Core\Filter\SelectFilter;
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
     * @throws Exception if no tables found in page.
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
            throw new Exception("No tables found in writables.");
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
    }
}
