<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Customer;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Customers as CustomersRequest;

final class Customers
{
    /**
     * @param CustomersRequest $request
     *
     * @return array
     */
    public function getAllFilters(CustomersRequest $request): array
    {
        return [
            'search' => $request->json('search') ?? $request->get('search'),

            'date' => $request->json('date') ?? $request->get('date'),

            'user_id' => $request->json('user_id') ?? $request->get('user_id'),

            'creator_id' => $request->json('creator_id') ?? $request->get('created_id'),

            'referral_id' => $request->json('referral_id') ?? $request->get('referral_id'),

            'passport' => $request->json('passport') ?? $request->get('passport'),

            'balance' => $request->json('balance') ?? $request->get('balance'),

            'debt' => $request->json('debt') ?? $request->get('debt'),

            'birth_date' => $request->json('birth_date') ?? $request->get('birth_date'),

            'note' => $request->json('note') ?? $request->get('note'),

            'phone' => $request->json('phone') ?? $request->get('phone'),

            'only_recipient' => $request->json('only_recipient') ?? $request->get('only_recipient') ?? false,
        ];
    }

    /**
     * @param CustomersRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(CustomersRequest $request): array
    {
        return $request->only('search', 'date', 'user_id', 'creator_id',
            'referral_id', 'passport', 'balance', 'debt', 'birth_date', 'note', 'phone', 'only_recipient');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getCustomers(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Customer $customer) {
            return [
                'id' => $customer->sender->id ?? $customer->recipient->id,

                'is_recipient' => (bool) $customer->recipient,

                'user' => [
                    'full_name' => $customer->user->full_name,

                    'phone' => $customer->user->getPhonesWithLimit(),

                    'email' => $customer->user->email,

                    'photo' => $customer->user->profile['photo'],
                ],

                'balance' => $customer->balance,

                'debt' => $customer->debt,

                'created_at' => $customer->created_at,

                'updated_at' => $customer->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Customer $customer
     *
     * @return array
     */
    public function showCustomer(Customer $customer): array
    {
        return [
            'id' => $customer->id,

            'user_id' => $customer->user_id,

            'creator_id' => $customer->creator_id,

            'referral_id' => $customer->referral_id,

            'passport' => $customer->passport,

            'balance' => $customer->balance,

            'birth_date' => $customer->birth_date,

            'note' => $customer->note,

            'created_at' => $customer->created_at,

            'updated_at' => $customer->updated_at,

            'user' => $customer->user,

            'creator' => $customer->creator,

            'referral' => $customer->referral,
        ];
    }

    /**
     * @param CustomersRequest $request
     *
     * @return array
     */
    public function storeCredentials(CustomersRequest $request): array
    {
        return [
            'user_id' => $request->json('user_id'),

            'referral_id' => $request->json('referral_id'),

            'passport' => $request->json('passport'),

            'balance' => $request->json('balance'),

            'birth_date' => $request->json('birth_date'),

            'note' => $request->json('note'),
        ];
    }

    /**
     * @param CustomersRequest $request
     *
     * @return array
     */
    public function updateCredentials(CustomersRequest $request): array
    {
        $credentials = [
            'user_id' => $request->json('user_id'),

            'referral_id' => $request->json('referral_id'),

            'passport' => $request->json('passport'),

            'balance' => $request->json('balance'),

            'birth_date' => $request->json('birth_date'),

            'note' => $request->json('note'),
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteCustomer($id)
    {
        $id = json_decode($id);

        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
