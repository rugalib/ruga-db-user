<?php

declare(strict_types=1);

namespace Ruga\User;

use Ruga\Db\Schema\Updater;
use Ruga\User\Link\Role\UserHasRoleTable;
use Ruga\User\Role\RoleHasRoleTable;
use Ruga\User\Role\RoleTable;

/**
 * ConfigProvider.
 *
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * @see    https://docs.mezzio.dev/mezzio/v3/features/container/config/
 */
class ConfigProvider
{
    public function __invoke()
    {
        return [
            'db' => [
                Updater::class => [
                    'components' => [
                        User::class => [
                            Updater::CONF_REQUESTED_VERSION => 8,
                            Updater::CONF_SCHEMA_DIRECTORY => __DIR__ . '/../ruga-dbschema-user',
                            Updater::CONF_TABLES => [
                                'UserTable' => UserTable::class,
                                'RoleTable' => RoleTable::class,
                                'UserHasRoleTable' => UserHasRoleTable::class,
                                'RoleHasRoleTable' => RoleHasRoleTable::class,
                            ],
                        ],
                    ],
                ],
            ],
            'dependencies' => [
                'services' => [],
                'aliases' => [
                    'UserTable' => UserTable::class,
                    UserTableInterface::class => UserTable::class,
                    'RoleTable' => RoleTable::class,
                    'UserHasRoleTable' => UserHasRoleTable::class,
                    'RoleHasRoleTable' => RoleHasRoleTable::class,
                ],
                'factories' => [
                    UserTable::class => Container\UserTableFactory::class,
                    RoleTable::class => Container\RoleTableFactory::class,
                    UserHasRoleTable::class => Container\UserHasRoleTableFactory::class,
                    RoleHasRoleTable::class => Container\RoleHasRoleTableFactory::class,
                ],
                'invokables' => [],
                'delegators' => [],
            ],
        ];
    }
}
