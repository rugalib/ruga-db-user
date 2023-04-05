<?php

declare(strict_types=1);

namespace Ruga\User\Role;

use Laminas\Db\ResultSet\ResultSetInterface;
use Ruga\Db\ResultSet\ResultSet;
use Ruga\Db\Table\AbstractRugaTable;

/**
 * Abstract role table.
 *
 * @see      RoleTable
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractRoleTable extends AbstractRugaTable implements RoleTableInterface
{
    /**
     * Find rows by name.
     *
     * @param string|string[] $name
     *
     * @return ResultSetInterface
     */
    public function findByName($name): ResultSetInterface
    {
        return $this->select(['name' => $name]);
    }
    
    
    
    /**
     * Find row by name, id or instance.
     *
     * @param string|string[]|RoleInterface $q
     *
     * @return ResultSetInterface
     */
    public function find($q): ResultSetInterface
    {
        if ($q instanceof RoleInterface) {
            return $this->findById($q->uniqueid);
        } elseif (is_string($q) && (count($roles = $this->findByName($q)) > 0)) {
            return $roles;
        } elseif (is_string($q) && (count($roles = $this->findById($q)) > 0)) {
            return $roles;
        }
        return $this->findById(null);
    }
    
    
    
    /**
     * Creates the configuration array for mezzio-authorization-rbac.roles.
     *
     * @return array
     */
    public function getRolesConfig(): array
    {
        $roles = [];
        
        /** @var Role $role */
        foreach ($this->select() as $role) {
            $parents = $role->findParents();
            $roles[$role->name] = array_map(function (Role $role) {
                return $role->name;
            }, iterator_to_array($parents));
        }
        
        return $roles;
    }
    
    
}