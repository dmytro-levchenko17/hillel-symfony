<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Ship;
use Exception;

class LoadShipController extends AbstractController
{
    /**
     * @Route("/load", name="load", methods={"GET", "POST"})
    */
    public function load(Request $request, ManagerRegistry $doctrine): Response
    {
        $ships = [
            0 => [
                'name' => 'Jedi Starfighter',
                'weapon_power' => 5,
                'jedi_factor' => 15,
                'strength' => 30,
                'team' => 'rebel'
            ],
            1 => [
                'name' => 'CloakShape Fighter',
                'weapon_power' => 2,
                'jedi_factor' => 2,
                'strength' => 70,
                'team' => 'rebel'
            ],
            2 => [
                'name' => 'Super Star Destroyer',
                'weapon_power' => 70,
                'jedi_factor' => 0,
                'strength' => 500,
                'team' => 'empire'
            ],
            3 => [
                'name' => 'RZ-1 A-wing interceptor',
                'weapon_power' => 4,
                'jedi_factor' => 4,
                'strength' => 50,
                'team' => 'empire'
            ],
            4 => [
                'name' => 'Test ship',
                'weapon_power' => 14,
                'jedi_factor' => 14,
                'strength' => 150,
                'team' => 'Dark empire'
            ],
        ];

        $entityManager = $doctrine->getManager();
    
        foreach ($ships as $ship) {
            $checkShip = $entityManager->getRepository(Ship::class)->findOneBy(array('name' => $ship['name']));

            if ($checkShip !== null) {
                continue;
            }

            $dbship = new Ship();
            $dbship->setName($ship['name']);
            $dbship->setWeaponPower($ship['weapon_power']);
            $dbship->setJediFactor($ship['jedi_factor']);
            $dbship->setStrength($ship['strength']);
            $dbship->setTeam($ship['team']);
            
            $entityManager->persist($dbship);
        }
        $entityManager->flush();


        return new Response('<html><body>Ship load!</body></html>');
    }
}