<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: stats
class Stat extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['value', 'label', 'sort_order'];
}
