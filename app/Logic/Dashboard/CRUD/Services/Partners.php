<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Partner;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Partners as PartnersRequest;

final class Partners
{
    /**
     * @param PartneresRequest $request
     *
     * @return array
     */
    public function getAllFilters(PartnersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'city_id' => $request->json('city_id'),

            'name' => $request->json('name'),

            'description' => $request->json('description'),

            'address' => $request->json('address'),

            'phone' => $request->json('phone'),

            'city' => $request->json('city'),
        ];
    }

    /**
     * @param PartnersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(PartnersRequest $request): array
    {
        return $request->only('search', 'date','city_id','name','description','address','phone','city');
    }

    /**
     * @param PartnersRequest $request
     *
     * @return array
     */
    public function getAllSorts(PartnersRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param PartnersRequest $request
     *
     * @return array
     */
    public function getOnlySorts(PartnersRequest $request): array
    {
        return $request->only('sort');
    }



    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getPartners(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Partner $partner) {
            return [
                'id' => $partner->id,

                'city_id' => $partner->city_id,

                'name' => $partner->name,

                'description' => $partner->description,

                'address' => $partner->address,

                'phone' => $partner->phone,

                'created_at' => $partner->created_at,

                'updated_at' => $partner->updated_at,

                'city' => $partner->city,
            ];
        });

        return $paginator;
    }

    /**
     * @param Partner $partner
     *
     * @return array
     */
    public function showPartner(Partner $partner): array
    {
        return [
            'id' => $partner->id,

            'city_id' => $partner->city_id,

            'name' => $partner->name,

            'description' => $partner->description,

            'address' => $partner->address,

            'phone' => $partner->phone,

            'created_at' => $partner->created_at,

            'updated_at' => $partner->updated_at,

            'city' => $partner->city,
        ];
    }

    /**
     * @param PartnersRequest $request
     *
     * @return array
     */
    public function storeCredentials(PartnersRequest $request): array
    {
        return [
            'city_id' => $request->json('city_id'),

            'name' => $request->json('name'),

            'description' => $request->json('description'),

            'address' => $request->json('address'),

            'phone' => $request->json('phone'),

        ];
    }

    /**
     * @param PartnersRequest $request
     *
     * @return array
     */
    public function updateCredentials(PartnersRequest $request): array
    {
        $credentials = [
            'city_id' => $request->json('city_id'),

            'name' => $request->json('name'),

            'description' => $request->json('description'),

            'address' => $request->json('address'),

            'phone' => $request->json('phone'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deletePartner($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
