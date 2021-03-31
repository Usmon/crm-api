<?php


namespace App\Logic\Dashboard\CRUD\Services;


use Illuminate\Database\Eloquent\Collection;

use App\Models\Country;

/**
 * Class Countries
 *
 * @package App\Logic\Dashboard\CRUD\Services
 */
class Countries
{
    /**
     * @param Collection $countries
     *
     * @return Collection
     */
    public function getAll(Collection $countries): Collection
    {
        return $countries->transform(function(Country $country) {
            return [
                'id' => $country->id,

                'name' => $country->name,

                'code' => $country->code
            ];
        });
    }
}
