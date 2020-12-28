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
            $path = Storage::putFile('img/'.$credentials['folder'], new File($credentials['image']));

            return $path;
        }

        return null;
    }
}
