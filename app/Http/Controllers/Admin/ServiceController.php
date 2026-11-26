<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Admin page 2: Service cards
class ServiceController extends Controller
{
    use UploadsImages;

    public function edit()
    {
        return view('admin.services', [
            'services' => Service::orderBy('sort_order')->get()->toArray(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'services' => ['nullable', 'array', 'max:4'],
            'services.*.slug' => ['nullable', 'string', 'max:100', 'regex:#^(/|https?://|\#)#i'],
            'services.*.title' => ['required', 'string', 'max:50'],
            'services.*.text' => ['required', 'string', 'max:250'],
            'services.*.variant' => ['required', 'in:lime,ink,tissue'],
            'services.*.icon' => ['required_without:services.*.icon_file', 'nullable', 'string', 'max:500', 'regex:#^(https?://|uploads/)#i'],
            'services.*.icon_file' => $this->fileRules(),
        ], [
            'services.max' => 'You can add a maximum of 4 services.',
            'services.*.icon.required_without' => 'Please upload an icon image or enter an image URL.',
            'services.*.slug.regex' => 'Redirect link must start with /, #, http://, or https://.',
        ], [
            'services.*.slug' => 'redirect link',
            'services.*.title' => 'title',
            'services.*.text' => 'description',
            'services.*.variant' => 'card colour',
            'services.*.icon' => 'icon image',
            'services.*.icon_file' => 'icon image file',
        ]);

        DB::transaction(function () use ($request, $data) {
            Service::query()->delete();

            $order = 0;
            foreach ($data['services'] ?? [] as $key => $row) {
                $row['icon'] = $this->imagePath($request->file("services.$key.icon_file"), $row['icon'] ?? null);
                $row['number'] = str_pad((string) ($order + 1), 2, '0', STR_PAD_LEFT).'.';
                $row['sort_order'] = $order++;
                Service::create($row);
            }
        });

        return back()->with('status', 'Services saved!');
    }
}
