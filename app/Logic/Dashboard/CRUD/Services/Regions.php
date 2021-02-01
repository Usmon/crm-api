<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Region;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Regions as RegionsRequest;

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

            'address_id' => $request->json('address_id'),

            'name' => $request->json('name'),

            'zip_code' => $request->json('zip_code'),
        ];
    }

    /**
     * @param RegionsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(RegionsRequest $request): array
    {
        return $request->only('search', 'date', 'address_id', 'name','zip_code');
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
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getRegions(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Region $region) {
            return [
                'id' => $region->id,

                'address_id' => $region->address_id,

                'name' => $region->name,

                'zip_code' => $region->zip_code,

                'created_at' => $region->created_at,

                'updated_at' => $region->updated_at,

                'address' => $region->address,
            ];
        });

        return $paginator;
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

            'address_id' => $region->address_id,

            'name' => $region->name,

            'zip_code' => $region->zip_code,

            'created_at' => $region->created_at,

            'updated_at' => $region->updated_at,

            'address' => $region->address,
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
            'address_id' => $request->json('address_id'),

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
            'address_id' => $request->json('address_id'),

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
