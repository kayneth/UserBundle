<?php

namespace DT\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{

    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        $authError = Security::AUTHENTICATION_ERROR;

        if ($request->attributes->has($authError)) {
            $error = $request->attributes->get($authError);
        } elseif (null !== $session && $session->has($authError)) {
            $error = $session->get($authError);
            $session->remove($authError);
        } else{
            $error = null;
        }

        if(!$error instanceof AuthenticationException) {
            $error = null;
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(Security::LAST_USERNAME);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render("DTUserBundle:Security:login.html.twig", array(
            "last_username" => $lastUsername,
            "error"         => $error,
            'csrf_token' => $csrfToken,
        ));
    }

    public function check()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    public function logout()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}
