@extends('admin.layouts.master')
@section("title") Editar loja - Dashboard
@endsection
@section('content')
<style>
    .location-search-block {
        position: relative;
        top: -26rem;
        z-index: 999;
    }
</style>
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">Editando</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ $restaurant->name }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body" style="min-height: 75vh;">
                <form action="{{ route('admin.updateRestaurant') }}" method="POST" enctype="multipart/form-data" id="storeMainForm" style="min-height: 75vh;">
                    @csrf
                    <input type="hidden" name="window_redirect_hash" value="">
                    <input type="hidden" name="id" value="{{ $restaurant->id }}">

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg btnUpdateStore">
                        <b><i class="icon-database-insert ml-1"></i></b>
                        Atualizar Loja
                        </button>
                    </div>

                    <div class="d-lg-flex justify-content-lg-left">
                        <ul class="nav nav-pills flex-column mr-lg-3 wmin-lg-250 mb-lg-0">

                            <!-- Módulo de Cashback -->
                            @if(\Module::find("Cashback") && \Module::find("Cashback")->isEnabled())
                                <li class="nav-item"> 
                                    <a href="#cashbackSettings" class="nav-link" data-toggle="tab"> 
                                        <i class="icon-coin-dollar mr-2"></i> 
                                        {{ Lang::get('cashback::default.cashback') }} 
                                    </a>
                                </li> 
                            @endif 
                            <!-- Módulo de Cashback END --> 

                            <li class="nav-item">
                                <a href="#generalSettings" class="nav-link active" data-toggle="tab">
                                <i class="icon-store2 mr-2"></i>
                                Geral
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#metaDataSettings" class="nav-link" data-toggle="tab">
                                <i class="icon-info22 mr-2"></i>
                                Dados
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#operationAreaSettings" class="nav-link" data-toggle="tab">
                                <i class="icon-map mr-2"></i>
                                Área Operacional
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#deliverySettings" class="nav-link" data-toggle="tab">
                                <i class="icon-truck mr-2"></i>
                                Delivery
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#extraSettings" class="nav-link" data-toggle="tab">
                                <i class="icon-strategy mr-2"></i>
                                Extras
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#actionSettings" class="nav-link" data-toggle="tab">
                                <i class="icon-square-up-right mr-2"></i>
                                Ações
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#paymentGatewaySettings" class="nav-link" data-toggle="tab">
                                <i class="icon-coin-dollar mr-2"></i>
                                Gateways de Pagamento
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#commissionSettings" class="nav-link" data-toggle="tab">
                                <i class="icon-percent mr-2"></i>
                                Comissões
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)" class="nav-link" id="payoutDetails">
                                <i class="icon-coin-dollar mr-2"></i>
                                Detalhes de Pagamento
                                </a>
                            </li>
                            @if($restaurant->is_schedulable)
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link" id="schedulingSettings">
                                    <i class="icon-alarm mr-2"></i>
                                    Horário
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('admin.sortMenusAndItems', $restaurant->id) }}" class="nav-link">
                                <i class="icon-sort mr-2"></i>
                                Mover Menus e Produtos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.viewStoreReviews', $restaurant->id) }}" class="nav-link">
                                <i class="icon-stars mr-2"></i>
                                Classificação e Avaliação <span class="ml-1 badge badge-flat text-white {{ ratingColorClass($rating) }}">{{ $rating }} <i class="icon-star-full2 text-white" style="font-size: 0.6rem;"></i></span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" style="width: 100%; padding: 0 25px;">

                            <div class="tab-pane fade show active" id="generalSettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Configurações Gerais
                                </legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Nome:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->name }}" type="text" class="form-control form-control-lg" name="name"
                                            placeholder="Nome da Loja" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Descrição:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->description }}" type="text" class="form-control form-control-lg" name="description"
                                            placeholder="Descrição curta" required>
                                    </div>
                                </div>

                                <!-- Módulo StoreDashboardPRO -->
                                @if (\Module::find("StoreDashBoardPro") && \Module::find("StoreDashBoardPro")->isEnabled()) 
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">{{ Lang::get('storedashboardpro::default.dashboardChangeOrderStatus') }}</label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery mt-2">
                                                <label>
                                                <input value="true" type="checkbox" class="switchery-primary" @if($restaurant->is_change_status) checked="checked" @endif name="is_change_status">
                                                </label>
                                            </div>
                                        </div>
                                    </div>               
                                @endif 
                                <!-- Módulo StoreDashboardPRO END -->

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Imagem:</label>
                                    <div class="col-lg-9">
                                        <img src="{{ substr(url("/"), 0, strrpos(url("/"), '/')) }}{{ $restaurant->image }}" alt="Image" width="160" style="border-radius: 0.275rem;">
                                        <img class="slider-preview-image hidden" style="border-radius: 0.275rem;"/>
                                        <div class="uploader">
                                            <input type="hidden" name="old_image" value="{{ $restaurant->image }}">
                                            <input type="file" class="form-control-uniform" name="image" accept="image/x-png,image/gif,image/jpeg" onchange="readURL(this);">
                                            <span class="help-text text-muted">Dimensão máxima: 500x500px</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Taxas extras (Ex.: taxa de embalagem):</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->restaurant_charges }}" type="text" class="form-control form-control-lg restaurant_charges" name="restaurant_charges"
                                            placeholder="Store Charge in {{ config('appSettings.currencyFormat') }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Valor mínimo do pedido <i class="icon-question3 ml-1" data-popup="tooltip" title="Set the value as 0 if not required" data-placement="top"></i></label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->min_order_price }}" type="text" class="form-control form-control-lg min_order_price" name="min_order_price"
                                            placeholder="Valor minimo do pedido em {{ config('appSettings.currencyFormat') }}" required="required">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Categoria da Loja: </label>
                                    <div class="col-lg-9">
                                        <select multiple="multiple" class="form-control selectRestaurantCategory" data-fouc name="restaurant_category_restaurant[]">
                                            @foreach($restaurantCategories as $rC)
                                            <option value="{{ $rC->id }}" class="text-capitalize" {{isset($restaurant) &&  in_array($restaurant->id, $rC->restaurants()->pluck('restaurant_id')->toArray()) ? 'selected' : '' }}>{{ $rC->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>URL da loja (SLUG)</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->slug }}" type="text" class="form-control form-control-lg" name="store_url"
                                            placeholder="Slug da loja" required>
                                            <p onclick="copyURL()" class="text-muted">https://{{ request()->getHttpHost() }}/stores/<strong><span id="storeURL">{{ $restaurant->slug }}</span></strong></p>
                                    </div>

                                </div>
                                
                            </div>

                            <div class="tab-pane fade" id="metaDataSettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Dados da loja
                                </legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Endereço completo:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->address }}" type="text" class="form-control form-control-lg" name="address"
                                            placeholder="Endereço completo da loja" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" data-popup="tooltip" title="Cep" data-placement="bottom">Pincode:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->pincode }}" type="text" class="form-control form-control-lg" name="pincode"
                                            placeholder="Cep da loja">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Ponto de referência:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->landmark }}" type="text" class="form-control form-control-lg" name="landmark"
                                            placeholder="Complemento do endereço">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Classificação:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->rating }}" type="text" class="form-control form-control-lg rating" name="rating"
                                            placeholder="Classificação de 1-5" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Tempo aproximado de entrega:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->delivery_time }}" type="text" class="form-control form-control-lg delivery_time" name="delivery_time"
                                            placeholder="Tempo em minutos" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Preço médio dos produtos:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->price_range }}" type="text" class="form-control form-control-lg price_range" name="price_range"
                                            placeholder="Valor médio dos produtos em {{ config('appSettings.currencyFormat') }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Cnpj:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->certificate }}" type="text" class="form-control form-control-lg" name="certificate"
                                            placeholder="Cnpj da loja">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><strong>Mensagem personalizada da loja
                                    <i class="icon-question3 ml-1" data-popup="tooltip" title="Aparecerá na página da loja (HTML pode ser usado)" data-placement="left"></i>
                                    </strong></label>
                                    <div class="col-lg-9">
                                        <textarea class="summernote-editor" name="custom_message" placeholder="Mensagem personalizada da loja" rows="6">{{ $restaurant->custom_message }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="operationAreaSettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Área Operacional
                                </legend>
                                @if(config('appSettings.googleApiKeyNoRestriction') != null)
                                <fieldset class="gllpLatlonPicker">
                                    <div width="100%" id="map" class="gllpMap" style="position: relative; overflow: hidden;"></div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <label class="col-form-label">Latitude:</label><input type="text"
                                                class="form-control form-control-lg gllpLatitude latitude"
                                                name="latitude" placeholder="Latitude da loja" value="{{ $restaurant->latitude }}" required="required" readonly="readonly">
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="col-form-label">Longitude:</label><input type="text"
                                                class="form-control form-control-lg gllpLongitude longitude"
                                                name="longitude" placeholder="Longitude da loja"  value="{{ $restaurant->longitude }}" required="required" readonly="readonly">
                                        </div>
                                    </div>
                                    <input type="hidden" class="gllpZoom" value="20">
                                    <div class="d-flex justify-content-center">
                                        <div class="col-lg-6 d-flex location-search-block">       
                                            <input type="text" class="form-control form-control-lg gllpSearchField" placeholder="Pesquise por loja, cidades, bairros e etc...">
                                            <button type="button" class="btn btn-primary gllpSearchButton">Procurar</button>
                                        </div>
                                    </div>
                                </fieldset>
                                @else
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Latitude:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg gllpLatitude latitude" value="{{ $restaurant->latitude }}" name="latitude" placeholder="Latitude da loja" required="required">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Longitude:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control form-control-lg gllpLongitude longitude" value="{{ $restaurant->longitude }}" name="longitude" placeholder="Longitude da loja" required="required">
                                    </div>
                                </div>
                                <span class="text-muted">Você pode usar serviços como: <a href="https://www.mapcoordinates.net/pt" target="_blank">https://www.mapcoordinates.net/pt</a></span>
                                <br>
                                <mark>Você não definiu <a href="{{ route('admin.settings', "#mapSettings") }}" target="_blank">Google Maps API Key (IP/HTTP sem restrição)</a></mark><br>
                                <mark>Configure isso para acessar o Google Maps para buscar as cordenadas exatas da loja (Latitude/Longitude)</mark>
                                <br> Se você inserir uma Latitude/Longitude incorreta, o aplicativo poderá travar com uma tela branca.
                                @endif
                            <div style="padding: 25px; margin-top: 2rem; border-radius: 0.5rem; border: 1px solid #dedede">
                                <h3>Raio de entrega</h3>
                                <hr class="my-2" style="border-color: rgba(224, 224, 224, 59%)">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Raio de entrega em Km:</label>
                                    <div class="col-lg-9">
                                        <input type="text" value="{{ $restaurant->delivery_radius }}" class="form-control form-control-lg delivery_radius" name="delivery_radius"
                                            placeholder="Raio de entrega em km (Se você deixar em branco, será definido o raio de entrega para 10 km)" @if($dapCheck && count($restaurant->delivery_areas) > 0) disabled="disabled" style="cursor: not-allowed;" title="O Raio será ignorado se áreas do DeliveryÁreaPro estiver atribuída a loja." @endif>
                                    </div>
                                </div>
                            </div>

                                @if($dapCheck)
                                <div class="mt-4 d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="text-info"> <i class="icon-exclamation mr-2" style="font-size: 1.8rem; opacity: 0.3;"></i></span>
                                    </div>
                                    <div>
                                        <p class="mb-0">Você ativou o módulo Delivery Area Pro. O aplicativo começará a usar áreas em vez de raio de pelo menos uma área atribuída <b>{{ $restaurant->name }}.</b></p>
                                    </div>
                                </div>
                                @endif

                                <!-- Delivery Area Pro Module -->
                                @if($dapCheck)
                                <div style="padding: 25px; margin-top: 2rem; border-radius: 0.5rem; border: 1px solid #dedede">
                                    <h3><i class="icon-medal-star mr-2"></i> Delivery Área Pro </h3>
                                    <hr class="my-2" style="border-color: rgba(224, 224, 224, 59%)">
                                    <div class="form-group row">
                                        <div class="col-lg-12">
                                            @if(count($restaurant->delivery_areas) > 0)
                                                <b>Operational Areas:</b>
                                                <br>
                                                <div class="my-2">
                                                    @foreach($restaurant->delivery_areas as $deliveryArea)
                                                    <span class="badge badge-flat border-grey-800 mr-1 mb-2" style="font-size: 0.9rem;">{{ $deliveryArea->name }}</span>
                                                    @endforeach
                                                </div>
                                                <a href="{{ route('dap.assignAreasToStore', $restaurant->id) }}" class="btn btn-md btn-secondary">Gerenciar Áreas</a>
                                            @else
                                                <p class="text-warning mb-0 my-2" style="line-height: 2.4rem;"><b>{{ $restaurant->name }}</b> Nenhuma área atribuída.</p>
                                                <a href="{{ route('dap.assignAreasToStore', $restaurant->id) }}" class="btn btn-md btn-secondary">Atribui área</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- END Delivery Area Pro Module -->
                            </div>

                            <div class="tab-pane fade" id="deliverySettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Delivery
                                </legend>
                                @if(config("appSettings.enSPU") == "true")
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Tipo de Entrega:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control select" name="delivery_type" required>
                                        <option value="1" class="text-capitalize" @if($restaurant->delivery_type == "1") selected="selected" @endif>Delivery</option>
                                        <option value="2" class="text-capitalize" @if($restaurant->delivery_type == "2") selected="selected" @endif>Retirada no Balcão</option>
                                        <option value="3" class="text-capitalize" @if($restaurant->delivery_type == "3") selected="selected" @endif>Delivery e Retirada no Balcão</option>
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Tipo de taxa de entrega:</label>
                                    <div class="col-lg-9">
                                        <select class="form-control select" name="delivery_charge_type" required>
                                        <option value="FIXED" @if($restaurant->delivery_charge_type == "FIXED") selected="selected" @endif class="text-capitalize">Taxa Fixa</option>
                                        <option value="DYNAMIC" @if($restaurant->delivery_charge_type == "DYNAMIC") selected="selected" @endif class="text-capitalize">Taxa Dinâmica</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" id="deliveryCharge">
                                    <label class="col-lg-3 col-form-label">Taxa de entrega:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->delivery_charges }}" type="text" class="form-control form-control-lg delivery_charges" name="delivery_charges"
                                            placeholder="Delivery Charge in {{ config('appSettings.currencyFormat') }}">
                                    </div>
                                </div>
                                <div id="dynamicChargeDiv">
                                    <div class="form-group">
                                        <div class="col-lg-12 row p-0">
                                            <div class="col-lg-3">
                                                <label class="col-lg-12 col-form-label p-0 pb-1">Taxa de entrega base:</label>
                                                <input value="{{ $restaurant->base_delivery_charge }}" type="text" class="form-control form-control-lg base_delivery_charge" name="base_delivery_charge"
                                                    placeholder="Em {{ config('appSettings.currencyFormat') }}">
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="col-lg-12 col-form-label p-0 pb-1">Raio de entrega da taxa base:</label>
                                                <input value="{{ $restaurant->base_delivery_distance }}" type="text" class="form-control form-control-lg base_delivery_distance" name="base_delivery_distance"
                                                    placeholder="Em km">
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="col-lg-12 col-form-label p-0 pb-1">Taxa de entrega extra:</label>
                                                <input value="{{ $restaurant->extra_delivery_charge }}" type="text" class="form-control form-control-lg extra_delivery_charge" name="extra_delivery_charge"
                                                    placeholder="Em {{ config('appSettings.currencyFormat') }}">
                                            </div>
                                            <div class="col-lg-3">
                                                <label class="col-lg-12 col-form-label p-0 pb-1">Raio de entrega da taxa extra:</label>
                                                <input value="{{ $restaurant->extra_delivery_distance }}" type="text" class="form-control form-control-lg extra_delivery_distance" name="extra_delivery_distance" placeholder="Em km">
                                            </div>
                                        </div>
                                        <p class="help-text mt-2 mb-0 text-muted"> As taxas de entrega base serão aplicadas à distância de entrega base. E para cada distância extra de entrega, uma taxa de entrega extra será aplicada.</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="extraSettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Extras
                                </legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Vegetariano?</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox checkbox-switchery mt-2">
                                            <label>
                                            <input value="true" type="checkbox" class="switchery-primary" @if($restaurant->is_pureveg) checked="checked" @endif name="is_pureveg">
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Está em Destaque?</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox checkbox-switchery mt-2">
                                            <label>
                                            <input value="true" type="checkbox" class="switchery-primary" @if($restaurant->is_featured) checked="checked" @endif name="is_featured">
                                            </label>
                                        </div>
                                        @if($restaurant->custom_featured_name == null)
                                            <button class="btn btn-sm btn-default bg-light" id="customFeaturedBadgeBtn">Nome personalizado para o emblema Destaque</button>
                                        @endif
                                    </div>
                                </div>

                                
                                <div class="form-group row @if($restaurant->custom_featured_name == null) hidden @endif" id="customFeaturedBadgeInput">
                                    <label class="col-lg-3 col-form-label">Nome personalizado para o emblema Destaque</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->custom_featured_name }}" type="text" class="form-control form-control-lg" name="custom_featured_name">
                                        <mark>Deixe em branco para voltar ao padrão</mark>
                                    </div>
                                </div>
                                @if($restaurant->custom_featured_name == null)
                                <script>
                                    $(function() {
                                        $('#customFeaturedBadgeBtn').click(function(event) {
                                            $(this).remove();
                                            $('#customFeaturedBadgeInput').removeClass('hidden');
                                        });
                                    });
                                </script>
                                @endif

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Aceitar pedidos automaticamente</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox checkbox-switchery mt-2">
                                            <label>
                                            <input value="true" type="checkbox" class="switchery-primary"
                                            @if($restaurant->auto_acceptable) checked="checked" @endif name="auto_acceptable">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Notificação de novos pedidos por SMS</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox checkbox-switchery mt-2">
                                            <label>
                                            <input value="true" type="checkbox" class="switchery-primary"
                                            @if($restaurant->is_notifiable) checked="checked" @endif name="is_notifiable">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Horário automático</label>
                                    <div class="col-lg-9">
                                        <div class="checkbox checkbox-switchery mt-2">
                                            <label>
                                            <input value="true" type="checkbox" class="switchery-primary"
                                            @if($restaurant->is_schedulable) checked="checked" @endif name="is_schedulable">
                                            </label>
                                        </div>
                                        Saiba mais sobre o horário de Programação Automática (Abertura / Fechamento)  <a href="https://manual.meuappon.com/configuracoes-essenciais/abertura-e-fechamento-de-lojas-automatica" target="_blank"> aqui</a>
                                    </div>
                                </div>
                                @if(\Nwidart\Modules\Facades\Module::find('OrderSchedule') && \Nwidart\Modules\Facades\Module::find('OrderSchedule')->isEnabled())
                                    @if($restaurant->is_schedulable)
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Agendamento de pedidos:<br>(Pedidos futuros)</label>
                                        <div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery mt-2">
                                                <label>
                                                <input value="true" type="checkbox" class="switchery-primary"
                                                @if($restaurant->accept_scheduled_orders) checked="checked" @endif name="accept_scheduled_orders">
                                                </label>
                                            </div>
                                            Habilitar isso permitirá que os clientes agendem seus pedidos para o futuro com base no horário de abertura / fechamento da loja.
                                        </div>
                                    </div>
                                    @else
                                    <mark>Para ativar a programação de pedidos (pedidos futuros), primeiro ative <b>Horário automático</b> e configurar o tempo de abertura / fechamento para esta loja.</mark>
                                    @endif
                                    @if($restaurant->is_schedulable && $restaurant->accept_scheduled_orders)
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Permitir que o pedido de hoje seja agendado após: <br> (em minutos)</label>
                                            <div class="col-lg-9">
                                                <input value="{{ $restaurant->schedule_slot_buffer }}" type="text" class="form-control form-control-lg schedule_slot_buffer" name="schedule_slot_buffer" placeholder="In Minutes">
                                                <mark>Máx. 1140 minutos (24 horas), 30 minutos por padrão se deixado em branco.</mark>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <div class="tab-pane fade" id="actionSettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Ações
                                </legend>
                                <div class="text-left">
                                    <div class="btn-group btn-group-justified" style="width: 300px">
                                        @if($restaurant->is_accepted)
                                        <a href="{{ route('admin.acceptRestaurant', $restaurant->id) }}"
                                            class="btn btn-danger btn-labeled btn-labeled-left mr-2" data-popup="tooltip"
                                            title="The restaurant won't show up on customer's screen" data-placement="bottom">
                                        <b><i class="icon-exclamation"></i></b>
                                        Desativar
                                        </a>
                                        @else
                                        <a href="{{ route('admin.acceptRestaurant', $restaurant->id) }}"
                                            class="btn btn-secondary btn-labeled btn-labeled-left mr-2" data-popup="tooltip"
                                            title="Restaurant is not Active, it won't show up on the customer screen" data-placement="bottom">
                                        <b><i class="icon-exclamation"></i></b>
                                        Ativar
                                        </a>
                                        @endif 
                                        @if($restaurant->is_active)
                                        <a href="{{ route('admin.disableRestaurant', $restaurant->id) }}"
                                            class="btn btn-danger btn-labeled btn-labeled-left mr-2" data-popup="tooltip"
                                            title="Users won't be able to place order from this Store if Disabled" data-placement="bottom">
                                        <b><i class="icon-switch2"></i></b>
                                        Fechar
                                        </a>
                                        @else
                                        <a href="{{ route('admin.disableRestaurant', $restaurant->id) }}"
                                            class="btn btn-secondary btn-labeled btn-labeled-left mr-2" data-popup="tooltip"
                                            title="Store is Disabled. Enable to accept orders." data-placement="bottom">
                                        <b><i class="icon-switch2"></i></b>
                                        Abrir
                                        </a>
                                        @endif 
                                    </div>
                                    <p class="mt-2 text-muted">A intervenção manual em Abrir / Fechar irá desabilitar o Horário Automático se estiver habilitado anteriormente.</p>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="paymentGatewaySettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Gateways de pagamento
                                </legend>

                                @if(count($restaurant->payment_gateways) == 0)
                                <p class="text-danger">
                                    <strong>Nenhum Gateway ativo</strong>
                                    <br>
                                    Os gateways de pagamento selecionados pelo administrador serão herdados.
                                </p>
                                @endif
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Selecionar Gateways de Pagamento</label>
                                    <div class="col-lg-8">
                                         <select multiple="multiple" class="form-control select" name="store_payment_gateways[]">
                                        @foreach($adminPaymentGateways as $adminPaymentGateway)
                                            <option value="{{ $adminPaymentGateway->id }}" class="text-capitalize" 
                                                {{ in_array($adminPaymentGateway->id, $restaurant->payment_gateways()->pluck('payment_gateway_id')->toArray()) ? 'selected' : '' }}>
                                                <!-- Chang ProPaymentOnDeliveryPro -->
                                                {{ (\Module::find("PaymentOnDeliveryPro") && \Module::find("PaymentOnDeliveryPro")->isEnabled()) 
                                                    ? $adminPaymentGateway->name . ' - ' . Lang::get('paymentondeliverypro::default.' . $adminPaymentGateway->description ) 
                                                    : $adminPaymentGateway->name }}
                                                <!-- ProPaymentOnDeliveryPro -->
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Módulo Cashback -->
                            @if(\Module::find("Cashback") && \Module::find("Cashback")->isEnabled())
                            <div class="tab-pane fade" id="cashbackSettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm"> 
                                    {{ Lang::get("cashback::default.cashback") }} 
                                    Settings
                                </legend>
                                <div class="text-left">
                                    <div class="form-group row"> 
                                        <label class="col-lg-3 col-form-label">
                                            {{ Lang::get("cashback::default.activate_cashback") }}
                                        </label><div class="col-lg-9">
                                            <div class="checkbox checkbox-switchery mt-2"> 
                                                <label> <input value="true" type="checkbox" class="switchery-primary" name="cashback_status"  @if($restaurant->cashback_status) checked="checked" @endif> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row"> 
                                        <label class="col-lg-3 col-form-label"> {{ Lang::get("cashback::default.cashback_amount") }} </label>
                                        <div class="col-lg-9"> 
                                            <input type="text" class="form-control form-control-lg" name="cashback_value" value="{{ $restaurant->cashback_value == "0.00" ?  $restaurant->cashback_percentage :  $restaurant->cashback_value }}" placeholder="0.00 / 0%"> 
                                            <span class="help-block">{{ Lang::get("cashback::default.cashback_helper") }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row"> 
                                        <label class="col-lg-3 col-form-label"> {{ @trans('cashback::default.Cash Back Limit Value') }} </label>
                                        <div class="col-lg-9"> 
                                            <input type="text" class="form-control form-control-lg" name="cashback_limit_value" value="{{ isset($restaurant->cashback_limit_value) && !empty($restaurant->cashback_limit_value) ? $restaurant->cashback_limit_value : 0 }}" placeholder="0.00"> 
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        @endif
                        <!-- Módulo Cashback END -->

                            <div class="tab-pane fade" id="commissionSettings">
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    Comissões
                                </legend>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Taxa de comissão %:</label>
                                    <div class="col-lg-9">
                                        <input value="{{ $restaurant->commission_rate }}" type="text" class="form-control form-control-lg commission_rate" name="commission_rate"
                                            placeholder="Comissão %" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right mt-5">
                        <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg btnUpdateStore">
                        <b><i class="icon-database-insert ml-1"></i></b>
                        Atualizar Loja
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>


<div class="content" id="payoutDetailsBlock">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.updateStorePayoutDetails') }}" method="POST">
                <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-coin-dollar mr-2"></i> Detalhes da conta de pagamento (todos os campos abaixo são opcionais)
                </legend>
                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Nome do Titular: </strong></label>
                    <div class="col-lg-9">
                         <input type="text" class="form-control form-control-lg" name="bankName" value="@if(!empty($payoutData->bankName)){{ $payoutData->bankName }}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Tipo de chave Pix (Ex.: CPF): </strong></label>
                    <div class="col-lg-9">
                         <input type="text" class="form-control form-control-lg" name="bankCode" value="@if(!empty($payoutData->bankCode)){{ $payoutData->bankCode }}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Chave Pix: </strong></label>
                    <div class="col-lg-9">
                         <input type="text" class="form-control form-control-lg" name="recipientName" value="@if(!empty($payoutData->recipientName)){{ $payoutData->recipientName }}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Agência: </strong></label>
                    <div class="col-lg-9">
                         <input type="text" class="form-control form-control-lg" name="accountNumber" value="@if(!empty($payoutData->accountNumber)){{ $payoutData->accountNumber }}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Conta Bancária: </strong></label>
                    <div class="col-lg-9">
                         <input type="text" class="form-control form-control-lg" name="paypalId" value="@if(!empty($payoutData->paypalId)){{ $payoutData->paypalId }}@endif">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-3 col-form-label"><strong>Observações: </strong></label>
                    <div class="col-lg-9">
                         <input type="text" class="form-control form-control-lg" name="upiID" value="@if(!empty($payoutData->upiID)){{ $payoutData->upiID }}@endif">
                    </div>
                </div>
                @csrf
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">
                    Atualizar
                    <i class="icon-database-insert ml-1"></i>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($restaurant->is_schedulable)
    <div class="content" id="autoSchedulingBlock">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.updateRestaurantScheduleData') }}" method="POST"
                        enctype="multipart/form-data">
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class="icon-alarm mr-2"></i> Horário da loja
                        </legend>
                        <div class="form-group row mb-0">
                            <div class="col-lg-4">
                                <h3>Segunda</h3>
                            </div>
                        </div>
                        <!-- Checks if there is any schedule data -->
                        @if(!empty($schedule_data->monday) && count($schedule_data->monday) > 0)
                        <!-- If yes Then Loop Each Data as Time SLots -->
                        @foreach($schedule_data->monday as $time)
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label class="col-form-label">Abre às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->open}}"
                                    name="monday[]" required>
                            </div>
                            <div class="col-lg-5">
                                <label class="col-form-label"></span>Fecha às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->close}}"
                                    name="monday[]" required>
                            </div>
                            <div class="col-lg-2" day="monday">
                                <label class="col-form-label text-center" style="width: 43px;"></span><i class="icon-circle-down2"></i></label><br>
                                <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Slot">
                                <i class="icon-cross2"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div id="monday" class="timeSlots">
                        </div>
                        <a href="javascript:void(0)" onclick="add(this)" data-day="monday" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"> <b><i class="icon-plus22"></i></b>Add Slot</a>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-lg-4">
                                <h3>Terça</h3>
                            </div>
                        </div>
                        <!-- Checks if there is any schedule data -->
                        @if(!empty($schedule_data->tuesday) && count($schedule_data->tuesday) > 0)
                        <!-- If yes Then Loop Each Data as Time SLots -->
                        @foreach($schedule_data->tuesday as $time)
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label class="col-form-label">Abre às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->open}}"
                                    name="tuesday[]" required>
                            </div>
                            <div class="col-lg-5">
                                <label class="col-form-label"></span>Fecha às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->close}}"
                                    name="tuesday[]" required>
                            </div>
                            <div class="col-lg-2" day="tuesday">
                                <label class="col-form-label text-center" style="width: 43px;"></span><i class="icon-circle-down2"></i></label><br>
                                <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Slot">
                                <i class="icon-cross2"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div id="tuesday" class="timeSlots">
                        </div>
                        <a href="javascript:void(0)" onclick="add(this)" data-day="tuesday" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"> <b><i class="icon-plus22"></i></b>Add Slot</a>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-lg-4">
                                <h3>Quarta</h3>
                            </div>
                        </div>
                        <!-- Checks if there is any schedule data -->
                        @if(!empty($schedule_data->wednesday) && count($schedule_data->wednesday) > 0)
                        <!-- If yes Then Loop Each Data as Time SLots -->
                        @foreach($schedule_data->wednesday as $time)
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label class="col-form-label">Abre às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->open}}"
                                    name="wednesday[]" required>
                            </div>
                            <div class="col-lg-5">
                                <label class="col-form-label"></span>Fecha às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->close}}"
                                    name="wednesday[]" required>
                            </div>
                            <div class="col-lg-2" day="wednesday">
                                <label class="col-form-label text-center" style="width: 43px;"></span><i class="icon-circle-down2"></i></label><br>
                                <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Slot">
                                <i class="icon-cross2"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div id="wednesday" class="timeSlots">
                        </div>
                        <a href="javascript:void(0)" onclick="add(this)" data-day="wednesday" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"> <b><i class="icon-plus22"></i></b>Add Slot</a>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-lg-4">
                                <h3>Quinta</h3>
                            </div>
                        </div>
                        <!-- Checks if there is any schedule data -->
                        @if(!empty($schedule_data->thursday) && count($schedule_data->thursday) > 0)
                        <!-- If yes Then Loop Each Data as Time SLots -->
                        @foreach($schedule_data->thursday as $time)
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label class="col-form-label">Abre às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->open}}"
                                    name="thursday[]" required>
                            </div>
                            <div class="col-lg-5">
                                <label class="col-form-label"></span>Fecha às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->close}}"
                                    name="thursday[]" required>
                            </div>
                            <div class="col-lg-2" day="thursday">
                                <label class="col-form-label text-center" style="width: 43px;"></span><i class="icon-circle-down2"></i></label><br>
                                <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Slot">
                                <i class="icon-cross2"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div id="thursday" class="timeSlots">
                        </div>
                        <a href="javascript:void(0)" onclick="add(this)" data-day="thursday" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"> <b><i class="icon-plus22"></i></b>Add Slot</a>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-lg-4">
                                <h3>Sexta</h3>
                            </div>
                        </div>
                        <!-- Checks if there is any schedule data -->
                        @if(!empty($schedule_data->friday) && count($schedule_data->friday) > 0)
                        <!-- If yes Then Loop Each Data as Time SLots -->
                        @foreach($schedule_data->friday as $time)
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label class="col-form-label">Abre às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->open}}"
                                    name="friday[]" required>
                            </div>
                            <div class="col-lg-5">
                                <label class="col-form-label"></span>Fecha às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->close}}"
                                    name="friday[]" required>
                            </div>
                            <div class="col-lg-2" day="friday">
                                <label class="col-form-label text-center" style="width: 43px;"></span><i class="icon-circle-down2"></i></label><br>
                                <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Slot">
                                <i class="icon-cross2"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif 
                        <div id="friday" class="timeSlots">
                        </div>
                        <a href="javascript:void(0)" onclick="add(this)" data-day="friday" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"> <b><i class="icon-plus22"></i></b>Add Slot</a>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-lg-4">
                                <h3>Sábado</h3>
                            </div>
                        </div>
                        <!-- Checks if there is any schedule data -->
                        @if(!empty($schedule_data->saturday) && count($schedule_data->saturday) > 0)
                        <!-- If yes Then Loop Each Data as Time SLots -->
                        @foreach($schedule_data->saturday as $time)
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label class="col-form-label">Abre às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->open}}"
                                    name="saturday[]" required>
                            </div>
                            <div class="col-lg-5">
                                <label class="col-form-label"></span>Fecha às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->close}}"
                                    name="saturday[]" required>
                            </div>
                            <div class="col-lg-2" day="saturday">
                                <label class="col-form-label text-center" style="width: 43px;"></span><i class="icon-circle-down2"></i></label><br>
                                <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Slot">
                                <i class="icon-cross2"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div id="saturday" class="timeSlots">
                        </div>
                        <a href="javascript:void(0)" onclick="add(this)" data-day="saturday" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"> <b><i class="icon-plus22"></i></b>Add Slot</a>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="col-lg-4">
                                <h3>Domingo</h3>
                            </div>
                        </div>
                        <!-- Checks if there is any schedule data -->
                        @if(!empty($schedule_data->sunday) && count($schedule_data->sunday) > 0)
                        <!-- If yes Then Loop Each Data as Time SLots -->
                        @foreach($schedule_data->sunday as $time)
                        <div class="form-group row">
                            <div class="col-lg-5">
                                <label class="col-form-label">Abre às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->open}}"
                                    name="sunday[]" required>
                            </div>
                            <div class="col-lg-5">
                                <label class="col-form-label"></span>Fecha às</label>
                                <input type="time" class="form-control form-control-lg" value="{{$time->close}}"
                                    name="sunday[]" required>
                            </div>
                            <div class="col-lg-2" day="sunday">
                                <label class="col-form-label text-center" style="width: 43px;"></span><i class="icon-circle-down2"></i></label><br>
                                <button class="remove btn btn-danger" data-popup="tooltip" data-placement="right" title="Remover Slot">
                                <i class="icon-cross2"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                        @endif
                        <div id="sunday" class="timeSlots">
                        </div>
                        <a href="javascript:void(0)" onclick="add(this)" data-day="sunday" class="btn btn-secondary btn-labeled btn-labeled-left mr-2"> <b><i class="icon-plus22"></i></b>Add Slot</a>
                        <hr>
                        <input type="text" name="restaurant_id" hidden value="{{$restaurant->id}}">
                        @csrf
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg" data-popup="tooltip" title="Certifique-se de que o horário de fechamento é sempre maior do que o horário de abertura para todas as entradas" data-placement="bottom">
                            <b><i class="icon-alarm ml-1"></i></b>
                            Atualizar Horário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

