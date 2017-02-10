<?php

namespace DT\UserBundle\Utils;

use Doctrine\ORM\EntityManager;
use DT\UserBundle\Entity\UserInterface;

class UserManager implements UserManagerInterface
{

    private $em;
    private $passwordUpdater;

    public function __construct(EntityManager $em, PasswordUpdaterInterface $passwordUpdater)
    {
        $this->em = $em;
        $this->passwordUpdater = $passwordUpdater;
    }

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function create(UserInterface $user)
    {
        $this->passwordUpdater->hashPassword($user);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Activates the given user.
     *
     * @param string $username
     */
    public function activate($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setEnabled(true);
        $this->update($user);
    }

    /**
     * @param string $username
     * @return mixed
     */
    public function deactivate($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setEnabled(false);
        $this->update($user);
    }

    /**
     * Changes the password for the given user.
     *
     * @param string $username
     * @param string $password
     */
    public function changePassword($username, $password)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setPlainPassword($password);
        $this->update($user);
    }

    /**
     * Promotes the given user.
     *
     * @param string $username
     */
    public function promote($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setSuperAdmin(true);
        $this->update($user);
    }

    /**
     * Demotes the given user.
     *
     * @param string $username
     */
    public function demote($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $user->setSuperAdmin(false);
        $this->update($user);
    }

    /**
     * Adds role to the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return bool true if role was added, false if user already had the role
     */
    public function addRole($username, $role)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        if ($user->hasRole($role)) {
            return false;
        }
        $user->addRole($role);
        $this->update($user);
        return true;
    }

    /**
     * Removes role from the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return bool true if role was removed, false if user didn't have the role
     */
    public function removeRole($username, $role)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        if (!$user->hasRole($role)) {
            return false;
        }
        $user->removeRole($role);
        $this->update($user);
        return true;
    }

    /**
     * Finds a user by his username and throws an exception if we can't find it.
     *
     * @param string $username
     *
     * @throws \InvalidArgumentException When user does not exist
     *
     * @return UserInterface
     */
    public function findUserByUsernameOrThrowException($username)
    {
        $user = $this->em->getRepository("DTUserBundle:User")->findOneByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }
        return $user;
    }

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function reloadUser(UserInterface $user)
    {
        $this->em->refresh($user);
    }

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function update(UserInterface $user, $andFlush = true)
    {
        $this->updatePassword($user);
        $this->em->persist($user);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function updatePassword(UserInterface $user)
    {
        $this->passwordUpdater->hashPassword($user);
    }


}