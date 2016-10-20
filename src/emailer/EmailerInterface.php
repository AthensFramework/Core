<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;

interface EmailerInterface
{

    /**
     * @param EmailInterface $email
     * @return boolean
     */
    public function send(EmailInterface $email);
}
