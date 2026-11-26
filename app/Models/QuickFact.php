<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: quick_facts
class QuickFact extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['label', 'value', 'sort_order'];
}
