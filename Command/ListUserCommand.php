<?php

namespace DT\UserBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUserCommand extends ContainerAwareCommand
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('dt:list:users')
            ->setDescription('List app users')
            ->setHelp("This command allows you to list all users")
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $style = new OutputFormatterStyle('red', 'yellow', array('bold', 'blink'));
        $output->getFormatter()->setStyle('fire', $style);

        $output->writeln([
            '<fire>Listing users</fire>',
            '============='
        ]);

        $users = $this->getContainer()->get('doctrine')->getManager()->getRepository("DTUserBundle:User")->findAll();
        $usernames = array();
        foreach ($users as $user)
        {
            array_push($usernames, $user->getUsername());
        }

        $output->writeln($usernames);
    }
}