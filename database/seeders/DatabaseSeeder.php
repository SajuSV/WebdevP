<?php

namespace Database\Seeders;

use App\Models\ContactItem;
use App\Models\Experience;
use App\Models\Project;
use App\Models\QuickFact;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Stat;
use App\Models\Statement;
use App\Models\Toolkit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/*
 | Fills the database with your portfolio data (database/data/portfolio.json)
 | and creates the admin account.
 | Run with:  php artisan db:seed
 |
 | WARNING: running it again replaces the website content with the JSON data.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data = json_decode(file_get_contents(database_path('data/portfolio.json')), true);

        // 1) Admin account. Change the password after your first login.
        if (! User::where('email', 'johndoe@example.com')->exists()) {
            $admin = new User([
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'password' => 'Admin@12345',
            ]);
            $admin->is_admin = true;
            $admin->save();
        }

        // A transaction means: if one step fails, nothing is half saved.
        DB::transaction(function () use ($data) {
            // 2) Remove old content
            Project::query()->delete(); // images are deleted automatically
            foreach ([SiteSetting::class, Statement::class, Stat::class, Toolkit::class, QuickFact::class,
                Experience::class, Service::class, ContactItem::class] as $model) {
                $model::query()->delete();
            }

            // 3) Site settings: JSON uses heroTitleLine1, MySQL uses hero_title_line1
            $site = [];
            foreach ($data['site'] as $key => $value) {
                $column = $key === 'heroTitleLine1' ? 'hero_title_line1'
                    : ($key === 'heroTitleLine2' ? 'hero_title_line2' : Str::snake($key));
                $site[$column] = $value;
            }
            SiteSetting::create($site);

            // 4) Simple lists
            foreach ($data['statements'] as $i => $body) {
                Statement::create(['body' => $body, 'sort_order' => $i]);
            }
            foreach ($data['toolkitPills'] as $i => $name) {
                Toolkit::create(['name' => $name, 'sort_order' => $i]);
            }
            foreach ($data['stats'] as $i => $row) {
                Stat::create($row + ['sort_order' => $i]);
            }
            foreach ($data['quickFacts'] as $i => $row) {
                QuickFact::create($row + ['sort_order' => $i]);
            }
            foreach ($data['experience'] as $i => $row) {
                Experience::create($row + ['sort_order' => $i]);
            }
            foreach ($data['workCategories'] as $i => $row) {
                $row['number'] = $row['index'];
                Service::create($row + ['sort_order' => $i]);
            }
            foreach ($data['contactItems'] as $i => $row) {
                ContactItem::create($row + ['sort_order' => $i]);
            }

            // 5) Projects and their gallery images
            foreach ($data['projects'] as $i => $p) {
                $meta = array_column($p['meta'], 'value', 'label');

                $project = Project::create([
                    'slug' => $p['slug'],
                    'title' => $p['title'],
                    'headline_dim' => $p['headlineDim'],
                    'headline_rest' => trim($p['headlineRest']),
                    'description' => $p['description'],
                    'focus' => $meta['Focus'] ?? '',
                    'tools' => $meta['Tools'] ?? '',
                    'cover' => $p['cover'],
                    'cover_alt' => $p['coverAlt'],
                    'gallery_label' => $p['galleryLabel'],
                    'enable_lightbox' => $p['enableLightbox'],
                    'sort_order' => $i,
                ]);

                foreach ($p['images'] as $j => $image) {
                    $project->images()->create($image + ['sort_order' => $j]);
                }
            }
        });
    }
}
