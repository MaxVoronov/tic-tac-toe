<?php

declare(strict_types=1);

namespace App\Modes;

interface ModeInterface
{
    public function execute(): void;
}
