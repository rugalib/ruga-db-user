<?php

declare(strict_types=1);

namespace Ruga\User\Role;

/**
 * Role table.
 *
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class RoleTable extends AbstractRoleTable implements RoleTableInterface
{
    const TABLENAME = 'Role';
    const PRIMARYKEY = ['id'];
    const ROWCLASS = Role::class;
    
}
