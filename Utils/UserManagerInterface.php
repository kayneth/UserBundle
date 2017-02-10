<?php
/**
 * Created by PhpStorm.
 * User: dytembouct
 * Date: 09/02/2017
 * Time: 15:31
 */

namespace DT\UserBundle\Utils;


use DT\UserBundle\Entity\UserInterface;

interface UserManagerInterface
{

    /**
     * Create a new User based on a User Object and returns it
     *
     * @param UserInterface $user
     *
     * @return \DT\UserBundle\Entity\UserInterface
     */
    public function create(UserInterface $user);

    /**
     * Activates the given user.
     *
     * @param string $username
     */
    public function activate($username);

    /**
    * Deactivates the given user.
    *
    * @param string $username
    */
    public function deactivate($username);

    /**
     * Changes the password for the given user.
     *
     * @param string $username
     * @param string $password
     */
    public function changePassword($username, $password);

    /**
     * Promotes the given user.
     *
     * @param string $username
     */
    public function promote($username);

    /**
     * Demotes the given user.
     *
     * @param string $username
     */
    public function demote($username);

    /**
     * Adds role to the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return bool true if role was added, false if user already had the role
     */
    public function addRole($username, $role);

    /**
     * Removes role from the given user.
     *
     * @param string $username
     * @param string $role
     *
     * @return bool true if role was removed, false if user didn't have the role
     */
    public function removeRole($username, $role);

    /**
     * Finds a user by his username and throws an exception if we can't find it.
     *
     * @param string $username
     *
     * @throws \InvalidArgumentException When user does not exist
     *
     * @return UserInterface
     */
    public function findUserByUsernameOrThrowException($username);

    /**
     * Reloads a user.
     *
     * @param UserInterface $user
     */
    public function reloadUser(UserInterface $user);

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     */
    public function update(UserInterface $user);

    /**
     * Updates a user password if a plain password is set.
     *
     * @param UserInterface $user
     */
    public function updatePassword(UserInterface $user);
}