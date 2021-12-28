@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.paymentSetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.payment-settings.update", [$paymentSetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="currency_id">{{ trans('cruds.paymentSetting.fields.currency') }}</label>
                <select class="form-control select2 {{ $errors->has('currency') ? 'is-invalid' : '' }}" name="currency_id" id="currency_id" required>
                    @foreach($currencies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('currency_id') ? old('currency_id') : $paymentSetting->currency->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('currency'))
                    <span class="text-danger">{{ $errors->first('currency') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentSetting.fields.currency_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('tax_enabled') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="tax_enabled" id="tax_enabled" value="1" {{ $paymentSetting->tax_enabled || old('tax_enabled', 0) === 1 ? 'checked' : '' }} required>
                    <label class="required form-check-label" for="tax_enabled">{{ trans('cruds.paymentSetting.fields.tax_enabled') }}</label>
                </div>
                @if($errors->has('tax_enabled'))
                    <span class="text-danger">{{ $errors->first('tax_enabled') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentSetting.fields.tax_enabled_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tax_percentage">{{ trans('cruds.paymentSetting.fields.tax_percentage') }}</label>
                <input class="form-control {{ $errors->has('tax_percentage') ? 'is-invalid' : '' }}" type="number" name="tax_percentage" id="tax_percentage" value="{{ old('tax_percentage', $paymentSetting->tax_percentage) }}" step="0.01" required>
                @if($errors->has('tax_percentage'))
                    <span class="text-danger">{{ $errors->first('tax_percentage') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.paymentSetting.fields.tax_percentage_helper') }}</span>
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