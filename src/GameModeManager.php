<?php

declare(strict_types=1);

namespace App;

use App\Modes\CliMode;
use App\Modes\SocketMode;
use App\Modes\ModeInterface;
use App\Exception\UnsupportedModeException;

class GameModeManager
{
    protected const MODE_MAP = [
        CliMode::MODE_NAME => CliMode::class,
        SocketMode::MODE_NAME => SocketMode::class,
    ];

    /**
     * Start new game by selected mode
     *
     * @param string $mode
     * @param array $params
     */
    public function start(string $mode, array $params = []): void
    {
        $this->getStrategy($mode, $params)->execute();
    }

    /**
     * Return default game mode
     *
     * @return string
     */
    public static function getDefaultMode(): string
    {
        return CliMode::MODE_NAME;
    }

    /**
     * Return new mode object using strategy
     *
     * @param string $mode
     * @param array $params
     * @return ModeInterface
     */
    protected function getStrategy(string $mode, array $params = []): ModeInterface
    {
        if (!array_key_exists($mode, self::MODE_MAP)) {
            throw new UnsupportedModeException(sprintf('Unsupported mode "%s"', $mode));
        }

        $modeClass = self::MODE_MAP[$mode];

        return new $modeClass($params);
    }
}
