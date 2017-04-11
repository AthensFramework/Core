<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Visitor\VisitorInterface;

interface EmailerInterface extends VisitorInterface
{

    /**
     * @param EmailInterface $email
     * @return boolean
     */
    public function send(EmailInterface $email);
}
