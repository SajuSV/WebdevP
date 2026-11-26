<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: site_settings (always only ONE row)
class SiteSetting extends Model
{
    // "guarded = id" means every column except id can be saved.
    // This is safe because the controller only passes validated fields.
    protected $guarded = ['id'];

    protected $casts = [
        'require_user_login' => 'boolean',
        'user_access_password' => 'encrypted',
    ];

    // Returns the settings row. If the table is empty, returns an empty object.
    public static function current(): self
    {
        return static::first() ?? new static();
    }
}
