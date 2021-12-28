<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Earning;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EarningController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('earning_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $earnings = Earning::with(['provider'])->latest()->get();

        return view('admin.earnings.index', compact('earnings'));
    }
}
