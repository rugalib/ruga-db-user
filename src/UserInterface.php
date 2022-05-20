<?php

declare(strict_types=1);

namespace Ruga\User;

use Laminas\Db\ResultSet\ResultSetInterface;
use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;
use Ruga\Db\Row\RowInterface;
use Ruga\User\Role\RoleInterface;

/**
 * Interface UserInterface.
 *
 * @see      User
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface UserInterface extends RowInterface, UserAttributesInterface, FullnameFeatureRowInterface
{
    /**
     * Returns the roles of the user.
     *
     * @return ResultSetInterface
     */
    public function findRoles(): ResultSetInterface;
    
    
    
    /**
     * Stores the given password as hash in the database and checks the length of the password.
     *
     * @param string $pwd
     *
     * @return void
     */
    public function setPasswordHash(string $pwd);
    
    
    
    /**
     * Check the given password.
     * If the password is correct, the function checks if the hash is still up to date.
     *
     * @param string $pwd
     *
     * @return bool
     * @throws \Exception
     */
    public function verifyPassword(string $pwd): bool;
    
    
    
    /**
     * Check if the user has the given role.
     *
     * @param string|RoleInterface $role
     *
     * @return bool
     */
    public function hasRole($role): bool;
    
    
    
    /**
     * Add the given role(s) to the user.
     *
     * @param string|string[]|RoleInterface[] $roles
     *
     * @return void
     */
    public function addRoles($roles);
    
    
    
    /**
     * Remove the given role(s) from the user.
     *
     * @param string|string[]|RoleInterface[] $roles
     *
     * @return void
     */
    public function removeRoles($roles);
    
    
    
    /**
     * Return the linked roles uniqueid's as an array.
     * This gives all the assigned roles, even if the user has not been saved yet.
     *
     * @return string[]
     * @throws \ReflectionException
     */
    public function getRoles(): array;
    
}
