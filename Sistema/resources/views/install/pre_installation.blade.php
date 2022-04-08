@extends('install.layout.master') 
@section('title')
Pré-Instalação
@endsection
@section('content')
<style>
    .text-danger {
        color: #f44336;
    }
    
    .btn-primary {
    background: #873deb;
    color: #fff;
    border-color: #673ab7;
    font-size: 2rem;
    height: 5.5rem;
    width: 100%;
}
</style>
<h2>1. Pré-Instalação </h2>

<div class="box">
    <p>Certifique-se de que as extensões PHP listadas abaixo estão instaladas.</p>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 100%;">Extensões</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($requirement->extensions() as $label => $satisfied)
                <tr>
                    <td>
                        {{ $label }}
                        @if($label == "PHP = 7.2.x" && !$satisfied)
                            <br>
                            <span class="text-danger"><b>A versão do PHP deve ser 7.2 (or 7.2.x)
                            <br>
                            <a href="https://manual.meuappon.com" target="_blank"> Saiba mais </a></span>
                        @endif
                    </td>
                    <td class="text-center">
                        <i class="fa fa-{{ $satisfied ? 'check' : 'times' }}" aria-hidden="true"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="box">
    <p>Certifique-se de definir as permissões corretas para os diretórios listados abaixo. Todos esses diretórios / arquivos devem ser graváveis.</p>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 100%;">Diretórios</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($requirement->directories() as $label => $satisfied)
                <tr>
                    <td>{{ $label }}</td>
                    <td class="text-center">
                        <i class="fa fa-{{ $satisfied ? 'check' : 'times' }}" aria-hidden="true"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="content-buttons clearfix">
    <a href="{{ $requirement->satisfied() ? url('install/configuration') : '#' }}" class="btn btn-primary pull-right" {{ $requirement->satisfied() ? '' : 'disabled' }}>
            Continuar
        </a>
</div>
@endsection