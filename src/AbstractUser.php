<?php

declare(strict_types=1);

namespace Ruga\User;

use Laminas\Db\ResultSet\ResultSetInterface;
use Ruga\Db\Row\AbstractRugaRow;
use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;
use Ruga\User\Link\Role\UserHasRole;
use Ruga\User\Link\Role\UserHasRoleInterface;
use Ruga\User\Link\Role\UserHasRoleTable;
use Ruga\User\Role\RoleInterface;
use Ruga\User\Role\RoleTable;

/**
 * Abstract user.
 *
 * @see      User
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractUser extends AbstractRugaRow implements UserInterface
{
    /** @var array */
    private $roles;
    
    /** @var string The default hash algo used */
    const PASSWORD_HASH = PASSWORD_DEFAULT;
    
    /** @var int The minimum password length */
    const PASSWORD_MIN_LENGTH = 5;
    
    
    
    /**
     * Constructs a display name from the given fields.
     *
     * @return string
     * @throws \Exception
     * @see FullnameFeature
     * @see FullnameFeatureRowInterface
     *
     */
    public function getFullname(): string
    {
        return $this->offsetGet('fullname') ?? $this->offsetGet('username') ?? '';
    }
    
    
    
    /**
     * Persist the row and link the roles.
     *
     * @return int Affected Rows
     * @throws \Exception
     */
    public function save()
    {
        try {
            return parent::save();
        } finally {
            $rolesInDb = array_map(
                function (RoleInterface $item) {
                    // TODO: Change to uniqueid?
                    return "{$item->id}@{$item->type}";
                },
                iterator_to_array($this->findRoles())
            );
            
            $rolesToAdd = array_diff($this->roles ?? [], $rolesInDb);
            $rolesToDel = array_diff($rolesInDb, $this->roles ?? []);
            
            foreach ($rolesToAdd as $role_id) {
                /** @var RoleInterface $role */
                $role = (new RoleTable($this->getTableGateway()->getAdapter()))->findById($role_id)->current();
                /** @var UserHasRole $roleLink */
                $roleLink = (new UserHasRoleTable($this->getTableGateway()->getAdapter()))->createRow(
                    [
                        'User_id' => $this->id,
                        'Role_id' => $role->id,
                    ]
                );
                $roleLink->save();
            }
            
            foreach ($rolesToDel as $role_id) {
                /** @var RoleInterface $role */
                $role = (new RoleTable($this->getTableGateway()->getAdapter()))->findById($role_id)->current();
                if ($roleLink = (new UserHasRoleTable($this->getTableGateway()->getAdapter()))->findById(
                    [
                        [
                            'User_id' => $this->id,
                            'Role_id' => $role->id,
                        ],
                    ]
                )->current()) {
                    $roleLink->delete();
                }
            }
            
            $this->roles = null;
        }
    }
    
    
    
    /**
     * Returns the roles of the user.
     *
     * @return ResultSetInterface
     * @throws \ReflectionException
     */
    public function findRoles(): ResultSetInterface
    {
        $roleIds = array_map(
            function (UserHasRoleInterface $item) {
                return $item->Role_id;
            },
            iterator_to_array($this->findRoleLinks())
        );
        
        return (new RoleTable($this->getTableGateway()->getAdapter()))->findById($roleIds);
        /*
        $roleTable = new RoleTable($this->getTableGateway()->getAdapter());
        
        $user_id = $this->PK;
        $rs = $roleTable->select(
            function (Select $select) use ($user_id) {
                $select
                    ->join(['ur' => UserHasRoleTable::TABLENAME], 'id=ur.Role_id', [])
                    ->where(['ur.User_id' => $user_id]);
            }
        );
        return $rs;
        */
    }
    
    
    
    /**
     * Returns the links to the roles of the user.
     *
     * @return ResultSetInterface
     * @throws \ReflectionException
     */
    private function findRoleLinks(): ResultSetInterface
    {
        $linkTable = new UserHasRoleTable($this->getTableGateway()->getAdapter());
        
        $select = $linkTable->getSql()->select();
        $select->where(['User_id' => $this->PK]);
        return $linkTable->selectWith($select);
    }
    
    
    
    /**
     * Stores the given password as hash in the database and checks the length of the password.
     *
     * @param string $pwd
     *
     * @return void
     */
    public function setPasswordHash(string $pwd)
    {
        if (strlen($pwd) >= static::PASSWORD_MIN_LENGTH) {
            $this->password = password_hash($pwd, static::PASSWORD_HASH);
        } else {
            throw new Exception\PasswordTooShortException(
                "Password must be at least " . static::PASSWORD_MIN_LENGTH . " characters long"
            );
        }
    }
    
    
    
    /**
     * Check the given password.
     * If the password is correct, the function checks if the hash is still up to date.
     *
     * @param string $pwd
     *
     * @return bool
     * @throws \Exception
     */
    public function verifyPassword(string $pwd): bool
    {
        try {
            return password_verify($pwd ?? '', $this->password ?? '');
        } finally {
            if (!empty($this->password) && (strlen(
                        $this->password
                    ) >= static::PASSWORD_MIN_LENGTH) && password_needs_rehash(
                    $this->password,
                    static::PASSWORD_HASH
                )) {
                $this->setPasswordHash($pwd);
                \Ruga\Log::addLog(
                    "The password hash has been updated. Please save the user.",
                    \Ruga\Log\Severity::NOTICE
                );
            }
        }
    }
    
    
    
    /**
     * Return the linked roles uniqueid's as an array.
     * This gives all the assigned roles, even if the user has not been saved yet.
     *
     * @return string[]
     * @throws \ReflectionException
     */
    public function getRoles(): array
    {
        if ($this->roles === null) {
            // Store the uniqueid's of the roles in $this->roles
            $this->roles = array_map(
                function (RoleInterface $item) {
                    // TODO: Change to uniqueid?
                    return "{$item->id}@{$item->type}";
                },
                iterator_to_array($this->findRoles())
            );
        }
        return $this->roles;
    }
    
    
    
    /**
     * Check if the user has the given role.
     *
     * @param string|RoleInterface $roleQuery
     *
     * @return bool
     * @throws \ReflectionException
     */
    public function hasRole($roleQuery): bool
    {
        /** @var RoleInterface $role */
        if (!$role = (new RoleTable($this->getTableGateway()->getAdapter()))->find($roleQuery)->current()) {
            throw new Exception\RoleNotFoundException("Role '{$roleQuery}' not found");
        }
        
        return in_array($role->uniqueid, $this->getRoles());
    }
    
    
    
    /**
     * Add the given role(s) to the user.
     *
     * @param string|string[]|RoleInterface[] $rolesQuery
     *
     * @throws \ReflectionException
     */
    public function addRoles($rolesQuery)
    {
        if (!is_array($rolesQuery)) {
            $rolesQuery = [$rolesQuery];
        }
        
        foreach ($rolesQuery as $roleQuery) {
            /** @var RoleInterface $role */
            if (!$role = (new RoleTable($this->getTableGateway()->getAdapter()))->find($roleQuery)->current()) {
                throw new Exception\RoleNotFoundException("Role '{$roleQuery}' not found");
            }
            
            if (!$this->hasRole($role)) {
                $this->roles[] = $role->uniqueid;
            }
        }
    }
    
    
    
    /**
     * Remove the given role(s) from the user.
     *
     * @param string|string[]|RoleInterface[] $rolesQuery
     *
     * @return void
     * @throws \ReflectionException
     */
    public function removeRoles($rolesQuery)
    {
        if (!is_array($rolesQuery)) {
            $rolesQuery = [$rolesQuery];
        }
        
        foreach ($rolesQuery as $roleQuery) {
            /** @var RoleInterface $role */
            if (!$role = (new RoleTable($this->getTableGateway()->getAdapter()))->find($roleQuery)->current()) {
                throw new Exception\RoleNotFoundException("Role '{$roleQuery}' not found");
            }
            
            if ($this->hasRole($role)) {
                $this->roles = array_diff($this->getRoles(), [$role->uniqueid]);
            }
        }
    }
    
    
}
