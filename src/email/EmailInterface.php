<?php

namespace Athens\Core\Email;

use Athens\Core\Writer\WritableInterface;
use Athens\Core\Writer\Writer;
use Athens\Core\Emailer\EmailerInterface;

interface EmailInterface extends WritableInterface
{

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return string
     */
    public function getTo();

    /**
     * @return string
     */
    public function getFrom();

    /**
     * @return string
     */
    public function getCc();

    /**
     * @return string
     */
    public function getBcc();

    /**
     * @return string
     */
    public function getXMailer();

    /**
     * @return string
     */
    public function getContentType();

    /**
     * @return string
     */
    public function getMimeVersion();
}
