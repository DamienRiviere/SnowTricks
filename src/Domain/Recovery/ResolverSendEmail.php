<?php

namespace App\Domain\Recovery;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class ResolverSendEmail
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var UserRepository */
    protected $userRepo;

    /** @var EntityManagerInterface */
    protected $em;

    /** @var FlashBagInterface */
    protected $flash;

    /** @var MailerInterface */
    protected $mailer;

    public function __construct(
        FormFactoryInterface $formFactory,
        UserRepository $userRepo,
        EntityManagerInterface $em,
        FlashBagInterface $flash,
        MailerInterface $mailer
    ) {
        $this->formFactory = $formFactory;
        $this->userRepo = $userRepo;
        $this->em = $em;
        $this->flash = $flash;
        $this->mailer = $mailer;
    }

    public function getFormType(Request $request)
    {
        return $this->formFactory->create(SendEmailType::class)
                                 ->handleRequest($request);
    }

    public function saveRecovery(SendEmailDTO $email)
    {
        $user = $this->userRepo->findOneBy(['email' => $email->getEmail()]);

        if (!is_null($user)) {
            $user
                ->setRecoveryToken($user->getName() . '-' . uniqid())
                ->setRecoveryDate(new \DateTime());

            $this->em->flush();
        }

        return $user;
    }

    public function sendEmail(SendEmailDTO $email, User $user)
    {
        $email = (new TemplatedEmail())
            ->from('damien@d-riviere.fr')
            ->to(new Address($email->getEmail()))
            ->subject('Récupération du mot de passe !')
            ->htmlTemplate('recovery/recovery_email.html.twig')
            ->context(
                [
                    'user' => $user
                ]
            )
        ;

        $this->mailer->send($email);
    }

    public function checkUserAndSendEmail(?User $user, SendEmailDTO $email)
    {
        if (!is_null($user)) {
            $this->sendEmail($email, $user);
        }
    }

    public function getFlashMessage()
    {
        return $this->flash->add(
            'bg-success',
            'Vous allez recevoir un mail avec un lien de 
            réinitialisation de votre mot de passe dans quelques instants !'
        );
    }
}
