<?php

declare(strict_types=1);

namespace App\Tests\Game;

use App\Game\Board;
use App\Game\Player;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    protected $players;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->players = [
            1 => new Player(1, 'X'),
            2 => new Player(2, 'O')
        ];
    }

    public function testNewEmptyBoard(): void
    {
        $board = new Board;
        $expectedBoard = [0, 0, 0, 0, 0, 0, 0, 0, 0];
        $this->assertEquals($expectedBoard, $board->getBoard());
    }

    public function testPickCell(): void
    {
        $board = new Board;
        $expectedBoard = [1, 0, 2, 2, 1, 0, 1, 0, 2];
        $this->fillBoard($board, $expectedBoard);

        $this->assertEquals($expectedBoard, $board->getBoard());
    }

    public function testCheckUsableCells(): void
    {
        $board = new Board;
        $expectedBoard = [1, 0, 2, 2, 1, 0, 1, 0, 2];
        $this->fillBoard($board, $expectedBoard);

        foreach ($expectedBoard as $cellIdx => $cellValue) {
            if ($cellValue > 0) {
                $this->assertFalse($board->isUsableCell($cellIdx));
            } else {
                $this->assertTrue($board->isUsableCell($cellIdx));
            }
        }
    }

    public function testCheckFreeCells(): void
    {
        $board = new Board;
        $expectedBoard = [1, 0, 2, 2, 1, 0, 1, 0, 2];
        $this->fillBoard($board, $expectedBoard);

        $freeCells = $board->getFreeCells();
        $this->assertCount(3, $freeCells);
        foreach ($freeCells as $cellIdx => $cell) {
            $this->assertTrue($expectedBoard[$cellIdx] === 0);
        }
    }

    public function testResetBoard(): void
    {
        $board = new Board;
        $filledBoard = [1, 0, 2, 2, 1, 0, 1, 0, 2];
        $expectedBoard = [0, 0, 0, 0, 0, 0, 0, 0, 0];
        $this->fillBoard($board, $filledBoard);
        $board->reset();

        $this->assertEquals($expectedBoard, $board->getBoard());
    }

    public function testIsPlayerWinner(): void
    {
        $board = new Board;
        $matches = [
            // First player winning matches
            1 => [
                [1, 1, 1, 0, 2, 2, 2, 0, 0],
                [2, 1, 2, 0, 1, 2, 0, 1, 0],
                [1, 0, 2, 2, 1, 0, 2, 0, 1],
                [1, 0, 1, 2, 1, 2, 1, 2, 2],
            ],
            // First player winning matches
            2 => [
                [0, 1, 1, 2, 2, 2, 1, 0, 0],
                [0, 2, 1, 0, 2, 0, 1, 2, 1],
                [2, 2, 1, 1, 2, 0, 1, 1, 2],
                [1, 0, 2, 1, 2, 1, 2, 1, 2],
            ]
        ];

        foreach ($matches as $playerId => $winningMatches) {
            $player = $this->players[$playerId];
            foreach ($winningMatches as $match) {
                $board->reset();
                $this->fillBoard($board, $match);
                $this->assertTrue($board->isWinner($player));
            }
        }
    }

    protected function fillBoard(Board $board, array $picks): void
    {
        foreach ($picks as $cellIdx => $playerId) {
            if ($playerId > 0) {
                $board->pickCell($cellIdx, $this->players[$playerId]);
            }
        }
    }
}
