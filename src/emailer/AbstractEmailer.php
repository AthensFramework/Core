<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Settings\Settings;
use Athens\Core\Writer\WriterInterface;
use Athens\Core\Visitor\VisitableInterface;

/**
 * Class AbstractEmailer provides the framework for rendering an email body before
 * sending it.
 *
 * @package Athens\Core\Emailer
 */
abstract class AbstractEmailer implements EmailerInterface
{
    /** @var WriterInterface[] $writer */
    protected $writers;

    /**
     * AbstractEmailer constructor.
     *
     * @param WriterInterface[] $writers
     */
    public function __construct(array $writers)
    {
        $this->writers = $writers;
    }

    /**
     * Each Emailer must have a ::doSend which performs the actual sending of
     * the email.
     *
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    abstract protected function doSend($body, EmailInterface $email);

    /**
     * @param EmailInterface $visitable
     * @return void
     */
    public function visit(EmailInterface $visitable)
    {
        $this->send($visitable);
    }

    /**
     * Invoke the Emailer's ::doSend method.
     *
     * @param EmailInterface $email
     * @return boolean
     */
    public function send(EmailInterface $email)
    {
        foreach ($this->writers as $writer) {
            $content = $email->accept($writer);

            if ($content !== null) {
                return $this->doSend($content, $email);
            }
        }

        throw new \RuntimeException(
            "No visit method for " . get_class($email) . " found among writers."
        );
    }
}
