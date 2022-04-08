@extends("admin.layouts.master")
@section("title")
Cadastro de Entregador
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
    /* Edite apenas o backgroud */
 background: linear-gradient(180deg, rgba(135,61,235,1) 49%, rgba(255,255,255,1) 49%);
}

/* Botão Cadastrar */

.btn-primary {
    color: #ffffff;
    background: linear-gradient(to left, #6e00e6, #873deb);
    border-radius: 25px;
}

/* Botão Logar como dono de loja */

.btn-registerBtn {
    background: linear-gradient(to left, #873deb, #873deb);
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
    padding: 3.0rem;
}
.text-muted {
    color: #000000!important;
}
a {
    color: #000000;
    text-decoration: none;
    background-color: transparent;
}
.border-slate-300 {
    border-color: #3e4042;
    background-color: #3e4042;
}
.text-slate-300 {
    color: #ffffff;
}
</style>
 <form class="registration-form py-5 @if(Session::has('delivery_register_message')) hidden @endif" action="{{ route('registerRestaurantDelivery') }}" method="POST" id="regForm" style="margin: 0 auto 20px auto;">
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <span id="regIcon">
                     <i class='icon-truck icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1'></i>
                </span>
                <h5 class="mb-0">Cadastro para Parceiro de Entrega</h5>
                <span class="d-block text-muted">Por favor, preencha o formulário para se registrar</span>
            </div>
            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="text" class="form-control" placeholder="Nome Completo" name="name" required="required" value="{{ old('name') }}">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                {!! $errors->first('name', '<p class="text-danger small">:message</p>') !!}
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="email" class="form-control" placeholder="Email" name="email" required="required" value="{{ old('email') }}">
                <div class="form-control-feedback">
                    <i class="icon-mail5 text-muted"></i>
                </div>
                {!! $errors->first('email', '<p class="text-danger small">:message</p>') !!}
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="number" class="form-control" placeholder="Número de Telefone" name="phone" min="8" required="required" value="{{ old('phone') }}">
                <div class="form-control-feedback">
                    <i class="icon-mobile text-muted"></i>
                </div>
                {!! $errors->first('phone', '<p class="text-danger small">:message</p>') !!}
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="password" class="form-control" placeholder="Senha" name="password" required="required">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                {!! $errors->first('password', '<p class="text-danger small">:message</p>') !!}
            </div>
            <div class="captcha-code mb-2">
            	{!! captcha_img('flat') !!}
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
            <input type="text" class="form-control" placeholder="Digite o Captcha" name="captcha" required="required">
                <div class="form-control-feedback">
                    <i class="icon-font-size text-muted"></i>
                </div>
                {!! $errors->first('captcha', '<p class="text-danger small">:message</p>') !!}
            </div>
            <input type="hidden" name="role" id="roleValue" value="DELIVERY">
            @csrf
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" style="height: 2.8rem; font-size: 1rem;">Cadastrar <i
                    class="icon-circle-right2 ml-2"></i></button>
            </div>
        </div>
    </div>
</form>


@if(Session::has('delivery_register_message'))
<div class="d-flex justify-content-center align-items-center" style="margin-top: 8rem;">
     <div class="delivery-msg p-3 text-center">
     	<b>Cadastro feito com sucesso!</b><br>
     	Agora você pode fazer login no aplicativo de entrega usando seu telefone.
     	<br>
     	Acesse: <a href="https://{{ request()->getHttpHost() }}/delivery"><b>{{ request()->getHttpHost() }}/delivery</b></a> no seu celular. 
 	</div>
</div>
@endif



@endsection