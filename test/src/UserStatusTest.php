<?php

declare(strict_types=1);

namespace Ruga\User\Test;

use Laminas\ServiceManager\ServiceManager;
use Ruga\User\Exception\AccountIsNotUnverifiedException;

/**
 * @author Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
class UserStatusTest extends \Ruga\User\Test\PHPUnit\AbstractTestSetUp
{
    
    public function testCreatedUserIsLoginDisabled(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->save();
        
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
    }
    
    
    public function testCanSetActive(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setPasswordHash('hallowelt');
        $user->save();
    
        $this->assertFalse($user->isLoginDisabled());
        $this->assertTrue($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
    }
    
    
    public function testCanSetLoginDisabled(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setPasswordHash('hallowelt');
        $user->save();
        
        $this->assertFalse($user->isLoginDisabled());
        $this->assertTrue($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
        
        $user->disableLogin();
        $user->save();
    
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
    }
    
    
    public function testCanSetAccountDisabled(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setPasswordHash('hallowelt');
        $user->save();
        
        $this->assertFalse($user->isLoginDisabled());
        $this->assertTrue($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
        
        $user->disable();
        $user->save();
        
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertTrue($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
    }
    
    
    public function testCanSetAccountDeleted(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setPasswordHash('hallowelt');
        $user->save();
        
        $this->assertFalse($user->isLoginDisabled());
        $this->assertTrue($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
        
        $user->markDeleted();
        $user->save();
        
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertTrue($user->isDisabled());
        $this->assertTrue($user->isDeleted());
        $this->assertFalse($user->isUnverified());
    }
    
    
    public function testCanSetVerificationCode(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setVerificationCode();
        $user->save();
    
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertTrue($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertTrue($user->isUnverified());
    }
    
    
    public function testCanSetAndGetVerificationCode(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $verificationCode=$user->createVerificationCode();
        $user->setVerificationCode($verificationCode);
        $user->save();
        
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertTrue($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertTrue($user->isUnverified());
        
        $this->assertEquals($verificationCode, $user->getVerificationCode());
    }
    
    
    public function testCanVerifyAccount(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $verificationCode=$user->createVerificationCode();
        $user->setVerificationCode($verificationCode);
        $user->save();
        
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertTrue($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertTrue($user->isUnverified());
        
        $user->verifyAccount($verificationCode);
        $user->save();
    
        $this->assertTrue($user->isLoginDisabled());
        $this->assertFalse($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
    }
    
    
    public function testCanNotVerifiyAccountIfNotUnverfied(): void
    {
        $userTable = new \Ruga\User\UserTable($this->getAdapter());
        /** @var \Ruga\User\User $user */
        $user = $userTable->createRow();
        $this->assertInstanceOf(\Ruga\User\User::class, $user);
        $user->username = 'hans.mueller';
        $user->setPasswordHash('hallowelt');
        $verificationCode=$user->createVerificationCode();
        //$user->setVerificationCode($verificationCode);
        $user->save();
        
        $this->assertFalse($user->isLoginDisabled());
        $this->assertTrue($user->isLoginEnabled());
        $this->assertFalse($user->isDisabled());
        $this->assertFalse($user->isDeleted());
        $this->assertFalse($user->isUnverified());
        
        $this->expectException(AccountIsNotUnverifiedException::class);
        $user->verifyAccount($verificationCode);
        $user->save();
        
    }
    
}
