<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Region;

use App\Logic\Dashboard\CRUD\Requests\Regions as RegionsRequest;

use Illuminate\Database\Eloquent\Collection;

final class Regions
{
    /**
     * @param RegionsRequest $request
     *
     * @return array
     */
    public function getAllFilters(RegionsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'name' => $request->json('name'),

            'zip_code' => $request->json('zip_code'),

            'country_code' => $request->json('country_code')
        ];
    }

    /**
     * @param RegionsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(RegionsRequest $request): array
    {
        return $request->only('search', 'date','name','zip_code', 'country_code');
    }

    /**
     * @param RegionsRequest $request
     *
     * @return array
     */
    public function getAllSorts(RegionsRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param RegionsRequest $request
     *
     * @return array
     */
    public function getOnlySorts(RegionsRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Collection $items
     *
     * @return Collection
     */
    public function getRegions(Collection $items): Collection
    {
        $items->transform(function (Region $region) {
            return [
                'id' => $region->id,

                'label' => $region->name,

                'value' => $region->name,
            ];
        });

        return $items;
    }

    /**
     * @param Region $region
     *
     * @return array
     */
    public function showRegion(Region $region): array
    {
        return [
            'id' => $region->id,

            'name' => $region->name,

            'zip_code' => $region->zip_code,

            'created_at' => $region->created_at,

            'updated_at' => $region->updated_at,

            'cities' => $region->cities,
        ];
    }

    /**
     * @param RegionsRequest $request
     *
     * @return array
     */
    public function storeCredentials(RegionsRequest $request): array
    {
        return [
            'name' => $request->json('name'),

            'zip_code' => $request->json('zip_code'),
        ];
    }

    /**
     * @param RegionsRequest $request
     *
     * @return array
     */
    public function updateCredentials(RegionsRequest $request): array
    {
        $credentials = [
            'name' => $request->json('name'),

            'zip_code' => $request->json('zip_code'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteRegion($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
