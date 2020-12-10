<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Task;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Tasks as TasksRequest;

final class Tasks
{
    /**
     * @param TasksRequest $request
     *
     * @return array
     */
    public function getAllFilters(TasksRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'creator_id' => $request->json('creator_id'),

            'project_id' => $request->json('project_id'),

            'title' => $request->json('title'),

            'note' => $request->json('note'),

            'in_may_day' => $request->json('in_may_day'),

            'is_completed' => $request->json('is_completed'),

            'is_important' => $request->json('is_important'),

            'remind_me_at' => $request->json('remind_me_at'),

            'due_date' => $request->json('due_date'),

            'next_repeat' => $request->json('next_repeat'),
        ];
    }

    /**
     * @param TasksRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(TasksRequest $request): array
    {
        return $request->only('search', 'date', 'creator_id', 'project_id', 'title', 'note', 'in_may_day',
            'is_completed', 'is_important', 'remind_me_at', 'due_date', 'next_repeat');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getTasks(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Task $task) {
            return [
                'id' => $task->id,

                'creator_id' => $task->creator_id,

                'project_id' => $task->project_id,

                'title' => $task->title,

                'note' => $task->note,

                'in_may_day' => $task->in_may_day,

                'is_completed' => $task->is_completed,

                'is_important' => $task->is_important,

                'remind_me_at' => $task->remind_me_at,

                'due_date' => $task->due_date,

                'next_repeat' => $task->next_repeat,

                'created_at' => $task->created_at,

                'updated_at' => $task->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Task $task
     *
     * @return array
     */
    public function showTask(Task $task): array
    {
        return [
            'id' => $task->id,

            'creator_id' => $task->creator_id,

            'project_id' => $task->project_id,

            'title' => $task->title,

            'note' => $task->note,

            'in_may_day' => $task->in_may_day,

            'is_completed' => $task->is_completed,

            'is_important' => $task->is_important,

            'remind_me_at' => $task->remind_me_at,

            'due_date' => $task->due_date,

            'next_repeat' => $task->next_repeat,

            'created_at' => $task->created_at,

            'updated_at' => $task->updated_at,
        ];
    }

    /**
     * @param TasksRequest $request
     *
     * @return array
     */
    public function storeCredentials(TasksRequest $request): array
    {
        return [
            'creator_id' => $request->json('creator_id'),

            'project_id' => $request->json('project_id'),

            'title' => $request->json('title'),

            'note' => $request->json('note'),

            'in_may_day' => $request->json('in_may_day'),

            'is_completed' => $request->json('is_completed'),

            'is_important' => $request->json('is_important'),

            'remind_me_at' => $request->json('remind_me_at'),

            'due_date' => $request->json('due_date'),

            'next_repeat' => $request->json('next_repeat'),
        ];
    }

    /**
     * @param TasksRequest $request
     *
     * @return array
     */
    public function updateCredentials(TasksRequest $request): array
    {
        $credentials = [
            'creator_id' => $request->json('creator_id'),

            'project_id' => $request->json('project_id'),

            'title' => $request->json('title'),

            'note' => $request->json('note'),

            'in_may_day' => $request->json('in_may_day'),

            'is_completed' => $request->json('is_completed'),

            'is_important' => $request->json('is_important'),

            'remind_me_at' => $request->json('remind_me_at'),

            'due_date' => $request->json('due_date'),

            'next_repeat' => $request->json('next_repeat'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteTask($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
