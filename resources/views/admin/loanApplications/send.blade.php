@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        Send to {{ $role }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.loan-applications.send", $loanApplication) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ $role }}</label>
                <select class="form-control select2 {{ $errors->has('user_id') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Send
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
