<?php

declare(strict_types=1);

namespace App\Command;

use App\GameModeManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('start')
            ->setDescription('Start new game')
            ->addOption(
                'mode',
                'm',
                InputOption::VALUE_REQUIRED,
                'Game mode (cli or socket)',
                GameModeManager::getDefaultMode()
            )
            ->addOption(
                'host',
                null,
                InputOption::VALUE_REQUIRED,
                'Host (only for socket mode)',
                '0.0.0.0'
            )
            ->addOption(
                'port',
                null,
                InputOption::VALUE_REQUIRED,
                'Port (only for socket mode)',
                8888
            )
            ->addOption(
                'max_connections',
                'c',
                InputOption::VALUE_REQUIRED,
                'Maximum process child for processing connections (only for socket mode)',
                10
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $mode = $input->getOption('mode');
            $params = [
                'host' => $input->getOption('host'),
                'port' => $input->getOption('port'),
                'max_connections' => $input->getOption('max_connections'),
            ];

            $gameModeManager = new GameModeManager();
            $gameModeManager->start($mode, $params);
        } catch (\Exception $e) {
            $errorBlock = $this->getHelper('formatter')->formatBlock(['Error:', $e->getMessage()], 'error', true);
            $output->writeln($errorBlock);
        }
    }
}
