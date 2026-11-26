<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use App\Models\QuickFact;
use App\Models\Stat;
use App\Models\Toolkit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Admin page 3: Experience, toolkit, quick facts and numbers
class AboutController extends Controller
{
    public function edit()
    {
        return view('admin.about', [
            'experiences' => Experience::orderBy('sort_order')->get()->toArray(),
            'facts' => QuickFact::orderBy('sort_order')->get()->toArray(),
            'stats' => Stat::orderBy('sort_order')->get()->toArray(),
            // Turn the rows into "Figma, Photoshop, ..." for the text box
            'toolkit' => Toolkit::orderBy('sort_order')->pluck('name')->implode(', '),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'toolkit' => ['required', 'string', 'max:300'],
            'experiences' => ['nullable', 'array'],
            'experiences.*.role' => ['required', 'string', 'max:60'],
            'experiences.*.period' => ['required', 'string', 'max:30'],
            'experiences.*.place' => ['required', 'string', 'max:80'],
            'facts' => ['nullable', 'array'],
            'facts.*.label' => ['required', 'string', 'max:30'],
            'facts.*.value' => ['required', 'string', 'max:80'],
            'stats' => ['nullable', 'array'],
            'stats.*.value' => ['required', 'string', 'max:15'],
            'stats.*.label' => ['required', 'string', 'max:40'],
        ], [], [
            'experiences.*.role' => 'role',
            'experiences.*.period' => 'period',
            'experiences.*.place' => 'place',
            'facts.*.label' => 'label',
            'facts.*.value' => 'value',
            'stats.*.value' => 'value',
            'stats.*.label' => 'label',
        ]);

        DB::transaction(function () use ($data) {
            $this->replaceRows(Experience::class, $data['experiences'] ?? []);
            $this->replaceRows(QuickFact::class, $data['facts'] ?? []);
            $this->replaceRows(Stat::class, $data['stats'] ?? []);

            // "Figma, Photoshop" -> two rows
            $pills = [];
            foreach (explode(',', $data['toolkit'] ?? '') as $name) {
                if (trim($name) !== '') {
                    $pills[] = ['name' => mb_substr(trim($name), 0, 100)];
                }
            }
            $this->replaceRows(Toolkit::class, $pills);
        });

        return back()->with('status', 'About section saved!');
    }

    // Delete all rows of a table, then insert the rows from the form in order
    private function replaceRows(string $model, array $rows): void
    {
        $model::query()->delete();

        foreach (array_values($rows) as $i => $row) {
            $model::create($row + ['sort_order' => $i]);
        }
    }
}
