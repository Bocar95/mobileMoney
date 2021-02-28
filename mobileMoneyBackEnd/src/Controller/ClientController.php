<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Repository\ClientsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
{
    /**
     * @Route(path="/api/user/client/{nci}", name="getClientByNci", methods={"GET"})
     */
    public function getClientByNci($nci, ClientsRepository $clientRepo)
    {
        $client = new Clients();
        if ($this->isGranted("VIEW",$client)) {
            $client = $clientRepo->findOneBy([
                "numCni" => $nci
            ]);
            return $this->json($client, 200, [], ["groups" => ["getClientByNci"]]);
        }
        else{
          return $this->json(["message" => "Vous n'avez pas ce privilége."], Response::HTTP_FORBIDDEN);
        }
    }
}
