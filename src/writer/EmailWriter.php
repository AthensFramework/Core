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
 * Class EmailWriter is a visitor which writes emails.
 *
 * @package Athens\Core\Writer
 */
class EmailWriter extends TwigTemplateWriter
{
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
