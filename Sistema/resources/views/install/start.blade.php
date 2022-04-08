@extends('install.layout.master')
@section('title')
Instalar
@endsection
@section('thankyou')
<meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>
<style>
body {
            background: #873deb;
        }
    .main-col {
        display: none !important;
        
        
        
        .btn-primary {
    background: #873deb;
    color: #fff;
    border-color: #873deb;
    font-size: 2rem;
    height: 5.5rem;
    width: 100%;
    border-radius: 10px;
}
    }
</style>
<div class="col-lg-4 col-lg-offset-4 mt-5">
    <div class="thankyou-box">
        <h1>Meu App On</h1>
        <h2>Obrigado por sua compra</h2>
        <p>Este é o manual de instação, siga as etapas fornecidas na <a
                href="https://manual.meuappon.com" target="_blank">Documentação</a> se precisar de ajuda.</p>
        <a href="{{ url('install/pre-installation') }}" class="btn btn-primary" style="margin-top: 2rem;">Começar</a>
    </div>
</div>
@endsection