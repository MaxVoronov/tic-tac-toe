<?php

declare(strict_types=1);

namespace App\tests\Game;

use App\Game\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    protected $humanPlayer;
    protected $aiPlayer;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->humanPlayer = new Player(1, 'X');
        $this->aiPlayer = new Player(2, 'O');
    }

    public function testGetPlayerIndex(): void
    {
        $this->assertEquals(1, $this->humanPlayer->getIndex());
        $this->assertEquals(2, $this->aiPlayer->getIndex());
    }

    public function testGetPlayerSign(): void
    {
        $this->assertEquals('X', $this->humanPlayer->getSign());
        $this->assertEquals('O', $this->aiPlayer->getSign());
    }

    public function testPlayerEqual(): void
    {
        $humanPlayerClone = clone $this->humanPlayer;
        $aiPlayerClone = clone $this->aiPlayer;

        $this->assertTrue($this->humanPlayer->isEqual($humanPlayerClone));
        $this->assertTrue($this->aiPlayer->isEqual($aiPlayerClone));
        $this->assertFalse($this->humanPlayer->isEqual($aiPlayerClone));
        $this->assertFalse($this->aiPlayer->isEqual($humanPlayerClone));
    }
}
