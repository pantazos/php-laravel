<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCommissionRequest;
use App\Http\Requests\StoreCommissionRequest;
use App\Http\Requests\UpdateCommissionRequest;
use App\Models\Commission;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommissionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('commission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commissions = Commission::all();

        return view('admin.commissions.index', compact('commissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('commission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commissions.create');
    }

    public function store(StoreCommissionRequest $request)
    {
        $commission = Commission::create($request->all());

        return redirect()->route('admin.commissions.index');
    }

    public function edit(Commission $commission)
    {
        abort_if(Gate::denies('commission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commissions.edit', compact('commission'));
    }

    public function update(UpdateCommissionRequest $request, Commission $commission)
    {
        $commission->update($request->all());

        return redirect()->route('admin.commissions.index');
    }

    public function destroy(Commission $commission)
    {
        abort_if(Gate::denies('commission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commission->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommissionRequest $request)
    {
        Commission::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
