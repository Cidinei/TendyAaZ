@extends("admin.layouts.master")
@section("title")
Entrar
@endsection
@section("content")
<style>
/* Editar */
        
    /* Fundo */    
    body {
    margin: 0;
    font-family: Roboto,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: .9rem;
    font-weight: 400;
    line-height: 1.5385;
    color: #ffffff;
    text-align: left;
    background: linear-gradient(
180deg
, #221F20 49%, rgba(255,255,255,1) 49%);
}

/* Botão Entrar */

.btn-primary {
    color: #ffffff;
    background: #F37422;
    border-radius: 25px;
}

/* Botão Cadastrar */

.btn-registerBtn {
    background: #F37422;
    color: #ffffff;
    border-radius: 25px;
    box-shadow: 0 1px 6px 1px rgb(0 0 0 / 5%);
    transition: 0.2s linear all !important;
}

/* Fim */

.form-control {
    display: block;
    width: 100%;
    height: calc(1.5385em + .875rem + 2px);
    padding: .4375rem .875rem;
    font-size: .8125rem;
    font-weight: 400;
    line-height: 1.5385;
    color: #000000;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #ffffff;
    border-radius: 25px;
    box-shadow: 0 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.card .content-divider>span, .tab-content-bordered .content-divider>span {
    background-color: #e8e8e8;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #e8e8e8;
    color: #000000;
    background-clip: border-box;
    border: 0px solid rgba(0,0,0,.125);
    border-radius: 25px;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.text-muted {
    color: #000000!important;
}
a {
    color: #000000;
    text-decoration: none;
    background-color: transparent;
}
</style>

    <form class="registration-form py-5" action="{{ route('post.login') }}" method="POST" id="loginForm" style="margin: 0 auto 20px auto;">
        <div class="card mb-0">
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="{{ substr(url('/'), 0, strrpos(url('/'), '/')) }}/assets/img/logos/{{ config('appSettings.storeLogo') }}" alt="logo" class="img-fluid mb-3 mt-2" style="width: 135px;">
                    <h5 class="mb-0">Faça login no painel</h5>
                    <span class="d-block text-muted">Insira suas credenciais abaixo</span>
                </div>
                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="email" class="form-control" placeholder="E-mail" name="email" value="{{ old('email') }}">
                    <div class="form-control-feedback">
                        <i class="icon-user text-muted"></i>
                    </div>
                </div>
                <div class="form-group form-group-feedback form-group-feedback-left">
                    <input type="password" class="form-control" placeholder="Senha" name="password">
                    <div class="form-control-feedback">
                        <i class="icon-lock2 text-muted"></i>
                    </div>
                </div>
                <div class="form-group form-group-feedback form-group-feedback-left">
                    <label class="d-flex align-items-center">
                        <input type="checkbox" checked="checked" name="remember" class="mr-1" style="height: 1rem; width: 1rem">
                        <span>Lembrar?</span>
                    </label>
                </div>
                @csrf
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block" style="height: 2.8rem; font-size: 1rem;">Entrar <i
                        class="icon-circle-right2 ml-2"></i></button>
                </div>


                @if(config('appSettings.enPassResetEmail') == 'true')
                <div class="mb-2">
                    <a href="{{ route('forgotPassword') }}">Esqueceu a senha?</a>
                </div>
                @endif

                <div class="content-divider text-muted form-group"><span> OU </span></div>
                <div class="content d-flex justify-content-center align-items-center mt-3">
                    <a class="btn btn-lg btn-registerBtn mr-2" href="{{ route('storeRegistration') }}">Cadastrar Estabelecimento</a>
                    <a class="btn btn-lg btn-registerBtn" href="{{ route('deliveryRegistration') }}">Cadastro Entregador</a>
                </div>
            </div>
        </div>
    </form>
@endsection