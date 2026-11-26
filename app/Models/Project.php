<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Table: projects
class Project extends Model
{
    protected $fillable = [
        'slug', 'title', 'headline_dim', 'headline_rest', 'description',
        'focus', 'tools', 'cover', 'cover_alt', 'gallery_label', 'enable_lightbox', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['enable_lightbox' => 'boolean'];
    }

    // One project has many gallery images. Use it like: $project->images
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}
