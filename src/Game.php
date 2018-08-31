<?php

declare(strict_types=1);

namespace App;

use App\IO\IOInterface;
use App\Game\Board;
use App\Game\Player;

class Game
{
    protected $io;
    protected $board;
    protected $playerHuman;
    protected $playerAi;

    public function __construct(IOInterface $io)
    {
        $this->io = $io;
        $this->board = new Board();
        $this->playerHuman = new Player(1, 'X');
        $this->playerAi = new Player(2, 'O');
    }

    /**
     * Start new game
     */
    public function start(): void
    {
        $this->io->writeln('Welcome to Tic-Tac-Toe Game!');

        do {
            $this->io->writeln('============================');
            $this->io->writeln('Enter cell index for making move (1-9)');
            $this->loop();

            $this->io->emptyLine();
            $restart = strtolower(trim($this->io->readln('Do you wanna play again? (y/n): ')));
            if ($restart !== 'y' && $restart !== 'yes') {
                break;
            }
            $this->board->reset();
        } while (true);

        $this->io->writeln('Thanks for games! Good bye!');
    }

    /**
     * Main game loop
     */
    protected function loop(): void
    {
        $currentPlayer = $this->playerHuman;
        while (!$this->hasWinner()) {
            $this->io->emptyLine();

            // Move of Human
            if ($currentPlayer->isEqual($this->playerHuman)) {
                do {
                    $cell = ((int)$this->io->readln('Your move: ')) - 1;
                    if ($this->board->isUsableCell($cell)) {
                        break;
                    }

                    // Picked incorrect cell (inner loop)
                    $this->io->writeln('Nope! Please pick correct cell');
                } while (true);

                // Move of AI
            } else {
                $this->io->write('AI is making move... ');
                $move = $this->getNextMove($this->playerAi);
                $cell = $move['idx'];
                $this->io->writeln($cell + 1);
            }

            $this->board->pickCell($cell, $currentPlayer);

            $this->renderBoard();
            $currentPlayer = $this->togglePlayer($currentPlayer);
        }
    }

    /**
     * Return best next turn for AI
     * Using MinMax algorithm
     *
     * @param Player $player
     * @param Board $board
     * @return array
     */
    public function getNextMove(Player $player, Board $board = null): array
    {
        $board = $board ?? $this->board;
        $freeCells = $board->getFreeCells();

        if ($board->isWinner($this->playerHuman)) {
            return ['score' => -10];
        }
        if ($board->isWinner($this->playerAi)) {
            return ['score' => 10];
        }
        if (\count($freeCells) === 0) {
            return ['score' => 0];
        }

        $moves = [];
        foreach ($freeCells as $idx => $cell) {
            $move = ['idx' => $idx];

            $nextMoveBoard = clone $board;
            $nextMoveBoard->pickCell($idx, $player);

            $nextMove = $player->isEqual($this->playerAi)
                ? $this->getNextMove($this->playerHuman, $nextMoveBoard)
                : $this->getNextMove($this->playerAi, $nextMoveBoard);
            $move['score'] = $nextMove['score'];

            $moves[] = $move;
        }

        $bestMove = 0;
        if ($player->isEqual($this->playerAi)) {
            $bestScore = -10000;
            foreach ($moves as $move) {
                if ($move['score'] > $bestScore) {
                    $bestScore = $move['score'];
                    $bestMove = $move;
                }
            }
        } else {
            $bestScore = 10000;
            foreach ($moves as $move) {
                if ($move['score'] < $bestScore) {
                    $bestScore = $move['score'];
                    $bestMove = $move;
                }
            }
        }

        return $bestMove;
    }

    /**
     * Toggle current player
     *
     * @param Player $currentPlayer
     * @return Player
     */
    protected function togglePlayer(Player $currentPlayer): Player
    {
        return $currentPlayer->isEqual($this->playerHuman) ? $this->playerAi : $this->playerHuman;
    }

    /**
     * Check is we have winner or not
     *
     * @return bool
     */
    public function hasWinner(): bool
    {
        if ($this->board->isWinner($this->playerHuman)) {
            $this->io->writeln('You are Winner!');
            return true;
        }

        if ($this->board->isWinner($this->playerAi)) {
            $this->io->writeln('Game Over! AI is Winner!');
            return true;
        }

        if (\count($this->board->getFreeCells()) === 0) {
            $this->io->writeln('Draw!');
            return true;
        }

        return false;
    }

    /**
     * Draw game board
     *
     * @return Game
     */
    protected function renderBoard(): self
    {
        $this->io->writeln('----------------------------');

        $i = 0;
        foreach ($this->board->getBoard() as $cell) {
            $sign = ' ';
            if ($this->playerHuman->getIndex() === $cell) {
                $sign = $this->playerHuman->getSign();
            } elseif ($this->playerAi->getIndex() === $cell) {
                $sign = $this->playerAi->getSign();
            }

            $this->io->write('| ' . $sign . ' ');
            if (++$i % 3 === 0) {
                $this->io->writeln('|');
            }
        }

        return $this;
    }
}
