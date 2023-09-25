<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Role;

use Ruga\Db\ResultSet\ResultSet;
use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;
use Ruga\Db\Row\RowInterface;

/**
 * Interface UserInterface.
 *
 * @see      Role
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface RoleInterface extends RowInterface, RoleAttributesInterface, FullnameFeatureRowInterface
{
    /**
     * Returns the children of the role.
     * A role inherits all the permissions from its children.
     *
     * @return ResultSet
     */
    public function findChildren(): ResultSet;
    
    
    
    /**
     * Returns the parents of the role.
     * The parent roles inherit the permissions of the child.
     * AKA: The parents can do at least everything their children can do.
     *
     * @return ResultSet
     */
    public function findParents(): ResultSet;
}
