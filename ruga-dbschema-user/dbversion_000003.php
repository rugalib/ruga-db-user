<?php

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                    $comp_name
 */
$user = $resolver->getTableName(\Ruga\User\UserTable::class);
$role = $resolver->getTableName(\Ruga\User\Role\RoleTable::class);

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
INSERT INTO `{$role}` (`id`, `name`, `created`, `createdBy`, `changed`, `changedBy`) VALUES
 ('1', 'system', NOW(), '1', NOW(), '1')
,('2', 'guest', NOW(), '1', NOW(), '1')
,('3', 'admin', NOW(), '1', NOW(), '1')
,('4', 'user', NOW(), '1', NOW(), '1')
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
