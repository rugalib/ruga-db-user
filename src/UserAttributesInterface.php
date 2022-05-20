<?php

declare(strict_types=1);

namespace Ruga\User;

use Ruga\Db\Row\RowAttributesInterface;

/**
 * Interface UserAttributesInterface
 *
 * @see      User
 * @author   Roland Rusch, easy-smart solution GmbH <roland.rusch@easy-smart.ch>
 *
 * @property int    $id                         Primary Key
 * @property string $username                   Username
 * @property string $password                   Password hash
 * @property string $fullname                   Full name / display name
 * @property string $email                      Email
 * @property string $mobile                     Mobile number
 * @property string $remark                     Remark
 */
interface UserAttributesInterface extends RowAttributesInterface
{
    
}