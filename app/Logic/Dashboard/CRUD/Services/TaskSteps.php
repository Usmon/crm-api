<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\TaskStep;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\TaskSteps as TaskStepsRequest;

final class TaskSteps
{
    /**
     * @param TaskStepsRequest $request
     *
     * @return array
     */
    public function getAllFilters(TaskStepsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'task_id' => $request->json('task_id'),

            'step' => $request->json('step'),
        ];
    }

    /**
     * @param TaskStepsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(TaskStepsRequest $request): array
    {
        return $request->only('search', 'date', 'task_id', 'step');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getTaskSteps(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (TaskStep $taskStep) {
            return [
                'id' => $taskStep->id,

                'task_id' => $taskStep->task_id,

                'step' => $taskStep->step,

                'created_at' => $taskStep->created_at,

                'updated_at' => $taskStep->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param TaskStep $taskStep
     *
     * @return array
     */
    public function showTaskStep(TaskStep $taskStep): array
    {
        return [
            'id' => $taskStep->id,

            'task_id' => $taskStep->task_id,

            'step' => $taskStep->step,

            'created_at' => $taskStep->created_at,

            'updated_at' => $taskStep->updated_at,
        ];
    }

    /**
     * @param TaskStepsRequest $request
     *
     * @return array
     */
    public function storeCredentials(TaskStepsRequest $request): array
    {
        return [
            'task_id' => $request->json('task_id'),

            'step' => $request->json('step')
        ];
    }

    /**
     * @param TaskStepsRequest $request
     *
     * @return array
     */
    public function updateCredentials(TaskStepsRequest $request): array
    {
        $credentials = [
            'task_id' => $request->json('task_id'),

            'step' => $request->json('step'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteTaskStep($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
