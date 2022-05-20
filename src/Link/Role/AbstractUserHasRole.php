<?php

declare(strict_types=1);

namespace Ruga\User\Link\Role;

use Ruga\Db\Row\AbstractRugaRow;
use Ruga\Db\Row\Feature\FullnameFeatureRowInterface;
use Ruga\User\AbstractUser;
use Ruga\User\Role\AbstractRole;
use Ruga\User\Role\RoleTable;
use Ruga\User\UserTable;

/**
 * Abstract user - role link.
 *
 * @see      UserHasRole
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractUserHasRole extends AbstractRugaRow implements UserHasRoleInterface
{
    /** @var AbstractUser */
    private $user;
    
    /** @var AbstractRole */
    private $role;
    
    
    
    public function getUser(): AbstractUser
    {
        if (!$this->user) {
            $this->user = (new UserTable($this->getTableGateway()->getAdapter()))->findById($this->User_id)->current();
        }
        return $this->user;
    }
    
    
    
    public function getRole(): AbstractRole
    {
        if (!$this->role) {
            $this->role = (new RoleTable($this->getTableGateway()->getAdapter()))->findById($this->Role_id)->current();
        }
        return $this->role;
    }
    
    
    
    /**
     * Constructs a display name from the given fields.
     *
     * @return string
     * @see FullnameFeatureRowInterface
     *
     * @see FullnameFeature
     */
    public function getFullname(): string
    {
        return "user '{$this->getUser()->getFullname()}' has role '{$this->getRole()->getFullname()}'";
    }
    
}
