@extends('admin.layouts.master')
@section("title") Editar Produto - Dashboard
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Editando</span>
                <span class="badge badge-primary badge-pill animated flipInX">{{ $item->name }} <i class="icon-circle-right2 mx-1"></i>
                    {{ $item->restaurant->name }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.updateItem') }}" method="POST" enctype="multipart/form-data">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-address-book mr-2"></i> Detalhes dos produtos
                    </legend>
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Nome:</label>
                        <div class="col-lg-9">
                            <input value="{{ $item->name }}" type="text" class="form-control form-control-lg"
                                name="name" placeholder="Nome do produto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Descrição:</label>
                        <div class="col-lg-9">
                            <textarea class="summernote-editor" name="desc" placeholder="Descrição do produto"
                                rows="6">{{ $item->desc }}</textarea>
                        </div>
                    </div>

                    @if($item->old_price == 0)
                    <div class="form-group row" style="display: none;" id="discountedTwoPrice">
                        <div class="col-lg-6">
                            <label class="col-form-label">Preço:</label>
                            <input type="text" class="form-control form-control-lg price" name="old_price"
                                placeholder="Valor do produto em {{ config('appSettings.currencyFormat') }}"
                                value="{{ $item->old_price }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label"><span class="text-danger">*</span>Preço com desconto:</label>
                            <input type="text" class="form-control form-control-lg price" name="price"
                                placeholder="Valor em {{ config('appSettings.currencyFormat') }}" id="newSP"
                                value="{{ $item->price }}">
                        </div>
                    </div>

                    <div class="form-group row" id="singlePrice">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Preço:</label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control form-control-lg price" name="price"
                                placeholder="Valor do produto em {{ config('appSettings.currencyFormat') }}" required id="oldSP"
                                value="{{ $item->price }}">
                        </div>
                        <div class="col-lg-4">
                            <button type="button" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"
                                id="addDiscountedPrice">
                                <b><i class="icon-percent"></i></b>
                                Preço com desconto
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
                    @else
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label class="col-form-label">Preço: <i class="icon-question3 ml-1"
                                    data-popup="tooltip" title="Make this filed empty or zero if not required"
                                    data-placement="top"></i> </label>
                            <input type="text" class="form-control form-control-lg price" name="old_price"
                                placeholder="Valor do produto em {{ config('appSettings.currencyFormat') }}"
                                value="{{ $item->old_price }}">
                        </div>
                        <div class="col-lg-6">
                            <label class="col-form-label"><span class="text-danger">*</span>Preço com desconto:</label>
                            <input type="text" class="form-control form-control-lg price" name="price"
                                placeholder="Valor em {{ config('appSettings.currencyFormat') }}" id="newSP"
                                value="{{ $item->price }}">
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Loja do produto:</label>
                        <div class="col-lg-9">
                            <select class="form-control select" name="restaurant_id" required>
                                @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}" class="text-capitalize" @if($item->restaurant_id
                                    == $restaurant->id) selected="selected" @endif>{{ $restaurant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Categoria do produto:</label>
                        <div class="col-lg-9">
                            <select class="form-control select" name="item_category_id" required>
                                @foreach ($itemCategories as $itemCategory)
                                <option value="{{ $itemCategory->id }}" class="text-capitalize" @if($item->
                                    item_category_id == $itemCategory->id) selected="selected"
                                    @endif>{{ $itemCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Categoria de adicionais:</label>
                        <div class="col-lg-9">

                            <select multiple="multiple" class="form-control addonCategorySelect" data-fouc
                                name="addon_category_item[]">
                                @foreach($addonCategories as $addonCategory)
                                <option value="{{ $addonCategory->id }}" class="text-capitalize" {{isset($item) &&  in_array($item->id, $addonCategory->items()->pluck('item_id')->toArray()) ? 'selected' : '' }}>
                                    {{ $addonCategory->name }} @if($addonCategory->description != null)-> {{ $addonCategory->description }} @endif</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Imagem:</label>
                        <div class="col-lg-9">
                            @if($item->image)
                            <img src="{{ substr(url("/"), 0, strrpos(url("/"), '/')) }}{{ $item->image }}" alt="Image"
                                width="160" style="border-radius: 0.275rem;">
                            @endif
                            <img class="slider-preview-image hidden" style="border-radius: 0.275rem;" />
                            <div class="uploader">
                                <input type="hidden" name="old_image" value="{{ $item->image }}">
                                <input type="file" class="form-control-lg form-control-uniform" name="image"
                                    accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this);">
                                <span class="help-text text-muted">Dimensão máxima: 500x500px</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Recomendado?</label>
                        <div class="col-lg-9">
                            <div class="checkbox checkbox-switchery mt-2">
                                <label>
                                    <input value="true" type="checkbox" class="switchery-primary recommendeditem"
                                        @if($item->is_recommended) checked="checked" @endif name="is_recommended">
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
                                        @if($item->is_popular) checked="checked" @endif name="is_popular">
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
                                        @if($item->is_new) checked="checked" @endif name="is_new">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label display-block">Veg/Não-Veg: </label>
                        <div class="col-lg-9 d-flex align-items-center">
                            <label class="radio-inline mr-2">
                                <input type="radio" @if($item->is_veg) checked="checked" @endif name="is_veg" value="veg">
                                Vegetarino
                            </label>

                            <label class="radio-inline mr-2">
                                <input type="radio" @if(!$item->is_veg) checked="checked" @endif name="is_veg" value="nonveg">
                                Não vegetariano
                            </label>

                            <label class="radio-inline mr-2">
                                <input type="radio" @if(is_null($item->is_veg)) checked="checked" @endif name="is_veg" value="none">
                                Nenhum
                            </label>
                        </div>
                    </div>

                    @csrf
                    <div class="text-left">
                        <div class="btn-group btn-group-justified" style="width: 150px">
                            @if($item->is_active)
                            <a class="btn btn-danger" href="{{ route('admin.disableItem', $item->id) }}">
                                DESABILITAR
                                <i class="icon-switch2 ml-1"></i>
                            </a>
                            @else
                            <a class="btn btn-primary" href="{{ route('admin.disableItem', $item->id) }}">
                                HABILITAR
                                <i class="icon-switch2 ml-1"></i>
                            </a>
                            @endif
                        </div>
                    </div>
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
        $('.summernote-editor').summernote({
                   height: 200,
                   popover: {
                       image: [],
                       link: [],
                       air: []
                     }
            });

        $('.select').select2();
        $('.addonCategorySelect').select2({
            closeOnSelect: false
        })
    
         var recommendeditem = document.querySelector('.recommendeditem');
        new Switchery(recommendeditem, { color: '#f44336' });
    
        var popularitem = document.querySelector('.popularitem');
        new Switchery(popularitem, { color: '#8360c3' });
    
        var newitem = document.querySelector('.newitem');
        new Switchery(newitem, { color: '#333' });

        
        $('.form-control-uniform').uniform();
        $('.price').numeric({allowThouSep:false, maxDecimalPlaces: 2 });
    });
</script>
@endsection