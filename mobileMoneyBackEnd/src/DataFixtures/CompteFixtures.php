<?php

namespace App\DataFixtures;

use App\Entity\Users;
use App\Entity\Comptes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $date = new DateTime();
        $date->format('Y-m-d H:i:s');

        $tabUser = ['772222222', '773333333'];

        $tabCompte = [
            [
                "numeroCompte"=>"aze222zer",
                "solde"=>500000,
                "dateCreation"=>$date
            ],
            [
                "numeroCompte"=>"vbn111poi",
                "solde"=>500000,
                "dateCreation"=>$date
            ]
        ];

        for ($i=0; $i<count($tabCompte); $i++){
            $compte = new Comptes();

            $user=$this->getReference($tabUser[$i]);

            $compte->setNumeroCompte($tabCompte[$i]["numeroCompte"]);
            $compte->setSolde($tabCompte[$i]["telephone"]);
            $compte->setDateCreation($tabCompte[$i]["email"]);

            $manager->persist($compte);
            $manager->flush();

            if ($tabCompte[$i]["numeroCompte"]=="aze222zer") {
                $this->setReference("aze222zer",$compte);
            }
            elseif ($tabCompte[$i]["numeroCompte"]=="vbn111poi") {
                $this->setReference("vbn111poi",$user);
            }
        }
        
    }

    public function getDependencies () {
        return array(Users::class,);
    }
}
