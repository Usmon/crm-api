<?php

namespace App\Observers;

use App\Models\Customer;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Auth;

final class CustomerObserver
{
    /**
     * @param Customer $customer
     */
    public function creating(Customer $customer): void
    {
        $this->defaultProperties($customer);
    }

    /**
     * @param Customer $customer
     */
    public function updating(Customer $customer): void
    {
        $this->defaultProperties($customer);
    }

    /**
     * @param Customer $customer
     */
    public function deleting(Customer $customer): void
    {
        $customer->deleted_by = $customer->deleted_by ?? Auth::id();

        $customer->deleted_at = $customer->deleted_at ?? Carbon::now();

        $customer->update();
    }

    /**
     * @param Customer $customer
     */
    public function restoring(Customer $customer): void
    {
        $customer->deleted_at = null;
    }

    /**
     * @param Customer $customer
     */
    protected function defaultProperties(Customer $customer): void
    {
        $customer->balance = $customer->balance ?? 0;

        $customer->debt = $customer->debt ?? 0;

        $customer->deleted_at = $customer->deleted_at ?? null;

        $customer->deleted_by = $customer->deleted_by ?? null;

        $customer->creator_id = $customer->creator_id ?? Auth::id();

        $customer->created_at = $customer->created_at ?? Carbon::now();

        $customer->updated_at = $customer->updated_at ?? Carbon::now();
    }
}
