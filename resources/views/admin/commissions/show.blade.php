@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.commission.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.commissions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.commission.fields.id') }}
                        </th>
                        <td>
                            {{ $commission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commission.fields.key') }}
                        </th>
                        <td>
                            {{ $commission->key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commission.fields.name') }}
                        </th>
                        <td>
                            {{ $commission->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commission.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Commission::TYPE_SELECT[$commission->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commission.fields.value') }}
                        </th>
                        <td>
                            {{ $commission->value }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.commissions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection