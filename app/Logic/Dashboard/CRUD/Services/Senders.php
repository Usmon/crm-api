<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Logic\Dashboard\CRUD\Requests\Senders as SendersRequest;

use App\Models\Sender;

use Illuminate\Contracts\Pagination\Paginator;

final class Senders
{
    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getAllFilters(SendersRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'customer_id' => $request->json('customer_id'),

            'address' => $request->json('address'),

            'phone' => $request->json('phone'),
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(SendersRequest $request): array
    {
        return $request->only('search', 'date', 'customer_id','address');
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getOnlyPhone(SendersRequest $request): array
    {
        return $request->only('phone');
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getAllSorts(SendersRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getOnlySorts(SendersRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getSenders(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Sender $sender) {
            return [
                'id' => $sender->id,

                'customer'=> $sender->customer()->with(['phones','addresses'])->get(),

                'address' => $sender->address,

                'created_at' => $sender->created_at,

                'updated_at' => $sender->updated_at,


            ];
        });
        return $paginator;
    }

    /**
     * @param Sender $sender
     *
     * @return array
     */
    public function showSender(Sender $sender): array
    {
        return [
            'id' => $sender->id,

            'customer' => $sender->customer()->with(['phones','addresses'])->get(),

            'address' => $sender->address,

            'created_at' => $sender->created_at,

            'updated_at' => $sender->updated_at,
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function storeCredentials(SendersRequest $request): array
    {
        return [
            'customer_id' => $request->json('customer_id'),

            'address' => $request->json('address')
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function updateCredentials(SendersRequest $request): array
    {
        $credentials = [
            'customer_id' => $request->json('customer_id'),

            'address' => $request->json('address')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteSender($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
