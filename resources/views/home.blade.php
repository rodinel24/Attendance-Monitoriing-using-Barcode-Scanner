@extends('app')
@section('content')
@auth

<p>Welcome <b>{{ strtoupper(Auth::user()->name) }}</b></p>

@if(Auth::user()->role == 0)
    <a class="btn btn-primary" href="{{route ('student.index')}}">Student List</a>
@endif
<a class="btn btn-primary" href="{{route ('scan.form')}}">Student Scan</a>

</b></p>
<a class="btn btn-primary" href="{{ route('password') }}">Change Password</a>
<a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
@endauth
@guest
<a class="btn btn-primary" href="{{ route('login') }}">Login</a>

    <a class="btn btn-info" href="{{ route('register') }}">Register</a>



@endguest
@endsection