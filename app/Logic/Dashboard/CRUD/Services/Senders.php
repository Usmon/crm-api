<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Sender;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Senders as SendersRequest;
use Illuminate\Support\Collection;

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

            'customer' => $request->json('customer'),
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(SendersRequest $request): array
    {
        return $request->only('search', 'date', 'customer_id', 'customer',);
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

                'customer_id' => $sender->customer_id,

                'created_at' => $sender->created_at,

                'updated_at' => $sender->updated_at,

                'customer' => $sender->customer
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

            'customer_id' => $sender->customer_id,

            'created_at' => $sender->created_at,

            'updated_at' => $sender->updated_at,

            'customer' => $sender->customer
        ];
    }

    /**
     * @param Sender $sender
     *
     * @return array
     */
    public function showSenderPhone(Sender $sender): array
    {
        return [
            'id' => $sender->id,

            'sender_full_name' => $sender->customer->user->full_name,

            'sender_phone' => $sender->customer->user->phones()->first()->phone,

            'sender_email' => $sender->customer->user->email,

            'sender_region' => $sender->customer->user->addresses()->first()->city->region->name,

            'sender_city' => $sender->customer->user->addresses()->first()->city->name,

            'sender_zip_code' => '90800', //To be change from model

            'sender_address_line_1' => $sender->customer->user->addresses()->first()->first_address,

            'sender_address_line_2' => $sender->customer->user->addresses()->first()->second_address
        ];
    }

    /**
     * @param Collection $senders
     *
     * @return Collection
     */
    public function getPhones(Collection $senders): Collection
    {
        return $senders->transform(function (Sender $sender) {
            return [
                'id' => $sender->id,

                'full_name' => $sender->customer->user->full_name,

                'phone' => $sender->customer->user->phones->first()->phone ?? ''
            ];
        });
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
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return array
     */
    public function updateCredentials(SendersRequest $request): array
    {
        return [
            'customer_id' => $request->json('customer_id'),
        ];
    }

    /**
     * @param SendersRequest $request
     *
     * @return string
     */
    public function getOnlyPhone(SendersRequest $request): string
    {
        return $request->get('phone');
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
