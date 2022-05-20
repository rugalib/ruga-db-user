<?php

declare(strict_types=1);

namespace Ruga\User\Role;

use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Sql;
use Laminas\Db\Sql\SqlInterface;
use Laminas\Db\Sql\Where;
use Ruga\Db\ResultSet\ResultSet;
use Ruga\Db\Row\AbstractRugaRow;
use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;

/**
 * Abstract user.
 *
 * @see      Role
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractRole extends AbstractRugaRow implements RoleInterface
{
    /**
     * Returns the children of the role.
     * A role inherits all the permissions from its children.
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
