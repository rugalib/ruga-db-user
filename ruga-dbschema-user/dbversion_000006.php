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
CREATE TABLE `{$rolehasrole}` (
  `parent_Role_id` INT NOT NULL,
  `child_Role_id` INT NOT NULL,
  `created` DATETIME NOT NULL,
  `createdBy` INT NOT NULL,
  `changed` DATETIME NOT NULL,
  `changedBy` INT NOT NULL,
  PRIMARY KEY (`parent_Role_id`, `child_Role_id`),
  INDEX `fk_{$rolehasrole}_parent_Role1_idx` (`parent_Role_id` ASC),
  INDEX `fk_{$rolehasrole}_child_Role1_idx` (`child_Role_id` ASC),
  INDEX `fk_{$rolehasrole}_changedBy_idx` (`changedBy` ASC),
  INDEX `fk_{$rolehasrole}_createdBy_idx` (`createdBy` ASC),
  CONSTRAINT `fk_{$rolehasrole}_parent_Role1` FOREIGN KEY (`parent_Role_id`) REFERENCES `{$role}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$rolehasrole}_child_Role1` FOREIGN KEY (`child_Role_id`) REFERENCES `{$role}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$rolehasrole}_changedBy` FOREIGN KEY (`changedBy`) REFERENCES `{$user}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$rolehasrole}_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `{$user}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = InnoDB
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
