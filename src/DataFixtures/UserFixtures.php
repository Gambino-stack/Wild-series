<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
        $contributor = new User();
        $contributor->setEmail('subscriber@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setFirstname('Toto');
        $contributor->setPassword($this->passwordEncoder->encodePassword(
                   $contributor,
            'subscriberpassword'
        ));

       $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
       $admin = new User();
       $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstname('Admin');
        $admin->setPassword($this->passwordEncoder->encodePassword(
                    $admin,
           'adminpassword'
        ));

       $manager->persist($admin);
        // Sauvegarde des 2 nouveaux utilisateurs :

        $user = new User();
        $user->setEmail('yohan.lgd@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstname('Yohan');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'Yohan45'
        ));

        $manager->persist($user);
        $this->addReference('user', $user);
        $manager->flush();

    }
}
