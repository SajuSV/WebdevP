<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: services
class Service extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['number', 'slug', 'title', 'text', 'icon', 'variant', 'sort_order'];
}
