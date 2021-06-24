<?php


namespace App\Logic\Dashboard\CRUD\Services;

use App\Models\PaymentType;

use Illuminate\Support\Collection;

/**
 * Class PaymentTypes
 *
 * @package App\Logic\Dashboard\CRUD\Services
 */
class PaymentTypes
{
    /**
     * Get items with correction.
     *
     * @param Collection $items
     *
     * @return array
     */
    public function getItems(Collection $items): array
    {
        return $items->transform(function (PaymentType $item) {
            return [
                'id' => $item->id,

                'name' => $item->name,

                'slug' => $item->slug,

                'parameters' => $item->parameters,

                'is_active' => $item->is_active
            ];
        })->toArray();
    }

    /**
     * Get item
     *
     * @param PaymentType $item
     *
     * @return array
     */
    public function getItem(PaymentType $item): array
    {
        return [
            'id' => $item->id,

            'name' => $item->name,

            'slug' => $item->slug,

            'parameters' => $item->parameters,

            'is_active' => $item->is_active
        ];
    }
}
