<?php

namespace DT\UserBundle\Controller;

use DT\UserBundle\Event\DTUserEvents;
use DT\UserBundle\Entity\User;
use DT\UserBundle\Event\RegistrationEvent;
use DT\UserBundle\EventSubscriber\RegistrationSubscriber;
use DT\UserBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $user = new User();

        $dispatcher = $this->get('event_dispatcher');

        $event = new RegistrationEvent($user);
        $dispatcher->dispatch(DTUserEvents::REGISTER_INITIALIZE, $event);

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->get("dt_user.manager")->create($user);

            return $this->render("DTUserBundle:Registration:confirmed.html.twig");
        }

        return $this->render("DTUserBundle:Registration:register.html.twig", array(
            'form' => $form->createView()
        ));
    }
}
