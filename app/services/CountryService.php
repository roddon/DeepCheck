<?php

namespace App\Services;

use App\Models\Country;

class CountryService extends BaseService
{
    public function __construct(Country $country)
    {
        $this->model = $country;
    }


    public function getCountryByName(string $name)
    {
        $name = strtolower($name);
        $country = $this->model->where('name', $name);
        if ($country) {
            $country =
                $this->model->create(['name' => $name]);
        }

        return $country;
    }
}
