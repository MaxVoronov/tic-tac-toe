<?php

declare(strict_types=1);

namespace App\tests;

use App\Game;
use App\Game\Board;
use App\Game\Player;
use App\IO\DummyIO;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
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

    public function testCheckNextMove(): void
    {
        $board = new Board();
        $game = new Game(new DummyIO);
        $matches = [
            [
                'board' => [0, 1, 2, 2, 1, 0, 2, 0, 1],
                'expectedMove' => 0
            ], [
                'board' => [1, 0, 2, 2, 0, 2, 0, 1, 1],
                'expectedMove' => 4
            ], [
                'board' => [2, 1, 2, 2, 2, 1, 1, 1, 0],
                'expectedMove' => 8
            ], [
                'board' => [0, 2, 1, 1, 1, 0, 2, 0, 2],
                'expectedMove' => 7
            ], [
                'board' => [1, 1, 0, 1, 2, 1, 2, 1, 1],
                'expectedMove' => 2
            ]
        ];

        foreach ($matches as $match) {
            $board->reset();
            $this->fillBoard($board, $match['board']);

            $nextMove = $game->getNextMove($this->players[2], $board);
            $this->assertEquals($match['expectedMove'], $nextMove['idx']);
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
