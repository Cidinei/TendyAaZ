@extends('admin.layouts.master')
@section('title')
Foodomaa Utilities
@endsection

@section('content')
<div class="mt-4">
	<h2>Enable/Disable Stores</h2>
	<a href="{{ route('admin.utility.toggleStoreStatus', 'enable') }}" class="btn btn-dark btn-lg">Habilitar todas as lojas</a>
	<br><br>
	<a href="{{ route('admin.utility.toggleStoreStatus', 'disable') }}" class="btn btn-dark btn-lg">Desabilitar todas as lojas</a>
	<hr>
</div>

<footer>
	Em breve, mais utilitários.
</footer>
@endsection