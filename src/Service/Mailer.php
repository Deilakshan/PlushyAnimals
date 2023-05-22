<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class Mailer
{
    private $mailer;

    //classe est instanciée
    public function __construct(MailerInterface $mailer)
    {   
        // stocker dans la propriété $mailer un MailerInterface
        $this->mailer = $mailer;
    }

    public function sendEmail()
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('r.deilakshan@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Hello World')
            ->text('Sending emails is fun again!')
            ->html('<p>We have won the house</p>');

        $this->mailer->send($email);

        // ...

    }
}