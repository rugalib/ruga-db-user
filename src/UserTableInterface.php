<?php

declare(strict_types=1);

namespace Ruga\User;

use Laminas\Db\ResultSet\ResultSetInterface;
use Ruga\Db\Table\TableInterface;

/**
 * Interface UserTableInterface.
 *
 * @see      UserTable
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 */
interface UserTableInterface extends TableInterface
{
    /**
     * Find rows by unique identity.
     *
     * @param string $identity
     *
     * @return ResultSetInterface
     * @throws \Exception
     */
    public function findByIdentity($identity): ResultSetInterface;
}