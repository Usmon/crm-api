<?php


namespace App\Logic\Dashboard\CRUD\Repositories;

use App\Models\Country;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class Countries
 *
 * @package App\Logic\Dashboard\CRUD\Repositories
 */
class Countries
{
    /**
     * @return Collection
     */
    public function getRegions(): Collection
    {
        return Country::all();
    }
}
