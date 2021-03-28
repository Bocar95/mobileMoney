<?php

namespace App\DataFixtures;

use App\Entity\Agences;
use App\Entity\Comptes;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AgenceFixtures extends Fixture
{
    // $product = new Product();
   // $manager->persist($product);
    public function load(ObjectManager $manager)
    {
        $tabCompte = ['aze222zer', 'vbn111poi'];

        $tabAgence = [
            [
                "telephone"=>"773544431",
                "adresse"=>"Derkle",
                "lattitude"=>"14.726986206154207",
                "longitude"=>"-17.452552442128507"
            ],
            [
                "telephone"=>"771563467",
                "adresse"=>"Fass",
                "lattitude"=>"14.690255691249",
                "longitude"=>"-17.455985544067"
            ]
        ];

        for ($i=0; $i<count($tabAgence); $i++){
            $agence = new Agences();

            $compte=$this->getReference($tabCompte[$i]);

            $agence->setTelephone($$tabAgence[$i]["numeroCompte"]);
            $agence->setAdresse($$tabAgence[$i]["adresse"]);
            $agence->setLattitude($$tabAgence[$i]["lattitude"]);
            $agence->setLongitude($$tabAgence[$i]["longitude"]);

            $manager->persist($agence);
            $manager->flush();
        }
        
    }

    public function getDependencies () {
        return array(Comptes::class,);
    }
}
