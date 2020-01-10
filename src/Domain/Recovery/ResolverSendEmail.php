<?php

namespace App\Domain\Recovery;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Twig\Environment;

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

    /** @var Environment */
    protected $templating;

    /** @var Swift_Mailer */
    protected $mailer;

    public function __construct(
        FormFactoryInterface $formFactory,
        UserRepository $userRepo,
        EntityManagerInterface $em,
        FlashBagInterface $flash,
        Environment $templating,
        Swift_Mailer $mailer
    ) {
        $this->formFactory = $formFactory;
        $this->userRepo = $userRepo;
        $this->em = $em;
        $this->flash = $flash;
        $this->templating = $templating;
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
        $message = (new Swift_Message('Récupération du mot de passe !'))
            ->setFrom("damien@d-riviere.fr")
            ->setTo($email->getEmail())
            ->setBody(
                $this->templating->render(
                    'recovery/recovery_email.html.twig',
                    [
                        'user' => $user
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
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
