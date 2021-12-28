<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceExtraRequest;
use App\Http\Requests\StoreServiceExtraRequest;
use App\Http\Requests\UpdateServiceExtraRequest;
use App\Models\Service;
use App\Models\ServiceExtra;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceExtraController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_extra_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceExtras = ServiceExtra::with(['service'])->get();

        return view('admin.serviceExtras.index', compact('serviceExtras'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_extra_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.serviceExtras.create', compact('services'));
    }

    public function store(StoreServiceExtraRequest $request)
    {
        $serviceExtra = ServiceExtra::create($request->all());

        return redirect()->route('admin.service-extras.index');
    }

    public function edit(ServiceExtra $serviceExtra)
    {
        abort_if(Gate::denies('service_extra_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $services = Service::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $serviceExtra->load('service');

        return view('admin.serviceExtras.edit', compact('services', 'serviceExtra'));
    }

    public function update(UpdateServiceExtraRequest $request, ServiceExtra $serviceExtra)
    {
        $serviceExtra->update($request->all());

        return redirect()->route('admin.service-extras.index');
    }

    public function destroy(ServiceExtra $serviceExtra)
    {
        abort_if(Gate::denies('service_extra_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceExtra->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceExtraRequest $request)
    {
        ServiceExtra::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
