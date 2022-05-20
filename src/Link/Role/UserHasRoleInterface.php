<?php

declare(strict_types=1);

namespace Ruga\User\Link\Role;

use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;
use Ruga\Db\Row\RowInterface;

/**
 * Interface to a PersonHasContactMechanism.
 *
 * @see      UserHasRoleInterface
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface UserHasRoleInterface extends RowInterface, UserHasRoleAttributesInterface, FullnameFeatureRowInterface
{

}
