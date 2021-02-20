<?php


namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\PaymentType;
use Illuminate\Support\Collection;

/**
 * Class PaymentTypes
 * @package App\Logic\Dashboard\CRUD\Services
 */
class PaymentTypes
{
    public function getItems(Collection $items): array
    {
        return $items->transform(function (PaymentType $item) {
            return [
                'name' => $item->name,

                'slug' => $item->slug,

                'parameters' => $item->parameters,

                'is_active' => $item->is_active
            ];
        })->toArray();
    }
}
