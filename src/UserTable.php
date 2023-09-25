<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User;

/**
 * User table.
 *
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class UserTable extends AbstractUserTable implements UserTableInterface
{
    const TABLENAME = 'User';
    const PRIMARYKEY = ['id'];
    const ROWCLASS = User::class;
    
}
