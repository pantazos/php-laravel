<?php

namespace App\Http\Requests;

use App\Models\ServiceExtra;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyServiceExtraRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('service_extra_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:service_extras,id',
        ];
    }
}
