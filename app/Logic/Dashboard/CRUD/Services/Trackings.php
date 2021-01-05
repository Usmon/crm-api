<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Tracking;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Trackings as TrackingsRequest;

final class Trackings
{
    /**
     * @param TrackingsRequest $request
     *
     * @return array
     */
    public function getAllFilters(TrackingsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'tracking' => $request->json('tracking'),

            'customer' => $request->json('customer'),
        ];
    }

    /**
     * @param TrackingsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(TrackingsRequest $request): array
    {
        return $request->only('search', 'date', 'tracking', 'customer');
    }

    /**
     * @param TrackingsRequest $request
     *
     * @return array
     */
    public function getAllSorts(TrackingsRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param TrackingsRequest $request
     *
     * @return array
     */
    public function getOnlySorts(TrackingsRequest $request): array
    {
        return $request->only('sort');
    }
    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getTrackings(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Tracking $tracking) {
            return [
                'id' => $tracking->id,

                'tracking' => $tracking->tracking,

                'customer_id' => $tracking->customer_id,

                'item' => $tracking->item,

                'color' => $tracking->color,

                'QTN' => $tracking->QTN,

                'box_id' => $tracking->box_id,

                'image' => $tracking->image,

                'created_at' => $tracking->created_at,

                'updated_at' => $tracking->updated_at,

                'customer' => $tracking->customer,

                'box' => $tracking->box,
            ];
        });

        return $paginator;
    }

    /**
     * @param Tracking $tracking
     *
     * @return array
     */
    public function showTracking(Tracking $tracking): array
    {
        return [
            'id' => $tracking->id,

            'tracking' => $tracking->tracking,

            'customer_id' => $tracking->customer_id,

            'item' => $tracking->item,

            'color' => $tracking->color,

            'QTN' => $tracking->QTN,

            'box_id' => $tracking->box_id,

            'image' => $tracking->image,

            'created_at' => $tracking->created_at,

            'updated_at' => $tracking->updated_at,

            'customer' => $tracking->customer,

            'box' => $tracking->box,
        ];
    }

    /**
     * @param TrackingsRequest $request
     *
     * @return array
     */
    public function storeCredentials(TrackingsRequest $request): array
    {
        return [
            'tracking' => $request->json('tracking'),

            'customer_id' => $request->json('customer_id'),

            'item' => $request->json('item'),

            'color' => $request->json('color'),

            'QTN' => $request->json('QTN'),

            'box_id' => $request->json('box_id'),

            'image' => $request->json('image'),
        ];
    }

    /**
     * @param TrackingsRequest $request
     *
     * @return array
     */
    public function updateCredentials(TrackingsRequest $request): array
    {
        $credentials = [
            'tracking' => $request->json('tracking'),

            'customer_id' => $request->json('customer_id'),

            'item' => $request->json('item'),

            'color' => $request->json('color'),

            'QTN' => $request->json('QTN'),

            'box_id' => $request->json('box_id'),

            'image' => $request->json('image'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteTracking($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
