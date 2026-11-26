<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: contact_items
class ContactItem extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['label', 'value', 'href', 'icon', 'icon_image', 'variant', 'sort_order'];
}
