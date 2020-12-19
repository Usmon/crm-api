<?php

namespace App\Observers;

use Illuminate\Support\Carbon;

use App\Models\SpendingCategory;

use Illuminate\Support\Facades\Auth;

final class SpendingCategoryObserver
{
    /**
     * @param SpendingCategory $spendingCategory
     *
     * @return void
     */
    public function creating(SpendingCategory $spendingCategory): void
    {
        $this->defaultProperties($spendingCategory);
    }

    /**
     * @param SpendingCategory $spendingCategory
     *
     * @return void
     */
    public function updating(SpendingCategory $spendingCategory): void
    {
        $this->defaultProperties($spendingCategory);
    }

    /**
     * @param SpendingCategory $spendingCategory
     *
     * @return void
     */
    public function deleting(SpendingCategory $spendingCategory): void
    {
        $spendingCategory->deleted_by = Auth::id();

        $spendingCategory->deleted_at = $spendingCategory->deleted_at ?? Carbon::now();

        $spendingCategory->update();
    }

    /**
     * @param SpendingCategory $spendingCategory
     *
     * @return void
     */
    public function restoring(SpendingCategory $spendingCategory): void
    {
        $spendingCategory->deleted_at = null;
    }

    /**
     * @param SpendingCategory $spendingCategory
     *
     * @return void
     */
    protected function defaultProperties(SpendingCategory $spendingCategory): void
    {
        $spendingCategory->created_at = $spendingCategory->created_at ?? Carbon::now();

        $spendingCategory->updated_at = $spendingCategory->updated_at ?? Carbon::now();

        $spendingCategory->deleted_at = $spendingCategory->deleted_at ?? null;
    }
}
