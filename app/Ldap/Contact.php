<?php

namespace App\Ldap;

use LdapRecord\Models\Model;

class Contact extends Model
{
    public static array $objectClasses = [
        'user',
    ];
}
