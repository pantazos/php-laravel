<div class="m-3">

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.payment.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-payments">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.payment.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.payment.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.payment.fields.payment_method') }}
                            </th>
                            <th>
                                {{ trans('cruds.payment.fields.created_at') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $key => $payment)
                            <tr data-entry-id="{{ $payment->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $payment->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $payment->amount ?? '' }}
                                </td>
                                <td>
                                    {{ $payment->payment_method->name ?? '' }}
                                </td>
                                <td>
                                    {{ $payment->created_at ?? '' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    pageLength: 100,
  });
  let table = $('.datatable-payments:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
