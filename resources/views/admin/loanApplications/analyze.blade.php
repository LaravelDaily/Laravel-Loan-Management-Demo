@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Analysis
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.loan-applications.analyze", $loanApplication) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="description">{{ trans('cruds.comment.title_singular') }}</label>
                    <textarea class="form-control {{ $errors->has('comment_text') ? 'is-invalid' : '' }}" name="comment_text" id="comment_text">{{ old('comment_text') }}</textarea>
                    @if($errors->has('comment_text'))
                        <div class="invalid-feedback">
                            {{ $errors->first('comment_text') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-success" name="approve" type="submit">
                        Approve
                    </button>
                    <button class="btn btn-danger" name="reject" type="submit">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
