<?php

namespace UWDOEM\Framework\Writer;

use Twig_SimpleFilter;

use UWDOEM\Framework\Etc\SafeString;
use UWDOEM\Framework\Field\FieldInterface;
use UWDOEM\Framework\Filter\PaginationFilter;
use UWDOEM\Framework\Filter\SortFilter;
use UWDOEM\Framework\Form\FormInterface;
use UWDOEM\Framework\Form\FormAction\FormActionInterface;
use UWDOEM\Framework\Form\PickAFormInterface;
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


class Writer extends Visitor {

    protected $_environment;

    protected function getTemplatesDirectories() {
        return array_merge(Settings::getTemplateDirectories(), [dirname(__FILE__) . '/templates/base']);
    }

    protected function write(WritableInterface $host) {
        return $host->accept($this);
    }

    protected function getEnvironment() {
        if (!isset($this->_environment)) {
            $loader = new \Twig_Loader_Filesystem($this->getTemplatesDirectories());
            $this->_environment = new \Twig_Environment($loader);

            $filter = new Twig_SimpleFilter('write', function(WritableInterface $host) { return $host->accept($this); });
            $this->_environment->addFilter($filter);

            $filter = new Twig_SimpleFilter('slugify', function($string) { return StringUtils::slugify($string); });
            $this->_environment->addFilter($filter);

            $filter = new Twig_SimpleFilter('md5', function($string) { return md5($string); });
            $this->_environment->addFilter($filter);

            $filter = new Twig_SimpleFilter('stripForm', function($string) {
                $string = preg_replace('/<form[^>]+\>/i', "", $string);
                $string = preg_replace('#<div class="form-actions">(.*?)</div>#', '', $string);
                $string = str_replace("form-actions", "form-actions hidden", $string);
                $string = str_replace("</form>", "", $string);

                return $string;
            });
            $this->_environment->addFilter($filter);

            $filter = new Twig_SimpleFilter(
                'saferaw',
                function($string) {
                    if ( $string instanceof SafeString ) {
                        $string = (string)$string;
                    } else {
                        $string = htmlentities($string);
                    }

                    return $string;
                });
            $this->_environment->addFilter($filter);

            $requestURI = array_key_exists("REQUEST_URI", $_SERVER) ? $_SERVER["REQUEST_URI"] : "";
            $this->_environment->addGlobal("requestURI", $requestURI);
        }

        return $this->_environment;
    }

    protected function loadTemplate($subpath) {
        return $this->getEnvironment()->loadTemplate($subpath);
    }

    public function visitSection(SectionInterface $section) {

        $template = 'section/' . $section->getType() . '.twig';

        return $this
            ->loadTemplate($template)
            ->render([
                "label" => $section->getLabel(),
                "content" => $section->getContent(),
                "writables" => $section->getWritables(),
            ]);
    }

    public function visitPage(PageInterface $page) {
        $template = 'page/' . $page->getType() . '.twig';

        $writable = $page->getWritable();

        if ($writable) {
            $content = $writable->accept($this);
        } else {
            $content = "";
        }

        return $this
            ->loadTemplate($template)
            ->render([
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
            ]);
    }

    public function visitField(FieldInterface $field) {
        $template = 'field/' . $field->getType() . '.twig';

        if ($field->getType() === Field::FIELD_TYPE_CHOICE || $field->getType() === Field::FIELD_TYPE_MULTIPLE_CHOICE) {
            $choices = array_combine($field->getChoiceSlugs(), $field->getChoices());
        } else {
            $choices = [];
        }

        return $this
            ->loadTemplate($template)
            ->render([
                "slug" => $field->getSlug(),
                "initial" => $field->getInitial(),
                "choices" => $choices,
                "label" => $field->getLabel(),
                "required" => $field->isRequired(),
                "size" => $field->getSize(),
                "errors" => $field->getErrors()
            ]);
    }

    public function visitRow(RowInterface $row) {
        $template = 'row/base.twig';

        return $this
            ->loadTemplate($template)
            ->render([
                "visibleFields" => $row->getFieldBearer()->getVisibleFields(),
                "hiddenFields" => $row->getFieldBearer()->getHiddenFields(),
                "highlightable" => $row->isHighlightable(),
                "onClick" => $row->getOnClick(),
            ]);
    }

    public function visitTable(TableInterface $table) {
        $template = 'table/base.twig';

        $filters = [];
        for ($thisFilter = $table->getFilter(); $thisFilter !== null; $thisFilter = $thisFilter->getNextFilter()) {
            $filters[] = $thisFilter;
        }

        return $this
            ->loadTemplate($template)
            ->render([
                "rows" => $table->getRows(),
                "filters" => $filters,
            ]);
    }

    public function visitPaginationFilter(PaginationFilter $filter) {
        $type = $filter->getType();

        return $this->visitFilterOfType($filter, "$type-pagination");
    }

    public function visitSortFilter(SortFilter $filter) {
        return $this->visitFilterOfType($filter, "sort");
    }

    public function visitSearchFilter(SearchFilter $filter) {
        return $this->visitFilterOfType($filter, "search");
    }

    public function visitStaticFilter(FilterInterface $filter) {
        return $this->visitFilterOfType($filter, "static");
    }

    public function visitSelectFilter(FilterInterface $filter) {
        return $this->visitFilterOfType($filter, "select");
    }

    public function visitDummyFilter(FilterInterface $filter) {
    }

    public function visitFilter(FilterInterface $filter) {
        return $this->visitFilterOfType($filter);
    }

    protected function visitFilterOfType(FilterInterface $filter, $type="base") {
        $template = "filter/$type.twig";

        return $this
            ->loadTemplate($template)
            ->render([
                "handle" => $filter->getHandle() ,
                "options" => $filter->getOptions(),
            ]);
    }

    public function visitForm(FormInterface $form) {
        $template = 'form/base.twig';

        return $this
            ->loadTemplate($template)
            ->render([
                "hash" => $form->getHash(),
                "visibleFields" => $form->getFieldBearer()->getVisibleFields(),
                "hiddenFields" => $form->getFieldBearer()->getHiddenFields(),
                "actions" => $form->getActions(),
                "errors" => $form->getErrors(),
                "subForms" => $form->getSubForms()
            ]);
    }

    public function visitFormAction(FormActionInterface $formAction) {
        $template = 'form-action/base.twig';

        return $this
            ->loadTemplate($template)
            ->render([
                "label" => $formAction->getLabel(),
                "method" => $formAction->getMethod(),
                "target" => $formAction->getTarget(),
            ]);
    }

    public function visitPickA(PickAInterface $pickA) {
        $template = 'pick-a/base.twig';

        return $this
            ->loadTemplate($template)
            ->render([
                "manifest" => $pickA->getManifest(),
                "hash" => $pickA->getHash()
            ]);
    }

    public function visitPickAForm(PickAFormInterface $pickAForm) {
        $template = 'form/pick-a-form.twig';

        return $this
            ->loadTemplate($template)
            ->render([
                "manifest" => $pickAForm->getManifest(),
                "selectedForm" => $pickAForm->getSelectedForm(),
                "hash" => $pickAForm->getHash()
            ]);
    }
}