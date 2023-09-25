<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Role;

use Ruga\Db\Table\AbstractRugaTable;

/**
 * RoleHasRole table.
 * A parent inherits all permissions of its children
 *
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class RoleHasRoleTable extends AbstractRugaTable
{
    const TABLENAME = 'Role_has_Role';
    const PRIMARYKEY = ['parent_Role_id', 'child_Role_id'];
    const ROWCLASS = RoleHasRole::class;
}
