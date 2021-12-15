<?php

declare(strict_types=1);

namespace App\lib\Service;

use App\lib\Model\Ship;

class JsonShipStorage implements ShipStorageInterface
{
    private string $jsonFile;

    public function __construct(string $jsonFile)
    {
        $this->jsonFile = $jsonFile;
    }

    public function getPathJson()
    {
        return $this->jsonFile;
    }

    public function findOneById(int $id): ?Ship
    {
        $shipsFromJson = $this->getJsonData();
        
        foreach ($shipsFromJson as $shipFromJson) {
            $ship = $this->transformDataToShip($shipFromJson);

            if ($ship->getId() == $id) {
                if (empty($ship)) {
                    return null;
                }
                return $ship;
            }
        }  
    }

    public function fetchAll(): array
    {
        $shipsFromJson = $this->getJsonData();
        $ships = [];

        foreach ($shipsFromJson as $ship) {
            $ships[] = $this->transformDataToShip($ship);
        }

        return $ships;
    }

    private function transformDataToShip(array $data): Ship
    {
        $ship = new Ship($data['name']);
        $ship->setStrength((int) $data['strength'])
            ->setJediFactor((int) $data['jedi_factor'])
            ->setWeaponPower((int) $data['weapon_power'])
            ->setId((int) $data['id'])
        ;

        return $ship;
    }

    public function getJsonData(): array
    {
        $pathToJson = $this->getPathJson();
        $json = file_get_contents($pathToJson);
        $shipsFromJson = json_decode($json, true);

        return $shipsFromJson;
    }
}