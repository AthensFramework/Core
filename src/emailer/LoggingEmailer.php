<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Emailer\PhpEmailer;
use Athens\Core\Email\EmailInterface;

/**
 * Class LoggingEmailer Sends emails by logging them to the error log.
 *
 * @package Athens\Core\Test\Mock
 */
class LoggingEmailer extends PhpEmailer
{

    /**
     * Constructs a single string from the email body and headers.
     *
     * @param string         $body
     * @param EmailInterface $email
     * @return string
     */
    protected function buildMessage($body, EmailInterface $email)
    {
        $message = "To: " . $email->getTo() . "\r\n";
        $message .= "Subject: " . $email->getSubject() . "\r\n";
        $message .= $this->buildHeaders($email) . "\r\n";
        $message .= $body;

        return $message;
    }

    /**
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    protected function doSend($body, EmailInterface $email)
    {
        error_log($this->buildMessage($body, $email));
        return true;
    }
}
