<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShipController extends AbstractController
{
    /**
     * @Route("/ship", name="ship", methods={"GET"})
    */
    public function index(): Response
    {
        $ships = [
            'starfighter' => [
                'name' => 'Jedi Starfighter',
                'weapon_power' => 5,
                'jedi_factor' => 15,
                'strength' => 30,
            ],
            'cloakshape_fighter' => [
                'name' => 'CloakShape Fighter',
                'weapon_power' => 2,
                'jedi_factor' => 2,
                'strength' => 70,
            ],
            'super_star_destroyer' => [
                'name' => 'Super Star Destroyer',
                'weapon_power' => 70,
                'jedi_factor' => 0,
                'strength' => 500,
            ],
            'rz1_a_wing_interceptor' => [
                'name' => 'RZ-1 A-wing interceptor',
                'weapon_power' => 4,
                'jedi_factor' => 4,
                'strength' => 50,
            ],
        ];

        return $this->render('ship/index.html.twig', ['ships' => $ships]);
    }
}