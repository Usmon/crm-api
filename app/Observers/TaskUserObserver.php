<?php

namespace App\Observers;

use App\Models\TaskUser;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class TaskUserObserver
{
    /**
     * @param TaskUser $taskUser
     *
     * @return void
     */
    public function creating(TaskUser $taskUser): void
    {
        $this->defaultProperties($taskUser);
    }

    /**
     * @param TaskUser $taskUser
     *
     * @return void
     */
    public function updating(TaskUser $taskUser): void
    {
        $this->defaultProperties($taskUser);
    }

    /**
     * @param TaskUser $taskUser
     *
     * @return void
     */
    public function deleting(TaskUser $taskUser): void
    {
        $taskUser->deleted_by = $taskUser->deleted_by ?? Auth::id();

        $taskUser->deleted_at = $taskUser->deleted_at ?? Carbon::now();

        $taskUser->update();
    }

    /**
     * @param TaskUser $taskUser
     *
     * @return void
     */
    public function restoring(TaskUser $taskUser): void
    {
        $taskUser->deleted_at = null;
    }

    /**
     * @param TaskUser $taskUser
     *
     * @return void
     */
    protected function defaultProperties(TaskUser $taskUser): void
    {
        $taskUser->created_at = $taskUser->created_at ?? Carbon::now();

        $taskUser->updated_at = $taskUser->updated_at ?? Carbon::now();

        $taskUser->deleted_at = $taskUser->deleted_at ?? null;
    }
}
