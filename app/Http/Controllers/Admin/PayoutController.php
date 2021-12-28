<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayoutRequest;
use App\Models\Payout;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PayoutController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('payout_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $payouts = Payout::with(['provider'])->latest()->get();

        return view('admin.payouts.index', compact('payouts'));
    }

    public function create(User $provider)
    {
        abort_if(Gate::denies('payout_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $available_amount = $provider->availablePayout;

        return view('admin.payouts.create', compact('provider', 'available_amount'));
    }

    public function store(StorePayoutRequest $request)
    {
        $payout = Payout::create($request->all());

        return redirect()->route('admin.payouts.index');
    }
}
