<?php

namespace App\Http\Controllers;

use App\Models\ContactItem;
use App\Models\Experience;
use App\Models\Project;
use App\Models\QuickFact;
use App\Models\Service;
use App\Models\Stat;
use App\Models\Statement;
use App\Models\Toolkit;

// Shows the public pages: it reads from MySQL and sends the data to a Blade view.
class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'statements' => Statement::orderBy('sort_order')->get(),
            'experiences' => Experience::orderBy('sort_order')->get(),
            'toolkits' => Toolkit::orderBy('sort_order')->get(),
            'quickFacts' => QuickFact::orderBy('sort_order')->get(),
            'stats' => Stat::orderBy('sort_order')->get(),
            'services' => Service::orderBy('sort_order')->get(),
            'contactItems' => ContactItem::orderBy('sort_order')->get(),
            // with('images') loads all images in one go (faster)
            'projects' => Project::with('images')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function projects()
    {
        return view('pages.projects', [
            'projects' => Project::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    // Laravel finds the project by its slug. A wrong slug shows a 404 page.
    public function project(Project $project)
    {
        return view('pages.project-detail', [
            'project' => $project->load('images'),
        ]);
    }
}
