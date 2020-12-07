<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Project;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Projects as ProjectsRequest;

final class Projects
{
    /**
     * @param ProjectsRequest $request
     *
     * @return array
     */
    public function getAllFilters(ProjectsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'name' => $request->json('name'),
        ];
    }

    /**
     * @param ProjectsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(ProjectsRequest $request): array
    {
        return $request->only('search', 'date', 'name');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getProjects(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Project $project) {
            return [
                'id' => $project->id,

                'name' => $project->name,

                'created_at' => $project->created_at,

                'updated_at' => $project->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Project $project
     *
     * @return array
     */
    public function showProject(Project $project): array
    {
        return [
            'id' => $project->id,

            'name' => $project->name,

            'created_at' => $project->created_at,

            'updated_at' => $project->updated_at,
        ];
    }

    /**
     * @param ProjectsRequest $request
     *
     * @return array
     */
    public function storeCredentials(ProjectsRequest $request): array
    {
        return [
            'name' => $request->json('name'),
        ];
    }

    /**
     * @param ProjectsRequest $request
     *
     * @return array
     */
    public function updateCredentials(ProjectsRequest $request): array
    {
        $credentials = [
            'name' => $request->json('name'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteProject($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
