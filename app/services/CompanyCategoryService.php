<?php

namespace App\Services;

use App\Models\CompanyCateogry;


class CompanyCategoryService extends BaseService
{
    public function __construct(CompanyCateogry $companyCateogry)
    {
        $this->model = $companyCateogry;
    }

    /**
     * Get company category by its name
     * @param string $name
     */
    public function getCompanyByName(string $name)
    {
        $companyCategory = $this->model->where('name', strtolower($name));
        if ($companyCategory) {
            $companyCategory =
                $this->model->create(['name' => strtolower($name)]);
        }

        return $companyCategory;
    }
}
