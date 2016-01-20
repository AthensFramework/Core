<?php

namespace UWDOEM\Framework\Emailer;

use UWDOEM\Framework\Email\EmailInterface;

/**
 * Class PhpEmailer provides an EmailerInterface for PHP's mail method.
 *
 * @package UWDOEM\Framework\Emailer
 */
class PhpEmailer extends AbstractEmailer
{

    /**
     * @param EmailInterface $email
     * @return string
     */
    protected function buildHeaders(EmailInterface $email)
    {
        $headers = ["From: " . $email->getFrom(), ];

        if ($email->getMimeVersion() !== null) {
            $headers[] = "MIME-VERSION: " . $email->getMimeVersion();
        }

        if ($email->getContentType() !== null) {
            $headers[] = "Content-type: " . $email->getContentType();
        }

        if ($email->getCc() !== null) {
            $headers[] = "Cc: " . $email->getCc();
        }

        if ($email->getBcc() !== null) {
            $headers[] = "Bcc: " . $email->getBcc();
        }

        if ($email->getXMailer() !== null) {
            $headers[] = "X-Mailer: " . $email->getXMailer();
        }

        return implode("\r\n", $headers);
    }

    /**
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    protected function doSend($body, EmailInterface $email)
    {
        return mail($email->getTo(), $email->getSubject(), $body, $this->buildHeaders($email));
    }
}
