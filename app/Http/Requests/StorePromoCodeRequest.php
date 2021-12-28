<?php

namespace App\Http\Requests;

use App\Models\PromoCode;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePromoCodeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('promo_code_create');
    }

    public function rules()
    {
        return [
            'enabled' => [
                'required',
            ],
            'code' => [
                'string',
                'required',
                'unique:promo_codes',
            ],
            'type' => [
                'required',
            ],
            'discount' => [
                'numeric',
                'required',
            ],
            'expires_at' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'categories.*' => [
                'integer',
            ],
            'categories' => [
                'array',
            ],
            'services.*' => [
                'integer',
            ],
            'services' => [
                'array',
            ],
        ];
    }
}
