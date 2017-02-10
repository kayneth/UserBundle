<?php

namespace DT\UserBundle\Command;

use DT\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class CreateUserCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('dt:create:user')
            ->setDescription('Create a new user')
            ->setHelp("This command allows you to create a new user")
        ;

//        $this
//            ->addArgument('username', InputArgument::REQUIRED, "The Username of the user")
//            ->addArgument('email', InputArgument::REQUIRED, "The email of the user")
//            ->addArgument('password', InputArgument::REQUIRED, "The password of the user")
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        //USERNAME
        $question = new Question('Username : ');
        $username = $helper->ask($input, $output, $question);

        //EMAIL
        $question = new Question('Email : ');
        $question->setValidator(function ($value) {
            $pattern ='/^.+\@\S+\.\S+$/';
            if (!preg_match($pattern, $value)) {
                throw new \Exception('This should be a valid email address');
            }

            return $value;
        });
        $email = $helper->ask($input, $output, $question);

        //PASSWORD
        $question = new Question('Please enter your password : ');
        $question->setValidator(function ($value) {
            if (trim($value) == '') {
                throw new \Exception('The password cannot be empty');
            }

            return $value;
        });
        $question->setHidden(true);
        $question->setMaxAttempts(3);
        $password = (true === $helper->ask($input, $output, $question));

        //ISADMIN
        $question = new ConfirmationQuestion('Is this user should be promote admin ? ', false);
        $isAdmin = $helper->ask($input, $output, $question);

        //CONFIRM
        $question = new ConfirmationQuestion('Do you confirm the creation of the user '.$username.' ? ', false);
        if (!$helper->ask($input, $output, $question)) {
            return;
        }

        $user = new User();
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail($email);
        $user->setSuperAdmin($isAdmin);

       $this->getContainer()->get("dt_user.manager")->create($user);

        $output->writeln(['==============', 'User successfully generated!']);
    }
}