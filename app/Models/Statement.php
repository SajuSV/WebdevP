<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: statements
class Statement extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['body', 'sort_order'];
}
