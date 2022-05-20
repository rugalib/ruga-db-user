<?php

declare(strict_types=1);

namespace Ruga\User\Test;

use Laminas\ServiceManager\ServiceManager;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class UserTest extends \Ruga\User\Test\PHPUnit\AbstractTestSetUp
{
    public function testCanReadUser(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->findById(1)->current();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        echo "id: $user->id" . PHP_EOL;
        echo "username: $user->username" . PHP_EOL;
        echo "fullname: $user->fullname" . PHP_EOL;
    }
    
    
    
    public function testCanGetRoles(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->findByIdentity('admin')->current();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $roles = $user->findRoles();
        foreach ($roles as $role) {
            $this->assertInstanceOf(\Ruga\User\Role\Role::class, $role);
            echo $role->idname . PHP_EOL;
        }
        
        $roles = $user->getRoles();
        $this->assertIsArray($roles);
        print_r($roles);
    }
    
    
    
    public function testCanCreateUser(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setPasswordHash('hallowelt');
        $user->save();
    }
    
    
    
    public function testCanCreateRole(): void
    {
        $roleTable = new \Ruga\User\Role\RoleTable($this->getAdapter());
        /** @var \Ruga\User\Role\Role $role */
        $role = $roleTable->createRow();
        $this->assertInstanceOf(\Ruga\User\Role\Role::class, $role);
        $role->name = 'lagerist';
        $role->save();
    }
    
    
    
    public function testCanAddRoleToUser(): void
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
        
        $user->addRoles($role);
        $user->save();
    }
    
    
    
    public function testCanAddRolesToUser(): void
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
    }
    
    
    
    public function testCanAddMoreRolesToUser(): void
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
        
        $user->addRoles(['user', 'admin']);
        $user->save();
        $this->assertTrue($user->hasRole('lagerist'));
        $this->assertTrue($user->hasRole('user'));
        $this->assertTrue($user->hasRole('admin'));
    }
    
    
    
    public function testCanRemoveRolesFromUser(): void
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
        
        $user->addRoles([$role, 'user', 'admin']);
        $user->save();
        $this->assertTrue($user->hasRole('lagerist'));
        $this->assertTrue($user->hasRole('user'));
        $this->assertTrue($user->hasRole('admin'));
        
        
        $user->removeRoles(['admin']);
        $user->save();
        $this->assertTrue($user->hasRole('lagerist'));
        $this->assertTrue($user->hasRole('user'));
        $this->assertFalse($user->hasRole('admin'));
    }
    
}
