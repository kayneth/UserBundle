<?php
/**
 * Created by PhpStorm.
 * User: dytembouct
 * Date: 08/02/2017
 * Time: 12:06
 */

namespace DT\UserBundle\Entity;


use Symfony\Component\Security\Core\User\AdvancedUserInterface;

interface UserInterface extends AdvancedUserInterface, \Serializable
{

    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    /**
     * Returns the user unique id.
     *
     * @return mixed
     */
    public function getId();
    /**
     * Sets the username.
     *
     * @param string $username
     *
     * @return self
     */
    public function setUsername($username);
    /**
     * @param string|null $salt
     */
    public function setSalt($salt);
    /**
     * Gets email.
     *
     * @return string
     */
    public function getEmail();
    /**
     * Sets the email.
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail($email);
    /**
     * Gets the plain password.
     *
     * @return string
     */
    public function getPlainPassword();
    /**
     * Sets the plain password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPlainPassword($password);
    /**
     * Sets the hashed password.
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword($password);
    /**
     * Tells if the the given user has the super admin role.
     *
     * @return bool
     */
    public function isSuperAdmin();
    /**
     * @param bool $boolean
     *
     * @return self
     */
    public function setEnabled($boolean);
    /**
     * Sets the super admin status.
     *
     * @param bool $boolean
     *
     * @return self
     */
    public function setSuperAdmin($boolean);

    /**
     * Sets the timestamp that the user requested a password reset.
     *
     * @param null|\DateTime $date
     *
     * @return self
     */
    public function setPasswordRequestedAt(\DateTime $date = null);
    /**
     * Checks whether the password reset request has expired.
     *
     * @param int $ttl Requests older than this many seconds will be considered expired
     *
     * @return int
     */
    public function isPasswordRequestNonExpired($ttl);
    /**
     * Sets the last login time.
     *
     * @param \DateTime $time
     *
     * @return self
     */
    public function setLastLogin(\DateTime $time = null);
    /**
     * Never use this to check if this user has access to anything!
     *
     * Use the AuthorizationChecker, or an implementation of AccessDecisionManager
     * instead, e.g.
     *
     *         $authorizationChecker->isGranted('ROLE_USER');
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role);
    /**
     * Sets the roles of the user.
     *
     * This overwrites any previous roles.
     *
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles);
    /**
     * Adds a role to the user.
     *
     * @param string $role
     *
     * @return self
     */
    public function addRole($role);
    /**
     * Removes a role to the user.
     *
     * @param string $role
     *
     * @return self
     */
    public function removeRole($role);
}