<script>

    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $('.slider-preview-image')
                    .removeClass('hidden')
                    .attr('src', e.target.result)
                    .width(160)
                   .height(117)
                   .css('borderRadius', '0.275rem');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function add(data) {
        var para = document.createElement("div");
        let day = data.getAttribute("data-day")
        para.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><label class='col-form-label'>Opening Time</label><input type='time' class='form-control form-control-lg' name='"+day+"[]' required> </div> <div class='col-lg-5'> <label class='col-form-label'>Closing Time</label><input type='time' class='form-control form-control-lg' name='"+day+"[]'  required> </div> <div class='col-lg-2'> <label class='col-form-label text-center' style='width: 43px'></span><i class='icon-circle-down2'></i></label><br><button class='remove btn btn-danger' data-popup='tooltip' data-placement='right' title='Remove Time Slot'><i class='icon-cross2'></i></button></div></div>";
        document.getElementById(day).appendChild(para);
    }
    
    $(function () {
        
        $('input[name=store_url]').keyup(function(event) {
            let slug = $(this).val();
            slug = slug.toLowerCase();
            slug = slug.replace(/[^a-zA-Z0-9]+/g,'-');
            $(this).val(slug);
            $('#storeURL').html(slug);
        });

        $('body').tooltip({
            selector: 'button'
        });
        
        $(document).on("click", ".remove", function() {
            $(this).tooltip('hide')
            $(this).parent().parent().remove();
        });
    
        $('.select').select2({
            minimumResultsForSearch: Infinity,
        });
        
        $('.selectRestaurantCategory').select2({
            closeOnSelect: false
        })
    
      if (Array.prototype.forEach) {
               var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-primary'));
               elems.forEach(function(html) {
                   var switchery = new Switchery(html, { color: '#2196F3' });
               });
           }
           else {
               var elems = document.querySelectorAll('.switchery-primary');
               for (var i = 0; i < elems.length; i++) {
                   var switchery = new Switchery(elems[i], { color: '#2196F3' });
               }
           }
    
       $('.form-control-uniform').uniform();
    
       $('.rating').numeric({allowThouSep:false,  min: 1, max: 5, maxDecimalPlaces: 1 });
       $('.delivery_time').numeric({allowThouSep:false});
       $('.price_range').numeric({allowThouSep:false});
       $('.latitude').numeric({allowThouSep:false});
       $('.longitude').numeric({allowThouSep:false});
       $('.restaurant_charges').numeric({ allowThouSep:false, maxDecimalPlaces: 2 });
       $('.delivery_charges').numeric({ allowThouSep:false, maxDecimalPlaces: 2 });
       $('.commission_rate').numeric({ allowThouSep:false, maxDecimalPlaces: 2, max: 100 });
    
       $('.base_delivery_charge').numeric({ allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });
        $('.base_delivery_distance').numeric({ allowThouSep:false, maxDecimalPlaces: 0, allowMinus: false });
        $('.extra_delivery_charge').numeric({ allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });
        $('.extra_delivery_distance').numeric({ allowThouSep:false, maxDecimalPlaces: 0, allowMinus: false });
        
        $('.min_order_price').numeric({ allowThouSep:false, maxDecimalPlaces: 2, allowMinus: false });

        $('.schedule_slot_buffer').numeric({ allowThouSep:false, maxDecimalPlaces: 0, allowMinus: false, max: 1440 });
        
    
        @if($restaurant->delivery_charge_type == "FIXED")
            $('#dynamicChargeDiv').addClass('hidden');
        @else
            $('#deliveryCharge').addClass('hidden');
        @endif
       
        $("[name='delivery_charge_type']").change(function(event) {
             if ($(this).val() == "FIXED") {
                 $('#dynamicChargeDiv').addClass('hidden');
                 $('#deliveryCharge').removeClass('hidden')
             } else {
                 $('#deliveryCharge').addClass('hidden');
                 $('#dynamicChargeDiv').removeClass('hidden')
             }
         });

        $('#schedulingSettings').click(function(event) {
            var targetOffset = $('#autoSchedulingBlock').offset().top - 70;
            $('html, body').animate({scrollTop: targetOffset}, 500);
        });

        $('#payoutDetails').click(function(event) {
            var targetOffset = $('#payoutDetailsBlock').offset().top - 70;
            $('html, body').animate({scrollTop: targetOffset}, 500);
        });
   

        $('.summernote-editor').summernote({
           height: 200,
           popover: {
               image: [],
               link: [],
               air: []
             }
        });

        /* Navigate with hash */
        var hash = window.location.hash;
        $("[name='window_redirect_hash']").val(hash);
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
        $('.nav-pills a').click(function (e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop();
            window.location.hash = this.hash;
            $("[name='window_redirect_hash']").val(this.hash);
            $('html, body').scrollTop(scrollmem);
        });

        $('.btnUpdateStore').click(function () {
            $('input:invalid').each(function () {
                // Find the tab-pane that this element is inside, and get the id
                var $closest = $(this).closest('.tab-pane');
                var id = $closest.attr('id');

                // Find the link that corresponds to the pane and have it show
                $('ul.nav a[href="#' + id + '"]').tab('show');

                var hash = '#'+id;
                window.location.hash = hash;
                $("[name='window_redirect_hash']").val(hash);

                return false;
            });
        });

     });
</script>
@endsection