<?php

/*
 * This file is part of the JoliNotif project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Joli\JoliNotif;

interface Notifier
{
    public const PRIORITY_LOW = 0;
    public const PRIORITY_MEDIUM = 50;
    public const PRIORITY_HIGH = 100;

    /**
     * This method is called to check whether the notifier can be used on the
     * current system or not.
     *
     * @return bool if this notifier class is supported on this os
     */
    public function isSupported(): bool;

    /**
     * this method is used to create start menu entries for windows, so notifications can get the flavour of your application
     *
     * @param string $appName name and path for start menue (e.g. MyApp/MyApp.lnk))
     * @param string $pathToExecutable path to exe file of this application
     * @param string $appId app id used for notifications
     * @return bool if its succeed
     */
    public function install(string $appName, string $pathToExecutable, string $appId): bool;

    /**
     * The supported notifier with the higher priority will be preferred.
     * @return int get priority as int value (higher is more important))
     */
    public function getPriority(): int;

    /**
     * Send the given notification.
     *
     * @return bool if its succeed
     *
     * @throws Exception\InvalidNotificationException if the notification is invalid
     */
    public function send(Notification $notification): bool;
}
