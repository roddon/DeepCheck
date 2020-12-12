<?php

namespace App\Services;


use App\Models\County;

class CountyService extends BaseService
{
    public function __construct(County $county)
    {
        $this->model = $county;
    }

    public function getCountyByName(string $name, int $countryId)
    {
        $companyCategory = $this->model->where('name', strtolower($name));
        if ($companyCategory) {
            $companyCategory =
                $this->model->create([
                    'name' => strtolower($name),
                    'country_id' => $countryId
                ]);
        }

        return $companyCategory;
    }
}
