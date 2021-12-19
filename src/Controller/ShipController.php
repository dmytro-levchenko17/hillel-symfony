<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\lib\Service\BattleManager;
use App\lib\Service\JsonShipStorage;
use App\Service\MarkdownService;
use Symfony\Component\Cache\CacheItem;
use Symfony\Contracts\Cache\CacheInterface;

class ShipController extends AbstractController
{
    /**
     * @Route("/ship", name="ship", methods={"GET", "POST"})
    */
    public function index(Request $request, MarkdownService $markdownService): Response
    {

        $jsonShips = new JsonShipStorage('../resources/ships.json');
        $ships = $jsonShips->fetchAll();

        $pageTitle = '**Космическая битва**';
        $pageTitle = $markdownService->parse($pageTitle);

        $battleTitle = 'Корабли готовы к следующей *Миссии*';
        $battleTitle = $markdownService->parse($battleTitle);

        $battleBtnTitle = '*В атаку!*';
        $battleBtnTitle = $markdownService->parse($battleBtnTitle);

        $mission = '***Миссия***';
        $mission = $markdownService->parse($mission);

        $battleDesc = 'Увлекательная битва **супер мощных `космических кораблей`**';
        $battleDesc = $markdownService->parse($battleDesc);

        $enemy = '**Противник**';
        $enemy = $markdownService->parse($enemy);

        $selectShip = '###Выберите корабль';
        $selectShip = $markdownService->parse($selectShip);

        $iDontKnow = '*Я не знаю что еще придумать и вставить в шаблон!*';
        $iDontKnow = $markdownService->parse($iDontKnow);

        $iDontKnow1 = '> Text that is a quote';
        $iDontKnow1 = $markdownService->parse($iDontKnow1);

        $iDontKnow2 = '**Я не знаю что еще придумать и вставить в шаблон!**';
        $iDontKnow2 = $markdownService->parse($iDontKnow2);

        return $this->render('ship/index.html.twig', [
            'ships' => $ships,
            'pageTitle' => $pageTitle,
            'battleTitle' => $battleTitle,
            'battleBtnTitle' => $battleBtnTitle,
            'mission' => $mission,
            'battleDesc' => $battleDesc,
            'enemy' => $enemy,

            'selectShip' => $selectShip,
            'iDontKnow' => $iDontKnow,
            'iDontKnow1' => $iDontKnow1,
            'iDontKnow2' => $iDontKnow2    
        ]);
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