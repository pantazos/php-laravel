@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.payout.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payouts.update", [$payout->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="provider_id">{{ trans('cruds.payout.fields.provider') }}</label>
                <select class="form-control select2 {{ $errors->has('provider') ? 'is-invalid' : '' }}" name="provider_id" id="provider_id" required>
                    @foreach($providers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('provider_id') ? old('provider_id') : $payout->provider->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('provider'))
                    <span class="text-danger">{{ $errors->first('provider') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.provider_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.payout.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="number" name="amount" id="amount" value="{{ old('amount', $payout->amount) }}" step="0.01" required>
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
                        <option value="{{ $key }}" {{ old('method', $payout->method) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('method'))
                    <span class="text-danger">{{ $errors->first('method') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.method_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="paid_at">{{ trans('cruds.payout.fields.paid_at') }}</label>
                <input class="form-control date {{ $errors->has('paid_at') ? 'is-invalid' : '' }}" type="text" name="paid_at" id="paid_at" value="{{ old('paid_at', $payout->paid_at) }}" required>
                @if($errors->has('paid_at'))
                    <span class="text-danger">{{ $errors->first('paid_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.payout.fields.paid_at_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection