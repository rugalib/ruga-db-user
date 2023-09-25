<?php
/*
 * SPDX-FileCopyrightText: 2023 Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace Ruga\User\Link\Role;

use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;
use Ruga\Db\Row\RowInterface;
use Ruga\User\AbstractUser;
use Ruga\User\Role\AbstractRole;

/**
 * Interface to a PersonHasContactMechanism.
 *
 * @see      UserHasRoleInterface
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface UserHasRoleInterface extends RowInterface, UserHasRoleAttributesInterface, FullnameFeatureRowInterface
{
    /**
     * Returns the ROLE assigned to this link.
     *
     * @return AbstractRole
     */
    public function getRole(): AbstractRole;
    
    
    
    /**
     * Returns the USER assigned to this link.
     *
     * @return AbstractUser
     */
    public function getUser(): AbstractUser;
}
