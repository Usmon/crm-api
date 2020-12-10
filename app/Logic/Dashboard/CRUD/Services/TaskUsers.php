<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\TaskUser;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\TaskUsers as TaskUsersRequest;

final class TaskUsers
{
    /**
     * @param TaskUsersRequest $request
     *
     * @return array
     */
    public function getAllFilters(TaskUsersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'user_id' => $request->json('user_id'),

            'task_id' => $request->json('task_id'),
        ];
    }

    /**
     * @param TaskUsersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(TaskUsersRequest $request): array
    {
        return $request->only('search', 'date', 'user_id', 'task_id');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getTaskUsers(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (TaskUser $taskUser) {
            return [
                'id' => $taskUser->id,

                'user_id' => $taskUser->user_id,

                'task_id' => $taskUser->task_id,

                'created_at' => $taskUser->created_at,

                'updated_at' => $taskUser->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param TaskUser $taskUser
     *
     * @return array
     */
    public function showTaskUser(TaskUser $taskUser): array
    {
        return [
            'id' => $taskUser->id,

            'user_id' => $taskUser->user_id,

            'task_id' => $taskUser->task_id,

            'created_at' => $taskUser->created_at,

            'updated_at' => $taskUser->updated_at,
        ];
    }

    /**
     * @param TaskUsersRequest $request
     *
     * @return array
     */
    public function storeCredentials(TaskUsersRequest $request): array
    {
        return [
            'user_id' => $request->json('user_id'),

            'task_id' => $request->json('task_id')
        ];
    }

    /**
     * @param TaskUsersRequest $request
     *
     * @return array
     */
    public function updateCredentials(TaskUsersRequest $request): array
    {
        $credentials = [
            'user_id' => $request->json('user_id'),

            'task_id' => $request->json('task_id')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteTaskUser($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
