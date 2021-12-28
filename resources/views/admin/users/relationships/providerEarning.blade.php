<div class="m-3">

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.earning.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-providerEarning">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.earning.fields.provider') }}
                        </th>
                        <th>
                            {{ trans('cruds.earning.fields.bookings_count') }}
                        </th>
                        <th>
                            {{ trans('cruds.earning.fields.total_earning') }}
                        </th>
                        <th>
                            {{ trans('cruds.earning.fields.admin_earning') }}
                        </th>
                        <th>
                            {{ trans('cruds.earning.fields.provider_earning') }}
                        </th>
                        <th>
                            {{ trans('cruds.earning.fields.total_tax') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($earning))
                        <tr data-entry-id="{{ $earning->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $earning->provider->name ?? '' }}
                            </td>
                            <td>
                                {{ $earning->bookings_count ?? '' }}
                            </td>
                            <td>
                                {{ $earning->total_earning ?? '' }}
                            </td>
                            <td>
                                {{ $earning->admin_earning ?? '' }}
                            </td>
                            <td>
                                {{ $earning->provider_earning ?? '' }}
                            </td>
                            <td>
                                {{ $earning->total_tax ?? '' }}
                            </td>
                            <td>
                                @can('payout_create')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.payouts.create', $earning->provider) }}">
                                        {{ trans('cruds.payout.title_singular') }} {{ trans('cruds.payout.fields.provider') }}
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endif
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
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-providerEarning:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
