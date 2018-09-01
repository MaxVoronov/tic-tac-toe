<?php

declare(strict_types=1);

namespace App\IO;

class SocketIO implements IOInterface
{
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function readln(string $message = ''): string
    {
        if (!empty($message)) {
            $this->write($message);
        }

        return trim(socket_read($this->client, 4096, PHP_BINARY_READ));
    }

    /**
     * @inheritdoc
     */
    public function write($message): IOInterface
    {
        socket_write($this->client, $message);

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
        $this->writeln('');

        return $this;
    }
}
