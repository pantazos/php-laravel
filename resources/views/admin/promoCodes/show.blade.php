@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.promoCode.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.promo-codes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.id') }}
                        </th>
                        <td>
                            {{ $promoCode->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.enabled') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $promoCode->enabled ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.code') }}
                        </th>
                        <td>
                            {{ $promoCode->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\PromoCode::TYPE_SELECT[$promoCode->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.discount') }}
                        </th>
                        <td>
                            {{ $promoCode->discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.expires_at') }}
                        </th>
                        <td>
                            {{ $promoCode->expires_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.categories') }}
                        </th>
                        <td>
                            @foreach($promoCode->categories as $key => $categories)
                                <span class="label label-info">{{ $categories->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.promoCode.fields.services') }}
                        </th>
                        <td>
                            @foreach($promoCode->services as $key => $services)
                                <span class="label label-info">{{ $services->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.promo-codes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection