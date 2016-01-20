<?php

namespace UWDOEM\Framework\Emailer;

use UWDOEM\Framework\Email\EmailInterface;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\Writer\Writer;

/**
 * Class AbstractEmailer provides the framework for rendering an email body before
 * sending it.
 *
 * @package UWDOEM\Framework\Emailer
 */
abstract class AbstractEmailer implements EmailerInterface
{

    /**
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    abstract protected function doSend($body, EmailInterface $email);

    /**
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
