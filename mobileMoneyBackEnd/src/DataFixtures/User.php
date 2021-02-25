<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class User extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $tabRoles = ['ADMIN_SYSTEME', 'CAISSIER', 'ADMIN_AGENCE'];

        $tabUser = [
            [
                "email"=>"adminSysteme@gmail.com",
                "password"=>"adminSysteme",
                "telephone"=>"000000000",
                "prenom"=>"Birane",
                "nom"=>"Wane"
            ],
            [
                "email"=>"caissier@gmail.com",
                "password"=>"caissier",
                "telephone"=>"111111111",
                "prenom"=>"dump",
                "nom"=>"die"
            ],
            [
                "email"=>"adminAgence@gmail.com",
                "password"=>"adminAgence",
                "telephone"=>"222222222",
                "prenom"=>"json",
                "nom"=>"token"
            ]
        ];

        for ($i=0; $i<count($tabUser); $i++){
            $user = new Users();

            $role=$this->getReference($tabRoles[$i]);
            $password = $this->encoder->encodePassword($user, $tabUser[$i]["password"]);

            $user->setRoles([$tabRoles[$i]]);
            $user->setTelephone($tabUser[$i]["telephone"]);
            $user->setEmail($tabUser[$i]["email"]);
            $user->setPrenom($tabUser[$i]["prenom"]);
            $user->setNom($tabUser[$i]["nom"]);
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }
        
    }

    public function getDependencies () {
        return array(Roles::class,);
    }
}
