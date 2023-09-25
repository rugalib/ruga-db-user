<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Link\Role;

use Ruga\User\Role\RoleTable;
use Ruga\User\UserTable;

/**
 * The user - role link table.
 *
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class UserHasRoleTable extends AbstractUserHasRoleTable
{
    const TABLENAME = UserTable::TABLENAME . '_has_' . RoleTable::TABLENAME;
    const PRIMARYKEY = [UserTable::TABLENAME . '_id', RoleTable::TABLENAME . '_id'];
//    const RESULTSETCLASS = ;
    const ROWCLASS = UserHasRole::class;
}
