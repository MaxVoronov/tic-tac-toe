<?php

declare(strict_types=1);

namespace App\Modes;

use App\Game;
use App\IO\SocketIO;
use App\Exception\SocketException;

class SocketMode implements ModeInterface
{
    public const MODE_NAME = 'socket';

    /** @var resource */
    protected $socket;

    /** @var string */
    protected $host;

    /** @var int */
    protected $port;

    /** @var int */
    protected $maxConnections;

    public function __construct(array $params = [])
    {
        $this->host = $params['host'] ?? '0.0.0.0';
        $this->port = (int)($params['port'] ?? 8888);
        $this->maxConnections = (int)($params['max_connections'] ?? 10);

        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false) {
            throw new SocketException('Can\'t create socket');
        }

        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);    // ???
        if (!socket_bind($this->socket, $this->host, $this->port)) {
            $socketError = socket_strerror(socket_last_error($this->socket));
            throw new SocketException(sprintf('Can\'t bind socket to %s:%s: %s', $this->host, $this->port, $socketError));
        }

        if (!socket_listen($this->socket, 2)) {
            throw new SocketException('Can\'t set up socket listen');
        }
    }

    /**
     * Execute child processes for connection processing
     */
    public function execute(): void
    {
        for ($i = 0; $i < $this->maxConnections; $i++) {
            $pid = pcntl_fork();
            if ($pid === 0) {
                while (true) {
                    $client = socket_accept($this->socket);
                    $socketIO = new SocketIO($client);

                    $game = new Game($socketIO);
                    $game->start();

                    socket_close($client);
                }
            }
        }

        while (pcntl_waitpid(0, $status) !== -1) {
            pcntl_wexitstatus($status);
        }

        socket_close($this->socket);
    }
}