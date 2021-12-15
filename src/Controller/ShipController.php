<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\lib\Service\BattleManager;
use App\lib\Service\JsonShipStorage;

class ShipController extends AbstractController
{
    /**
     * @Route("/ship", name="ship", methods={"GET", "POST"})
    */
    public function index(Request $request): Response
    {

        $jsonShips = new JsonShipStorage('../resources/ships.json');
        $ships = $jsonShips->fetchAll();

        return $this->render('ship/index.html.twig', ['ships' => $ships]);
    }

     /**
     * @Route("/battle", name="battle", methods={"POST"})
    */
    public function battle(BattleManager $battleManager): Response
    {
        $ship1Id = (int) $_POST['ship1'] ?? null;
        $ship1Quantity = (int) $_POST['ship1Q'] ?? 1;
        $ship2Id = (int) $_POST['ship2'] ?? null;
        $ship2Quantity = (int) $_POST['ship2Q'] ?? 1;

        $jsonShips = new JsonShipStorage('../resources/ships.json');
       
        $ship1 = $jsonShips->findOneById($ship1Id);
        $ship2 = $jsonShips->findOneById($ship2Id);
    
        $outcome = $battleManager->battle($ship1, $ship1Quantity, $ship2, $ship2Quantity);

        return $this->render('ship/result.html.twig', [
            'outcome' => $outcome,
            'ship1' => $ship1,
            'ship2' => $ship2,
            'ship1Quantity' => $ship1Quantity,
            'ship2Quantity' => $ship2Quantity,
        ]);
    }
}