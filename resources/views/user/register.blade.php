@extends('app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if($errors->any())
        @foreach($errors->all() as $err)
        <p class="alert alert-danger">{{ $err }}</p>
        @endforeach
        @endif
        <form action="{{ route('register.action') }}" method="POST" class="my-5">
            @csrf
            <div class="mb-3">
                <label for="name">Name <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="name" value="{{ old('name') }}" id="name" />
            </div>
            <div class="mb-3">
                <label for="username">Username <span class="text-danger">*</span></label>
                <input class="form-control" type="username" name="username" value="{{ old('username') }}" id="username" />
            </div>
            <div class="mb-3">
                <label for="password">Password <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="password" id="password" />
            </div>
            <div class="mb-3">
                <label for="password_confirm">Password Confirmation<span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="password_confirm" id="password_confirm" />
            </div>
            <div class="mb-3">
                <label for="role">Role <span class="text-danger">*</span></label>
                <select class="form-control" name="role" id="role">
                    <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>Admin</option>
                    <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Operator</option>
                </select>
            </div>


            <div class="mb-3 text-center">
                <button class="btn btn-primary">Register</button>
                <a class="btn btn-danger" href="{{ route('home') }}">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection
