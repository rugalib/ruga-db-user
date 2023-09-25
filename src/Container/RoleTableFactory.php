<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Container;

use Psr\Container\ContainerInterface;
use Ruga\Db\Adapter\Adapter;
use Ruga\User\AbstractUserTable;
use Ruga\User\Role\AbstractRoleTable;
use Ruga\User\Role\RoleTable;
use Ruga\User\UserTable;

class RoleTableFactory
{
    public function __invoke(ContainerInterface $container): AbstractRoleTable
    {
        return new RoleTable($container->get(Adapter::class));
    }
}