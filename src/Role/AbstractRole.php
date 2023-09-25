<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Role;

use Laminas\Db\Sql\Select;
use Ruga\Db\ResultSet\ResultSet;
use Ruga\Db\Row\AbstractRugaRow;

/**
 * Abstract user.
 *
 * @see      Role
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractRole extends AbstractRugaRow implements RoleInterface
{
    /**
     * Returns the children of the ROLE non-recursively.
     * A ROLE inherits all the permissions from its children.
     *
     * @return ResultSet
     */
    public function findChildren(): ResultSet
    {
        /** @var Select $select */
        $select = $this->getTableGateway()->getSql()->select();
        $select
            ->join(['rhr' => RoleHasRoleTable::TABLENAME], 'rhr.child_Role_id = Role.id', [])
            ->where(['rhr.parent_Role_id' => $this->PK]);

//        \Ruga\Log::log_msg("SQL={$this->getTableGateway()->getSql()->buildSqlString($select)}");
        return $this->getTableGateway()->selectWith($select);
    }
    
    
    
    /**
     * Find all ROLEs recursively by iterating through all children.
     *
     * @param array|null $prevIds
     *
     * @return ResultSet
     * @throws \Exception
     */
    public function findChildrenRecursive(array &$prevIds = null): ResultSet
    {
        $ids = $prevIds === null ? [] : $prevIds;
        /** @var RoleInterface $child */
        foreach ($this->findChildren() as $child) {
            $ids[] = $child->uniqueid;
            $child->findChildrenRecursive($ids);
        }
        
        if ($prevIds === null) {
            return $this->getTableGateway()->findById($ids);
        }
        
        $prevIds = $ids;
        return $this->getTableGateway()->findById(null);
    }
    
    
    
    /**
     * Returns the parents of the role.
     * The parent roles inherit the permissions of the child.
     * AKA: The parents can do at least everything their children can do.
     *
     * @return ResultSet
     */
    public function findParents(): ResultSet
    {
        /** @var Select $select */
        $select = $this->getTableGateway()->getSql()->select();
        $select
            ->join(['rhr' => RoleHasRoleTable::TABLENAME], 'rhr.parent_Role_id = Role.id', [])
            ->where(['rhr.child_Role_id' => $this->PK]);

//        \Ruga\Log::log_msg("SQL={$this->getTableGateway()->getSql()->buildSqlString($select)}");
        return $this->getTableGateway()->selectWith($select);
    }
    
}
