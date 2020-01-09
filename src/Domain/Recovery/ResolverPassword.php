<?php

namespace App\Domain\Recovery;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ResolverPassword
{

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var UserRepository */
    protected $userRepo;

    /** @var EntityManagerInterface $em */
    protected $em;

    /** @var UserPasswordEncoderInterface */
    protected $encoder;

    /** @var FlashBagInterface */
    protected $flash;

    public function __construct(
        FormFactoryInterface $formFactory,
        UserRepository $userRepo,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder,
        FlashBagInterface $flash
    ) {
        $this->formFactory = $formFactory;
        $this->userRepo = $userRepo;
        $this->em = $em;
        $this->encoder = $encoder;
        $this->flash = $flash;
    }

    public function getFormType(Request $request)
    {
        return $this->formFactory->create(PasswordType::class)
                                 ->handleRequest($request);
    }

    public function updatePassword(User $user, PasswordDTO $password)
    {
        $user
            ->setPassword($this->encoder->encodePassword($user, $password->getPassword()))
            ->setRecoveryToken(null)
            ->setRecoveryDate(null);

        $this->em->flush();
    }

    public function checkTokenDate(?User $user)
    {
        if (!is_null($user)) {
            $todayDate = new \DateTime();
            $interval = $todayDate->diff($user->getRecoveryDate());

            return $interval->i;
        }
    }

    public function checkIfTokenExist(string $token)
    {
        return $this->userRepo->findOneBy(['recoveryToken' => $token]);
    }

    public function getFlashMessageSuccess()
    {
        return $this->flash->add(
            'bg-success',
            'Votre mot de passe a été mis à jour avec succès, 
            vous pouvez maintenant vous connecter avec vos nouveaux identifiants !'
        );
    }

    public function getFlashMessageTokenFalse()
    {
        return $this->flash->add(
            'bg-danger',
            'Votre demande de réinitialisation de mot de passe a expiré !'
        );
    }
}
