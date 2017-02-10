<?php

namespace DT\UserBundle\Event;

use DT\UserBundle\Entity\UserInterface;
use Symfony\Component\EventDispatcher\Event;

class RegistrationEvent extends Event
{

    private $user;

    function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}