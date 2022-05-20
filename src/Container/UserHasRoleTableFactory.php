<?php

declare(strict_types=1);

namespace Ruga\User\Container;

use Psr\Container\ContainerInterface;
use Ruga\Db\Adapter\Adapter;
use Ruga\User\Link\Role\AbstractUserHasRoleTable;
use Ruga\User\Link\Role\UserHasRoleTable;

class UserHasRoleTableFactory
{
    public function __invoke(ContainerInterface $container): AbstractUserHasRoleTable
    {
        return new UserHasRoleTable($container->get(Adapter::class));
    }
}