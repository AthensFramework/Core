<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Writer\HTMLWriter;

interface EmailerInterface
{

    /**
     * @param EmailInterface $email
     * @param HTMLWriter|null    $writer
     * @return boolean
     */
    public function send(EmailInterface $email, HTMLWriter $writer);
}
