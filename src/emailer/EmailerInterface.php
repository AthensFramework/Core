<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Writer\Writer;

interface EmailerInterface
{

    /**
     * @param EmailInterface $email
     * @param Writer|null    $writer
     * @return boolean
     */
    public function send(EmailInterface $email, Writer $writer);
}
