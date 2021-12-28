<?php

namespace App\Http\Requests;

use App\Models\ServiceExtra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateServiceExtraRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('service_extra_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
            'service_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
