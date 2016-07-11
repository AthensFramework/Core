<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Settings\Settings;
use Athens\Core\Writer\HTMLWriter;

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
     * @param EmailInterface  $email
     * @param HTMLWriter|null $writer
     * @return boolean
     */
    public function send(EmailInterface $email, HTMLWriter $writer = null)
    {
        if ($writer === null) {
            $writer = Settings::getInstance()->getDefaultWriterClass();
            $writer = new $writer();
        }
        $body = $email->accept($writer);

        return $this->doSend($body, $email);
    }
}
