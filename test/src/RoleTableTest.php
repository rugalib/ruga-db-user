<?php

declare(strict_types=1);

namespace Ruga\User\Test;

use Laminas\ServiceManager\ServiceManager;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class RoleTableTest extends \Ruga\User\Test\PHPUnit\AbstractTestSetUp
{
    public function testCanFindRole(): void
    {
        $roleTable = new \Ruga\User\Role\RoleTable($this->getAdapter());
        /** @var \Ruga\User\Role\Role $role */
        $role = $roleTable->findByName('user')->current();
        $this->assertInstanceOf(\Ruga\User\Role\RoleInterface::class, $role);
        echo $role->idname;
    }
    
    
    
    public function testCanFindRoles(): void
    {
        $roleTable = new \Ruga\User\Role\RoleTable($this->getAdapter());
        /** @var \Ruga\User\Role\Role $role */
        $roles = $roleTable->findByName(['user', 'admin']);
        $this->assertCount(2, $roles);
        foreach ($roles as $role) {
            $this->assertInstanceOf(\Ruga\User\Role\RoleInterface::class, $role);
            echo $role->idname . PHP_EOL;
        }
    }
    
    
    
    public function testCreateRoleInheritanceConfig(): void
    {
        $roleTable = new \Ruga\User\Role\RoleTable($this->getAdapter());
        $a = $roleTable->getRolesConfig();
        print_r($a);
        $this->assertIsArray($a);
        $this->assertArrayHasKey('admin', $a);
        $this->assertContains('system', $a['admin']);
    }
}
