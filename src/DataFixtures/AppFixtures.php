<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Style;
use App\Entity\Trick;
use App\Entity\Video;
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

        $styles = [];

        // Create several style
        for ($i = 0; $i < 10; $i++) {
            $style = new Style();
            $style
                ->setName($faker->sentence(1))
                ->setDescription($faker->sentence(10));

            $styles[] = $style;
            $manager->persist($style);
        }

        $users = [];

        // Create several users
        for ($i = 0; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setName($faker->firstName)
                ->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, 'password'))
                ->setSlug($slugify->slugify($user->getName()))
                ->setPicture("default.png")
                ->setRoles("ROLE_USER");

            $users[] = $user;
            $manager->persist($user);
        }

        // Create several tricks
        for ($i = 0; $i < 50; $i++) {
            $trick = new Trick();

            $trick
                ->setName($faker->sentence(1))
                ->setSlug($slugify->slugify($trick->getName()))
                ->setStyle($styles[array_rand($styles)])
                ->setDescription($faker->sentence(15))
                ->setCreatedAt(new \DateTime())
                ->setUser($users[array_rand($users)]);

            $firstPicture = new Picture();
            $firstPicture
                ->setPicture("image_1.jpg")
                ->setTitle("Image 1")
                ->setTrick($trick);

            $secondPicture = new Picture();
            $secondPicture
                ->setPicture("image_2.jpg")
                ->setTitle("Image 2")
                ->setTrick($trick);

            $firstVideo = new Video();
            $firstVideo
                ->setLink("https://www.youtube.com/embed/SQyTWk7OxSI")
                ->setTrick($trick);

            $secondVideo = new Video();
            $secondVideo
                ->setLink("https://www.youtube.com/embed/G9qlTInKbNE")
                ->setTrick($trick);

            // Create comments
            for ($c = 0; $c < 15; $c++) {
                $comment = new Comment();
                $comment
                    ->setContent($faker->sentence(10))
                    ->setUser($users[array_rand($users)])
                    ->setTrick($trick)
                    ->setCreatedAt(new \DateTime());
                    $manager->persist($comment);
            }

            $manager->persist($trick);
            $manager->persist($firstPicture);
            $manager->persist($secondPicture);
            $manager->persist($firstVideo);
            $manager->persist($secondVideo);
        }

        $manager->flush();
    }
}
