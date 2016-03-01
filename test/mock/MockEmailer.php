<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Email\EmailInterface;

class MockEmailer extends LoggingEmailer
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
        $this->sent[] = $this->buildMessage($body, $email);

        return true;
    }
}
