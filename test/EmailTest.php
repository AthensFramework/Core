<?php

namespace Athens\Core\Test;

use Athens\Core\Writer\EmailWriter;
use PHPUnit_Framework_TestCase;

use Athens\Core\Email\EmailBuilder;

use Athens\Core\Test\Mock\MockEmailer;

class EmailTest extends PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {
        $type = "t" . (string)rand();
        $subject = "t" . (string)rand();
        $message = "t" . (string)rand();
        $to = "t" . (string)rand();
        $to2 = "t" . (string)rand();
        $from = "t" . (string)rand();
        $replyTo = "t" . (string)rand();
        $cc = "t" . (string)rand();
        $cc2 = "t" . (string)rand();
        $bcc = "t" . (string)rand();
        $bcc2 = "t" . (string)rand();
        $xmailer = "t" . (string)rand();
        $contentType = "t" . (string)rand();
        $mimeVersion = "t" . (string)rand();

        $email = EmailBuilder::begin()
            ->setType($type)
            ->setSubject($subject)
            ->setMessage($message)
            ->addTo($to)
            ->addTo($to2)
            ->setFrom($from)
            ->setReplyTo($replyTo)
            ->addCc($cc)
            ->addCc($cc2)
            ->addBcc($bcc)
            ->addBcc($bcc2)
            ->setXMailer($xmailer)
            ->setContentType($contentType)
            ->setMimeVersion($mimeVersion)
            ->build();

        $this->assertEquals($type, $email->getType());
        $this->assertEquals($subject, $email->getSubject());
        $this->assertEquals($message, $email->getMessage());
        $this->assertEquals(implode('; ', [$to, $to2]), $email->getTo());
        $this->assertEquals($from, $email->getFrom());
        $this->assertEquals($replyTo, $email->getReplyTo());
        $this->assertEquals(implode('; ', [$cc, $cc2]), $email->getCc());
        $this->assertEquals(implode('; ', [$bcc, $bcc2]), $email->getBcc());
        $this->assertEquals($xmailer, $email->getXMailer());
        $this->assertEquals($contentType, $email->getContentType());
        $this->assertEquals($mimeVersion, $email->getMimeVersion());
    }

    public function testLiteralMessageSetting()
    {
        $message = "Test content.\n\nA second paragraph.";

        $email = EmailBuilder::begin()
            ->setLiteralMessage($message)
            ->build();

        $this->assertEquals($message, (string)$email->getMessage());
    }

    public function testNonLiteralMessageSetting()
    {
        $message = "Test content.\n\nA second paragraph.";

        $email = EmailBuilder::begin()
            ->setMessage($message)
            ->build();

        $this->assertEquals(nl2br($message), (string)$email->getMessage());
    }

    public function testEmailer()
    {
        $subject = "type" . (string)rand();
        $message = "message" . (string)rand();
        $to = "to" . (string)rand();
        $from = "from" . (string)rand();
        $cc = "cc" . (string)rand();
        $bcc = "bcc" . (string)rand();
        $xmailer = "xmailer" . (string)rand();
        $contentType = "contentType" . (string)rand();
        $mimeVersion = "mimeVersion" . (string)rand();

        $email = EmailBuilder::begin()
            ->setSubject($subject)
            ->setMessage($message)
            ->addTo($to)
            ->setFrom($from)
            ->addCc($cc)
            ->addBcc($bcc)
            ->setXMailer($xmailer)
            ->setContentType($contentType)
            ->setMimeVersion($mimeVersion)
            ->build();

        $emailer = new MockEmailer([new EmailWriter()]);
        $emailer->send($email);

        $result = $emailer->sent[0];

        $this->assertContains($subject, $result);
        $this->assertContains($message, $result);
        $this->assertContains($to, $result);
        $this->assertContains($from, $result);
        $this->assertContains($cc, $result);
        $this->assertContains($bcc, $result);
        $this->assertContains($xmailer, $result);
        $this->assertContains($contentType, $result);
        $this->assertContains($mimeVersion, $result);
    }
}
