<?php

declare(strict_types=1);

namespace App\IO;

class CliIO implements IOInterface
{
    /**
     * @inheritdoc
     */
    public function readln(string $message = ''): string
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
        $this->write($message . PHP_EOL);

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
