@extends('install.layout.master') 
@section('title')
Configuração
@endsection
@section('content')
@if (session()->has('error'))
<div class="alert alert-danger fade in alert-dismissable">
    {{ session("error") }}
</div>
@endif
<h2>2. Configuração</h2>
<form method="POST" action="{{ url('install/configuration') }}" class="form-horizontal">
    {{ csrf_field() }}
    <div class="box">
        @if(Session::has('message'))
        <div style="padding: 10px; background-color: #F44336; margin-bottom: 1rem; border-radius: 0.275rem;">
               <p style="color: #fff"> {{ Session::get('message') }} </p>
        </div>
        @endif

        @if($errors->any())
            <div style="padding: 10px; background-color: #F44336; margin-bottom: 1rem; border-radius: 0.275rem;">
                <p style="color: #fff"> {{ implode('', $errors->all(':message')) }} </p>
            </div>
        @endif
    </div>
    <div class="box">
        <p>Insira os detalhes do seu Banco de Dados.</p>
        <div class="configure-form">
            <div class="form-group {{ $errors->has('db.host') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="host">Host <span>*</span></label>
                <div class="col-sm-9">
                    <input type="text" value="{{ old('db.host') }}" name="db[host]" placeholder="Geralmente 127.0.0.1 ou localhost" id="host" class="form-control" autofocus /> {!!
                    $errors->first('db.host', ' <span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('db.port') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="port">Porta <span>*</span></label>
                <div class="col-sm-9">
                    <input type="text" value="{{ old('db.port') }}" name="db[port]" placeholder="Geralmente 3306" id="port" class="form-control" /> {!! $errors->first('db.port',
                    ' <span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('db.database') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="database">Database <span>*</span></label>
                <div class="col-sm-9">
                    <input type="text" value="{{ old('db.database') }}" name="db[database]" placeholder="Nome do Banco de Dados" id="database" class="form-control" autocomplete="off" />
                    {!! $errors->first('db.database', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('db.username') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="db-username">Usuário DB <span>*</span></label
                    >
                <div class="col-sm-9">
                    <input autocomplete="new-user" type="text" value="{{ old('db.username') }}" name="db[username]" placeholder="Usuário do Banco de Dados" id="db-username" class="form-control"autocomplete="off" />
                    {!! $errors->first('db.username', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="db-password">Senha DB</label>
                <div class="col-sm-9">
                    <input autocomplete="new-password" type="text" value="{{ old('db.password') }}" name="db[password]" placeholder="Senha do Banco de Dados" id="db-password" class="form-control" autocomplete="off" />
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <p>Insira as credenciais de Administrador.</p>
        <div class="configure-form">
            <div class="form-group {{ $errors->has('admin.name') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="admin-name">Nome Completo<span>*</span></label
                    >
                <div class="col-sm-9">
                    <input type="text" value="{{ old('admin.name') }}" name="admin[name]" placeholder="Nome do Admin" id="admin-name" class="form-control" />
                    {!! $errors->first('admin.name', ' <span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('admin.email') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="admin-email">Email <span>*</span></label>
                <div class="col-sm-9">
                    <input type="text" value="{{ old('admin.email') }}" name="admin[email]" placeholder="Email do admin" id="admin-email" class="form-control" />                    {!! $errors->first('admin.email', ' <span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('admin.password') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="admin-password">Senha <span>*</span></label
                    >
                <div class="col-sm-9">
                    <input type="password" value="{{ old('admin.password') }}" name="admin[password]" placeholder="Senha segura do admin" id="admin-password" class="form-control"/>
                    {!! $errors->first('admin.password', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box">
        <p>Detalhes da Plataforma.</p>
        <div class="configure-form p-b-5">
            <div class="form-group {{ $errors->has('store.storeName') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="store-name">Nome do App <span>*</span></label>
                <div class="col-sm-9">
                    <input type="text" value="{{ old('store.storeName') }}" name="store[storeName]" placeholder="Nome da sua Plataforma" id="store-name" class="form-control" />                    {!! $errors->first('store.storeName', ' <span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('store.storeEmail') ? 'has-error': '' }}">
                <label class="control-label col-sm-3" for="store-email">Email do App <span>*</span></label>
                <div class="col-sm-9">
                    <input type="text" value="{{ old('store.storeEmail') }}" name="store[storeEmail]" placeholder="Email da Plataforma" id="store-email" class="form-control" />                    {!! $errors->first('store.storeEmail', '
                    <span class="help-block">:message</span>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="content-buttons clearfix">
        <button type="submit" class="btn btn-primary pull-right install-button">Instalar</button>
    </div>
</form>
<script>
    $(document).ready(function() {
        $(".install-button").on("click", function(e) {
        var button = $(e.currentTarget);
         button
             .css("pointer-events", "none")
             .data("loading-text", button.html())
             .addClass("btn-loading")
             .button("loading");
        });
        $(this).attr('disabled', 'disabled');
    });
</script>
@endsection