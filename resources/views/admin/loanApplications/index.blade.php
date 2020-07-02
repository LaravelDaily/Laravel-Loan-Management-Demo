@extends('layouts.admin')
@section('content')
@can('loan_application_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.loan-applications.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.loanApplication.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.loanApplication.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LoanApplication">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.loan_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.loanApplication.fields.status') }}
                        </th>
                        @if($user->is_admin)
                            <th>
                                {{ trans('cruds.loanApplication.fields.analyst') }}
                            </th>
                            <th>
                                {{ trans('cruds.loanApplication.fields.cfo') }}
                            </th>
                        @endif
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loanApplications as $key => $loanApplication)
                        <tr data-entry-id="{{ $loanApplication->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $loanApplication->id ?? '' }}
                            </td>
                            <td>
                                {{ $loanApplication->loan_amount ?? '' }}
                            </td>
                            <td>
                                {{ $loanApplication->description ?? '' }}
                            </td>
                            <td>
                                {{ $user->is_user && $loanApplication->status_id < 8 ? $defaultStatus->name : $loanApplication->status->name }}
                            </td>
                            @if($user->is_admin)
                                <td>
                                    {{ $loanApplication->analyst->name ?? '' }}
                                </td>
                                <td>
                                    {{ $loanApplication->cfo->name ?? '' }}
                                </td>
                            @endif
                            <td>
                                @if($user->is_admin && in_array($loanApplication->status_id, [1, 3, 4]))
                                    <a class="btn btn-xs btn-success" href="{{ route('admin.loan-applications.showSend', $loanApplication->id) }}">
                                        Send to
                                        @if($loanApplication->status_id == 1)
                                            analyst
                                        @else
                                            CFO
                                        @endif
                                    </a>
                                @elseif(($user->is_analyst && $loanApplication->status_id == 2) || ($user->is_cfo && $loanApplication->status_id == 5))
                                    <a class="btn btn-xs btn-success" href="{{ route('admin.loan-applications.showAnalyze', $loanApplication->id) }}">
                                        Submit analysis
                                    </a>
                                @endif

                                @can('loan_application_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.loan-applications.show', $loanApplication->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @if(Gate::allows('loan_application_edit') && in_array($loanApplication->status_id, [6,7]))
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.loan-applications.edit', $loanApplication->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endif

                                @can('loan_application_delete')
                                    <form action="{{ route('admin.loan-applications.destroy', $loanApplication->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('loan_application_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.loan-applications.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-LoanApplication:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
