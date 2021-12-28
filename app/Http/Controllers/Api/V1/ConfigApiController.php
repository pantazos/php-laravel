<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Resources\Api\PaymentMethodResource;
use App\Http\Resources\Api\ServiceResource;
use App\Http\Resources\Api\PaymentSettingResource;
use App\Http\Resources\Api\StatusResource;
use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\PaymentSetting;
use App\Models\Service;
use App\Models\Status;

class ConfigApiController extends Controller
{
    public function index()
    {
        return response([
            'categories' => CategoryResource::collection(Category::all()),
            'services' => ServiceResource::collection(Service::all()),
            'statuses' => StatusResource::collection(Status::all()),
            'paymentSettings' => new PaymentSettingResource(PaymentSetting::firstOrFail()),
            'paymentMethods' => PaymentMethodResource::collection(PaymentMethod::all()),
        ]);
    }
}
