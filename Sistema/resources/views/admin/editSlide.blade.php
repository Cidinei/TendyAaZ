@extends('admin.layouts.master')
@section("title") Editar Slide - Dashboard
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Editando slide <a href="{{ route('admin.get.editSlider', $slide->promo_slider->id) }}">{{ $slide->promo_slider->name }}</a></span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-image2 mr-2"></i> Detalhes do slide
                </legend>
                <form action="{{ route('admin.updateSlide') }}" method="POST" id="slideForm" class="mt-3" enctype="multipart/form-data">
                    <input type="hidden" class="form-control form-control-lg" name="id" value="{{ $slide->id }}" required>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Nome:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="name" placeholder="Nome do slide" required value="{{ $slide->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Imagem:</label>
                        <div class="col-lg-9">
                            <img src="{{ substr(url("/"), 0, strrpos(url("/"), '/')) }}{{ $slide->image }}" alt="Image"
                            width="160" style="border-radius: 0.275rem;">
                            <img class="slider-preview-image hidden"/>
                            <div class="uploader mt-1">
                                <input type="file" class="form-control-uniform" name="image" accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this);">
                                <small>Dimens??o para tela cheia 740x340px</small>
                            </div>
                        </div>
                    </div>

                    @if($link != null)
                        <div class="my-4">
                         <p> <b> O slide est?? vinculado a </b> <br> {!! $link !!} <a href="javascript:void(0)" class="btn btn-outline-secondary btn-sm ml-2" id="changeLink">Alterar</a> </p> 
                       </div>
                    @else
                        <div class="my-4">
                            <p class="text-danger"> Este slide n??o est?? vinculado, por isso aparecer?? no local selecionado de cada usu??rio.</p>
                        </div>
                    @endif


                    <div class="form-group row @if($link != null) hidden @endif" id="linkSlideTo">
                        <label class="col-lg-3 col-form-label">Linkar Slide:</label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-lg linkTo" name="model" @if($link == null) required="required" @endif>
                                <option></option>
                                <option value="1">Loja</option>
                                <option value="2">Produto</option>
                                <option value="3">URL</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row hidden" id="storesList">
                        <label class="col-lg-3 col-form-label">Selecione a Loja:</label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-lg storesList" name="restaurant_id">
                                <option></option>
                                @foreach($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row hidden" id="itemList">
                        <label class="col-lg-3 col-form-label">Selecione o Produto:</label>
                        <div class="col-lg-9">
                            <select class="form-control form-control-lg itemList" name="item_id">
                                <option></option>
                                    @foreach($restaurants as $store)
                                        <optgroup label="{{ $store->name }}">
                                            @foreach($store->items as $storeItem)
                                            <option value="{{ $storeItem->id }}">{{ $storeItem->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row hidden" id="customURL">
                       <label class="col-lg-3 col-form-label">URL Personalizado:</label>
                        <div class="col-lg-9">
                            <input class="form-control form-control-lg" name="customUrl" id="customUrl" placeholder="Enter your custom URL" value="{{ $slide->url }}">
                            <span class="help-text small">Insira o URL completo com http: // ou https: // ou o redirecionamento n??o funcionar??.</span>
                        </div>
                    </div>

                    <div id="onCustomUrlActive" class="hidden">
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            Exibir localiza????o
                        </legend>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label"><strong>Restringir Local<i class="icon-question3 ml-1" data-popup="tooltip" title="Ativar isso permitir?? que voc?? defina a latitude, longitude e raio de exibi????o para este slide / imagem e somente quando a localiza????o do usu??rio estiver dentro do raio, o slide / imagem aparecer??." data-placement="top"></i></strong> </label>
                            <div class="col-lg-9">
                                <div class="checkbox checkbox-switchery mt-2">
                                    <label>
                                    <input value="true" type="checkbox" class="switchery-primary"
                                    @if($slide->is_locationset == 1) checked="checked" @endif
                                    name="is_locationset">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="locationProperties" class="@if(!$slide->is_locationset) hidden @endif">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Latitude:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-lg latitude" name="latitude"
                                        placeholder="Digite a Latitude" value="{{ $slide->latitude }}" @if($slide->is_locationset) required="required" @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Longitude:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-lg longitude" name="longitude"
                                        placeholder="Digite a Longitude" value="{{ $slide->longitude }}" @if($slide->is_locationset) required="required" @endif>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Raio:</label>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control form-control-lg radius" name="radius"
                                        placeholder="Raio em km" value="{{ $slide->radius }}" @if($slide->is_locationset) required="required" @endif>
                                </div>
                            </div>

                            <span class="text-muted">Voc?? pode usar servi??os como: <a href="https://www.mapcoordinates.net/pt" target="_blank">https://www.mapcoordinates.net/pt</a></span> <br> <span class="text-muted">Se voc?? inserir uma Latitude/Longitude inv??lida, o app poder?? travar com uma tela branca.</span>
                        </div>
                    </div>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        ATUALIZAR
                        <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                </form>
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
                    .width(120)
                    .height(120);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(function () {

        $('#changeLink').click(function(event) {
            $('#linkSlideTo').removeClass('hidden');
            $(this).addClass('hidden');
            $('.linkTo').attr('required', 'required');
        });

        $('.latitude').numeric({allowThouSep:false});
        $('.longitude').numeric({allowThouSep:false});
        $('.radius').numeric({ allowThouSep:false, maxDecimalPlaces: 0, allowMinus: false  });

       var elem = document.querySelector('.switchery-primary');
       var switchery = new Switchery(elem, { color: '#2196F3' });

       elem.onchange = function() {
         if (elem.checked) {
            $('#locationProperties').removeClass('hidden');
            $('.latitude').attr('required', 'required');
            $('.longitude').attr('required', 'required');
            $('.radius').attr('required', 'required');
         } else {
             $('#locationProperties').addClass('hidden');
             $('.latitude').removeAttr('required');
             $('.longitude').removeAttr('required');
             $('.radius').removeAttr('required');
         }
       };

        $('.linkTo').select2({
             placeholder: "Choose an option",
             minimumResultsForSearch: -1
        });

        $('.storesList').select2({
            placeholder: "Select a store",
        });

         $('.itemList').select2({
            placeholder: "Select an item",
        });

        $("[name='model']").change(function() {
            let selectedLinkOption = $(this).val();

            //on store selected
            if (selectedLinkOption == 1) {
                $('#storesList').removeClass('hidden');
                $('.storesList').attr('required', 'required');

                $('#itemList').addClass('hidden');
                $('#customURL').addClass('hidden');

                $('#customUrl').removeAttr('required');
                $('.itemList').removeAttr('required');

                $('#onCustomUrlActive').addClass('hidden');
            }

            //on items selected
            if (selectedLinkOption == 2) {
                $('#itemList').removeClass('hidden');
                 $('.itemList').attr('required', 'required');

                $('#storesList').addClass('hidden');
                $('#customURL').addClass('hidden');

                $('#customUrl').removeAttr('required');
                $('.storesList').removeAttr('required');

                $('#onCustomUrlActive').addClass('hidden');
            }

            //om custom URL selected
            if (selectedLinkOption == 3) {
                $('#customURL').removeClass('hidden');
                $('#customUrl').attr('required', 'required');

                $('#itemList').addClass('hidden');
                $('#storesList').addClass('hidden');

                $('.storesList').removeAttr('required');
                $('.itemList').removeAttr('required');

                $('#onCustomUrlActive').removeClass('hidden');
            } 

        });
    
       $('.form-control-uniform').uniform();
    
        $("#addSlide").click(function(event) {
            $("#slideForm").removeClass('hidden');
            $("#noSlidesContainer").remove();
            $(this).remove();
        });
    
        $("#urlInput").on("change paste keyup", function() {
            $("#urlHelpBlockContainer").removeClass('hidden');
            $("#appendURL").html($(this).val());
        });
    
         let URL = "{{ url("/") }}";
         URL = URL.substring(0, URL.lastIndexOf("/") + 1);
         $("#baseURL").html(URL);

    });
</script>
@endsection