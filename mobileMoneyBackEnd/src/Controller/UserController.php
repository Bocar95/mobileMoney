<?php

namespace App\Controller;

use DateTime;
use App\Entity\Users;
use App\Entity\Agences;
use App\Entity\Comptes;
use App\Entity\Transactions;
use App\Repository\RolesRepository;
use App\Repository\UsersRepository;
use App\Repository\AgencesRepository;
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
    public function addUser(Request $request,SerializerInterface $serializer ,EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder, RolesRepository $roleRepo, AgencesRepository $agenceRepo)
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

            $agenceExistante = $agenceRepo->findOneBy([
              "telephone" => $userTab["agence"]["telephone"]
            ]);

            if($agenceExistante && ($role->getLibelle() == "USER_AGENCE")){
              $agenceExistante->addUser($user);
            }
            else{
              if ($agenceExistante && ($role->getLibelle() == "USER_ADMIN")) {
                return $this->json(["message" => "Désolé, mais ce numéro d'agence existe déja."], Response::HTTP_FORBIDDEN);
              }
              $compte->setNumeroCompte("ism786hhh");
              $compte->setDateCreation($date);
              $compte->setSolde("500000");
              $compte->setUsers($user);
  
              $agence->setTelephone($userTab["agence"]["telephone"]);
              $agence->setAdresse($userTab["agence"]["adresse"]);
              $agence->setLattitude($userTab["agence"]["lattitude"]);
              $agence->setLongitude($userTab["agence"]["longitude"]);
              $agence->setCompte($compte);
              $user->setAgences($agence);
            }

            $manager->persist($user);
            $manager->flush();
            return new JsonResponse("success",Response::HTTP_CREATED,[],true);
        }
        else{
          return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * @Route("/api/user/username", name="getUserByUsername", methods={"GET"})
     */
    public function getUserByUsername(Request $request,UsersRepository $userRepo)
    {
      $user = new Users();

      if ($this->isGranted("VIEW",$user)) {

        //Recupération du token pour distinguer le user qui fait le retrait.
        $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
        $token = explode(".",$token);
        if (isset($token[1])){
          $payload = $token[1];
          $payload = json_decode(base64_decode($payload));

          $user = $userRepo->findOneBy([
            "telephone" => $payload->username
          ]);
        }

        if (!$user){
          return $this->json(
            ["message" => "Désolé, mais ce user n'existe pas."],
            Response::HTTP_FORBIDDEN
          );
        }

        return $this->json($user, 200, [], ["groups" => ["getUserByUsername"]]);
      }
      else{
        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
      }
    }

    /**
     * @Route("/api/user/{username}/compte", name="getCompteByUserTelephone", methods={"GET"})
     */
    public function getCompteByUserTelephone($username, UsersRepository $userRepo)
    {
      $user = new Users();
      $compte = new Comptes();

      if ($this->isGranted("VIEW",$user)) {
        $user = $userRepo->findOneBy([
          "telephone" => $username
        ]);

        if (!$user){
          return $this->json(
            ["message" => "Désolé, mais ce user n'existe pas."],
            Response::HTTP_FORBIDDEN
          );
        }

        $compte = $user->getAgences()->getCompte();

        return $this->json($compte, 200, [], ["groups" => ["getCompteByUserTelephone"]]);
      }
      else{
        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
      }
    }

}
