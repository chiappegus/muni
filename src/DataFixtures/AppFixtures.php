<?php

namespace App\DataFixtures;

use App\Entity\Persona;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 20; $i++) {

            $user = new Persona();
            $user->setEmail(sprintf('gus%d@gus.com', $i));
            $user->setNombre(sprintf('gus%d', $i));
            $user->setApellido(sprintf('gus%d', $i));
            $user->setDni(26252 + $i);

            //$user->setNombre($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'engage'
            ));
            $manager->persist($user);

        };
        $manager->flush();

    }
}
