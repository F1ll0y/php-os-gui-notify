<?php

/*
 * This file is part of the JoliNotif project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace F1ll0y\PHPOSGUINotify\Notifier;

use F1ll0y\PHPOSGUINotify\Notification;

/**
 * This notifier can be used on Linux distributions running KDE, using the command kdialog.
 * This command is shipped by default with KDE.
 */
class KDialogNotifier extends CliBasedNotifier
{
    public function getBinary(): string
    {
        return 'kdialog';
    }

    public function getPriority(): int
    {
        return static::PRIORITY_HIGH;
    }

    protected function getCommandLineArguments(Notification $notification): array
    {
        $arguments = [];

        if ($notification->getTitle()) {
            $arguments[] = '--title';
            $arguments[] = $notification->getTitle();
        }

        $arguments[] = '--passivepopup';
        $arguments[] = $notification->getBody();

        // Timeout, in seconds
        $arguments[] = 5;

        return $arguments;
    }

    protected function getInstallCommandLineArguments(string $appName, string $pathToExecutable, string $appId): array
    {
        // TODO: Implement getInstallCommandLineArguments() method.
        return [];
    }
}
