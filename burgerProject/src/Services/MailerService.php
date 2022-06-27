<?php
namespace App\Services;

use Twig\Environment;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailerService{

    private MailerInterface $mailer;
    private Environment $twig;

    public function __construct(MailerInterface $mailer,Environment $twig)
    {
        $this->mailer= $mailer;
        $this->twig = $twig;
    }

    public function sendMail($user,$object='compte'){
        $emails= (new Email())

        ->from('rpd@gmail.com')
        ->to($user->getUsername())
        ->subject($object)
        ->html($this->twig->render("mail/index.html.twig",[
            "user"=>$user
        ]));
        $this->mailer->send($emails);


    
    }

}