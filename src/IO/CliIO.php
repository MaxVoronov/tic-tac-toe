<?php

declare(strict_types=1);

namespace App\IO;

class CliIO implements IOInterface
{
    /**
     * @inheritdoc
     */
    public function readln($message = ''): string
    {
        return readline($message);
    }

    /**
     * @inheritdoc
     */
    public function write($message): IOInterface
    {
        echo $message;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function writeln($message): IOInterface
    {
        echo $message . PHP_EOL;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function emptyLine(): IOInterface
    {
        return $this->writeln('');
    }
}
