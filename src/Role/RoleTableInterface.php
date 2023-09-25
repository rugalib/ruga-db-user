<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Role;

use Laminas\Db\ResultSet\ResultSetInterface;
use Ruga\Db\Table\TableInterface;

/**
 * Interface RoleTableInterface.
 *
 * @see      RoleTable
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface RoleTableInterface extends TableInterface
{
    /**
     * Find rows by name.
     *
     * @param string|string[] $name
     *
     * @return ResultSetInterface
     */
    public function findByName($name): ResultSetInterface;
    
    
    
    /**
     * Find row by name, id or instance.
     *
     * @param string|string[]|RoleInterface $q
     *
     * @return ResultSetInterface
     */
    public function find($q): ResultSetInterface;
    
    
    
    /**
     * Creates the configuration array for mezzio-authorization-rbac.roles.
     *
     * @return array
     */
    public function getRolesConfig(): array;
}