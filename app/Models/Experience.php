<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: experiences
class Experience extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['role', 'period', 'place', 'sort_order'];
}
