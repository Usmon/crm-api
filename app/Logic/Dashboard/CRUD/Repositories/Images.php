<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use Illuminate\Http\File;

use Illuminate\Support\Facades\Storage;

final class Images
{
    /**
     * @param array $credentials
     *
     * @return false|string|null
     */
    public function storeImage(array $credentials)
    {
        if(file_exists($credentials['image'])){
            $path = Storage::disk('s3')->putFile($credentials['folder'], new File($credentials['image']));

            return Storage::disk('s3')->url($path);
        }

        return null;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function delete(string $path): bool
    {
        return Storage::disk('s3')->delete($path);
    }

    /**
     * @param array $credentials
     *
     * @return bool
     */
    public function deleteMultiple(array $credentials): bool
    {
        return Storage::disk('s3')->delete($credentials);
    }
}
