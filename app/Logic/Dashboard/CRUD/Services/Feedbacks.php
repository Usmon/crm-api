<?php

namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\Feedback;

use Illuminate\Contracts\Pagination\Paginator;

use App\Logic\Dashboard\CRUD\Requests\Feedbacks as FeedbacksRequest;

final class Feedbacks
{
    /**
     * @param FeedbacksRequest $request
     *
     * @return array
     */
    public function getAllFilters(FeedbacksRequest $request): array
    {
        return [
            'search' => $request->json('search'),

            'date' => $request->json('date'),

            'staff_id' => $request->json('staff_id'),

            'customer_id' => $request->json('customer_id'),

            'message' => $request->json('message'),
        ];
    }

    /**
     * @param FeedbacksRequest $request
     *
     * @return array
     */
    public function getOnlyFilters(FeedbacksRequest $request): array
    {
        return $request->only('search', 'date', 'staff_id', 'customer_id', 'message');
    }

    /**
     * @param Paginator $paginator
     *
     * @return Paginator
     */
    public function getFeedbacks(Paginator $paginator): Paginator
    {
        $paginator->getCollection()->transform(function (Feedback $feedback) {
            return [
                'id' => $feedback->id,

                'staff_id' => $feedback->staff_id,

                'customer_id' => $feedback->customer_id,

                'message' => $feedback->message,

                'created_at' => $feedback->created_at,

                'updated_at' => $feedback->updated_at,
            ];
        });

        return $paginator;
    }

    /**
     * @param Feedback $feedback
     *
     * @return array
     */
    public function showFeedback(Feedback $feedback): array
    {
        return [
            'id' => $feedback->id,

            'staff_id' => $feedback->staff_id,

            'customer_id' => $feedback->customer_id,

            'message' => $feedback->message,

            'created_at' => $feedback->created_at,

            'updated_at' => $feedback->updated_at,
        ];
    }

    /**
     * @param FeedbacksRequest $request
     *
     * @return array
     */
    public function storeCredentials(FeedbacksRequest $request): array
    {
        return [
            'staff_id' => $request->json('staff_id'),

            'customer_id' => $request->json('customer_id'),

            'message' => $request->json('message')
        ];
    }

    /**
     * @param FeedbacksRequest $request
     *
     * @return array
     */
    public function updateCredentials(FeedbacksRequest $request): array
    {
        $credentials = [
            'staff_id' => $request->json('staff_id'),

            'customer_id' => $request->json('customer_id'),

            'message' => $request->json('message')
        ];

        return $credentials;
    }

    /**
     * @param $id
     *
     * @return array|int
     */
    public function deleteFeedback($id)
    {
        $id = json_decode($id);
        return (is_int($id) || array_filter($id,'is_int')===$id) ? $id : 0;
    }
}
