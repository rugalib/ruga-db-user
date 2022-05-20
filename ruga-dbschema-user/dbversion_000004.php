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
CREATE TABLE `{$userhasrole}` (
  `{$user}_id` INT NOT NULL,
  `{$role}_id` INT NOT NULL,
  `created` DATETIME NOT NULL,
  `createdBy` INT NOT NULL,
  `changed` DATETIME NOT NULL,
  `changedBy` INT NOT NULL,
  PRIMARY KEY (`{$user}_id`, `{$role}_id`),
  INDEX `fk_{$userhasrole}_{$user}1_idx` (`{$user}_id` ASC),
  INDEX `fk_{$userhasrole}_{$role}1_idx` (`{$role}_id` ASC),
  INDEX `fk_{$userhasrole}_changedBy_idx` (`changedBy` ASC),
  INDEX `fk_{$userhasrole}_createdBy_idx` (`createdBy` ASC),
  CONSTRAINT `fk_{$userhasrole}_{$user}1` FOREIGN KEY (`{$user}_id`) REFERENCES `{$user}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$userhasrole}_{$role}1` FOREIGN KEY (`{$role}_id`) REFERENCES `{$role}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$userhasrole}_changedBy` FOREIGN KEY (`changedBy`) REFERENCES `{$user}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$userhasrole}_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `{$user}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE = InnoDB
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
