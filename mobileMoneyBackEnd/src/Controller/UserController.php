<?php

namespace App\Controller;

use DateTime;
use App\Entity\Users;
use App\Entity\Agences;
use App\Entity\Comptes;
use App\Entity\Transactions;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route(path="/api/user", name="addUser", methods="POST")
     */
    public function addUser(Request $request,SerializerInterface $serializer ,EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, RolesRepository $roleRepo)
    {
        $user = new Users();
        $agence = new Agences();
        $compte = new Comptes();

        if ($this->isGranted("EDIT",$user)) {
            $userJson = $request->getContent();
            $userTab = $serializer->decode($userJson, 'json');

            $user->setPrenom($userTab["prenom"]);
            $user->setNom($userTab["nom"]);
            $user->setTelephone($userTab["telephone"]);
            $user->setEmail($userTab["email"]);

            $password = $encoder->encodePassword($user, $userTab["password"]);
            $user->setPassword($password);

            $role = $roleRepo->findOneBy([
                "id" => $userTab["role"]
            ]);
            if ($role){
                $user->setRole($role);
            }

            $date = new DateTime();
            $date->format('Y-m-d H:i:s');

            $compte->setNumeroCompte("iss876ghj");
            $compte->setDateCreation($date);
            $compte->setSolde("500000");
            $compte->setUsers($user);

            $agence->setTelephone($userTab["agence"]["telephone"]);
            $agence->setAdresse($userTab["agence"]["adresse"]);
            $agence->setLattitude($userTab["agence"]["lattitude"]);
            $agence->setLongitude($userTab["agence"]["longitude"]);
            $agence->setCompte($compte);
            $user->setAgences($agence);

            $manager->persist($user);
            $manager->flush();
            return new JsonResponse("success",Response::HTTP_CREATED,[],true);
        }
        else{
          return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
        }
    }

}
