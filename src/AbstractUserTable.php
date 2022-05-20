<?php

declare(strict_types=1);

namespace Ruga\User;

use Laminas\Db\ResultSet\ResultSetInterface;
use Ruga\Db\Table\AbstractRugaTable;

/**
 * Abstract user.
 *
 * @see      UserTable
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
abstract class AbstractUserTable extends AbstractRugaTable implements UserTableInterface
{
    public function findByIdentity($identity): ResultSetInterface
    {
        $s = $this->sql->select()->where(['username' => $identity]);
        return $this->selectWith($s);
    }
    
}