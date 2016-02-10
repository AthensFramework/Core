<?php

namespace UWDOEM\Framework\Test;

use PHPUnit_Framework_TestCase;

use UWDOEM\Framework\Email\EmailBuilder;

use UWDOEM\Framework\Test\Mock\MockEmailer;

class EmailTest extends PHPUnit_Framework_TestCase
{

    public function testBuilder()
    {
        $type = "t" . (string)rand();
        $subject = "t" . (string)rand();
        $message = "t" . (string)rand();
        $to = "t" . (string)rand();
        $from = "t" . (string)rand();
        $cc = "t" . (string)rand();
        $bcc = "t" . (string)rand();
        $xmailer = "t" . (string)rand();
        $contentType = "t" . (string)rand();
        $mimeVersion = "t" . (string)rand();

        $email = EmailBuilder::begin()
            ->setType($type)
            ->setSubject($subject)
            ->setMessage($message)
            ->setTo($to)
            ->setFrom($from)
            ->setCc($cc)
            ->setBcc($bcc)
            ->setXMailer($xmailer)
            ->setContentType($contentType)
            ->setMimeVersion($mimeVersion)
            ->build();

        $this->assertEquals($type, $email->getType());
        $this->assertEquals($subject, $email->getSubject());
        $this->assertEquals($message, $email->getMessage());
        $this->assertEquals($to, $email->getTo());
        $this->assertEquals($from, $email->getFrom());
        $this->assertEquals($cc, $email->getCc());
        $this->assertEquals($bcc, $email->getBcc());
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
            ->setTo($to)
            ->setFrom($from)
            ->setCc($cc)
            ->setBcc($bcc)
            ->setXMailer($xmailer)
            ->setContentType($contentType)
            ->setMimeVersion($mimeVersion)
            ->build();

        $emailer = new MockEmailer();
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
