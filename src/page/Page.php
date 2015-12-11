<?php

namespace UWDOEM\Framework\Page;

use DOMPDF;

use UWDOEM\Framework\Section\SectionInterface;
use UWDOEM\Framework\Table\TableInterface;
use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\Writer;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\Initializer\Initializer;
use UWDOEM\Framework\Field\FieldInterface;

class Page implements PageInterface
{

    const PAGE_TYPE_AJAX_ACTION = "ajax-action";
    const PAGE_TYPE_AJAX_PAGE = "ajax-page";
    const PAGE_TYPE_EXCEL = "excel";
    const PAGE_TYPE_FULL_HEADER = "full-header";
    const PAGE_TYPE_MINI_HEADER = "mini-header";
    const PAGE_TYPE_MULTI_PANEL = "multi-panel";
    const PAGE_TYPE_PDF = "pdf";
    const PAGE_TYPE_MARKDOWN_DOCUMENTATION = "markdown-documentation";

    use VisitableTrait;

    /** @var string */
    protected $title;

    /** @var string */
    protected $baseHref;

    /** @var string */
    protected $header;
    
    /** @var string */
    protected $subHeader;

    /** @var string[] */
    protected $breadCrumbs;
    
    /** @var string[] */
    protected $returnTo;

    /** @var WritableInterface */
    protected $writable;

    /** @var string */
    protected $type;


    public function getId()
    {
        return md5($_SERVER['REQUEST_URI']);
    }

    /**
     * Page constructor.
     * @param string                 $type
     * @param string                 $title
     * @param string                 $baseHref
     * @param string                 $header
     * @param string                 $subHeader
     * @param string[]               $breadCrumbs
     * @param string[]               $returnTo
     * @param WritableInterface|null $writable
     */
    public function __construct(
        $type,
        $title,
        $baseHref,
        $header,
        $subHeader,
        array $breadCrumbs,
        array $returnTo,
        WritableInterface $writable = null
    ) {
    
        $this->title = $title;
        $this->baseHref = $baseHref;
        $this->header = $header;
        $this->subHeader = $subHeader;
        $this->breadCrumbs = $breadCrumbs;
        $this->returnTo = $returnTo;
        $this->writable = $writable;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBaseHref()
    {
        return $this->baseHref;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @return string
     */
    public function getSubHeader()
    {
        return $this->subHeader;
    }

    /**
     * @return string[]
     */
    public function getBreadCrumbs()
    {
        return $this->breadCrumbs;
    }

    /**
     * @return string[]
     */
    public function getReturnTo()
    {
        return $this->returnTo;
    }

    /**
     * @return WritableInterface|null
     */
    public function getWritable()
    {
        return $this->writable;
    }

    protected function makeDefaultInitializer()
    {
        $initializerClass = Settings::getDefaultInitializerClass();
        return new $initializerClass();
    }

    protected function makeDefaultWriter()
    {
        $writerClass = Settings::getDefaultWriterClass();
        return new $writerClass();
    }

    protected static function areAllTableInterface(array $writables)
    {
        $totalWritables = count($writables);
        $totalTableInterface = count(
            array_filter(
                $writables,
                function (WritableInterface $writable) {
                    return $writable instanceof TableInterface;
                }
            )
        );

        return $totalWritables === $totalTableInterface;
    }

    protected static function renderExcel(PageInterface $writable, $writer)
    {
        $filename = "title";
        $filename = date("Y-m-d-") . "$filename.xlsx";

        header("Content-Disposition: attachment; filename=$filename;");
        header("Content-Type: application/octet-stream");

        if (($writable->getWritable() instanceof TableInterface)) {
            $tables = [$writable->getWritable()];
        } elseif ($writable->getWritable() instanceof SectionInterface &&
            static::areAllTableInterface($writable->getWritable()->getWritables())
        ) {
            $tables = $writable->getWritable()->getWritables();
        } else {
            throw new \Exception("The pageSection of an Excel template must either be a table, " .
                "or a multiSection containing only tables.");
        }

        $objPHPExcel = new \PHPExcel();

        $letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        /** @var TableInterface $table */
        foreach ($tables as $table) {

            // Create a sheet
            $objWorkSheet = $objPHPExcel->createSheet();
//            $objWorkSheet->setTitle($table->getLabel());

            if (sizeof($table->getRows()) > 0) {
                // Write header
                /** @var FieldInterface $field */
                foreach (array_values($table->getRows()[0]->getFieldBearer()->getVisibleFields()) as $j => $field) {
                    $cellIndex = substr($letters, $j, 1) . "1";
                    $objWorkSheet->setCellValue($cellIndex, $field->getLabel());
                    $objWorkSheet->getStyle($cellIndex)->getFont()->setBold(true);
                }

                // Write cells
                foreach ($table->getRows() as $i => $row) {
                    foreach (array_values($row->getFieldBearer()->getVisibleFields()) as $j => $field) {
                        if ($field->getInitial()) {
                            $cellIndex = substr($letters, $j, 1) . ($i + 2);
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

    protected static function renderPDF(PageInterface $writable, $writer)
    {
        $documentName = $writable->getTitle() ? $writable->getTitle() : "document";
        $content = $writable->accept($writer);

        $dompdf = new DOMPDF();
        $dompdf->load_html($content);
        $dompdf->render();
        $dompdf->stream($documentName . ".pdf");
    }

    protected function makeDefaultRendererFunction()
    {

        switch ($this->getType()) {
            case static::PAGE_TYPE_PDF:
                return $this->{"renderPDF"};
                break;
            case static::PAGE_TYPE_EXCEL:
                return $this->{"renderExcel"};
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
     * @return null
     */
    public function render(
        Initializer $initializer = null,
        Writer $writer = null,
        callable $renderFunction = null
    ) {
    

        if (is_null($initializer)) {
            $initializer = $this->makeDefaultInitializer();
        }
        
        if (is_null($writer)) {
            $writer = $this->makeDefaultWriter();
        }

        if (is_null($renderFunction)) {
            $renderFunction = $this->makeDefaultRendererFunction();
        }

        $this->accept($initializer);
        $renderFunction($this, $writer);
    }
}
