@extends('layouts.admin')
@section('content')
@can('promo_code_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.promo-codes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.promoCode.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.promoCode.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-PromoCode">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.promoCode.fields.enabled') }}
                        </th>
                        <th>
                            {{ trans('cruds.promoCode.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.promoCode.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.promoCode.fields.discount') }}
                        </th>
                        <th>
                            {{ trans('cruds.promoCode.fields.expires_at') }}
                        </th>
                        <th>
                            {{ trans('cruds.promoCode.fields.categories') }}
                        </th>
                        <th>
                            {{ trans('cruds.promoCode.fields.services') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promoCodes as $key => $promoCode)
                        <tr data-entry-id="{{ $promoCode->id }}">
                            <td>

                            </td>
                            <td>
                                <span style="display:none">{{ $promoCode->enabled ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $promoCode->enabled ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $promoCode->code ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\PromoCode::TYPE_SELECT[$promoCode->type] ?? '' }}
                            </td>
                            <td>
                                {{ $promoCode->discount ?? '' }}
                            </td>
                            <td>
                                {{ $promoCode->expires_at ?? '' }}
                            </td>
                            <td>
                                @foreach($promoCode->categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($promoCode->services as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('promo_code_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.promo-codes.show', $promoCode->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('promo_code_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.promo-codes.edit', $promoCode->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('promo_code_delete')
                                    <form action="{{ route('admin.promo-codes.destroy', $promoCode->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
@can('promo_code_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.promo-codes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    pageLength: 100,
  });
  let table = $('.datatable-PromoCode:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
