<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 | Creates all the portfolio tables in MySQL.
 | Run with:  php artisan migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        // "is_admin" decides who can open the admin panel.
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
        });

        // One single row that holds all the general website text.
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $short = [
                'name', 'role', 'tagline', 'hero_title_line1', 'hero_title_line2', 'hero_cta_label',
                'services_heading', 'about_title', 'work_in_focus_title', 'projects_page_title',
                'projects_page_muted_title', 'footer_cta_label', 'footer_disclaimer', 'email',
                'phone', 'phone_href', 'location', 'linkedin_url', 'linkedin_label',
                'contact_heading', 'avatar', 'resume_url', 'hero_video_url', 'copyright',
            ];
            foreach ($short as $column) {
                $table->string($column, 500)->nullable();
            }
            // Longer text uses the TEXT type.
            foreach (['hero_subtitle', 'description', 'projects_page_description', 'footer_heading'] as $column) {
                $table->text($column)->nullable();
            }
            $table->timestamps();
        });

        // The big sentences that change while you scroll on the home page.
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // "My Journey in Numbers"
        Schema::create('stats', function (Blueprint $table) {
            $table->id();
            $table->string('value', 50);
            $table->string('label');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Skill pills (Figma, HTML5 ...)
        Schema::create('toolkits', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('quick_facts', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('value');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('period', 100)->nullable();
            $table->string('place')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Service cards on the home page.
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('index', 10)->nullable();
            $table->string('number', 10)->nullable();   // "01."
            $table->string('slug', 100)->nullable();    // links to a project
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('icon', 500)->nullable();
            $table->string('variant', 20)->default('lime'); // card colour
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('contact_items', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->string('value');
            $table->string('href', 500)->nullable();
            $table->string('icon', 30)->default('globe');
            $table->string('icon_image', 500)->nullable();
            $table->string('variant', 20)->default('lime');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();       // used in the URL: /projects/{slug}
            $table->string('title');
            $table->string('headline_dim')->nullable();  // grey part of the headline
            $table->string('headline_rest')->nullable(); // dark part of the headline
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus')->nullable();
            $table->string('tools')->nullable();
            $table->string('cover', 500)->nullable();
            $table->string('cover_alt')->nullable();
            $table->string('gallery_label', 100)->nullable();
            $table->boolean('enable_lightbox')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // Gallery images. One project has many images.
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            // cascadeOnDelete: deleting a project also deletes its image rows.
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('src', 500);
            $table->string('alt')->nullable();
            $table->string('href', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    // Runs on "php artisan migrate:rollback"
    public function down(): void
    {
        $tables = ['project_images', 'projects', 'contact_items', 'services', 'experiences',
            'quick_facts', 'toolkits', 'stats', 'statements', 'site_settings'];

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
