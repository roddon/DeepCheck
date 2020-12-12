<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = null;
        if (!empty($this->id)) {
            $id = $this->id;
        }
        return [
            'name' => "required|unique:subscription_plans,name,{$id},id",
            'description' => 'required',
            'trial_days' => 'integer',
            'trial_days_doc_numbers' => 'integer',
            'planRecords.*.no_of_records_count' => 'integer',
            'planRecords.*.price' => 'numeric',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name' => [
                'required' => __('subscription_plan.required_name')
            ],
            'description' => [
                'required' => __('subscription_plan.required_description')
            ],
            'trial_days.integer' => 'Trial days must be integer',
            'trial_days_doc_numbers.integer' => 'Trial days document number must be integer',
            'planRecords.*.no_of_records_count.integer' => 'No of record must be integer',
            'planRecords.*.price.numeric' => 'Price must be numeric',
        ];
    }
}
