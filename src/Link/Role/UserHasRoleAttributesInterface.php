<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Link\Role;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface UserHasRoleAttributesInterface
 *
 * @property int $User_id                       Primary key / foreign key to User
 * @property int $Role_id                       Primary key / foreign key to Role
 */
interface UserHasRoleAttributesInterface extends RowAttributesInterface
{
    
}