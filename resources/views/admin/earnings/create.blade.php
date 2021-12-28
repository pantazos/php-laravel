@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.earning.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.earnings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="provider_id">{{ trans('cruds.earning.fields.provider') }}</label>
                <select class="form-control select2 {{ $errors->has('provider') ? 'is-invalid' : '' }}" name="provider_id" id="provider_id" required>
                    @foreach($providers as $id => $entry)
                        <option value="{{ $id }}" {{ old('provider_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('provider'))
                    <span class="text-danger">{{ $errors->first('provider') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.earning.fields.provider_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="bookings_count">{{ trans('cruds.earning.fields.bookings_count') }}</label>
                <input class="form-control {{ $errors->has('bookings_count') ? 'is-invalid' : '' }}" type="number" name="bookings_count" id="bookings_count" value="{{ old('bookings_count', '0') }}" step="1" required>
                @if($errors->has('bookings_count'))
                    <span class="text-danger">{{ $errors->first('bookings_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.earning.fields.bookings_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="total_earning">{{ trans('cruds.earning.fields.total_earning') }}</label>
                <input class="form-control {{ $errors->has('total_earning') ? 'is-invalid' : '' }}" type="number" name="total_earning" id="total_earning" value="{{ old('total_earning', '0') }}" step="0.01" required>
                @if($errors->has('total_earning'))
                    <span class="text-danger">{{ $errors->first('total_earning') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.earning.fields.total_earning_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="admin_earning">{{ trans('cruds.earning.fields.admin_earning') }}</label>
                <input class="form-control {{ $errors->has('admin_earning') ? 'is-invalid' : '' }}" type="number" name="admin_earning" id="admin_earning" value="{{ old('admin_earning', '0') }}" step="0.01" required>
                @if($errors->has('admin_earning'))
                    <span class="text-danger">{{ $errors->first('admin_earning') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.earning.fields.admin_earning_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="provider_earning">{{ trans('cruds.earning.fields.provider_earning') }}</label>
                <input class="form-control {{ $errors->has('provider_earning') ? 'is-invalid' : '' }}" type="number" name="provider_earning" id="provider_earning" value="{{ old('provider_earning', '0') }}" step="0.01" required>
                @if($errors->has('provider_earning'))
                    <span class="text-danger">{{ $errors->first('provider_earning') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.earning.fields.provider_earning_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="total_tax">{{ trans('cruds.earning.fields.total_tax') }}</label>
                <input class="form-control {{ $errors->has('total_tax') ? 'is-invalid' : '' }}" type="number" name="total_tax" id="total_tax" value="{{ old('total_tax', '0') }}" step="0.01" required>
                @if($errors->has('total_tax'))
                    <span class="text-danger">{{ $errors->first('total_tax') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.earning.fields.total_tax_helper') }}</span>
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