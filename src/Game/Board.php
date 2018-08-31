<?php

declare(strict_types=1);

namespace App\Game;

class Board
{
    private const INIT_BOARD = [
        0, 0, 0,
        0, 0, 0,
        0, 0, 0,
    ];

    /** @var array Game board */
    protected $board = self::INIT_BOARD;

    /**
     * Pick cell on board
     *
     * @param int $cellIdx
     * @param Player $player
     * @return bool
     */
    public function pickCell(int $cellIdx, Player $player): bool
    {
        if ($this->isUsableCell($cellIdx)) {
            $this->board[$cellIdx] = $player->getIndex();
            return true;
        }

        return false;
    }

    /**
     * Check can we use cell
     *
     * @param $cellIdx
     * @return bool
     */
    public function isUsableCell($cellIdx): bool
    {
        return array_key_exists($cellIdx, $this->board) && empty($this->board[$cellIdx]);
    }

    /**
     * Return array of empty cells
     *
     * @return array
     */
    public function getFreeCells(): array
    {
        return array_filter($this->board, function ($val) {
            return empty($val);
        });
    }

    /**
     * Check player is winner
     *
     * @param Player $player
     * @return bool
     */
    public function isWinner(Player $player): bool
    {
        $playerId = $player->getIndex();

        return ($this->board[0] === $playerId && $this->board[1] === $playerId && $this->board[2] === $playerId)
            || ($this->board[3] === $playerId && $this->board[4] === $playerId && $this->board[5] === $playerId)
            || ($this->board[6] === $playerId && $this->board[7] === $playerId && $this->board[8] === $playerId)
            || ($this->board[0] === $playerId && $this->board[3] === $playerId && $this->board[6] === $playerId)
            || ($this->board[1] === $playerId && $this->board[4] === $playerId && $this->board[7] === $playerId)
            || ($this->board[2] === $playerId && $this->board[5] === $playerId && $this->board[8] === $playerId)
            || ($this->board[0] === $playerId && $this->board[4] === $playerId && $this->board[8] === $playerId)
            || ($this->board[2] === $playerId && $this->board[4] === $playerId && $this->board[6] === $playerId);
    }

    /**
     * Reset current board
     *
     * @return Board
     */
    public function reset(): self
    {
        $this->board = self::INIT_BOARD;

        return $this;
    }

    /**
     * Return current board (array of all cells)
     *
     * @return array
     */
    public function getBoard(): array
    {
        return $this->board;
    }
}
