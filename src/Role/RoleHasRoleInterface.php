<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Role;

use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;
use Ruga\Db\Row\RowInterface;

/**
 * Interface RoleHasRoleInterface.
 *
 * @see      RoleHasRole
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface RoleHasRoleInterface extends RowInterface, RoleHasRoleAttributesInterface, FullnameFeatureRowInterface
{
}
