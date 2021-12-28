@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.earning.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.earnings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.earning.fields.id') }}
                        </th>
                        <td>
                            {{ $earning->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.earning.fields.provider') }}
                        </th>
                        <td>
                            {{ $earning->provider->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.earning.fields.bookings_count') }}
                        </th>
                        <td>
                            {{ $earning->bookings_count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.earning.fields.total_earning') }}
                        </th>
                        <td>
                            {{ $earning->total_earning }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.earning.fields.admin_earning') }}
                        </th>
                        <td>
                            {{ $earning->admin_earning }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.earning.fields.provider_earning') }}
                        </th>
                        <td>
                            {{ $earning->provider_earning }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.earning.fields.total_tax') }}
                        </th>
                        <td>
                            {{ $earning->total_tax }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.earnings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection