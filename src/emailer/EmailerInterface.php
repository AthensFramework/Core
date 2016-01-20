<?php

namespace UWDOEM\Framework\Emailer;

use UWDOEM\Framework\Email\EmailInterface;
use UWDOEM\Framework\Writer\Writer;

interface EmailerInterface
{

    /**
     * @param EmailInterface $email
     * @param Writer|null    $writer
     * @return boolean
     */
    public function send(EmailInterface $email, Writer $writer);
}
