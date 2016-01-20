<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEM\Framework\Emailer\PhpEmailer;
use UWDOEM\Framework\Email\EmailInterface;

class MockEmailer extends PhpEmailer
{

    /** @var string[] */
    public $sent = [];

    /**
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    public function doSend($body, EmailInterface $email)
    {
        $message = "To: " . $email->getTo() . "\r\n";
        $message .= "Subject: " . $email->getSubject() . "\r\n";
        $message .= $this->buildHeaders($email) . "\r\n";
        $message .= $body;

        $this->sent[] = $message;

        return true;
    }
}
