# Tic Tac Toe Game

This simple game is creative homework for Otus PHP course.

## Usage
You can run the game one of two modes: CLI or Socket. For running in CLI mode use:
```
$ bin/game start
```

For running game in socket mode set additional flag (mode) and another settings:
```
$ bin/game start --mode=socket
$ bin/game start --mode=socket --host=0.0.0.0 --port=8888 --max_connections=10
```

After running you can connect via _telnet_ and start playing:
```
$ telnet localhost 8888
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.