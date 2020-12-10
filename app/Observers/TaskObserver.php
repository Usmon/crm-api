<?php

namespace App\Observers;

use App\Models\Task;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class TaskObserver
{
    /**
     * @param Task $task
     *
     * @return void
     */
    public function creating(Task $task): void
    {
        $this->defaultProperties($task);
    }

    /**
     * @param Task $task
     *
     * @return void
     */
    public function updating(Task $task): void
    {
        $this->defaultProperties($task);
    }

    /**
     * @param Task $task
     *
     * @return void
     */
    public function deleting(Task $task): void
    {
        $task->deleted_by = $task->deleted_by ?? Auth::id();

        $task->deleted_at = $task->deleted_at ?? Carbon::now();

        $task->update();
    }

    /**
     * @param Task $task
     *
     * @return void
     */
    public function restoring(Task $task): void
    {
        $task->deleted_at = null;
    }

    /**
     * @param Task $task
     *
     * @return void
     */
    protected function defaultProperties(Task $task): void
    {
        $task->created_at = $task->created_at ?? Carbon::now();

        $task->updated_at = $task->updated_at ?? Carbon::now();

        $task->creator_id = $task->creator_id ?? Auth::id();

        $task->is_completed = $task->is_completed ?? '0';

        $task->is_important = $task->is_important ?? '0';

        $task->in_may_day = $task->in_may_day ?? '0';

        $task->deleted_at = $task->deleted_at ?? null;
    }
}
