<?php

namespace Tests\DT\UserBundle\Command;

use DT\UserBundle\Command\ListUserCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ListUserCommandTest extends  KernelTestCase
{
    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new ListUserCommand());

        $command = $application->find('dt:list:users');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array());

        $output = $commandTester->getDisplay();
        $this->assertContains('');
    }
}