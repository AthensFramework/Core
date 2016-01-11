<?php

namespace UWDOEM\Framework\Writer;

use Twig_SimpleFilter;

use UWDOEM\Framework\Etc\SafeString;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Filter\PaginationFilter;
use UWDOEM\Framework\Filter\SortFilter;
use UWDOEM\Framework\Form\FormInterface;
use UWDOEM\Framework\Form\FormAction\FormActionInterface;
use UWDOEM\Framework\PickA\PickAFormInterface;
use UWDOEM\Framework\PickA\PickAInterface;
use UWDOEM\Framework\Section\SectionInterface;
use UWDOEM\Framework\Visitor\Visitor;
use UWDOEM\Framework\Page\PageInterface;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Table\TableInterface;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\Etc\StringUtils;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Filter\FilterInterface;
use UWDOEM\Framework\Filter\SearchFilter;
use UWDOEM\Framework\Table\TableFormInterface;

/**
 * Class Writer is a visitor which renders Writable elements.
 *
 * @package UWDOEM\Framework\Writer
 */
class Writer extends Visitor
{
    /** @var \Twig_Environment */
    protected $environment;

    /**
     * @return string[] An array containing all Framework-registered Twig template directories.
     */
    protected function getTemplatesDirectories()
    {
        return array_merge(Settings::getTemplateDirectories(), [dirname(__FILE__) . '/../../templates/base']);
    }

    /**
     * Visit a writable host and render it into html.
     *
     * @param WritableInterface $host
     * @return string
     */
    protected function write(WritableInterface $host)
    {
        return $host->accept($this);
    }

    /**
     * Get this Writer's Twig_Environment; create if it doesn't exist;
     *
     * @return \Twig_Environment
     */
    protected function getEnvironment()
    {
        if ($this->environment === null) {
            $loader = new \Twig_Loader_Filesystem($this->getTemplatesDirectories());
            $this->environment = new \Twig_Environment($loader);

            $filter = new Twig_SimpleFilter(
                'write',
                function (WritableInterface $host) {
                    return $host->accept($this);
                }
            );
            $this->environment->addFilter($filter);

            $filter = new Twig_SimpleFilter(
                'slugify',
                function ($string) {
                    return StringUtils::slugify($string);
                }
            );
            $this->environment->addFilter($filter);

            $filter = new Twig_SimpleFilter(
                'md5',
                function ($string) {
                    return md5($string);
                }
            );
            $this->environment->addFilter($filter);

            $filter = new Twig_SimpleFilter(
                'stripForm',
                function ($string) {
                    $string = str_replace("<form", "<div", $string);
                    $string = preg_replace('#<div class="form-actions">(.*?)</div>#', '', $string);
                    $string = str_replace("form-actions", "form-actions hidden", $string);
                    $string = str_replace(" form-errors", " form-errors hidden", $string);
                    $string = str_replace('"form-errors', '"form-errors hidden', $string);
                    $string = str_replace("</form>", "</div>", $string);
                    return $string;
                }
            );
            $this->environment->addFilter($filter);

            $filter = new Twig_SimpleFilter(
                'saferaw',
                function ($string) {
                    if ($string instanceof SafeString) {
                        $string = (string)$string;
                    } else {
                        $string = htmlentities($string);
                    }

                    return $string;
                }
            );
            $this->environment->addFilter($filter);

            $requestURI = array_key_exists("REQUEST_URI", $_SERVER) ? $_SERVER["REQUEST_URI"] : "";
            $this->environment->addGlobal("requestURI", $requestURI);
        }

        return $this->environment;
    }

    /**
     * Find a template by path from within the registered template directories.
     *
     * Ex: `loadTemplate("page/full_header.twig");`
     *
     * @param string $subpath
     * @return \Twig_TemplateInterface
     */
    protected function loadTemplate($subpath)
    {
        return $this->getEnvironment()->loadTemplate($subpath);
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
                    "writables" => $section->getWritables(),
                ]
            );
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
        $template = 'page/' . $page->getType() . '.twig';

        $writable = $page->getWritable();

        if ($writable !== null) {
            $content = $writable->accept($this);
        } else {
            $content = "";
        }

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "id" => $page->getId(),
                    "classes" => $page->getClasses(),
                    "pageType" => $page->getType(),
                    "title" => $page->getTitle(),
                    "header" => $page->getHeader(),
                    "subHeader" => $page->getSubHeader(),
                    "baseHref" => $page->getBaseHref(),
                    "breadCrumbs" => $page->getBreadCrumbs(),
                    "returnTo" => $page->getReturnTo(),
                    "projectCSS" => Settings::getProjectCSS(),
                    "projectJS" => Settings::getProjectJS(),
                    "content" => $content,
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

        if ($field->getType() === Field::FIELD_TYPE_CHOICE || $field->getType() === Field::FIELD_TYPE_MULTIPLE_CHOICE) {
            $choices = array_combine($field->getChoiceSlugs(), $field->getChoices());
        } else {
            $choices = [];
        }

        return $this
            ->loadTemplate($template)
            ->render(
                [
                    "hash" => $field->getId(),
                    "slug" => $field->getSlug(),
                    "initial" => $field->getInitial(),
                    "choices" => $choices,
                    "label" => $field->getLabel(),
                    "required" => $field->isRequired(),
                    "size" => $field->getSize(),
                    "errors" => $field->getErrors()
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
     * Render a PaginationFilter into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param PaginationFilter $filter
     * @return string
     */
    public function visitPaginationFilter(PaginationFilter $filter)
    {
        $type = $filter->getType();

        return $this->visitFilterOfType($filter, "$type-pagination");
    }

    /**
     * Render a SortFilter into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param SortFilter $filter
     * @return string
     */
    public function visitSortFilter(SortFilter $filter)
    {
        return $this->visitFilterOfType($filter, "sort");
    }

    /**
     * Render a SearchFilter into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param SearchFilter $filter
     * @return string
     */
    public function visitSearchFilter(SearchFilter $filter)
    {
        return $this->visitFilterOfType($filter, "search");
    }

    /**
     * Render a StaticFilter into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FilterInterface $filter
     * @return string
     */
    public function visitStaticFilter(FilterInterface $filter)
    {
        return $this->visitFilterOfType($filter, "static");
    }

    /**
     * Render a SelectFilter into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FilterInterface $filter
     * @return string
     */
    public function visitSelectFilter(FilterInterface $filter)
    {
        return $this->visitFilterOfType($filter, "select");
    }

    /**
     * Render a DummyFilter into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FilterInterface $filter
     * @return string
     */
    public function visitDummyFilter(FilterInterface $filter)
    {
        return "";
    }

    /**
     * Render a FilterInterface into html.
     *
     * This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.
     *
     * @param FilterInterface $filter
     * @return string
     */
    public function visitFilter(FilterInterface $filter)
    {
        return $this->visitFilterOfType($filter);
    }

    /**
     * Helper method to render a FilterInterface to html.
     *
     * @param FilterInterface $filter
     * @param string          $type
     * @return string
     */
    protected function visitFilterOfType(FilterInterface $filter, $type = "base")
    {
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
}
