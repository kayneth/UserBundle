<?php

namespace DT\UserBundle\Security;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use DT\UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{


    private $em;
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    public function loadUserByUsername($username)
    {
        $criteria = new Criteria();
        $criteria->where(new Comparison("username", Comparison::EQ, $username));
        $criteria->orWhere(new Comparison("email", Comparison::EQ, $username));
        $criteria->setMaxResults(1);
        $userData = $this->em->getRepository("DTUserBundle:User")->matching($criteria)->first();
        if ($userData != null) {
            switch ($userData->getActive()) {
                case User::DISABLED:
                    throw new DisabledException("Your account is disabled. Please contact the administrator.");
                    break;
//                case User::_WAIT_VALIDATION:
//                    throw new LockedException("Your account is locked. Check and valid your email account.");
//                    break;
                case User::ACTIVE:
                    return $userData;
                    break;
            }
        }
        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
    }

    /**
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return mixed
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $class
     * @return mixed
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }


}