@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.payout.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payouts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="provider_id">{{ trans('cruds.payout.fields.provider') }}</label>
                <select class="form-control select2 {{ $errors->has('provider') ? 'is-invalid' : '' }}" name="provider_id" id="provider_id" required disabled>
                        <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>{{ $provider->name }}</option>
                </select>
                @if($errors->has('provider'))
                    <span class="text-danger">{{ $errors->first('provider') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.provider_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.payout.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $available_amount) }}" step="0.01" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.payout.fields.method') }}</label>
                <select class="form-control {{ $errors->has('method') ? 'is-invalid' : '' }}" name="method" id="method" required>
                    <option value disabled {{ old('method', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Payout::METHOD_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('method', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('method'))
                    <span class="text-danger">{{ $errors->first('method') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.method_helper') }}</span>
            </div>
            <input type="hidden" name="provider_id" value="{{ $provider->id }}">
            <input type="hidden" name="available_amount" value="{{ $available_amount }}">
            <input type="hidden" name="paid_at" value="{{ NOW()->format(config('panel.date_format')) }}">
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
