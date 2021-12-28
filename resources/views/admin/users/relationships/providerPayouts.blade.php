<div class="m-3">
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.payout.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-providerPayouts">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.payout.fields.provider') }}
                            </th>
                            <th>
                                {{ trans('cruds.payout.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.payout.fields.method') }}
                            </th>
                            <th>
                                {{ trans('cruds.payout.fields.paid_at') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payouts as $key => $payout)
                            <tr data-entry-id="{{ $payout->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $payout->provider->name ?? '' }}
                                </td>
                                <td>
                                    {{ $payout->amount ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\Payout::METHOD_SELECT[$payout->method] ?? '' }}
                                </td>
                                <td>
                                    {{ $payout->paid_at ?? '' }}
                                </td>
                                <td>



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
  let table = $('.datatable-providerPayouts:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
