<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Recipient;

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
     * @return array
     */
    public function getOnlyPhone(RecipientsRequest $request): array
    {
        return [
            'customer' => $request->json('phone')
        ];
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
     * @param Recipient $recipient
     *
     * @return array
     */
    public function showRecipient(Recipient $recipient): array
    {
        return [
            'id' => $recipient->id,

            'customer' => $recipient->customer()->with(['phones'])->get(),


            'created_at' => $recipient->created_at,

            'updated_at' => $recipient->updated_at,
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
            'customer_id' => $request->json('customer_id'),
        ];
    }

    /**
     * @param RecipientsRequest $request
     *
     * @return array
     */
    public function updateCredentials(RecipientsRequest $request): array
    {
        $credentials = [
            'customer_id' => $request->json('customer_id'),
        ];

        return $credentials;
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
