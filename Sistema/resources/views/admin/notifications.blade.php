@extends('admin.layouts.master')
@section("title") Enviar Notificações - Dashboard
@endsection
@section('content')
<style>
    .dropzone {
    border: 2px dotted #EEEEEE !important;
    }
</style>
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">TOTAL</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-1">{{ count($users) }} usuários</span>
                <i class="icon-question3" data-popup="tooltip" title="Estes são o total de usuários registrados em seus sites que podem receber apenas mensagens de Alertas." data-placement="top"></i>
                <br>
                <span class="font-weight-bold mr-2">TOTAL</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-1">{{ $subscriberCount }} Inscritos</span>
                <i class="icon-question3" data-popup="tooltip" title="Estes são o total de usuários inscritos em notificações por push registrados em seus sites que podem receber apenas mensagens de Alertas e Notificações por Push." data-placement="top"></i>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-muted mb-3"><strong>Enviar notificações a todos os usuários</strong></h3>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">imagem: </label>
                        <div class="col-lg-9">
                            <img class="slider-preview-image hidden"/>
                            <div class="uploader">
                                <form method="POST" action="{{ route('admin.uploadNotificationImage') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrfToken">
                                </form>
                                <span class="help-text text-muted">Dimensão da imagem: 1600x1100px</span>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.sendNotifiaction') }}" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Título:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="data[title]"
                                    placeholder="Título da notificação" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Mensagem:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="data[message]"
                                    placeholder="Mensagem" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">URL:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="data[click_action]"
                                    placeholder="Este link será aberto quando a notificação for clicada">
                            </div>
                        </div>
                        <input type="hidden" name="data[badge]" value="/assets/img/favicons/favicon-96x96.png">
                        <input type="hidden" name="data[icon]" value="/assets/img/favicons/favicon-512x512.png">
                        <input type="hidden" name="data[image]" value="" class="notificationImage">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left">
                            <b><i class="icon-paperplane"></i></b>
                            Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($countJunkData > 0)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-muted mb-3"><strong>Contagem de dados de lixo <strong class="text-warning">{{ $countJunkData }}</strong></strong></h3>
                    
                    <p class="text-muted mb-3">As alterações com mais de 7 dias não são mostradas aos usuários e, portanto, são inúteis. Clicar no botão abaixo apenas excluirá<b>{{ $countJunkData }} Dados de alertas</b> que têm mais de 7 dias.</p>

                    <button class="btn btn-danger btn-md float-right" onclick="confirmDelete()">Deletar lixo</button>
                </div>
            </div>
        </div>
        @endif

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3 class="text-muted mb-3"><strong>Enviar notificações a usuários selecionados</strong></h3>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Imagem: </label>
                        <div class="col-lg-9">
                            <img class="slider-preview-image hidden"/>
                            <div class="uploader">
                                <form method="POST" action="{{ route('admin.uploadNotificationImage') }}" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="csrfToken">
                                </form>
                                <span class="help-text text-muted">Dimensão da imagem: 1600x1100px</span>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.sendNotificationToSelectedUsers') }}" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Selecionar usuários:</label>
                            <div class="col-lg-9">
                                <select multiple="multiple" class="form-control select" data-fouc name="users[]" required="required">
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" class="text-capitalize">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Título:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="data[title]"
                                    placeholder="Título da notificação" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Mensagem:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="data[message]"
                                    placeholder="Mensagem" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">URL:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="data[click_action]"
                                    placeholder="Este link será aberto quando a notificação for clicada">
                            </div>
                        </div>
                        <input type="hidden" name="data[badge]" value="/assets/img/favicons/favicon-96x96.png">
                        <input type="hidden" name="data[icon]" value="/assets/img/favicons/favicon-512x512.png">
                        <input type="hidden" name="data[image]" value="" class="notificationImage">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left">
                            <b><i class="icon-paperplane"></i></b>
                            Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function readURL(input) {
       if (input.files && input.files[0]) {
           let reader = new FileReader();
           reader.onload = function (e) {
               $('.slider-preview-image')
                   .removeClass('hidden')
                   .attr('src', e.target.result)
                   .width(300)
           };
           reader.readAsDataURL(input.files[0]);
       }
    }
    

    $(function() {
       $('.form-control-uniform').uniform();

       $('.select').select2({
           minimumResultsForSearch: Infinity,
           placeholder: 'Select Users',
       });

    });

    @if($subscriberCount == 0)
        $.jGrowl("Não há assinantes para enviar notificações push.", {
            position: 'bottom-center',
            header: 'Wooopsss ⚠️',
            theme: 'bg-warning',
            life: '5000'
        }); 
    @endif
</script>
<script type="text/javascript">
    Dropzone.options.dropzone =
     {
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
           return time+file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 50000,
        removedfile: function(file) 
        {
           $('.notificationImage').attr('value', "");
            var fileRef;
            return (fileRef = file.previewElement) != null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function(file, response) 
        {
            console.log(response.success);
            $('.notificationImage').attr('value', '/assets/img/various/' +response.success);
        },
        error: function(file, response)
        {
           return false;
        }
    };

    function confirmDelete()
    {
          var r = confirm("Tem certeza? Esta ação é irreversível!");
          if (r == true) {
            let url = "{{ url('admin/delete-alerts-junk') }}";
            window.location.href = url;
          }
    }
</script>
@endsection