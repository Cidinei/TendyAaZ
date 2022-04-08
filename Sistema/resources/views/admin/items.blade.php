@extends('admin.layouts.master')
@section("title") Items - Dashboard
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                @if(empty($query))
                <span class="font-weight-bold mr-2">TOTAL</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ $count }} Produtos</span>
                @else
                <span class="font-weight-bold mr-2">TOTAL</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ $count }} Produtos</span>
                <br>
                <span class="font-weight-normal mr-2">Exibindo resultados de "{{ $query }}"</span>
                @endif
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-md-0">
            <div class="breadcrumb">
                <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left mr-2" id="addNewItem"
                    data-toggle="modal" data-target="#addNewItemModal">
                    <b><i class="icon-plus2"></i></b>
                    Novo item
                </button>
                <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left" id="addBulkItem"
                    data-toggle="modal" data-target="#addBulkItemModal">
                    <b><i class="icon-database-insert"></i></b>
                    Upload de CSV em massa
                </button>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <form action="{{ route('admin.post.searchItems') }}" method="GET">
        <div class="form-group form-group-feedback form-group-feedback-right search-box">
            @if(isset($restaurant_id))
            <input type="hidden" name="restaurant_id" value="{{ $restaurant_id }}">
            @endif
            @if(Request::get('restaurant_id'))
                <input type="hidden" name="restaurant_id" value="{{ Request::get('restaurant_id') }}">
            @endif
            <input type="text" class="form-control form-control-lg search-input" placeholder="Pesquise por nome do item"
                name="query">
            <div class="form-control-feedback form-control-feedback-lg">
                <i class="icon-search4"></i>
            </div>
        </div>
        @csrf
    </form>
    @if($agent->isDesktop())
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th style="width: 20%">Loja do produto</th>
                            <th>Categoria do produto</th>
                            <th>Preço</th>
                            <th>Atributos</th>
                            <th style="width: 20%">Criado em</th>
                            <th class="text-center" style="width: 10%;"><i class="
                                icon-circle-down2"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>@if($item->image)<img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $item->image }}"
                                    alt="{{ $item->name }}" height="80" width="80" style="border-radius: 0.275rem;">@endif
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->restaurant->name }}</td>
                            <td>{{ $item->item_category->name }}</td>
                            <td>{{ config('appSettings.currencyFormat') }}{{ $item->price }}</td>
                            <td>
                                @if($item->is_recommended)
                                <span class="badge badge-flat border-grey-800 text-danger text-capitalize mr-1">
                                    Recomendado
                                </span>
                                @endif
                                @if($item->is_popular)
                                <span class="badge badge-flat border-grey-800 text-primary text-capitalize mr-1">
                                    Popular
                                </span>
                                @endif
                                @if($item->is_new)
                                <span class="badge badge-flat border-grey-800 text-default text-capitalize mr-1">
                                    Novo
                                </span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->diffForHumans() }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-justified align-items-center">
                                    <a href="{{ route('admin.get.editItem', $item->id) }}"
                                        class="btn btn-sm btn-primary"> Edit </a>
                                    <div class="checkbox checkbox-switchery ml-2" style="padding-top: 0.92rem; zoom: 1.2">
                                        <label>
                                        <input value="true" type="checkbox" class="action-switch"
                                        @if($item->is_active) checked="checked" @endif data-id="{{ $item->id }}">
                                        </label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $items->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
    @else
    
    @foreach ($items as $item)
    <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex">
                <div>
                    <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $item->image }}" alt="{{ $item->name }}" height="80" width="80" style="border-radius: 0.275rem;">
                </div>
                <div class="ml-3">
                    <h4 class="mb-0"><strong>{{ $item->name }}</strong></h4>
                    <span>{{ $item->restaurant->name }}</span><br>
                    <span>{{ $item->item_category->name }}</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="card-body pt-0 pb-2">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-0"><strong>{{ config('appSettings.currencyFormat') }}{{ $item->price }}</strong></h4>
                </div>
                <div>
                    @if($item->is_recommended)
                    <span class="badge badge-flat border-grey-800 text-danger text-capitalize mr-1">
                        Recomendado
                    </span>
                    @endif
                    @if($item->is_popular)
                    <span class="badge badge-flat border-grey-800 text-primary text-capitalize mr-1">
                        Popular
                    </span>
                    @endif
                    @if($item->is_new)
                    <span class="badge badge-flat border-grey-800 text-default text-capitalize mr-1">
                        Novo
                    </span>
                    @endif
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.get.editItem', $item->id) }}"
                        class="btn btn-secondary btn-labeled btn-labeled-left">
                    <b><i class="icon-database-edit2"></i></b>
                    EDITAR
                    </a>
                </div>
                <div>
                    <div class="checkbox checkbox-switchery" style="padding-top: 0.93rem;">
                        <label>
                        <input value="true" type="checkbox" class="action-switch-mobile"
                        @if($item->is_active) checked="checked" @endif data-id="{{ $item->id }}">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="mt-4">
        {{ $items->appends($_GET)->links() }}
    </div>
       
    @endif
