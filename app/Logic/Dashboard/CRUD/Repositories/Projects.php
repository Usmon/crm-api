<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Project;

use Illuminate\Contracts\Pagination\Paginator;

final class Projects
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getProjects(array $filters): Paginator
    {
        return Project::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Project
     */
    public function storeProject(array $credentials): Project
    {
        $project = Project::create($credentials);

        return $project;
    }

    /**
     * @param Project $project
     *
     * @param array $credentials
     *
     * @return Project
     */
    public function updateProject(Project $project, array $credentials): Project
    {
        $project->update($credentials);

        return $project;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteProject($id)
    {
        return Project::destroy($id);
    }
}
