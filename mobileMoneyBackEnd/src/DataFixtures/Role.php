<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Role extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $tab = ['ADMIN_SYSTEME', 'CAISSIER', 'ADMIN_AGENCE', 'USER_AGENCE'];

        for ($i=0; $i<count($tab); $i++){

            $roles = new Roles();
            $roles->setLibelle($tab[$i]);

            $manager->persist($roles);
            $manager->flush();
            
            if ($tab[$i]=="ADMIN_SYSTEME") {
                $this->setReference("ADMIN_SYSTEME",$roles);
            }
            elseif ($tab[$i]=="CAISSIER") {
                $this->setReference("CAISSIER",$roles);
            }  
            elseif ($tab[$i]=="ADMIN_AGENCE") {
                $this->setReference("ADMIN_AGENCE",$roles);
            }  
            elseif ($tab[$i]=="USER_AGENCE") {
                $this->setReference("USER_AGENCE",$roles);
            }
        }
    }
}
