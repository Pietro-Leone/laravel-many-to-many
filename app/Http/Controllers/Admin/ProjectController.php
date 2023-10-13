<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectUpsertRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $projects = Project::all();
        return view("admin.projects.index", compact("projects"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view("admin.projects.create", compact("types", "technologies"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectUpsertRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data["slug"] = $this->generateSlug($data, $data["title"]);
        $data["thumb"] = Storage::put("projects", $data["thumb"]);

        $project = Project::create($data);

        if (key_exists("technologies", $data)) {
            $project->technologies()->attach($data["technologies"]);
        }

        return redirect()->route("admin.projects.show", $project->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $project = Project::where("slug", $slug)->first();

        return view("admin.projects.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug): View
    {
        $project = Project::where("slug", $slug)->firstOrFail();
        $types = Type::all();
        $technologies = Technology::all();

        return view("admin.projects.edit", compact("project", "types", "technologies"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectUpsertRequest $request, $slug): RedirectResponse
    {
        $data = $request->validated();

        $project = Project::where("slug", $slug)->firstOrFail();

        if (isset($data["thumb"])) {
            Storage::delete($project->thumb);
            $data["thumb"] = Storage::put("projects", $data["thumb"]);
        } else {
            $data["thumb"] = $project->thumb;
        };

        if ($data["title"] !== $project->title) {
            $data["slug"] = $this->generateSlug($data, $data["title"]);
        }

        $project->technologies()->sync($data["technologies"]);

        $project->update($data);

        return redirect()->route("admin.projects.show", $project->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $project = Project::where("slug", $slug)->firstOrFail();

        if ($project->thumb) {
            Storage::delete($project->thumb);
        }

        $project->technologies()->detach();
        $project->delete();

        return redirect()->route("admin.projects.index");
    }

    protected function generateSlug($data)
    {
        // contatore da usare per avere un numero incrementale
        $counter = 0;

        do {
            // creo uno slug e se il counter è maggiore di 0, concateno il counter
            $slug = Str::slug($data["title"]) . ($counter > 0 ? "-" . $counter : "");

            // cerco se esiste già un elemento con questo slug
            $alreadyExists = Project::where("slug", $slug)->first();

            $counter++;
        } while ($alreadyExists); // finché esiste già un elemento con questo slug, ripeto il ciclo per creare uno slug nuovo

        return $slug;
    }
}
