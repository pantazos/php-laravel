@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.promoCode.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.promo-codes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div class="form-check {{ $errors->has('enabled') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="checkbox" name="enabled" id="enabled" value="1" required {{ old('enabled', 0) == 1 || old('enabled') === null ? 'checked' : '' }}>
                    <label class="required form-check-label" for="enabled">{{ trans('cruds.promoCode.fields.enabled') }}</label>
                </div>
                @if($errors->has('enabled'))
                    <span class="text-danger">{{ $errors->first('enabled') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.promoCode.fields.enabled_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.promoCode.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.promoCode.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.promoCode.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\PromoCode::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', 'fixed') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.promoCode.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="discount">{{ trans('cruds.promoCode.fields.discount') }}</label>
                <input class="form-control {{ $errors->has('discount') ? 'is-invalid' : '' }}" type="number" name="discount" id="discount" value="{{ old('discount', '') }}" step="0.01" required>
                @if($errors->has('discount'))
                    <span class="text-danger">{{ $errors->first('discount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.promoCode.fields.discount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="expires_at">{{ trans('cruds.promoCode.fields.expires_at') }}</label>
                <input class="form-control datetime {{ $errors->has('expires_at') ? 'is-invalid' : '' }}" type="text" name="expires_at" id="expires_at" value="{{ old('expires_at') }}">
                @if($errors->has('expires_at'))
                    <span class="text-danger">{{ $errors->first('expires_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.promoCode.fields.expires_at_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="categories">{{ trans('cruds.promoCode.fields.categories') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                    @foreach($categories as $id => $category)
                        <option value="{{ $id }}" {{ in_array($id, old('categories', [])) ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <span class="text-danger">{{ $errors->first('categories') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.promoCode.fields.categories_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="services">{{ trans('cruds.promoCode.fields.services') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('services') ? 'is-invalid' : '' }}" name="services[]" id="services" multiple>
                    @foreach($services as $id => $service)
                        <option value="{{ $id }}" {{ in_array($id, old('services', [])) ? 'selected' : '' }}>{{ $service }}</option>
                    @endforeach
                </select>
                @if($errors->has('services'))
                    <span class="text-danger">{{ $errors->first('services') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.promoCode.fields.services_helper') }}</span>
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