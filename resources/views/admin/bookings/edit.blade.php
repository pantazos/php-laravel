@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.update", [$booking->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.booking.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $booking->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="provider_id">{{ trans('cruds.booking.fields.provider') }}</label>
                <select class="form-control select2 {{ $errors->has('provider') ? 'is-invalid' : '' }}" name="provider_id" id="provider_id">
                    @foreach($providers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('provider_id') ? old('provider_id') : $booking->provider->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('provider'))
                    <span class="text-danger">{{ $errors->first('provider') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.provider_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="service_id">{{ trans('cruds.booking.fields.service') }}</label>
                <select class="form-control select2 {{ $errors->has('service') ? 'is-invalid' : '' }}" name="service_id" id="service_id" required>
                    @foreach($services as $id => $entry)
                        <option value="{{ $id }}" {{ (old('service_id') ? old('service_id') : $booking->service->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('service'))
                    <span class="text-danger">{{ $errors->first('service') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.service_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="extras">{{ trans('cruds.booking.fields.extras') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('extras') ? 'is-invalid' : '' }}" name="extras[]" id="extras" multiple>
                    @foreach($extras as $id => $extra)
                        <option value="{{ $id }}" {{ (in_array($id, old('extras', [])) || $booking->extras->contains($id)) ? 'selected' : '' }}>{{ $extra }}</option>
                    @endforeach
                </select>
                @if($errors->has('extras'))
                    <span class="text-danger">{{ $errors->first('extras') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.extras_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status_id">{{ trans('cruds.booking.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $booking->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="promo_code_id">{{ trans('cruds.booking.fields.promo_code') }}</label>
                <select class="form-control select2 {{ $errors->has('promo_code') ? 'is-invalid' : '' }}" name="promo_code_id" id="promo_code_id">
                    @foreach($promo_codes as $id => $entry)
                        <option value="{{ $id }}" {{ (old('promo_code_id') ? old('promo_code_id') : $booking->promo_code->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('promo_code'))
                    <span class="text-danger">{{ $errors->first('promo_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.promo_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="booking_at">{{ trans('cruds.booking.fields.booking_at') }}</label>
                <input class="form-control datetime {{ $errors->has('booking_at') ? 'is-invalid' : '' }}" type="text" name="booking_at" id="booking_at" value="{{ old('booking_at', $booking->booking_at) }}" required>
                @if($errors->has('booking_at'))
                    <span class="text-danger">{{ $errors->first('booking_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.booking_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.booking.fields.notes') }}</label>
                <input class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" type="text" name="notes" id="notes" value="{{ old('notes', $booking->notes) }}">
                @if($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="latitude">{{ trans('cruds.booking.fields.latitude') }}</label>
                <input class="form-control {{ $errors->has('latitude') ? 'is-invalid' : '' }}" type="text" name="latitude" id="latitude" value="{{ old('latitude', $booking->latitude) }}" required>
                @if($errors->has('latitude'))
                    <span class="text-danger">{{ $errors->first('latitude') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.latitude_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="longitude">{{ trans('cruds.booking.fields.longitude') }}</label>
                <input class="form-control {{ $errors->has('longitude') ? 'is-invalid' : '' }}" type="text" name="longitude" id="longitude" value="{{ old('longitude', $booking->longitude) }}" required>
                @if($errors->has('longitude'))
                    <span class="text-danger">{{ $errors->first('longitude') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.longitude_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address_name">{{ trans('cruds.booking.fields.address_name') }}</label>
                <input class="form-control {{ $errors->has('address_name') ? 'is-invalid' : '' }}" type="text" name="address_name" id="address_name" value="{{ old('address_name', $booking->address_name) }}" required>
                @if($errors->has('address_name'))
                    <span class="text-danger">{{ $errors->first('address_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.address_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address_details">{{ trans('cruds.booking.fields.address_details') }}</label>
                <input class="form-control {{ $errors->has('address_details') ? 'is-invalid' : '' }}" type="text" name="address_details" id="address_details" value="{{ old('address_details', $booking->address_details) }}" required>
                @if($errors->has('address_details'))
                    <span class="text-danger">{{ $errors->first('address_details') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.address_details_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="parts_cost">{{ trans('cruds.booking.fields.parts_cost') }}</label>
                <input class="form-control {{ $errors->has('parts_cost') ? 'is-invalid' : '' }}" type="number" name="parts_cost" id="parts_cost" value="{{ old('parts_cost', $booking->parts_cost) }}" step="0.01">
                @if($errors->has('parts_cost'))
                    <span class="text-danger">{{ $errors->first('parts_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.parts_cost_helper') }}</span>
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
