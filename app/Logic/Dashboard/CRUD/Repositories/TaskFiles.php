<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\TaskFile;

use Illuminate\Contracts\Pagination\Paginator;

final class TaskFiles
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getTaskFiles(array $filters): Paginator
    {
        return TaskFile::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return TaskFile
     */
    public function storeTaskFile(array $credentials): TaskFile
    {
        $taskFile = TaskFile::create($credentials);

        return $taskFile;
    }

    /**
     * @param TaskFile $taskFile
     *
     * @param array $credentials
     *
     * @return TaskFile
     */
    public function updateTaskFile(TaskFile $taskFile, array $credentials): TaskFile
    {
        $taskFile->update($credentials);

        return $taskFile;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteTaskFile($id)
    {
        return TaskFile::destroy($id);
    }
}
