<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Writer\WriterInterface;

interface EmailerInterface
{

    /**
     * @param EmailInterface  $email
     * @param WriterInterface[] $writer
     * @return boolean
     */
    public function send(EmailInterface $email, array $writer);
}
