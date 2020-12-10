<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\TaskStep;

use Illuminate\Contracts\Pagination\Paginator;

final class TaskSteps
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getTaskSteps(array $filters): Paginator
    {
        return TaskStep::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return TaskStep
     */
    public function storeTaskStep(array $credentials): TaskStep
    {
        $taskStep = TaskStep::create($credentials);

        return $taskStep;
    }

    /**
     * @param TaskStep $taskStep
     *
     * @param array $credentials
     *
     * @return TaskStep
     */
    public function updateTaskStep(TaskStep $taskStep, array $credentials): TaskStep
    {
        $taskStep->update($credentials);

        return $taskStep;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteTaskStep($id)
    {
        return TaskStep::destroy($id);
    }
}
