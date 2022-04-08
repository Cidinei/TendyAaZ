@extends('admin.layouts.master')
@section("title") Bem vindo - Dashboard
@endsection
@section('content')
<div class="d-flex mt-5">
<h3>Bem vindo, <span class="text-capitalize">{{ Auth::user()->name }}</span>.</h3>
</div>
@endsection
