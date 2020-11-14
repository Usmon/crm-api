<?php

namespace App\Observers;

use App\Models\User;

use Illuminate\Support\Carbon;

final class UserObserver
{
    /**
     * @param User $user
     *
     * @return void
     */
    public function creating(User $user): void
    {
        $this->defaultProperties($user);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function updating(User $user): void
    {
        $this->defaultProperties($user);
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function deleting(User $user): void
    {
        $user->deleted_at = $user->deleted_at ?? Carbon::now();
    }

    /**
     * @param User $user
     *
     * @return void
     */
    public function restoring(User $user): void
    {
        $user->deleted_at = null;
    }

    /**
     * @param User $user
     *
     * @return void
     */
    protected function defaultProperties(User $user): void
    {
        $user->profile = $user->profile ?? User::DEFAULT_PROFILE;

        $user->reset_token = $user->reset_token ?? null;

        $user->verify_token = $user->verify_token ?? null;

        $user->remember_token = $user->remember_token ?? null;

        $user->created_at = $user->created_at ?? Carbon::now();

        $user->updated_at = $user->updated_at ?? Carbon::now();

        $user->deleted_at = $user->deleted_at ?? null;
    }
}
