<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPromoCodeRequest;
use App\Http\Requests\StorePromoCodeRequest;
use App\Http\Requests\UpdatePromoCodeRequest;
use App\Models\Category;
use App\Models\PromoCode;
use App\Models\Service;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PromoCodeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('promo_code_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $promoCodes = PromoCode::with(['categories', 'services'])->get();

        return view('admin.promoCodes.index', compact('promoCodes'));
    }

    public function create()
    {
        abort_if(Gate::denies('promo_code_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id');

        $services = Service::pluck('name', 'id');

        return view('admin.promoCodes.create', compact('categories', 'services'));
    }

    public function store(StorePromoCodeRequest $request)
    {
        $promoCode = PromoCode::create($request->all());
        $promoCode->categories()->sync($request->input('categories', []));
        $promoCode->services()->sync($request->input('services', []));

        return redirect()->route('admin.promo-codes.index');
    }

    public function edit(PromoCode $promoCode)
    {
        abort_if(Gate::denies('promo_code_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id');

        $services = Service::pluck('name', 'id');

        $promoCode->load('categories', 'services');

        return view('admin.promoCodes.edit', compact('categories', 'services', 'promoCode'));
    }

    public function update(UpdatePromoCodeRequest $request, PromoCode $promoCode)
    {
        $promoCode->update($request->all());
        $promoCode->categories()->sync($request->input('categories', []));
        $promoCode->services()->sync($request->input('services', []));

        return redirect()->route('admin.promo-codes.index');
    }

    public function show(PromoCode $promoCode)
    {
        abort_if(Gate::denies('promo_code_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $promoCode->load('categories', 'services');

        return view('admin.promoCodes.show', compact('promoCode'));
    }

    public function destroy(PromoCode $promoCode)
    {
        abort_if(Gate::denies('promo_code_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $promoCode->delete();

        return back();
    }

    public function massDestroy(MassDestroyPromoCodeRequest $request)
    {
        PromoCode::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
