<?php

declare(strict_types=1);

namespace Ruga\User\Container;

use Psr\Container\ContainerInterface;
use Ruga\Db\Adapter\Adapter;
use Ruga\User\Role\RoleHasRoleTable;

class RoleHasRoleTableFactory
{
    public function __invoke(ContainerInterface $container): RoleHasRoleTable
    {
        return new RoleHasRoleTable($container->get(Adapter::class));
    }
}