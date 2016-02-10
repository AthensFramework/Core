<?php

namespace UWDOEM\Framework\Email;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Etc\SafeString;

/**
 * Class EmailBuilder
 *
 * @package UWDOEM\Framework\Email
 */
class EmailBuilder extends AbstractBuilder
{

    /** @var string */
    protected $type = "base";

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

    /**
     * @param string $type
     * @return EmailBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $subject
     * @return EmailBuilder
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param string $message
     * @return EmailBuilder
     */
    public function setMessage($message)
    {
        if (($message instanceof SafeString) === false) {
            $message = htmlentities($message);
        }
        $message = SafeString::fromString(nl2br($message));

        return $this->setLiteralMessage($message);
    }

    /**
     * @param string $message
     * @return EmailBuilder
     */
    public function setLiteralMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param string $to
     * @return EmailBuilder
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @param string $from
     * @return EmailBuilder
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @param string $cc
     * @return EmailBuilder
     */
    public function setCc($cc)
    {
        $this->cc = $cc;
        return $this;
    }

    /**
     * @param string $bcc
     * @return EmailBuilder
     */
    public function setBcc($bcc)
    {
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @param string $xMailer
     * @return EmailBuilder
     */
    public function setXMailer($xMailer)
    {
        $this->xMailer = $xMailer;
        return $this;
    }

    /**
     * @param string $contentType
     * @return EmailBuilder
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @param string $mimeVersion
     * @return EmailBuilder
     */
    public function setMimeVersion($mimeVersion)
    {
        $this->mimeVersion = $mimeVersion;
        return $this;
    }

    /**
     * @return Email
     */
    public function build()
    {
        return new Email(
            $this->type,
            $this->subject,
            $this->message,
            $this->to,
            $this->from,
            $this->cc,
            $this->bcc,
            $this->xMailer,
            $this->contentType,
            $this->mimeVersion
        );
    }
}
