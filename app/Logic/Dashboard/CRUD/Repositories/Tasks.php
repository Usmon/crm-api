<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Task;

use Illuminate\Contracts\Pagination\Paginator;

final class Tasks
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getTasks(array $filters): Paginator
    {
        return Task::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Task
     */
    public function storeTask(array $credentials): Task
    {
        $task = Task::create($credentials);

        return $task;
    }

    /**
     * @param Task $task
     *
     * @param array $credentials
     *
     * @return Task
     */
    public function updateTask(Task $task, array $credentials): Task
    {
        $task->update($credentials);

        return $task;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteTask($id)
    {
        return Task::destroy($id);
    }
}
