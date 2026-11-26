<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Table: users (login accounts)
class User extends Authenticatable
{
    use Notifiable;

    // "is_admin" is left out on purpose, so a form can never make someone an admin.
    protected $fillable = ['name', 'email', 'password'];

    // Never show these when the user is converted to JSON.
    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // passwords are encrypted automatically
            'is_admin' => 'boolean',
        ];
    }
}
