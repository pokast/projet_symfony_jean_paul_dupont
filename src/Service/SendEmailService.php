<?php

namespace App\Service;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

    class SendEmailService
    {
        private MailerInterface $mailer;

        public function __construct(MailerInterface $mailer)
        {
            $this->mailer = $mailer;
        }

        public function send(array $data)
        {
            $sender_email        = $data['sender_email'];
            $sender_name         = $data['sender_name'];
            $recipient_email     = $data['recipient_email'];
            $subject             = $data['subject'];
            $html_template       = $data['html_template'];
            $context             = $data['context'];
            
            $email = new TemplatedEmail();

            $email->from(new Address($sender_email, $sender_name))
                  ->to($recipient_email)
                  ->subject($subject)            // Sujet de l'email
                  ->htmlTemplate($html_template) // Contenu de l'email en lui même
                  ->context($context)
                  ;
                  
                  try 
                  {
                      $this->mailer->send($email);
                  } 
                  catch (TransportExceptionInterface $te) 
                  {
                      throw $te;
                        
                  }
        }
    }
