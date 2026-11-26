<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Table: project_images
class ProjectImage extends Model
{
    // Columns that can be filled using Model::create() / update()
    protected $fillable = ['project_id', 'src', 'alt', 'href', 'sort_order'];
}
