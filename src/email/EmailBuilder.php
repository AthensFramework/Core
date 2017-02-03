<?php

namespace Athens\Core\Email;

use Athens\Core\Emailer\EmailerInterface;
use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Etc\SafeString;

/**
 *
 * Class EmailBuilder
 *
 * Build emails which satisfy Athens\Core\Email\EmailInterface
 *
 * You may set the type either to base or html, letting Athens know what type of email you would like to send.
 *
 * Building a plain text email:
 * ```
 *  // creating the email
 *  $email = EmailBuilder::begin()
 *    ->setType('base')
 *    ->setTo('recipient@example.com')
 *    ->setFrom('sender@example.com')
 *    ->setSubject('This will be the subject line')
 *    ->setMessage('Hey there buddy, you are awesome!')
 *    ->build();
 * ```
 *
 * Building an html email:
 * ```
 *  //namespaces
 *  use Athens\Core\Email\EmailBuilder;
 *  use Athens\SendGrid\Emailer;
 *
 *  // creating the email
 *  $email = EmailBuilder::begin()
 *    ->setType('html')
 *    ->setContentType('text/html; charset=UTF-8')
 *    ->setTo('recipient@example.com')
 *    ->setFrom('sender@example.com')
 *    ->setSubject('This will be the subject line')
 *    ->setMessage('Hey there buddy, you are awesome!')
 *    ->build();
 *
 *  //sending the email
 *  $emailer = new Emailer();
 *  $emailer->send($email);
 * ```
 * Other than setting the type to 'html', we also need to setContentType to 'text/html; charset=UTF-8'
 * so that the recipient's email client will know to render the message as html.
 *
 * @package Athens\Core\Email
 */
class EmailBuilder extends AbstractWritableBuilder
{

    /** @var string */
    protected $type = "base";

    /** @var string */
    protected $subject;

    /** @var string */
    protected $message;

    /** @var string[] */
    protected $to = [];

    /** @var string */
    protected $from;

    /** @var string */
    protected $replyTo;

    /** @var string[] */
    protected $cc = [];

    /** @var string[] */
    protected $bcc = [];

    /** @var string */
    protected $xMailer;

    /** @var string */
    protected $contentType;

    /** @var string */
    protected $mimeVersion;
    
    /** @var EmailerInterface */
    protected $emailer;

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
    public function addTo($to)
    {
        $this->to[] = $to;
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
     * @param string $replyTo
     * @return EmailBuilder
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    /**
     * @param string $cc
     * @return EmailBuilder
     */
    public function addCc($cc)
    {
        $this->cc[] = $cc;
        return $this;
    }

    /**
     * @param string $bcc
     * @return EmailBuilder
     */
    public function addBcc($bcc)
    {
        $this->bcc[] = $bcc;
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
     * Construct a emailer from setting defaults, if none has been provided.
     *
     * @return void
     */
    protected function validateEmailer()
    {
        if ($this->emailer === null) {
            $settingsInstance = $this->getSettingsInstance();

            $writerClasses = $settingsInstance->getDefaultEmailWriterClasses();
            $emailerClass = $settingsInstance->getDefaultEmailerClass();

            $writerInstances = [];
            foreach ($writerClasses as $writerClass) {
                $writerInstances[] = new $writerClass();
            }

            $this->emailer = new $emailerClass($writerInstances);
        }
    }

    /**
     * @return Email
     */
    public function build()
    {
        $this->validateEmailer();
        
        return new Email(
            $this->type,
            $this->subject,
            $this->message,
            implode('; ', $this->to),
            $this->from,
            $this->replyTo,
            implode('; ', $this->cc),
            implode('; ', $this->bcc),
            $this->xMailer,
            $this->contentType,
            $this->mimeVersion,
            $this->emailer
        );
    }
}
