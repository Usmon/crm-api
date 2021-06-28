<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Partner;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Partners as PartnersRequest;
use Illuminate\Database\Eloquent\Collection;

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
            'search' => $request->json('search') ?? $request->json('search'),

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
     * @param Collection $partners
     *
     * @return Collection
     */
    public function getList(Collection $partners): Collection
    {
        return $partners->transform(function(Partner $partner) {
            return [
                'id' => $partner->id,

                'label' => $partner->name,

                'value' => $partner->name
            ];
        });
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

                'name' => $partner->name,

                'creator' => [
                    'full_name' => $partner->user->full_name,

                    'photo' => $partner->user->profile['photo'] ?? '',
                ],

                'weight_price' => $partner->weight_price,

                'warehouse_price' => $partner->warehouse_price,

                'pickup' => $partner->pickup,

                'delivery' => $partner->delivery,

                'discount_price' => $partner->discount_price,

                'created_at' => $partner->created_at,

                'updated_at' => $partner->updated_at
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

            'name' => $partner->name,

            'photo' => $partner->photo,

            'address' => [
                'region' => [
                    'id' => $partner->city->region->id ?? null,

                    'name' => $partner->city->region->name ?? null
                ],

                'city' => [
                    'id' => $partner->city->id ?? null,

                    'name' => $partner->city->name ?? null
                ],

                'code' => $partner->code,

                'address' => $partner->address,

                'address_additional' => $partner->address_additional
            ],

            'creator' => [
                'full_name' => $partner->user->full_name,

                'login' => $partner->user->login,

                'email' => $partner->user->email,

                'photo' => $partner->user->profile['photo'] ?? '',

                'phones' => $partner->user->getPhonesWithLimit(5)
            ],

            'weight_price' => $partner->weight_price,

            'warehouse_price' => $partner->warehouse_price,

            'pickup' => $partner->pickup,

            'delivery' => $partner->delivery,

            'discount_price' => $partner->discount_price,

            'created_at' => $partner->created_at,

            'updated_at' => $partner->updated_at
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

            'code' => $request->json('code'),

            'address' => $request->json('address'),

            'address_additional' => $request->json('address_additional'),

            'name' => $request->json('name'),

            'photo' => $request->json('photo'),

            'weight_price' => $request->json('weight_price'),

            'warehouse_price' => $request->json('warehouse_price'),

            'pickup' => $request->json('pickup'),

            'delivery' => $request->json('delivery'),

            'discount_price' => $request->json('discount_price')
        ];
    }

    /**
     * @param PartnersRequest $request
     *
     * @return array
     */
    public function updateCredentials(PartnersRequest $request): array
    {
        return [
            'city_id' => $request->json('city_id'),

            'code' => $request->json('code'),

            'address' => $request->json('address'),

            'address_additional' => $request->json('address_additional'),

            'name' => $request->json('name'),

            'weight_price' => $request->json('weight_price'),

            'warehouse_price' => $request->json('warehouse_price'),

            'pickup' => $request->json('pickup'),

            'delivery' => $request->json('delivery'),

            'discount_price' => $request->json('discount_price')
        ];
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
