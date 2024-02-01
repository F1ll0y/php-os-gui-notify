<?php

/*
 * This file is part of the JoliNotif project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace F1ll0y\PHPOSGUINotify;

use F1ll0y\PHPOSGUINotify\Exception\NoSupportedNotifierException;
use F1ll0y\PHPOSGUINotify\Notifier\AppleScriptNotifier;
use F1ll0y\PHPOSGUINotify\Notifier\GrowlNotifyNotifier;
use F1ll0y\PHPOSGUINotify\Notifier\KDialogNotifier;
use F1ll0y\PHPOSGUINotify\Notifier\NotifuNotifier;
use F1ll0y\PHPOSGUINotify\Notifier\NotifySendNotifier;
use F1ll0y\PHPOSGUINotify\Notifier\NullNotifier;
use F1ll0y\PHPOSGUINotify\Notifier\SnoreToastNotifier;
use F1ll0y\PHPOSGUINotify\Notifier\TerminalNotifierNotifier;
use JoliCode\PhpOsHelper\OsHelper;

class NotifierFactory
{
    /**
     * @param Notifier[] $notifiers
     */
    public static function create(array $notifiers = []): Notifier
    {
        if (!$notifiers) {
            $notifiers = static::getDefaultNotifiers();
        }

        return self::chooseBestNotifier($notifiers) ?: new NullNotifier();
    }

    /**
     * @param Notifier[] $notifiers
     */
    public static function createOrThrowException(array $notifiers = []): Notifier
    {
        if (empty($notifiers)) {
            $notifiers = static::getDefaultNotifiers();
        }

        $bestNotifier = self::chooseBestNotifier($notifiers);

        if (!$bestNotifier) {
            throw new NoSupportedNotifierException();
        }

        return $bestNotifier;
    }

    /**
     * @return Notifier[]
     */
    public static function getDefaultNotifiers(): array
    {
        // Don't retrieve notifiers which are certainly not supported on this
        // system. This helps to lower the number of process to run.
        if (OsHelper::isUnix() && !OsHelper::isWindowsSubsystemForLinux()) {
            return self::getUnixNotifiers();
        }

        return self::getWindowsNotifiers();
    }

    /**
     * @return Notifier[]
     */
    private static function getUnixNotifiers(): array
    {
        return [
            new GrowlNotifyNotifier(),
            new TerminalNotifierNotifier(),
            new AppleScriptNotifier(),
            new KDialogNotifier(),
            new NotifySendNotifier(),
        ];
    }

    /**
     * @return Notifier[]
     */
    private static function getWindowsNotifiers(): array
    {
        return [
            new SnoreToastNotifier(),
            new NotifuNotifier(),
        ];
    }

    /**
     * @param Notifier[] $notifiers
     */
    private static function chooseBestNotifier(array $notifiers): ?Notifier
    {
        /** @var Notifier|null $bestNotifier */
        $bestNotifier = null;

        foreach ($notifiers as $notifier) {
            if (!$notifier->isSupported()) {
                continue;
            }

            if (null !== $bestNotifier && $bestNotifier->getPriority() >= $notifier->getPriority()) {
                continue;
            }

            $bestNotifier = $notifier;
        }

        return $bestNotifier;
    }
}
