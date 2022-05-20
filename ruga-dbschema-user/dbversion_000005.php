<?php

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                    $comp_name
 */
$user = $resolver->getTableName(\Ruga\User\UserTable::class);
$role = $resolver->getTableName(\Ruga\User\Role\RoleTable::class);
$userhasrole = $resolver->getTableName(\Ruga\User\Link\Role\UserHasRoleTable::class);

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
INSERT INTO `{$userhasrole}` (`{$user}_id`, `{$role}_id`, `created`, `createdBy`, `changed`, `changedBy`) VALUES (1, 1, '2020-01-01 00:00:00', 1, '2020-01-01 00:00:00', 1);
INSERT INTO `{$userhasrole}` (`{$user}_id`, `{$role}_id`, `created`, `createdBy`, `changed`, `changedBy`) VALUES (2, 2, '2020-01-01 00:00:00', 1, '2020-01-01 00:00:00', 1);
INSERT INTO `{$userhasrole}` (`{$user}_id`, `{$role}_id`, `created`, `createdBy`, `changed`, `changedBy`) VALUES (3, 3, '2020-01-01 00:00:00', 1, '2020-01-01 00:00:00', 1);
SET FOREIGN_KEY_CHECKS = 1;

SQL;
