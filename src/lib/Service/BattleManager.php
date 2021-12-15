<?php

declare(strict_types=1);

namespace App\lib\Service;

use App\lib\Model\BattleResult;
use App\lib\Model\Ship;
use Symfony\Component\HttpFoundation\JsonResponse;

class BattleManager
{
    /**
     * Our complex fighting algorithm!
     *
     * @param Ship $ship1
     * @param int $ship1Quantity
     * @param Ship $ship2
     * @param int $ship2Quantity
     * @return array With keys winning_ship, losing_ship & used_jedi_powers
     */
    public function battle(Ship $ship1, int $ship1Quantity, Ship $ship2, int $ship2Quantity): BattleResult
    {
        $ship1Health = $ship1->getStrength() * $ship1Quantity;
        $ship2Health = $ship2->getStrength() * $ship2Quantity;

        $ship1UsedJediPowers = false;
        $ship2UsedJediPowers = false;
        while ($ship1Health > 0 && $ship2Health > 0) {
            if ($this->isJediDestroyShipUsingTheForce($ship1)) {
                $ship2Health = 0;
                $ship1UsedJediPowers = true;

                break;
            }
            if ($this->isJediDestroyShipUsingTheForce($ship2)) {
                $ship1Health = 0;
                $ship2UsedJediPowers = true;

                break;
            }

            $ship1Health -= ($ship2->getWeaponPower() * $ship2Quantity);
            $ship2Health -= ($ship1->getWeaponPower() * $ship1Quantity);
        }

        if ($ship1Health <= 0 && $ship2Health <= 0) {
            $winningShip = null;
            $ship1 = $ship1;
            $ship1HP = 0;
            $ship1Q = $ship1Quantity;
            $ship2 = $ship2;
            $ship2HP = 0;
            $ship2Q = $ship2Quantity;
            $isJediPowerUsed = $ship1UsedJediPowers || $ship2UsedJediPowers;
        } elseif ($ship1Health <= 0) {
            $winningShip = $ship2;
            $ship1 = $ship1;
            $ship1HP = $ship1Health;
            $ship1Q = $ship1Quantity;
            $ship2 = $ship2;
            $ship2HP = $ship2Health;
            $ship2Q = $ship2Quantity;
            $isJediPowerUsed = $ship2UsedJediPowers;
        } else {
            $winningShip = $ship1;
            $ship1 = $ship1;
            $ship1HP = $ship1Health;
            $ship1Q = $ship1Quantity;
            $ship2 = $ship2;
            $ship2HP = $ship2Health;
            $ship2Q = $ship2Quantity;
            $isJediPowerUsed = $ship1UsedJediPowers;
        }

        return new BattleResult(
            $winningShip,
            $ship1,
            $ship1HP,
            $ship1Q,
            $ship2,
            $ship2HP,
            $ship2Q,
            $isJediPowerUsed
        );
    }

    private function isJediDestroyShipUsingTheForce(Ship $ship): bool
    {
        return mt_rand(1, 100) <= $ship->getJediFactor();
    }
}