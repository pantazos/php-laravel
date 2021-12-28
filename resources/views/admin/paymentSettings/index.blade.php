@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.paymentSetting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PaymentSetting">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.paymentSetting.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSetting.fields.currency') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSetting.fields.tax_enabled') }}
                        </th>
                        <th>
                            {{ trans('cruds.paymentSetting.fields.tax_percentage') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentSettings as $key => $paymentSetting)
                        <tr data-entry-id="{{ $paymentSetting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $paymentSetting->id ?? '' }}
                            </td>
                            <td>
                                {{ $paymentSetting->currency->name ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $paymentSetting->tax_enabled ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $paymentSetting->tax_enabled ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $paymentSetting->tax_percentage ?? '' }}
                            </td>
                            <td>

                                @can('payment_setting_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.payment-settings.edit', $paymentSetting->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan


                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-PaymentSetting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection