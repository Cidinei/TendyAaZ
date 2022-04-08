@extends('admin.layouts.master')
@section("title") Editar Slider - Dashboard
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Editando: </span>
                <span class="badge badge-primary badge-pill animated flipInX">{{ $slider->name }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content" style="margin-bottom: 10rem;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        Propriedades do Slider
                    </legend>
                    <form action="{{ route('admin.updateSlider') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="{{ $slider->id }}">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Nome:</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control form-control-lg" name="name"
                                    placeholder="Nome do slider" required value="{{ $slider->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Position:</label>
                            <div class="col-lg-8">
                                <select name="position_id" class="form-control form-control-lg select">
                                <option value="0" @if($slider->position_id == 0) selected="selected" @endif>Topo</option>
                                <option value="1" @if($slider->position_id == 1) selected="selected" @endif>Após a 1º Loja</option>
                                <option value="2" @if($slider->position_id == 2) selected="selected" @endif>Após a 2º Loja</option>
                                <option value="3" @if($slider->position_id == 3) selected="selected" @endif>Após a 3º Loja</option>
                                <option value="4" @if($slider->position_id == 4) selected="selected" @endif>Após a 4º Loja</option>
                                <option value="5" @if($slider->position_id == 5) selected="selected" @endif>Após a 5º Loja</option>
                                <option value="6" @if($slider->position_id == 6) selected="selected" @endif>Após a 6º Loja</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">Tamanho: (não fará diferença se o css personalizado com a classe do banner estiver editado)</label>
                            <div class="col-lg-8">
                                <select name="size" class="form-control form-control-lg select" required="required">
                                <option value="1" @if($slider->size == 1) selected="selected" @endif>Extra Pequeno</option>
                                <option value="2" @if($slider->size == 2) selected="selected" @endif>Pequeno</option>
                                <option value="3" @if($slider->size == 3) selected="selected" @endif>Médio</option>
                                <option value="4" @if($slider->size == 4) selected="selected" @endif>Grande</option>
                                <option value="5" @if($slider->size == 5) selected="selected" @endif>Extra Grande</option>
                                </select>
                            </div>
                        </div>

                        @csrf
                        <div class="d-flex justify-content-end my-4">
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                Atualizar
                                <i class="icon-database-insert ml-1"></i>
                                </button>
                            </div>
                        </div>

                        <hr>

                        <div class="text-left">
                            <div class="btn-group btn-group-justified">
                                @if($slider->is_active)
                                <a href="{{ route('admin.disableSlider', $slider->id) }}" class="btn btn-warning text-white mr-3" data-popup="tooltip" title="Disable Slider" data-placement="bottom"> Desabilitar <i class="icon-switch2 ml-1"></i> </a>
                                @else
                                <a href="{{ route('admin.disableSlider', $slider->id) }}" class="btn btn-primary text-white mr-3" data-popup="tooltip" title="Enable Slider" data-placement="bottom"> Habilitar <i class="icon-switch2 ml-1"></i> </a>
                                @endif
                                <a class="btn btn-danger text-white" data-toggle="modal" data-target="#deleteSliderConfirmModal" id="deleteSliderButton" href="javascript:void(0)">
                                DELETAR SLIDER
                                <i class="icon-trash ml-1"></i>
                                </a>
                            </div>

                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        Slides
                    </legend>
                    @if(count($slides) == 0)
                    <div id="noSlidesContainer">
                        <strong>No Slides</strong>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary" id="addSlide">
                            ADD SLIDE
                            <i class="icon-plus3 ml-1"></i>
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="row" id="sortable">
                        @foreach($slides as $slide)
                        <div class="col-md-3 mb-2 each-slide" data-id="{{ $slide->id }}">
                            <p class="h6 mb-1"><strong>{{ $slide->name }}</strong></p>
                            <img src="{{ substr(url("/"), 0, strrpos(url("/"), '/')) }}{{ $slide->image }}" alt="{{ $slide->name }}" width="150" height="150"
                            data-popup="tooltip" title="{{ $slide->link }}" data-placement="right">
                            <div class="btn-group btn-group-justified" style="width: 150px">
                                <a href="{{ route('admin.editSlide', $slide->id) }}" class="btn btn-dark rounded-0" data-popup="tooltip" title="Edit Slide" data-placement="bottom"> <i class="icon-pencil3"></i> </a>
                                <a href="{{ route('admin.deleteSlide', $slide->id) }}" class="btn btn-danger" data-popup="tooltip" title="Delete Slide" data-placement="bottom"> <i class="icon-trash"></i> </a>
                                @if($slide->is_active)
                                <a href="{{ route('admin.disableSlide', $slide->id) }}" class="btn btn-secondary rounded-0" data-popup="tooltip" title="Desabilitar Slide" data-placement="bottom"> <i class="icon-switch2"></i> </a>
                                @else
                                <a href="{{ route('admin.disableSlide', $slide->id) }}" class="btn btn-warning rounded-0" data-popup="tooltip" title="Habilitar Slide" data-placement="bottom"> <i class="icon-switch2"></i> </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary" id="addSlide">
                        ADD SLIDE
                        <i class="icon-plus3 ml-1"></i>
                        </button>
                    </div>
                    @endif
                    <form action="{{ route('admin.saveSlide') }}" method="POST" id="slideForm" class="mt-3 hidden" enctype="multipart/form-data">
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                             Novo Slide
                        </legend>
                        <input type="hidden" class="form-control form-control-lg" name="promo_slider_id" value="{{ $slider->id }}" required>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nome:</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control form-control-lg" name="name" placeholder="Nome do Slide" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Imagem:</label>
                            <div class="col-lg-9">
                                <img class="slider-preview-image hidden"/>
                                <div class="uploader">
                                    <input type="file" class="form-control-uniform" name="image" required accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this);">
                                    <small>Dimensão para tela cheia 740x340ox</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="linkSlideTo">
                            <label class="col-lg-3 col-form-label">Link Slide To:</label>
                            <div class="col-lg-9">
                                <select class="form-control form-control-lg linkTo" name="model">
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
                           <label class="col-lg-3 col-form-label">URL:</label>
                            <div class="col-lg-9">
                                <input type="url" class="form-control form-control-lg" name="customUrl" id="customUrl" placeholder="Digite a URL Personalizada">
                                <span class="help-text small">URL completo com http:// ou https://</span>
                            </div>
                        </div>

                        <div id="onCustomUrlActive" class="hidden">
                            <legend class="font-weight-semibold text-uppercase font-size-sm">
                                Exibir local
                            </legend>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label"><strong>Restringir local<i class="icon-question3 ml-1" data-popup="tooltip" title="Ativar isso permitirá que você defina a latitude, longitude e raio de exibição para este slide / imagem e somente quando a localização do usuário estiver dentro do raio, o slide / imagem aparecerá." data-placement="top"></i></strong> </label>
                                <div class="col-lg-9">
                                    <div class="checkbox checkbox-switchery mt-2">
                                        <label>
                                        <input value="true" type="checkbox" class="switchery-primary">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="locationProperties" class="hidden">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Latitude:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg latitude" name="latitude"
                                            placeholder="Latitude">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Longitude:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg longitude" name="longitude"
                                            placeholder="Longitude">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Raio:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg radius" name="radius"
                                            placeholder="Raio em km ">
                                    </div>
                                </div>

                                <span class="text-muted">Para obter uma latitude / longitude válida, você pode usar serviços como: <a href="https://www.mapcoordinates.net/pt" target="_blank">https://www.mapcoordinates.net/pt</a></span> <br> <span class="text-muted">Se você inserir uma latitude / longitude inválida, o sistema pode travar com uma tela branca.</span>
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
</div>
<div id="deleteSliderConfirmModal" class="modal fade mt-5" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Você tem certeza?</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <span class="help-text">Tenha cuidado, todos os slides associados a este controle deslizante também serão excluídos permanentemente. <br> Você pode usar o "<strong>DESABILITAR</strong>" recurso para desativar temporariamente o Slider.</span>
                <div class="modal-footer mt-4">
                    <a href="{{ route('admin.deleteSlider', $slider->id) }}" class="btn btn-primary">Yes</a>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="token" value="{{ csrf_token() }}">
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

        $('.select').select2({
            minimumResultsForSearch: -1
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
    
         /*handle custom url click */ 
         $('#enterCustomURL').click(function(event) {
            $(this).hide();
            $('#customURL').removeClass('hidden');
            $('#restaurantURL').addClass('hidden');
            $('#urlInput').removeAttr('required');
            $('#customUrl').attr('required', 'required');
         });
    
        $('#sortable').sortable({
            animation: 350,
            easing: "cubic-bezier(0.42, 0, 0.58, 1.0)",
            ghostClass: "sortable-placeholder",
            onUpdate: function (evt) {
                let newSortOrder = {};
                $('.each-slide').each(function() {
                    newSortOrder[$(this).index()] = $(this).data('id');
                });
                $.ajax({
                  url: '{{ route('admin.updateSlidePosition') }}',
                  type: 'POST',
                  dataType: 'JSON',
                  data: {newOrder: newSortOrder, _token: $('#token').val()},
              })
              .done(function(res) {
                   $.jGrowl("Slides sorted successfully", {
                       position: 'bottom-center',
                       header: 'Done ✅',
                       theme: 'bg-success',
                       life: '2000',
                   }); 
              })
              .fail(function() {
                  console.log("error");
                  $.jGrowl("Something went wrong! Reload the page and try again later.", {
                      position: 'bottom-center',
                      header: 'Wooopsss ⚠️',
                      theme: 'bg-warning',
                  });
              })
            },
        });
    });
</script>
@endsection