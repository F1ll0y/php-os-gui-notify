<?php

/*
 * This file is part of the JoliNotif project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace F1ll0y\PHPOSGUINotify\Exception;

use F1ll0y\PHPOSGUINotify\Notification;

class InvalidNotificationException extends \LogicException implements Exception
{
    private Notification $notification;

    public function __construct(
        Notification $notification,
        $message = '',
        $code = 0,
        Exception $previous = null
    ) {
        $this->notification = $notification;

        parent::__construct($message, $code, $previous);
    }

    public function getNotification(): Notification
    {
        return $this->notification;
    }
}
