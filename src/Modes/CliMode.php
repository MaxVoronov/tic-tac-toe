<?php

declare(strict_types=1);

namespace App\Modes;

use App\Game;
use App\IO\CliIO;

class CliMode implements ModeInterface
{
    public const MODE_NAME = 'cli';

    public function execute(): void
    {
        $game = new Game(new CliIO);
        $game->start();
    }
}
