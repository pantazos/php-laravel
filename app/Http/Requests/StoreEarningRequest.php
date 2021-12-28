<?php

namespace App\Http\Requests;

use App\Models\Earning;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEarningRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('earning_create');
    }

    public function rules()
    {
        return [
            'provider_id' => [
                'required',
                'integer',
            ],
            'bookings_count' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'total_earning' => [
                'required',
            ],
            'admin_earning' => [
                'required',
            ],
            'provider_earning' => [
                'required',
            ],
            'total_tax' => [
                'required',
            ],
        ];
    }
}
