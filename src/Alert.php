<?php

namespace Cpeter\PhpCmsVersionChecker;

use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class Alert 
{

    protected static $instance;
    protected $mailer;
    
    public static function getInstance($configuration)
    {
        if (self::$instance == null) {

            // Create the Transport
            $transport = Swift_SmtpTransport::newInstance();

            // Create the Mailer using your created Transport
            $mailer = Swift_Mailer::newInstance($transport);
            
            self::$instance = new self();
            self::$instance->mailer = $mailer;
        }

        return static::$instance;
    }
    
    public function send($cms, $version_id)
    {

        // Create a message. Here we could use tempaltes if we want to.
        $message = Swift_Message::newInstance('Wonderful Subject')
            ->setFrom(array('john@doe.com' => 'John Doe'))
            ->setTo(array('receiver@domain.org', 'other@domain.org' => 'A name'))
            ->setBody('Here is the message itself')
        ;


        // Send the message
        $numSent = $this->mailer->send($message);

        return $numSent;
    }
}
