<?php

namespace Athens\Core\Email;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writer\WritableTrait;

/**
 * Class Email encapsulates the data which consitutes an email.
 *
 * @package Athens\Core\Email
 */
class Email implements EmailInterface
{
    /** @var string */
    protected $type;

    /** @var string */
    protected $subject;

    /** @var string */
    protected $message;

    /** @var string */
    protected $to;

    /** @var string */
    protected $from;

    /** @var string */
    protected $cc;

    /** @var string */
    protected $bcc;

    /** @var string */
    protected $xMailer;

    /** @var string */
    protected $contentType;

    /** @var string */
    protected $mimeVersion;

    use WritableTrait;
    use VisitableTrait;

    /**
     * Email constructor.
     *
     * @param string $type
     * @param string $subject
     * @param string $message
     * @param string $to
     * @param string $from
     * @param string $cc
     * @param string $bcc
     * @param string $xMailer
     * @param string $contentType
     * @param string $mimeVersion
     */
    public function __construct($type, $subject, $message, $to, $from, $cc, $bcc, $xMailer, $contentType, $mimeVersion)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->to = $to;
        $this->from = $from;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->xMailer = $xMailer;
        $this->contentType = $contentType;
        $this->mimeVersion = $mimeVersion;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @return string
     */
    public function getBcc()
    {
        return $this->bcc;
    }

    /**
     * @return string
     */
    public function getXMailer()
    {
        return $this->xMailer;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @return string
     */
    public function getMimeVersion()
    {
        return $this->mimeVersion;
    }
}
