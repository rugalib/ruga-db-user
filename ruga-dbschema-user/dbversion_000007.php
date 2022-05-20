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
$rolehasrole = $resolver->getTableName(\Ruga\User\Role\RoleHasRoleTable::class);

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
INSERT INTO `{$rolehasrole}` (`parent_Role_id`, `child_Role_id`, `created`, `createdBy`, `changed`, `changedBy`) VALUES
 ('1', '3', NOW(), '1', NOW(), '1')
,('3', '4', NOW(), '1', NOW(), '1')
,('4', '2', NOW(), '1', NOW(), '1')
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
