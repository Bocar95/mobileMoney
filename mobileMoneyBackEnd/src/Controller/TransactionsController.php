<?php

namespace App\Controller;

use DateTime;
use App\Entity\Clients;
use App\Entity\Transactions;
use App\Repository\UsersRepository;
use App\Service\transactionService;
use App\Repository\ClientsRepository;
use App\Repository\ComptesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransactionsController extends AbstractController
{
    /**
     * @Route(path="/api/user/transactions", name="addDepot", methods={"POST"}
     *)
     */
    public function addDepot(Request $request,SerializerInterface $serializer ,EntityManagerInterface $manager,TransactionsRepository $transRepo, UsersRepository $usersRepo, ComptesRepository $compteRepo, ClientsRepository $clientsRepo)
    {
      $depotTrans = new Transactions();
      $clientDepot = new Clients();
      $clientRetrait = new Clients();
      $service = new transactionService($transRepo);

      if ($this->isGranted("EDIT",$depotTrans)) {

        $depotTransJson = $request->getContent();
        $depotTransTab = $serializer->decode($depotTransJson, 'json');

        $date = new DateTime();
        $date->format('Y-m-d H:i:s');

        //génération du code de transaction, calcule des commission et frais dans le service de transaction.
        $codeTrans = $service->codeTrans($transRepo);
        $fraisDepot = $service->commissionOperateurDepot($depotTransTab["montant"]);
        $fraisRetrait = $service->commissionOperateurRetrait($depotTransTab["montant"]);
        $fraisEtat = $service->commissionEtat($depotTransTab["montant"]);
        $fraisSysteme = $service->commissionTranfert($depotTransTab["montant"]);
        $fraisEnvoi = $service->fraisEnvoi($depotTransTab["montant"]);

        //Frais total de l'opération.
        $fraisOperationtotal = $depotTransTab["montant"] + $fraisEnvoi;

        //Recupération du token pour distinguer le user qui fait le depot.
        $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
        $token = explode(".",$token);

        if (isset($token[1])){
          $payload = $token[1];
          $payload = json_decode(base64_decode($payload));

          $userDepot = $usersRepo->findOneBy([
            "telephone" => $payload->username
          ]);
          $depotTrans->setUsersDepot($userDepot);
        }

        //on recupére le compte de l'agence du user_agence.
        $compteDepot = $userDepot->getAgences()->getCompte();
        
        //on recupére le solde de son compte 
        $soldeCompte = $compteDepot->getSolde();

        //on détermine si le compte a suffisament d'argent pour frais l'opération de dépot
        if ($soldeCompte < 5000){
          return $this->json(
            ["message" => "Désolé, mais le solde de votre compte est insuffisant pour cette opération."],
            Response::HTTP_FORBIDDEN
          );
        }

        //si oui on ajoute l'argent de l'opération sur son compte
        $compteAvecNewSolde = $compteDepot->setSolde($soldeCompte + $fraisOperationtotal);

        //on fait les set()
        $depotTrans->setMontant($depotTransTab["montant"]);
        $depotTrans->setDateDepot($date);
        $depotTrans->setCodeTrans($codeTrans);
        $depotTrans->setFrais($fraisEnvoi);
        $depotTrans->setFraisDepot($fraisDepot);
        $depotTrans->setFraisRetrait($fraisRetrait);
        $depotTrans->setFraisEtat($fraisEtat);
        $depotTrans->setFraisSysteme($fraisSysteme);
        $depotTrans->setCompteDepot($compteAvecNewSolde);

        //on détermine si le client qui fait le dépot éxiste dans la base de données. Puis on l'ajoute dans la table Client
        //faisant une opération de dépot
        $client1 = $depotTransTab["clientDepot"];
        $client1Existante = $clientsRepo->findOneBy([
          "telephone" => $client1["telephone"]
        ]);

        if ($client1Existante){
          $client1Existante->addTransactionsDepot($depotTrans);
          $depotTrans->setClientDepot($client1Existante);
        }else{
          $clientDepot->setNomComplet($client1["nomComplet"]);
          $clientDepot->setTelephone($client1["telephone"]);
          $clientDepot->setNumCni($client1["numCni"]);
          $clientDepot->addTransactionsDepot($depotTrans);
          $depotTrans->setClientDepot($clientDepot);
        }

        //on détermine si le client qui doit faire le retrait éxiste dans la base de données. Puis on l'ajoute dans la table Client
        //qui doit l'opération de retrait
        $client2 = $depotTransTab["clientRetrait"];
        $client2Existante = $clientsRepo->findOneBy([
          "telephone" => $client2["telephone"]
        ]);

        if ($client2Existante){
          $depotTrans->setClientRetrait($client2Existante);
        }else{
          $clientRetrait->setNomComplet($client2["nomComplet"]);
          $clientRetrait->setTelephone($client2["telephone"]);
          $depotTrans->setClientRetrait($clientRetrait);
        }

        //on cré la transaction.
        $manager->persist($depotTrans);
        $manager->flush();
        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
      }
      else{
        return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
      }
    }

    /**
     * @Route("/api/user/transactions/retrait", name="retraitTrans", methods={"PUT"})
     */
    public function retraitTrans(Request $request,SerializerInterface $serializer ,EntityManagerInterface $manager,TransactionsRepository $transRepo, UsersRepository $usersRepo, ClientsRepository $clientsRepo)
    {
      $retraitTrans = new Transactions();

      if ($this->isGranted("EDIT",$retraitTrans)) {

        $retraitTransJson = $request->getContent();
        $retraitTransTab = $serializer->decode($retraitTransJson, 'json');

        $transaction = $transRepo->findOneBy([
          "codeTrans" => $retraitTransTab["codeTrans"]
        ]);

        if ($transaction){

          $dateRetrait = $transaction->getDateRetrait();

          if ($dateRetrait != null){
            return $this->json(
              ["message" => "Désolé, mais cette transaction de retrait a déja été faite."],
              Response::HTTP_FORBIDDEN
            );
          }

          $clientRetrait = $clientsRepo->findOneBy([
            "telephone" => $retraitTransTab["telephone"]
          ]);

          if ($clientRetrait){
            $clientRetrait->setNumCni($retraitTransTab["numCni"]);
            $clientRetrait->addTransactionsRetrait($transaction);
            $transaction->setClientRetrait($clientRetrait);
          }else{
            return $this->json(
              ["message" => "Désolé, mais le numéro de téléphone ne correspond pas."],
              Response::HTTP_FORBIDDEN
            );
          }

          //Recupération du token pour distinguer le user qui fait le retrait.
          $token = substr($request->server->get("HTTP_AUTHORIZATION"), 7);
          $token = explode(".",$token);
          if (isset($token[1])){
            $payload = $token[1];
            $payload = json_decode(base64_decode($payload));

            $userRetrait = $usersRepo->findOneBy([
              "telephone" => $payload->username
            ]);
            $transaction->setUsersRetrait($userRetrait);
          }

          $montantTransactions = $transaction->getMontant();
          $soldeCompteUserRetrait = $userRetrait->getAgences()->getCompte()->getSolde();

          if ($soldeCompteUserRetrait < $montantTransactions){
            return $this->json(
              ["message" => "Désolé, mais votre solde de compte est insuffisant pour faire la transaction de retrait."],
              Response::HTTP_FORBIDDEN
            );
          }

          $newSoldeCompte = $userRetrait->getAgences()->getCompte()->setSolde($soldeCompteUserRetrait - $montantTransactions);

          $date = new DateTime();
          $date->format('Y-m-d H:i:s');
          $transaction->setDateRetrait($date);
          $transaction->setCompteRetrait($userRetrait->getAgences()->getCompte());
        }

        $manager->persist($transaction);
        $manager->flush();
        return new JsonResponse("success",Response::HTTP_CREATED,[],true);
      }
    }
}
