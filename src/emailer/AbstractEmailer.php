<?php

namespace Athens\Core\Emailer;

use Athens\Core\Email\EmailInterface;
use Athens\Core\Settings\Settings;
use Athens\Core\Writer\WriterInterface;

/**
 * Class AbstractEmailer provides the framework for rendering an email body before
 * sending it.
 *
 * @package Athens\Core\Emailer
 */
abstract class AbstractEmailer implements EmailerInterface
{

    /**
     * Each Emailer must have a ::doSend which performs the actual sending of
     * the email.
     *
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    abstract protected function doSend($body, EmailInterface $email);

    /**
     * Invoke the Emailer's ::doSend method.
     *
     * @param EmailInterface    $email
     * @param WriterInterface[] $writers
     * @return boolean
     */
    public function send(EmailInterface $email, array $writers = [])
    {
        if ($writers === []) {
            $writerClasses = Settings::getInstance()->getDefaultWriterClasses();
            
            $writers = [];
            foreach ($writerClasses as $writerClass) {
                $writers[] = new $writerClass();
            }
        }

        foreach ($writers as $writer) {
            $body = $email->accept($writer);
    
            if ($body !== null) {
                return $this->doSend($body, $email);
            }
        }

        throw new \RuntimeException(
            "No visit method for " . get_class($email) . " found among writers."
        );
    }
}
