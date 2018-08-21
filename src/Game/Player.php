<?php

declare(strict_types=1);

namespace App\Game;

class Player
{
    protected $index;
    protected $sign;

    public function __construct(int $playerIndex, string $sign)
    {
        $this->index = $playerIndex;
        $this->sign = $sign;
    }

    public function getIndex(): int
    {
        return $this->index;
    }

    public function getSign(): string
    {
        return $this->sign;
    }

    public function isEqual(self $anotherPlayer): bool
    {
        return $this->getIndex() === $anotherPlayer->getIndex();
    }
}
