<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Role;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface RoleAttributesInterface
 *
 * @see      Role
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 *
 * @property int    $id                         Primary Key
 * @property string $name                       Role name
 * @property string $remark                     Remark
 */
interface RoleAttributesInterface extends RowAttributesInterface
{
    
}