<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Order;

use App\Models\Recipient;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Recipients as RecipientsRequest;

final class Recipients
{
    /**
     * @param RecipientsRequest $request
     *
     * @return array
     */
    public function getAllFilters(RecipientsRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'customer_id' => $request->json('customer_id'),

            'customer' => $request->json('customer'),
        ];
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(RecipientsRequest $request): array
    {
        return $request->only('search', 'date', 'customer_id', 'customer');
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return string
     */
    public function getOnlyPhone(RecipientsRequest $request): string
    {
        return $request->get('phone') ?? $request->json('phone');
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return array
     */
    public function getAllSorts(RecipientsRequest $request): array
    {
        return $request->json('sort') ?? [];
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return array
     */
    public function getOnlySorts(RecipientsRequest $request): array
    {
        return $request->only('sort');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getRecipients(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Recipient $recipient) {
            return [
                'id' => $recipient->id,

                'customer' => $recipient->customer()->get(),

                'created_at' => $recipient->created_at,

                'updated_at' => $recipient->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Collection $recipients
     *
     * @return Collection
     */
    public function getPhones(Collection $recipients, string $phone): Collection
    {
        return $recipients->transform(function (Recipient $recipient) use($phone) {
            return [
                'id' => $recipient->id,

                'full_name' => $recipient->customer->user->full_name,

                'phone' => $recipient->getPhone($phone)
            ];
        });
    }

    /**
     * @param Recipient $recipient
     *
     * @return array
     */
    public function showRecipient(Recipient $recipient): array
    {
        return [
            'id' => $recipient->id,

            'full_name' => $recipient->customer->user->full_name,

            'email' => $recipient->customer->user->email,

            'city' => $recipient->customer->user->addresses()->first()->city,

            'zip_code' => $recipient->customer->user->addresses()->first()->city->codes[0],

            'address_line_1' => $recipient->customer->user->addresses()->first()->first_address,

            'address_line_2' => $recipient->customer->user->addresses()->first()->second_address,

            'passport' => $recipient->customer->passport,

            'created_at' => $recipient->created_at,

            'updated_at' => $recipient->updated_at,

            'phones' => $recipient->customer->user->getPhonesWithLimit(10)
        ];
    }

    /**
     * @param Recipient $recipient
     *
     * @param string $phone
     *
     * @return array
     */
    public function showRecipientPhone(Recipient $recipient, string $phone): array
    {
        return [
            'id' => $recipient->id,

            'recipient_full_name' => $recipient->customer->user->full_name,

            'recipient_phone' => $recipient->customer->user->phones()->where('phone', '=', $phone)->first()->phone,

            'recipient_email' => $recipient->customer->user->email,

            'recipient_region' => $recipient->customer->user->addresses()->first()->city->region->name,

            'recipient_city' => $recipient->customer->user->addresses()->first()->city->name,

            'recipient_zip_code' => $recipient->customer->user->addresses()->first()->city->codes[0],

            'recipient_address_line_1' => $recipient->customer->user->addresses()->first()->first_address,

            'recipient_address_line_2' => $recipient->customer->user->addresses()->first()->second_address,

            'recipient_limit' => $recipient->limit,

            'histories' => $recipient->orders->unique('sender_id')->transform(function(Order $order) {
                return [
                    'id' => $order->sender->id,

                    'full_name' => $order->sender->customer->user->full_name,

                    'phone' => $order->sender->customer->user->phones->first()->phone,

                    'email' => $order->sender->customer->user->email,

                    'region' => $order->sender->customer->user->addresses->first()->city->region->name,

                    'city' => $order->sender->customer->user->addresses->first()->city->name,

                    'zip_code' => $order->sender->customer->user->addresses->first()->city->codes[0],

                    'address_line_1' => $order->sender->customer->user->addresses->first()->first_address,

                    'address_line_2' => $order->sender->customer->user->addresses->first()->second_address,
                ];
            })
        ];
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return array
     */
    public function storeCredentials(RecipientsRequest $request): array
    {
        return [
            'customer' => [
                'passport' => $request->json('passport')
            ],

            'user' => [
                'full_name' => $request->json('user')['full_name'],

                'profile' => [
                    'fist_name' => $request->json('user')['first_name'] ?? null,

                    'middle_name' => $request->json('user')['middle_name'] ?? null,

                    'last_name' => $request->json('user')['last_name'] ?? null,

                    'photo' => null
                ]
            ],

            'phone' => $request->json('phone'),

            'address' => $request->json('address'),
        ];
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return array
     */
    public function updateCredentials(RecipientsRequest $request): array
    {
        return [
            'customer' => [
                'passport' => $request->json('passport')
            ],

            'user' => [
                'full_name' => $request->json('user')['full_name'],

                'email' => $request->json('user')['email'],

                'profile' => [
                    'fist_name' => $request->json('user')['first_name'] ?? null,

                    'middle_name' => $request->json('user')['middle_name'] ?? null,

                    'last_name' => $request->json('user')['last_name'] ?? null,

                    'photo' => null
                ]
            ],

            'phones' => collect($request->json('phones'))->transform(function (string $phone) {
                return ['phone' => $phone];
            }),

            'address' => $request->json('address'),
        ];
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteRecipient($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
