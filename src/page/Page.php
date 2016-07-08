<?php

namespace Athens\Core\Page;

use Exception;

use DOMPDF;

use Athens\Core\WritableBearer\WritableBearerBearerTrait;
use Athens\Core\Table\TableInterface;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writer\Writer;
use Athens\Core\Etc\Settings;
use Athens\Core\Initializer\Initializer;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Writable\WritableTrait;

/**
 * Class Page Provides the primary writable for a page request.
 *
 * @package Athens\Core\Page
 */
class Page implements PageInterface
{
    use VisitableTrait;
    use WritableTrait;
    use WritableBearerBearerTrait;

    /** @var string */
    protected $title;

    /** @var string */
    protected $baseHref;

    /**
     * Page constructor.
     *
     * @param string $id
     * @param string $type
     * @param string[] $classes
     * @param string[] $data
     * @param string $title
     * @param string $baseHref
     * @param WritableInterface|null $writable
     */
    public function __construct(
        $id, $type, array $classes, array $data, $title, $baseHref, WritableInterface $writable = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->baseHref = $baseHref;
        $this->writableBearer = $writable;
        $this->type = $type;
        $this->classes = $classes;
        $this->data = $data;
    }
    
    /**
     * Returns the type of the page.
     *
     * This will usually be one of the PageBuilder::TYPE_ consts defined above.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the title of the page.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the baseHref of the page.
     *
     * @return string
     */
    public function getBaseHref()
    {
        return $this->baseHref;
    }

    /**
     * @return Initializer
     */
    protected function makeDefaultInitializer()
    {
        $initializerClass = Settings::getDefaultInitializerClass();
        return new $initializerClass();
    }

    /**
     * @return Writer
     */
    protected function makeDefaultWriter()
    {
        $writerClass = Settings::getDefaultWriterClass();
        return new $writerClass();
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
     * @param PageInterface $writable
     * @param Writer        $writer
     * @return void
     * @throws \Exception If the writable of the page is not a table, or set of tables.
     */
    protected static function renderExcel(PageInterface $writable, Writer $writer)
    {
        $filename = "title";
        $filename = date("Y-m-d-") . "$filename.xlsx";

        header("Content-Disposition: attachment; filename=$filename;");
        header("Content-Type: application/octet-stream");

        /** @var WritableInterface[] $writables */
        $writables = [$writable];

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
        $objWriter->save('php://output');
    }

    /**
     * @param PageInterface $writable
     * @param Writer        $writer
     * @return void
     */
    protected static function renderPDF(PageInterface $writable, Writer $writer)
    {
        $documentName = $writable->getTitle() ? $writable->getTitle() : "document";
        $content = $writable->accept($writer);

        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream($documentName . ".pdf");
    }

    /**
     * @return callable
     */
    protected function makeDefaultRendererFunction()
    {
        switch ($this->getType()) {
            case static::TYPE_PDF:
                $page = $this;
                $renderFunction = function (PageInterface $writable, $writer) use ($page) {
                    $page->renderPDF($writable, $writer);
                };
                break;
            case static::TYPE_EXCEL:
                $page = $this;
                $renderFunction = function (PageInterface $writable, $writer) use ($page) {
                    $page->renderExcel($writable, $writer);
                };
                break;
            default:
                $renderFunction = function (PageInterface $writable, $writer) {
                    echo $writable->accept($writer);
                };
        }

        return $renderFunction;
    }

    /**
     * @param Initializer|null $initializer
     * @param Writer|null      $writer
     * @param callable|null    $renderFunction
     * @return void
     */
    public function render(
        Initializer $initializer = null,
        Writer $writer = null,
        callable $renderFunction = null
    ) {
        if ($initializer === null) {
            $initializer = $this->makeDefaultInitializer();
        }

        if ($writer === null) {
            $writer = $this->makeDefaultWriter();
        }

        if ($renderFunction === null) {
            $renderFunction = $this->makeDefaultRendererFunction();
        }

        $this->accept($initializer);
        $renderFunction($this, $writer);
    }
}
