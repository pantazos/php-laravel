@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Booking">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.key') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.provider') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.service') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.booking_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.address_details') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.tax') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.total') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $key => $booking)
                        <tr data-entry-id="{{ $booking->key }}">
                            <td>

                            </td>
                            <td>
                                {{ $booking->key ?? '' }}
                            </td>
                            <td>
                                {{ $booking->customer->name ?? '' }}
                            </td>
                            <td>
                                {{ $booking->provider->name ?? '' }}
                            </td>
                            <td>
                                {{ $booking->service->name ?? '' }}
                            </td>
                            <td>
                                {{ $booking->status->name ?? '' }}
                            </td>
                            <td>
                                {{ $booking->booking_at ?? '' }}
                            </td>
                            <td>
                                {{ $booking->address_details ?? '' }}
                            </td>
                            <td>
                                {{ $booking->tax ?? '' }}
                            </td>
                            <td>
                                {{ $booking->total ?? '' }}
                            </td>
                            <td>
                                @can('booking_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.bookings.show', $booking->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('booking_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.bookings.edit', $booking->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('booking_delete')
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="{{ trans('global.delete') }}">
                                    </form>
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
            @can('booking_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.bookings.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                pageLength: 100,
            });
            let table = $('.datatable-Booking:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
