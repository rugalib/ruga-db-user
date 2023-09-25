<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface UserAttributesInterface
 *
 * @see      User
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 *
 * @property int    $id                         Primary Key
 * @property string $username                   Username
 * @property string $password                   Password hash (null: login disabled, *: user disabled, -: user deleted, +<verification_code>: email verification)
 * @property string $fullname                   Full name / display name
 * @property string $email                      Email
 * @property string $mobile                     Mobile number
 * @property string $remark                     Remark
 */
interface UserAttributesInterface extends RowAttributesInterface
{
    
}