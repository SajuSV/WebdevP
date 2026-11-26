<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactItem;
use App\Models\SiteSetting;
use App\Models\Statement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

// Admin page 1: Site & Hero, statements, contact cards, user access
class SiteController extends Controller
{
    use UploadsImages;

    public function edit()
    {
        return view('admin.site', [
            'settings' => SiteSetting::current(),
            'visitor' => User::where('is_admin', false)->first(),
            // toArray() lets the view treat database rows and old() form input the same way
            'statements' => Statement::orderBy('sort_order')->get()->toArray(),
            'contacts' => ContactItem::orderBy('sort_order')->get()->toArray(),
        ]);
    }

    public function update(Request $request)
    {
        // Normal text fields: field name => maximum length
        $textFields = [
            'role' => 60, 'tagline' => 120, 'hero_title_line1' => 50, 'hero_title_line2' => 50,
            'hero_subtitle' => 200, 'hero_cta_label' => 30, 'description' => 300,
            'services_heading' => 50, 'about_title' => 50, 'work_in_focus_title' => 50,
            'contact_heading' => 50, 'projects_page_title' => 50, 'projects_page_muted_title' => 50,
            'projects_page_description' => 300, 'location' => 80, 'phone' => 30,
            'linkedin_label' => 80, 'footer_heading' => 150, 'footer_cta_label' => 30,
            'footer_disclaimer' => 80, 'copyright' => 80,
        ];

        $rules = [];
        foreach ($textFields as $field => $max) {
            $rules[$field] = ['nullable', 'string', "max:$max"];
        }

        $rules += [
            'name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:100'],
            'phone_href' => ['nullable', 'max:30', 'starts_with:tel:'],
            'linkedin_url' => ['nullable', 'url:http,https', 'max:300'],
            'resume_url' => ['nullable', 'url:http,https', 'max:300'],
            'hero_video_url' => ['nullable', 'url:http,https', 'max:300'],
            'avatar' => $this->pathRules(),
            'avatar_file' => $this->fileRules(),

            'statements' => ['nullable', 'array'],
            'statements.*.body' => ['required', 'string', 'max:250'],

            'contacts' => ['nullable', 'array'],
            'contacts.*.label' => ['required', 'string', 'max:30'],
            'contacts.*.value' => ['required', 'string', 'max:100'],
            // Only safe link types are allowed
            'contacts.*.href' => ['nullable', 'string', 'max:300', 'regex:#^(https?://|mailto:|tel:)#i'],
            'contacts.*.icon' => ['required', 'in:email,location,phone,linkedin,github,behance,dribbble,globe'],
            'contacts.*.variant' => ['required', 'in:lime,ink,paper,tissue'],
            'contacts.*.icon_image' => $this->pathRules(),
            'contacts.*.icon_file' => $this->fileRules(),
        ];

        $data = $request->validate($rules, [], [
            'statements.*.body' => 'statement',
            'contacts.*.label' => 'label',
            'contacts.*.value' => 'display value',
            'contacts.*.href' => 'link',
            'contacts.*.icon' => 'icon',
            'contacts.*.variant' => 'card colour',
            'contacts.*.icon_image' => 'custom icon',
            'contacts.*.icon_file' => 'custom icon file',
        ]);

        DB::transaction(function () use ($request, $data) {
            // ----- 1. Settings (single row) -----
            $settings = collect($data)->except(['statements', 'contacts', 'avatar_file'])->all();
            $settings['avatar'] = $this->imagePath($request->file('avatar_file'), $data['avatar'] ?? null);

            SiteSetting::current()->fill($settings)->save();

            // ----- 2. Statements: delete the old rows, insert the new rows -----
            Statement::query()->delete();
            foreach (array_values($data['statements'] ?? []) as $i => $row) {
                Statement::create(['body' => $row['body'], 'sort_order' => $i]);
            }

            // ----- 3. Contact cards -----
            ContactItem::query()->delete();
            $order = 0;
            foreach ($data['contacts'] ?? [] as $key => $row) {
                $row['icon_image'] = $this->imagePath(
                    $request->file("contacts.$key.icon_file"),
                    $row['icon_image'] ?? null
                );
                $row['sort_order'] = $order++;
                ContactItem::create($row); // extra keys like icon_file are ignored
            }
        });

        return back()->with('status', 'Site settings saved!');
    }

    public function userAccess(Request $request)
    {
        $visitor = User::where('is_admin', false)->first();
        $enabled = $request->boolean('require_user_login');

        $data = $request->validate([
            'require_user_login' => ['nullable', 'boolean'],
            'user_access_id' => [
                Rule::requiredIf($enabled || $request->filled('user_access_password')),
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'email')->ignore($visitor?->id),
            ],
            'user_access_password' => [
                Rule::requiredIf($enabled && ! $visitor),
                'nullable',
                'string',
                'min:4',
                'max:255',
            ],
        ]);

        DB::transaction(function () use ($visitor, $enabled, $data) {
            $siteUpdates = ['require_user_login' => $enabled];
            if (! empty($data['user_access_password'])) {
                $siteUpdates['user_access_password'] = $data['user_access_password'];
            }
            SiteSetting::current()->fill($siteUpdates)->save();

            if (! empty($data['user_access_id'])) {
                if ($visitor) {
                    $updates = ['email' => $data['user_access_id']];
                    if (! empty($data['user_access_password'])) {
                        $updates['password'] = $data['user_access_password'];
                    }
                    $visitor->update($updates);
                } elseif (! empty($data['user_access_password'])) {
                    User::create([
                        'name' => 'Visitor',
                        'email' => $data['user_access_id'],
                        'password' => $data['user_access_password'],
                    ]);
                }
            }
        });

        return back()->with('status', 'User-side access settings saved!');
    }
}
