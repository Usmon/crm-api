<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\TaskFile;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\TaskFiles as TaskFilesRequest;

final class TaskFiles
{
    /**
     * @param TaskFilesRequest $request
     *
     * @return array
     */
    public function getAllFilters(TaskFilesRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'task_id' => $request->json('task_id'),

            'name' => $request->json('name'),
        ];
    }

    /**
     * @param TaskFilesRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(TaskFilesRequest $request): array
    {
        return $request->only('search', 'date', 'task_id', 'name');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getTaskFiles(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (TaskFile $taskFile) {
            return [
                'id' => $taskFile->id,

                'task_id' => $taskFile->task_id,

                'name' => $taskFile->name,

                'created_at' => $taskFile->created_at,

                'updated_at' => $taskFile->updated_at,

                'task' => $taskFile->task,
            ];
        });
        return $paginator;
    }

    /**
     * @param TaskFile $taskFile
     *
     * @return array
     */
    public function showTaskFile(TaskFile $taskFile): array
    {
        return [
            'id' => $taskFile->id,

            'task_id' => $taskFile->task_id,

            'name' => $taskFile->name,

            'created_at' => $taskFile->created_at,

            'updated_at' => $taskFile->updated_at,

            'task' => $taskFile->task,
        ];
    }

    /**
     * @param TaskFilesRequest $request
     *
     * @return array
     */
    public function storeCredentials(TaskFilesRequest $request): array
    {
        return [
            'task_id' => $request->json('task_id'),

            'name' => $request->json('name')
        ];
    }

    /**
     * @param TaskFilesRequest $request
     *
     * @return array
     */
    public function updateCredentials(TaskFilesRequest $request): array
    {
        $credentials = [
            'task_id' => $request->json('task_id'),

            'name' => $request->json('name')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteTaskFile($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
