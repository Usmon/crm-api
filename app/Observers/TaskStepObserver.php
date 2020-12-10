<?php

namespace App\Observers;

use App\Models\TaskStep;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class TaskStepObserver
{
    /**
     * @param TaskStep $taskStep
     *
     * @return void
     */
    public function creating(TaskStep $taskStep): void
    {
        $this->defaultProperties($taskStep);
    }

    /**
     * @param TaskStep $taskStep
     *
     * @return void
     */
    public function updating(TaskStep $taskStep): void
    {
        $this->defaultProperties($taskStep);
    }

    /**
     * @param TaskStep $taskStep
     *
     * @return void
     */
    public function deleting(TaskStep $taskStep): void
    {
        $taskStep->deleted_by = $taskStep->deleted_by ?? Auth::id();

        $taskStep->deleted_at = $taskStep->deleted_at ?? Carbon::now();

        $taskStep->update();
    }

    /**
     * @param TaskStep $taskStep
     *
     * @return void
     */
    public function restoring(TaskStep $taskStep): void
    {
        $taskStep->deleted_at = null;
    }

    /**
     * @param TaskStep $taskStep
     *
     * @return void
     */
    protected function defaultProperties(TaskStep $taskStep): void
    {
        $taskStep->created_at = $taskStep->created_at ?? Carbon::now();

        $taskStep->updated_at = $taskStep->updated_at ?? Carbon::now();

        $taskStep->deleted_at = $taskStep->deleted_at ?? null;
    }
}
