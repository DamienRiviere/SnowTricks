<?php

namespace App\DataFixtures;

use App\Entity\Style;
use Faker\Factory;
use App\Entity\User;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $slugify = new Slugify();

        $damien = new User();
        $damien
            ->setName("Damien")
            ->setEmail("damien@d-riviere.fr")
            ->setPassword($this->encoder->encodePassword($damien, 'password'))
            ->setCreatedAt(new \DateTime())
            ->setSlug($slugify->slugify($damien->getName()))
            ->setPicture("http://image.jeuxvideo.com/avatar-md/default.jpg")
            ->setRoles("ROLE_USER");

        for ($i = 0; $i < 5; $i++) {
            $style = new Style();
            $style
                ->setName("Style n°" . $i)
                ->setDescription($faker->sentence(10));
            $manager->persist($style);
        }

        $manager->persist($damien);
        $manager->flush();
    }
}
