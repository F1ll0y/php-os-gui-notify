<?php

/*
 * This file is part of the JoliNotif project.
 *
 * (c) Loïck Piera <pyrech@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace F1ll0y\PHPOSGUINotify\tests\Notifier;

use F1ll0y\PHPOSGUINotify\Notifier;
use F1ll0y\PHPOSGUINotify\Notifier\GrowlNotifyNotifier;

class GrowlNotifyNotifierTest extends NotifierTestCase
{
    use CliBasedNotifierTestTrait;

    private const BINARY = 'growlnotify';

    public function testGetBinary()
    {
        $notifier = $this->getNotifier();

        $this->assertSame(self::BINARY, $notifier->getBinary());
    }

    public function testGetPriority()
    {
        $notifier = $this->getNotifier();

        $this->assertSame(Notifier::PRIORITY_HIGH, $notifier->getPriority());
    }

    protected function getNotifier(): Notifier
    {
        return new GrowlNotifyNotifier();
    }

    protected function getExpectedCommandLineForNotification(): string
    {
        return <<<'CLI'
            'growlnotify' '--message' 'I'\''m the notification body'
            CLI;
    }

    protected function getExpectedCommandLineForNotificationWithATitle(): string
    {
        return <<<'CLI'
            'growlnotify' '--message' 'I'\''m the notification body' '--title' 'I'\''m the notification title'
            CLI;
    }

    protected function getExpectedCommandLineForNotificationWithAnIcon(): string
    {
        $iconDir = $this->getIconDir();

        return <<<CLI
            'growlnotify' '--message' 'I'\\''m the notification body' '--image' '{$iconDir}/image.gif'
            CLI;
    }

    protected function getExpectedCommandLineForNotificationWithAllOptions(): string
    {
        $iconDir = $this->getIconDir();

        return <<<CLI
            'growlnotify' '--message' 'I'\\''m the notification body' '--title' 'I'\\''m the notification title' '--image' '{$iconDir}/image.gif'
            CLI;
    }
}
