<?php

declare(strict_types=1);

namespace Ruga\User\Test;

use Laminas\ServiceManager\ServiceManager;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class Issue13Test extends \Ruga\User\Test\PHPUnit\AbstractTestSetUp
{
   
    public function testUserKeepsRoleAfterReadSaveCycle(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setPasswordHash('hallowelt');
        $user->save();
        
        $roleTable = new \Ruga\User\Role\RoleTable($this->getAdapter());
        /** @var \Ruga\User\Role\Role $role */
        $role = $roleTable->createRow();
        $this->assertInstanceOf(\Ruga\User\Role\Role::class, $role);
        $role->name = 'lagerist';
        $role->save();
        
        $user->addRoles([$role, 'user']);
        $user->save();
        $this->assertTrue($user->hasRole('lagerist'));
        $this->assertTrue($user->hasRole('user'));
        
        unset($user);
        unset($role);
        
        /** @var \Ruga\User\User $user */
        $user=$userTable->findByIdentity('hans.mueller')->current();
        $user->save();
        
        $this->assertTrue($user->hasRole('lagerist'));
        $this->assertTrue($user->hasRole('user'));
        
    }
    
    
    
    
}
