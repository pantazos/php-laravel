@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.serviceExtra.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.service-extras.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceExtra.fields.id') }}
                        </th>
                        <td>
                            {{ $serviceExtra->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceExtra.fields.name') }}
                        </th>
                        <td>
                            {{ $serviceExtra->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceExtra.fields.price') }}
                        </th>
                        <td>
                            {{ $serviceExtra->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceExtra.fields.description') }}
                        </th>
                        <td>
                            {{ $serviceExtra->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.serviceExtra.fields.service') }}
                        </th>
                        <td>
                            {{ $serviceExtra->service->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.service-extras.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection