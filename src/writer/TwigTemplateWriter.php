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
use Athens\Core\FormAction\FormActionInterface;
use Athens\Core\Section\SectionInterface;
use Athens\Core\Page\PageInterface;
use Athens\Core\Row\RowInterface;
use Athens\Core\Table\TableInterface;
use Athens\Core\Settings\Settings;
use Athens\Core\Etc\StringUtils;
use Athens\Core\Link\LinkInterface;
use Athens\Core\Filter\FilterInterface;
use Athens\Core\Filter\SearchFilter;
use Athens\Core\Writable\WritableInterface;

/**
 * Class TwigTemplateWriter is an abstract class which provides methods for writing from twig
 * templates.
 *
 * @package Athens\Core\Writer
 */
abstract class TwigTemplateWriter extends AbstractWriter
{
    /** @var \Twig_Environment */
    protected $environment;

    /**
     * @return string[] An array containing all Framework-registered Twig template directories.
     */
    protected function getTemplatesDirectories()
    {
        return array_merge(Settings::getInstance()->getTemplateDirectories(), [dirname(__FILE__) . '/../../templates']);
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
                'html_attribute',
                function ($string) {
                    return preg_replace(array('/[^a-zA-Z0-9 -]/','/^-|-$/'), array('',''), $string);
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

            $filter = new Twig_SimpleFilter(
                'writedata',
                function ($data) {
                    $string = ' ';

                    foreach ($data as $key => $value) {
                        $key = htmlentities($key);
                        $value = htmlentities($value);

                        $string .= "data-$key=\"$value\" ";
                    }

                    return trim($string);
                }
            );
            $this->environment->addFilter($filter);

            $requestURI = array_key_exists("REQUEST_URI", $_SERVER) === true ? $_SERVER["REQUEST_URI"] : "";
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
}
