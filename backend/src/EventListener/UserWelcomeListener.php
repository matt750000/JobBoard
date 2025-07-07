<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

#[AsEntityListener(Events::postPersist, method: 'sendWelcomeEmail', entity: User::class)]
final class UserWelcomeListener
{
    public function __construct(
        private MailerInterface $mailer,

        #[Autowire(env: 'MAIL_SUBJECT')]
        private string $mailSubject
    )
    {
    }

    public function sendWelcomeEmail(User $user): void
    {
        $email = (new TemplatedEmail())
            ->to(new Address($user->getEmail()))
            ->subject($this->mailSubject)
            ->htmlTemplate('emails/welcome.html.twig')
            ->context([
                'user' => $user,
            ])
        ;

        $this->mailer->send($email);
    }
}
