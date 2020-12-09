<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\TaskUser;

use Illuminate\Contracts\Pagination\Paginator;

final class TaskUsers
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getTaskUsers(array $filters): Paginator
    {
        return TaskUser::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return TaskUser
     */
    public function storeTaskUser(array $credentials): TaskUser
    {
        $taskUser = TaskUser::create($credentials);

        return $taskUser;
    }

    /**
     * @param TaskUser $taskUser
     *
     * @param array $credentials
     *
     * @return TaskUser
     */
    public function updateTaskUser(TaskUser $taskUser, array $credentials): TaskUser
    {
        $taskUser->update($credentials);

        return $taskUser;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteTaskUser($id)
    {
        return TaskUser::destroy($id);
    }
}
