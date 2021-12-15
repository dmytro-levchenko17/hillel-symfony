<?php

declare(strict_types=1);

namespace App\lib\Service;

use App\lib\Model\Ship;

interface ShipStorageInterface
{
    public function findOneById(int $id): ?Ship;

    public function fetchAll(): array;
}