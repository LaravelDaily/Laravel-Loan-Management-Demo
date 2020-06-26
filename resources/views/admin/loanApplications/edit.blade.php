@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.loanApplication.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loan-applications.update", [$loanApplication->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="loan_amount">{{ trans('cruds.loanApplication.fields.loan_amount') }}</label>
                <input class="form-control {{ $errors->has('loan_amount') ? 'is-invalid' : '' }}" type="number" name="loan_amount" id="loan_amount" value="{{ old('loan_amount', $loanApplication->loan_amount) }}" step="0.01" required>
                @if($errors->has('loan_amount'))
                    <div class="invalid-feedback">
                        {{ $errors->first('loan_amount') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.loanApplication.fields.loan_amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.loanApplication.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $loanApplication->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.loanApplication.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="analyst_id">{{ trans('cruds.loanApplication.fields.analyst') }}</label>
                <select class="form-control select2 {{ $errors->has('analyst') ? 'is-invalid' : '' }}" name="analyst_id" id="analyst_id">
                    @foreach($analysts as $id => $analyst)
                        <option value="{{ $id }}" {{ ($loanApplication->analyst ? $loanApplication->analyst->id : old('analyst_id')) == $id ? 'selected' : '' }}>{{ $analyst }}</option>
                    @endforeach
                </select>
                @if($errors->has('analyst'))
                    <div class="invalid-feedback">
                        {{ $errors->first('analyst') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.loanApplication.fields.analyst_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cfo_id">{{ trans('cruds.loanApplication.fields.cfo') }}</label>
                <select class="form-control select2 {{ $errors->has('cfo') ? 'is-invalid' : '' }}" name="cfo_id" id="cfo_id">
                    @foreach($cfos as $id => $cfo)
                        <option value="{{ $id }}" {{ ($loanApplication->cfo ? $loanApplication->cfo->id : old('cfo_id')) == $id ? 'selected' : '' }}>{{ $cfo }}</option>
                    @endforeach
                </select>
                @if($errors->has('cfo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cfo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.loanApplication.fields.cfo_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection