<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

// Admin page 4: Projects (a standard Laravel CRUD: Create, Read, Update, Delete)
class ProjectController extends Controller
{
    use UploadsImages;

    // READ: list of all projects
    public function index()
    {
        return view('admin.projects.index', [
            'projects' => Project::withCount('images')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    // CREATE: show an empty form
    public function create()
    {
        $nextOrder = Project::exists() ? ((int) Project::max('sort_order') + 1) : 0;

        return view('admin.projects.form', [
            'project' => new Project([
                'enable_lightbox' => true,
                'sort_order' => $nextOrder,
            ]),
            'images' => [],
        ]);
    }

    // CREATE: save the new project
    public function store(Request $request)
    {
        $project = $this->save($request, new Project());

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project created!');
    }

    // UPDATE: show the form filled with data
    public function edit(Project $project)
    {
        return view('admin.projects.form', [
            'project' => $project,
            'images' => $project->images->toArray(),
        ]);
    }

    // UPDATE: save changes
    public function update(Request $request, Project $project)
    {
        $this->save($request, $project);

        return redirect()->route('admin.projects.edit', $project)->with('status', 'Project saved!');
    }

    // DELETE
    public function destroy(Project $project)
    {
        DB::transaction(function () use ($project) {
            $project->delete();

            // Reorder remaining projects sequentially (0, 1, 2, ...) to fill any gap
            Project::orderBy('sort_order')->orderBy('id')->get()->values()
                ->each(fn (Project $item, int $index) => $item->update(['sort_order' => $index]));
        });

        return redirect()->route('admin.projects.index')->with('status', 'Project deleted.');
    }

    // Shared code for store() and update()
    private function save(Request $request, Project $project): Project
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            // The slug must be unique, but a project may keep its own slug
            'slug' => ['required', 'alpha_dash', 'max:60', Rule::unique('projects', 'slug')->ignore($project->id)],
            'headline_dim' => ['required', 'string', 'max:50'],
            'headline_rest' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'min:100', 'max:500'],
            'focus' => ['required', 'string', 'max:60'],
            'tools' => ['required', 'string', 'max:100'],
            'cover' => ['required_without:cover_file', 'nullable', 'string', 'max:500', 'regex:#^(https?://|uploads/)#i'],
            'cover_file' => $this->fileRules(),
            'cover_alt' => ['required', 'string', 'max:100'],
            'gallery_label' => ['required_with:images', 'nullable', 'string', 'max:40'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:10000', Rule::unique('projects', 'sort_order')->ignore($project->id)],

            'images' => ['nullable', 'array'],
            'images.*.src' => $this->pathRules(),
            'images.*.file' => $this->fileRules(),
            'images.*.alt' => ['nullable', 'string', 'max:100'],
            'images.*.href' => ['nullable', 'url:http,https', 'max:300'],
        ], [
            'cover.required_without' => 'Please upload a cover image or enter an image URL.',
            'gallery_label.required_with' => 'Gallery label is required when gallery images are added.',
        ], [
            'headline_dim' => 'headline (grey start)',
            'headline_rest' => 'headline (dark end)',
            'cover_alt' => 'cover alt text',
            'gallery_label' => 'gallery label',
            'sort_order' => 'order',
            'images.*.src' => 'image URL',
            'images.*.file' => 'image file',
            'images.*.alt' => 'alt text',
            'images.*.href' => 'website link',
        ]);

        DB::transaction(function () use ($request, $data, $project) {
            $data['cover'] = $this->imagePath($request->file('cover_file'), $data['cover'] ?? null);
            // An unticked checkbox sends nothing, so we use boolean()
            $data['enable_lightbox'] = $request->boolean('enable_lightbox');
            $data['sort_order'] = $data['sort_order'] ?? 0;

            $project->fill($data)->save();

            // Replace the gallery rows with the ones from the form
            $project->images()->delete();

            $order = 0;
            // all() keeps rows where the user only chose a file
            foreach ($request->all()['images'] ?? [] as $key => $row) {
                $src = $this->imagePath($request->file("images.$key.file"), $row['src'] ?? null);

                if (! $src) {
                    continue; // skip empty rows
                }

                $project->images()->create([
                    'src' => $src,
                    'alt' => $row['alt'] ?? null,
                    'href' => $row['href'] ?? null,
                    'sort_order' => $order++,
                ]);
            }
        });

        return $project;
    }
}
