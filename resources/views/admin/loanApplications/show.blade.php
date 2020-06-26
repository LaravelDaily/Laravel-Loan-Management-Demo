@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.loanApplication.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.id') }}
                        </th>
                        <td>
                            {{ $loanApplication->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.loan_amount') }}
                        </th>
                        <td>
                            {{ $loanApplication->loan_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.description') }}
                        </th>
                        <td>
                            {{ $loanApplication->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.status') }}
                        </th>
                        <td>
                            {{ $loanApplication->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.analyst') }}
                        </th>
                        <td>
                            {{ $loanApplication->analyst->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.loanApplication.fields.cfo') }}
                        </th>
                        <td>
                            {{ $loanApplication->cfo->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.loan-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection