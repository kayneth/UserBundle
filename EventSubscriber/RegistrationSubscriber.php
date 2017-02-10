<?php

namespace DT\UserBundle\EventSubscriber;

use DT\UserBundle\Event\DTUserEvents;
use DT\UserBundle\Event\RegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegistrationSubscriber implements EventSubscriberInterface
{
    function __construct()
    {
    }

    /**
     * @return mixed
     */
    public static function getSubscribedEvents()
    {
        return array(
            DTUserEvents::REGISTER_INITIALIZE => array(
                array("onRegisterInitialize")
            )
        );
    }

    public function onRegisterInitialize(RegistrationEvent $event)
    {
        return $event->getUser()->setEmail("test@mail.fr");
    }

}