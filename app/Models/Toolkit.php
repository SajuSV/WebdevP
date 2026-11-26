<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: toolkits
class Toolkit extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['name', 'sort_order'];
}
