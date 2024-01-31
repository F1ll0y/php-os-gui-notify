<?php

/*
 * This file is part of the JoliNotif project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Joli\JoliNotif\Notifier;

use Joli\JoliNotif\Notification;
use Joli\JoliNotif\Notifier;

class NullNotifier implements Notifier
{
    public function isSupported(): bool
    {
        return true;
    }

    public function getPriority(): int
    {
        return static::PRIORITY_LOW;
    }

    public function send(Notification $notification): bool
    {
        return false;
    }

    protected function getInstallCommandLineArguments(string $appName, string $pathToExecutable, string $appId): array
    {
        // TODO: Implement getInstallCommandLineArguments() method.
        return [];
    }

    public function install(string $appName, string $pathToExecutable, string $appId): bool
    {
        return true;
    }
}
