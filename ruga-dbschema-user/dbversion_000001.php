<?php

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                    $comp_name
 */
$user = $resolver->getTableName(\Ruga\User\UserTable::class);

$pwd = function ($pwd) {
    return password_hash($pwd, PASSWORD_DEFAULT);
};

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
INSERT INTO `{$user}` (`id`, `username`, `password`, `fullname`, `email`, `mobile`, `created`, `createdBy`, `changed`, `changedBy`) VALUES
 ('1', 'SYSTEM', null, 'SYSTEM', null, null, NOW(), '1', NOW(), '1')
,('2', 'GUEST', null, 'GUEST', null, null, NOW(), '1', NOW(), '1')
,('3', 'admin', '{$pwd('eZ.1234')}', null, null, 'admin', NOW(), '1', NOW(), '1')
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
