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
use F1ll0y\PHPOSGUINotify\Notifier\NotifuNotifier;

class NotifuNotifierTest extends NotifierTestCase
{
    use BinaryProviderTestTrait;
    use CliBasedNotifierTestTrait;

    private const BINARY = 'notifu';

    public function testGetBinary()
    {
        $notifier = $this->getNotifier();

        $this->assertSame(self::BINARY, $notifier->getBinary());
    }

    public function testGetPriority()
    {
        $notifier = $this->getNotifier();

        $this->assertSame(Notifier::PRIORITY_LOW, $notifier->getPriority());
    }

    protected function getNotifier(): Notifier
    {
        return new NotifuNotifier();
    }

    protected function getExpectedCommandLineForNotification(): string
    {
        return <<<'CLI'
            'notifu' '/m' 'I'\''m the notification body'
            CLI;
    }

    protected function getExpectedCommandLineForNotificationWithATitle(): string
    {
        return <<<'CLI'
            'notifu' '/m' 'I'\''m the notification body' '/p' 'I'\''m the notification title'
            CLI;
    }

    protected function getExpectedCommandLineForNotificationWithAnIcon(): string
    {
        $iconDir = $this->getIconDir();

        return <<<CLI
            'notifu' '/m' 'I'\\''m the notification body' '/i' '{$iconDir}/image.gif'
            CLI;
    }

    protected function getExpectedCommandLineForNotificationWithAllOptions(): string
    {
        $iconDir = $this->getIconDir();

        return <<<CLI
            'notifu' '/m' 'I'\\''m the notification body' '/p' 'I'\\''m the notification title' '/i' '{$iconDir}/image.gif'
            CLI;
    }
}
