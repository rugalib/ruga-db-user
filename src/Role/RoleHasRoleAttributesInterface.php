<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Role;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface RoleHasRoleAttributesInterface
 *
 * @see      RoleHasRole
 * @see      Role
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 *
 * @property int $parent_Role_id                         Foreign key to parent role
 * @property int $child_Role_id                          Foreign key to child role
 */
interface RoleHasRoleAttributesInterface extends RowAttributesInterface
{
    
}