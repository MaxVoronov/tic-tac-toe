<?php

declare(strict_types=1);

namespace App\IO;

class DummyIO implements IOInterface
{
    /**
     * @inheritdoc
     */
    public function readln(string $message = ''): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function write($message): IOInterface
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function writeln($message): IOInterface
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function emptyLine(): IOInterface
    {
        return $this;
    }
}
