<?php

declare(strict_types=1);

namespace App\lib\Model;

use App\lib\Model\Ship;

class BattleResult
{
    private ?Ship $winningShip;
    private ?Ship $ship1;
    private int $ship1HP;
    private int $ship1Q;
    private ?Ship $ship2;
    private int $ship2HP;
    private int $ship2Q;
    private bool $isJediPowerUsed;

    public function __construct(?Ship $winningShip, ?Ship $ship1, int $ship1HP, int $ship1Q, ?Ship $ship2, int $ship2HP, int $ship2Q, bool $isJediPowerUsed) {
        $this->winningShip = $winningShip;
        $this->ship1 = $ship1;
        $this->ship1HP = $ship1HP;
        $this->ship1Q = $ship1Q;
        $this->ship2 = $ship2;
        $this->ship2HP = $ship2HP;
        $this->ship2Q = $ship2Q;
        $this->isJediPowerUsed = $isJediPowerUsed;
    }

    public function getWinningShip(): ?Ship
    {
        return $this->winningShip;
    }

    public function getShip1(): ?Ship
    {
        return $this->ship1;
    }

    public function getShip1HP(): int
    {
        return $this->ship1HP;
    }

    public function getShip1Q(): int
    {
        return $this->ship1Q;
    }

    public function getShip2(): ?Ship
    {
        return $this->ship2;
    }

    public function getShip2HP(): int
    {
        return $this->ship2HP;
    }

    public function getShip2Q(): int
    {
        return $this->ship2Q;
    }

    public function isJediPowerUsed(): bool
    {
        return $this->isJediPowerUsed;
    }
}