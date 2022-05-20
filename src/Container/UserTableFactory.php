<?php

declare(strict_types=1);

namespace Ruga\User\Container;

use Psr\Container\ContainerInterface;
use Ruga\Db\Adapter\Adapter;
use Ruga\User\AbstractUserTable;
use Ruga\User\UserTable;

class UserTableFactory
{
    public function __invoke(ContainerInterface $container): AbstractUserTable
    {
        return new UserTable($container->get(Adapter::class));
    }
}