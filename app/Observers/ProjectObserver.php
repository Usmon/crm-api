<?php

namespace App\Observers;

use App\Models\Project;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class ProjectObserver
{
    /**
     * @param Project $project
     *
     * @return void
     */
    public function creating(Project $project): void
    {
        $this->defaultProperties($project);
    }

    /**
     * @param Project $project
     *
     * @return void
     */
    public function updating(Project $project): void
    {
        $this->defaultProperties($project);
    }

    /**
     * @param Project $project
     *
     * @return void
     */
    public function deleting(Project $project): void
    {
        $project->deleted_by = $project->deleted_by ?? Auth::id();

        $project->deleted_at = $project->deleted_at ?? Carbon::now();

        $project->update();
    }

    /**
     * @param Project $project
     *
     * @return void
     */
    public function restoring(Project $project): void
    {
        $project->deleted_at = null;
    }

    /**
     * @param Project $project
     *
     * @return void
     */
    protected function defaultProperties(Project $project): void
    {
        $project->created_at = $project->created_at ?? Carbon::now();

        $project->updated_at = $project->updated_at ?? Carbon::now();

        $project->deleted_at = $project->deleted_at ?? null;
    }
}
