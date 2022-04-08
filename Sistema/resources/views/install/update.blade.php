@extends('install.layout.master')
@section('title')
Update
@endsection

@section('update')
    <style>
         .main-col {
            display: none !important;
        }

        .hidden {
            display: none !important;
        }

        .update-messages {
            margin-top: 3rem;
        }

        .update-messages>p {
            margin-bottom: 1.5rem;
        }

        .update-messages>p>i {
            color: #673AB7;
            font-size: 2rem;
            margin-right: 1rem;
        }

        .message-overlay {
            position: absolute;
            height: 17rem;
            width: 100%;
            background-color: #fafafa;
            transform: translateY(0px);
            transition: 0.1s linear all;
        }
    </style>
    <div class="col-lg-4 col-lg-offset-4 mt-5">

        @if(!$extensionSatisfied)
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
                                @if(!$satisfied)
                                    <tr>
                                        <td>
                                            {{ $label }}
                                        </td>
                                        <td class="text-center">
                                            <i class="fa fa-{{ $satisfied ? 'check' : 'times' }}" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if(!$permissionSatisfied)
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
                                @if(!$satisfied)
                                    <tr>
                                        <td>{{ $label }}</td>
                                        <td class="text-center">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($requirement->satisfied())
            <div class="thankyou-box">
                <h2>
                    Atualização disponível {{ $updateVersion }}                 </h2>
                <p>
                    Este é o assistente de atualização.
                </p>

                <form action="{{ url('install/update') }}" method="POST" style="margin-top: 5rem;">
                    <div class="form-group text-left" style="margin-top: 3rem">
                        <label>Senha do Admin</label>
                        <input class="form-control mt-2" name="password" placeholder="Insira a senha do Admin" style="margin-top: 1.5rem" type="password" autocomplete="new-password" required="required"/>
                        {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                    </div>
                    @csrf
                    <button class="btn btn-primary update-button" style="margin-top: 2rem;" type="submit">
                        Atualizar agora
                    </button>
                    
                </form>
                <div class="box error-msg">
                    <div class="text-danger">
                        @if(Session::has('message'))
                        {{ Session::get('message') }}
                        @endif
                    </div>
                </div>

                <div class="warning-msg hidden" style="margin-top: 1.5rem">
                    <p class="text-danger">
                        O processo de atualização pode levar até 30 segundos.
                    </p>
                    <p class="text-danger">
                        <strong>
                            NÃO FAÇA
                        </strong>
                        feche ou recarregue esta janela.
                    </p>
                </div>
            </div>
        @else
        <div class="text-left" style="margin-top: 5rem;">
            <strong>Corrija os problemas acima e recarregue a página para atualizar o app para {{ $updateVersion }}</strong>
        </div>
        @endif

        <div class="update-messages">
            <div class="message-overlay">
            </div>
            <p>
                <i class="fa fa-check-circle">
                </i>
                <span>
                    Migrando novas tabelas ...
                </span>
            </p>
            <p>
                <i class="fa fa-check-circle">
                </i>
                <span>
                    Preenchendo novas configurações ...
                </span>
            </p>
            <p>
                <i class="fa fa-check-circle">
                </i>
                <span>
                    Definindo rotas de API ...
                </span>
            </p>
            <p>
                <i class="fa fa-check-circle">
                </i>
                <span>
                    Limpando arquivos inúteis ...
                </span>
            </p>
            <p>
                <i class="fa fa-check-circle">
                </i>
                <span>
                    Adicionando alguns feijões mágicos ... só um segundo ...
                </span>
            </p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("form").on("submit", function(e) {
               let invalid =  $('input:invalid');
               if (invalid.length == 0) {
                    var button = $('.update-button');
                     button
                         .css("pointer-events", "none")
                         .data("loading-text", button.html())
                         .addClass("btn-loading")
                         .button("loading");

                    $('.error-msg').remove();
                    $('.warning-msg').removeClass("hidden");

                    
                    setTimeout(() => {
                            console.log("Exec timeout")
                            let startTime = Date.now();
                            let count = 30;
                            let buffer = 0
                            var msgShowInterval = setInterval(() => {
                                if (Date.now() - startTime > 8000) { // run only for 8 seconds 
                                    clearInterval(msgShowInterval);
                                     return;
                                 }
                                console.log("Exec interval")
                                $('.message-overlay').css({
                                    'transform':'translateY('+count+'px)',
                                    'transition':'0.1s linear all'
                                });
                                buffer = buffer + 3
                                count = count + 30 + buffer;
                            }, 1500);
                        }, 2000)
                    $(this).attr('disabled', 'disabled');
                }
            });
        });
    </script>
    
@endsection
