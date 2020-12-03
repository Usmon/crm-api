<?php

namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Feedback;

use Illuminate\Contracts\Pagination\Paginator;

final class Feedbacks
{
    /**
     * @param array $filters
     *
     * @return Paginator
     */
    public function getFeedbacks(array $filters): Paginator
    {
        return Feedback::filter($filters)->orderBy('created_at', 'desc')->pager();
    }

    /**
     * @param array $credentials
     *
     * @return Feedback
     */
    public function storeFeedback(array $credentials): Feedback
    {
        $feedback = Feedback::create($credentials);

        return $feedback;
    }

    /**
     * @param Feedback $feedback
     *
     * @param array $credentials
     *
     * @return Feedback
     */
    public function updateFeedback(Feedback $feedback, array $credentials): Feedback
    {
        $feedback->update($credentials);

        return $feedback;
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function deleteFeedback($id)
    {
        return Feedback::destroy($id);
    }
}
