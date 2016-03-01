<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Etc\Settings;
use Athens\Core\Writer\Writer;

/**
 * Class AbstractEmailer provides the framework for rendering an email body before
 * sending it.
 *
 * @package Athens\Core\Emailer
 */
abstract class AbstractEmailer implements EmailerInterface
{

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
     * Invoke the Emailer's ::doSend method.
     *
     * @param EmailInterface $email
     * @param Writer|null    $writer
     * @return boolean
     */
    public function send(EmailInterface $email, Writer $writer = null)
    {
        if ($writer === null) {
            $writer = Settings::getDefaultWriterClass();
            $writer = new $writer();
        }
        $body = $email->accept($writer);

        return $this->doSend($body, $email);
    }
}
