<?php

namespace Athens\Core\Email;

use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Etc\SafeString;

/**
 * 
 * Class EmailBuilder
 * 
 * Build emails which satisfy Athens\Core\Email\EmailInterface
 * 
 * Example example of some more narrative documentation talking
 * about building html vs plain text emails.
 * 
 * Building a plain text email :
 * ```
 *  //namespaces
 *  use Athens\Core\Email\EmailBuilder;
 *  use Athens\SendGrid\Emailer;
 *  
 *  // creating the email 
 *  $email = EmailBuilder::begin()
 *    ->setTo($yourEmail)
 *    ->setFrom('my.awesome.email@gmail.com')
 *    ->setSubject('[INFO]: This will be the subject line')
 *    ->setMessage('Hey there buddy, you are awesome!')
 *    ->setType("base") 
 *    ->build();
 * 
 *  //sending the email
 *  $emailer = new Emailer();
 *  $emailer->send($email);
 * ```
 * You may set the type either to base or html, letting Athens know what type of email you would like to send.
 * 
 * Building an html email :
 * ```
 *  //namespaces
 *  use Athens\Core\Email\EmailBuilder;
 *  use Athens\SendGrid\Emailer;
 *  
 *  // creating the email 
 *  $email = EmailBuilder::begin()
 *    ->setTo($yourEmail)
 *    ->setFrom('my.awesome.email@gmail.com')
 *    ->setSubject('[INFO]: This will be the subject line')
 *    ->setType("html")
 *    ->setContentType('text/html; charset=UTF-8 ')
 *    ->setMessage($htmlMessage)
 *    ->build();
 * 
 *  //sending the email
 *  $emailer = new Emailer();
 *  $emailer->send($email);
 * ```
 * Other than setting the type to html, we also need to setContentType to 'text/html; charset=UTF-8' so that the 
 * email clients will know to expect an html email. 
 * 
 * @package Athens\Core\Email
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
