<?php

declare(strict_types=1);

/**
 * @return string
 * @var \Ruga\Db\Schema\Resolver $resolver
 * @var string                    $comp_name
 */
$user = $resolver->getTableName(\Ruga\User\UserTable::class);

return <<<"SQL"

SET FOREIGN_KEY_CHECKS = 0;
CREATE TABLE `{$user}` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NULL DEFAULT NULL,
  `fullname` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `mobile` VARCHAR(255) NULL DEFAULT NULL,
  `remark` TEXT NULL,
  `created` DATETIME NOT NULL,
  `createdBy` INT NOT NULL,
  `changed` DATETIME NOT NULL,
  `changedBy` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_{$user}_changedBy_idx` (`changedBy` ASC),
  INDEX `fk_{$user}_createdBy_idx` (`createdBy` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  CONSTRAINT `fk_{$user}_changedBy` FOREIGN KEY (`changedBy`) REFERENCES `{$user}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_{$user}_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `{$user}` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
;
SET FOREIGN_KEY_CHECKS = 1;

SQL;
