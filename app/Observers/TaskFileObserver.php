<?php

namespace App\Observers;

use App\Models\TaskFile;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class TaskFileObserver
{
    /**
     * @param TaskFile $taskFile
     *
     * @return void
     */
    public function creating(TaskFile $taskFile): void
    {
        $this->defaultProperties($taskFile);
    }

    /**
     * @param TaskFile $taskFile
     *
     * @return void
     */
    public function updating(TaskFile $taskFile): void
    {
        $this->defaultProperties($taskFile);
    }

    /**
     * @param TaskFile $taskFile
     *
     * @return void
     */
    public function deleting(TaskFile $taskFile): void
    {
        $taskFile->deleted_by = $taskFile->deleted_by ?? Auth::id();

        $taskFile->deleted_at = $taskFile->deleted_at ?? Carbon::now();

        $taskFile->update();
    }

    /**
     * @param TaskFile $taskFile
     *
     * @return void
     */
    public function restoring(TaskFile $taskFile): void
    {
        $taskFile->deleted_at = null;
    }

    /**
     * @param TaskFile $taskFile
     *
     * @return void
     */
    protected function defaultProperties(TaskFile $taskFile): void
    {
        $taskFile->created_at = $taskFile->created_at ?? Carbon::now();

        $taskFile->updated_at = $taskFile->updated_at ?? Carbon::now();

        $taskFile->deleted_at = $taskFile->deleted_at ?? null;
    }
}
