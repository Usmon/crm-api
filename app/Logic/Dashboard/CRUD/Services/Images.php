<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Logic\Dashboard\CRUD\Requests\Images as ImagesRequest;

final class Images
{
    /**
     * @param ImagesRequest $request
     *
     * @return array
     */
    public function storeCredentials(ImagesRequest $request): array
    {
        return [
            'image' => $request->file('image'),

            'folder' => $request->folder,
        ];
    }
}
