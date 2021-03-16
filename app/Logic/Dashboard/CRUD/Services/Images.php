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

    /**
     * @param ImagesRequest $request
     *
     * @return string
     */
    public function deleteCredentials(ImagesRequest $request): string
    {
        return $this->trimDomain($request->json('image_url'));
    }

    /**
     * @param ImagesRequest $request
     *
     * @return array
     */
    public function deleteMultipleCredentials(ImagesRequest $request): array
    {
        return collect($request->json('image_url'))->transform(function (string $url) {
            return $this->trimDomain($url);
        })->toArray();
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function trimDomain(string $url): string
    {
        return parse_url($url)['path'];
    }
}
