<?php

namespace App\Services;

use App\Models\City;

class CityService extends BaseService
{
    public function __construct(City $city)
    {
        $this->model = $city;
    }


    public function getCityByName(string $name, int $countyId)
    {
        $companyCategory = $this->model->where('name', strtolower($name));
        if ($companyCategory) {
            $companyCategory =
                $this->model->create(['name' => strtolower($name), 'county_id' => $countyId]);
        }

        return $companyCategory;
    }
}
