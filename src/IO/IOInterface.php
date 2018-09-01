<?php

declare(strict_types=1);

namespace App\IO;

interface IOInterface
{
    /**
     * Read line by user
     *
     * @param string $message
     * @return string
     */
    public function readln(string $message = ''): string;

    /**
     * Output simple string
     *
     * @param $message
     * @return IOInterface
     */
    public function write($message): IOInterface;

    /**
     * Output string and move to new line
     *
     * @param $message
     * @return IOInterface
     */
    public function writeln($message): IOInterface;

    /**
     * Output empty line
     *
     * @return IOInterface
     */
    public function emptyLine(): IOInterface;
}
