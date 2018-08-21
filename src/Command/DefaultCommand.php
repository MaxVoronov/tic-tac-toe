<?php

declare(strict_types=1);

namespace App\Command;

use App\Game;
use App\IO\CliIO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultCommand extends Command
{
    protected function configure()
    {
        $this->setName('cli')
            ->setDescription('Play in CLI mode');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $game = new Game(new CliIO);
        $game->start();
    }
}