</div>
<div id="addNewItemModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Novo produto</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.saveNewItem') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Nome:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="name" placeholder="Nome do produto"
                                required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Descrição</label>
                        <div class="col-lg-9">
                            <textarea class="summernote-editor" name="desc" placeholder="Descrição do produto "
                                rows="6"></textarea>
                        </div>
                    </div>

                    <div class="form-group row" style="display: none;" id="discountedTwoPrice">
                        <div class="col-lg-6">
                            <label class="col-form-label">Preço: <i class="icon-question3 ml-1"
                                    data-popup="tooltip" title="Deixe este campo vazio ou zero se não for necessário"
                                    data-placement="top"></i></label>
                            <input type="text" class="form-control form-control-lg price" name="old_price"
                                placeholder="Valor em {{ config('appSettings.currencyFormat') }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label"><span class="text-danger">*</span>Preço de venda:</label>
                            <input type="text" class="form-control form-control-lg price" name="price"
                                placeholder="Valor em {{ config('appSettings.currencyFormat') }}" id="newSP">
                        </div>
                    </div>
                    <div class="form-group row" id="singlePrice">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Preço:</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control form-control-lg price" name="price"
                                placeholder="Valor em {{ config('appSettings.currencyFormat') }}" required id="oldSP">
                        </div>
                        <div class="col-lg-3">
                            <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"
                                id="addDiscountedPrice">
                                <b><i class="icon-percent"></i></b>
                                Adicionar preço com desconto
                            </button>
                        </div>
                    </div>
                    <script>
                        $('#addDiscountedPrice').click(function(event) {
                            let price = $('#oldSP').val();
                            $('#newSP').val(price).attr('required', 'required');;
                            $('#singlePrice').remove();
                            $('#discountedTwoPrice').show();
                        });
                    </script>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Loja do produto:</label>
                        <div class="col-lg-9">
                            <select class="form-control select" name="restaurant_id" required>
                                @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" class="text-capitalize">{{ $restaurant->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Categoria do produto:</label>
                        <div class="col-lg-9">
                            <select class="form-control select" name="item_category_id" required>
                                @foreach ($itemCategories as $itemCategory)
                                <option value="{{ $itemCategory->id }}" class="text-capitalize">
                                    {{ $itemCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Categoria de complementos:</label>
                        <div class="col-lg-9">
                            <select multiple="multiple" class="form-control select" data-fouc
                                name="addon_category_item[]">
                                @foreach($addonCategories as $addonCategory)
                                <option value="{{ $addonCategory->id }}" class="text-capitalize">
                                    {{ $addonCategory->name }} @if($addonCategory->description != null)-> {{ $addonCategory->description }} @endif</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Imagem:</label>
                        <div class="col-lg-9">
                            <img class="slider-preview-image hidden" />
                            <div class="uploader">
                                <input type="file" class="form-control-lg form-control-uniform" name="image"
                                    accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this);">
                                <span class="help-text text-muted">Dimensão máxima 500x500px</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Recomendado?</label>
                        <div class="col-lg-9">
                            <div class="checkbox checkbox-switchery mt-2">
                                <label>
                                    <input value="true" type="checkbox" class="switchery-primary recommendeditem"
                                        name="is_recommended">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Popular?</label>
                        <div class="col-lg-9">
                            <div class="checkbox checkbox-switchery mt-2">
                                <label>
                                    <input value="true" type="checkbox" class="switchery-primary popularitem"
                                        name="is_popular">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Novo?</label>
                        <div class="col-lg-9">
                            <div class="checkbox checkbox-switchery mt-2">
                                <label>
                                    <input value="true" type="checkbox" class="switchery-primary newitem"
                                        checked="checked" name="is_new">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label display-block">Veg/N-Veg: </label>
                        <div class="col-lg-9 d-flex align-items-center">
                            <label class="radio-inline mr-2">
                                <input type="radio" name="is_veg" value="veg">
                                Vegetariano
                            </label>

                            <label class="radio-inline mr-2">
                                <input type="radio" name="is_veg" value="nonveg">
                                Não Vegetariano
                            </label>

                            <label class="radio-inline mr-2">
                                <input type="radio" name="is_veg" value="none" checked="checked">
                                Nenhum
                            </label>
                        </div>
                    </div>

                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            SALVAR
                            <i class="icon-database-insert ml-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="addBulkItemModal" class="modal fade mt-5" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Upload de CSV em massa</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.itemBulkUpload') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label">Arquivo CSV: </label>
                        <div class="col-lg-10">
                            <div class="uploader">
                                <input type="file" accept=".csv" name="item_csv"
                                    class="form-control-uniform form-control-lg" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-left">
                        <button type="button" class="btn btn-primary" id="downloadSampleItemCsv">
                            Baixar modelo CSV
                            <i class="icon-file-download ml-1"></i>
                        </button>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            Upload
                            <i class="icon-database-insert ml-1"></i>
                        </button>
                    </div>
                    @csrf
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
        $('.summernote-editor').summernote({
                   height: 200,
                   popover: {
                       image: [],
                       link: [],
                       air: []
                     }
            });
        
       $('.select').select2();
    
       var recommendeditem = document.querySelector('.recommendeditem');
       new Switchery(recommendeditem, { color: '#f44336' });
    
       var popularitem = document.querySelector('.popularitem');
       new Switchery(popularitem, { color: '#8360c3' });
    
       var newitem = document.querySelector('.newitem');
       new Switchery(newitem, { color: '#333' });

       
       $('.form-control-uniform').uniform();
       
        $('#downloadSampleItemCsv').click(function(event) {
           event.preventDefault();
           window.location.href = "{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/docs/items-sample-csv.csv";
       });
        
         $('.price').numeric({allowThouSep:false, maxDecimalPlaces: 2 });

         //Switch Action Function  
          var elems = document.querySelectorAll('.action-switch');
          for (var i = 0; i < elems.length; i++) {
              var switchery = new Switchery(elems[i], { color: '#8360c3' });
          }
          var elemsmb = document.querySelectorAll('.action-switch-mobile');
          for (var i = 0; i < elemsmb.length; i++) {
              var switchery = new Switchery(elemsmb[i], { color: '#8360c3' });
          }     

          $('.action-switch, .action-switch-mobile').click(function(event) {
            console.log("Clicked");
             let id = $(this).attr("data-id")
             let url = "{{ url('/admin/item/disable/') }}/"+id;
             let self = $(this);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'JSON',
            })
            .done(function(data) {
                console.log(data);
                console.log(self);
                $.jGrowl("", {
                    position: 'bottom-center',
                    header: 'Sucesso ✅',
                    theme: 'bg-success',
                    life: '1800'
                }); 
            })
            .fail(function(data) {
                console.log(data);
                $.jGrowl("", {
                    position: 'bottom-center',
                    header: 'Erro, tente novamento.',
                    theme: 'bg-danger',
                    life: '1800'
                }); 
            })            
          });
    });
</script>
@endsection