<?php

namespace App\Ldap;


use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;
use LdapRecord\Models\Model;

class User extends Model
{
    /**
     * The object classes of the LDAP model.
     */
    public static array $objectClasses = [];
    protected string $guidKey = 'uuid';

    

}
