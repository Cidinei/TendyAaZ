<style>
.extra-menu{min-width:500px}@media (min-width:320px) and (max-width:767px){.extra-menu{min-width:auto}}

.navbar-dark {
    color: rgba(255,255,255,.9);
    background: linear-gradient(to left,#00C250, #008E3C);
    border-bottom-color: rgba(255,255,255,.1);
}
.btn-primary {
    color: #fff;
    background-color: #008E3C;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #00C250;
}
</style>
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand wmin-0 mr-5">

        @can("dashboard_view")
        <a href="{{ route('admin.dashboard') }}" class="d-inline-block">
        <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/dashboard-logo.png" alt="Dashboard">
        </a>
        @else
        @role("Store Owner")
        @else
        <a href="{{ route('admin.manager') }}" class="d-inline-block">
        <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/dashboard-logo.png" alt="Dashboard">
        </a>
        @endrole
        @endcan

        @role("Store Owner")
        <a href="{{ route('restaurant.dashboard') }}" class="d-inline-block">
        <img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}/assets/backend/global_assets/images/dashboard-logo.png" alt="Dashboard">
        </a>
        @endrole
    </div>
    <div class="d-md-none">
        <button class="navbar-toggler dropdown-toggle" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <span>{{ Auth::user()->name }}</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right" id="navbar-mobile">
            @role("Store Owner")
                <a href="#" class="dropdown-item dropdown-toggle" data-toggle="dropdown">
                <span><i class="icon-earth"></i></span>
                </a>
                <div class="dropdown-menu">
                    @foreach($translationLangs as $lang)
                    <a href="{{ url('locale', $lang) }}" class="dropdown-item @if(app()->getLocale() === $lang) active @endif" style="text-transform: uppercase;"> {{ $lang }}</a>
                    @endforeach
                </div>
            <a href="{{ route('restaurant.zenMode', "true") }}" class="dropdown-item"><i class="icon-power3"></i>{{ __('storeDashboard.zenMode') }}</a>
            @endrole
            <a href="{{ route('logout') }}" class="dropdown-item"><i class="icon-switch2"></i> {{ __('storeDashboard.navLogout') }}</a>
        </div>
    </div>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            @role("Store Owner")
                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <span><i class="icon-earth mx-2"></i></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach($translationLangs as $lang)
                        <a href="{{ url('locale', $lang) }}" class="dropdown-item @if(app()->getLocale() === $lang) active @endif" style="text-transform: uppercase;"> {{ $lang }}</a>
                        @endforeach
                    </div>
                </li>
            @endrole
            
            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                <span>{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @role("Store Owner")
                    <a href="{{ route('restaurant.zenMode', "true") }}" class="dropdown-item"><i class="icon-power3"></i>{{ __('storeDashboard.zenMode') }}</a>
                    @endrole
                    <a href="{{ route('logout') }}" class="dropdown-item"><i class="icon-switch2"></i> {{ __('storeDashboard.navLogout') }}</a>
                </div>
            </li>
            
            @role("Store Owner")
                @impersonating
                    <li class="nav-item">
                        <a class="navbar-nav-link active" href="{{ route('impersonate.leave') }}"><i class="icon-arrow-left15 mr-1"></i>Voltar para Admin</a>
                    </li>
                @endImpersonating
            @endrole
        </ul>
    </div>
</div>
<div class="navbar navbar-expand-md navbar-light navbar-sticky">
    <div class="container">
        <div class="text-center d-md-none w-100">
            <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-navigation">
            <i class="icon-unfold mr-2"></i>
            Menu
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-navigation">
            <ul class="navbar-nav">

                @can("stores_view")
                <li class="nav-item">
                    <a href="{{ route("admin.restaurants") }}" class="navbar-nav-link {{ Request::is('admin/stores') ? 'active' : '' }}">
                    <i class="icon-store2 mr-2"></i>
                    Lojas
                    </a>
                </li>
                @endcan

                @canany(['addon_categories_view', 'addons_view', 'menu_categories_view', 'items_view'])
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle {{ Request::is('admin/items')  || Request::is('admin/addons') ? 'active' : '' }}" data-toggle="dropdown">
                        <i class="icon-stack-star mr-2"></i>
                        Itens & Menu
                        </a>
                        <div class="dropdown-menu">
                            @can("addon_categories_view")
                            <a href="{{ route("admin.addonCategories") }}" class="dropdown-item {{ Request::is('admin/addoncategories') ? 'active' : '' }}">
                            <i class="icon-tree6 mr-2"></i>
                            Categoria de Adicionais
                            </a>
                            @endcan

                            @can("addons_view")
                            <a href="{{ route("admin.addons") }}" class="dropdown-item {{ Request::is('admin/addons') ? 'active' : '' }}">
                            <i class="icon-list2 mr-2"></i>
                            Adicionais
                            </a>
                            @endcan

                            @can("menu_categories_view")
                            <a href="{{ route("admin.itemcategories") }}" class="dropdown-item {{ Request::is('admin/itemcategories') ? 'active' : '' }}">
                            <i class="icon-grid52 mr-2"></i>
                            Categoria de Produtos
                            </a>
                            @endcan

                            @can("items_view")
                            <a href="{{ route("admin.items") }}" class="dropdown-item {{ Request::is('admin/items') ? 'active' : '' }}">
                            <i class="icon-grid mr-2"></i>
                            Produtos
                            </a>
                            @endcan
                        </div>
                    </li>
                @endcanany

                @canany(['all_users_view', 'delivery_guys_view', 'store_owners_view'])
                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/users') || Request::is('admin/manage-delivery-guys') ? 'active' : '' }}" data-toggle="dropdown">
                        <i class="icon-users2 mr-2"></i>
                        Usuários
                        </a>
                        
                        <div class="dropdown-menu">
                            @can('all_users_view')
                            <a href="{{ route("admin.users") }}" class="dropdown-item {{ Request::is('admin/users') ? 'active' : ''}}"> <i class="icon-users4 mr-2"></i> Todos os usuários</a>
                            @endcan

                            @can('store_owners_view')
                            <a href="{{ route('admin.manageRestaurantOwners') }}" class="dropdown-item {{ Request::is('admin/manage-store-owners') ? 'active' : ''}}"> <i class="icon-user-tie mr-2"></i> Proprietários de lojas</a>
                            @endcan

                            @can('delivery_guys_view')
                            <a href="{{ route('admin.manageDeliveryGuys') }}" class="dropdown-item {{ Request::is('admin/manage-delivery-guys') ? 'active' : ''}}"> <i class="icon-truck mr-2"></i> Entregadores</a> 
                            @endcan
                        </div>
                    </li>
                    @endcanany

                    @can('reports_view')
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/sliders') || Request::is('admin/coupons') || Request::is('admin/notifications') ? 'active' : '' }}" data-toggle="dropdown">
                                <i class="icon-file-text mr-2"></i>
                                Relatórios
                            </a>
                            <div class="dropdown-menu">
                                <div class="row extra-menu">
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.customerPerformance') }}" class="dropdown-item {{ Request::is('reports/customer-performance-report') ? 'active' : '' }}">
                                            <i class="icon-rocket mr-2"></i>
                                            Desempenho do cliente
                                        </a>
                                        <a href="{{ route('admin.storeperformance') }}" class="dropdown-item {{ Request::is('reports/store-performance-report') ? 'active' : '' }}">
                                            <i class="icon-rocket mr-2"></i>
                                            Desempenho da loja
                                        </a>
                                        <a href="{{ route('admin.storeWiseOrderReport') }}" class="dropdown-item {{ Request::is('reports/store-wise-order-report') ? 'active' : '' }}">
                                            <i class="icon-store2 mr-2"></i>
                                            Pedidos da loja
                                        </a>
                                        <a href="{{ route('admin.deliveryEarningsReport') }}" class="dropdown-item {{ Request::is('reports/delivery-earnings-report') ? 'active' : '' }}">
                                            <i class="icon-truck mr-2"></i>
                                            Ganhos do entregador
                                        </a>
                                        <a href="{{ route('admin.orderWiseTaxReport') }}" class="dropdown-item {{ Request::is('reports/order-wise-tax-report') ? 'active' : '' }}">
                                            <i class="icon-hammer2 mr-2"></i>
                                            Impostos sobre pedidos
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.storeBalanceReport') }}" class="dropdown-item {{ Request::is('reports/store-balance-report') ? 'active' : '' }}">
                                            <i class="icon-coin-dollar mr-2"></i>
                                            Saldo da loja
                                        </a>
                                        <a href="{{ route('admin.paymentReport') }}" class="dropdown-item {{ Request::is('reports/order-payment-report') ? 'active' : '' }}">
                                            <i class="icon-coin-dollar mr-2"></i>
                                            Métodos de pagamentos de pedidos
                                        </a>
                                        <a href="{{ route('admin.adminEarningsReport') }}" class="dropdown-item {{ Request::is('reports/admin-earnings-report') ? 'active' : '' }}">
                                            <i class="icon-coin-dollar mr-2"></i>
                                            Ganhos do administrador
                                        </a>
                                        <!-- FoodomaProCashback -->
                                    @if(\Module::find("Cashback") && \Module::find("Cashback")->isEnabled())
                                        <a href="{{ url("admin/cashback/reports") }}" class="dropdown-item {{ Request::is('admin/cashback/reports') ? 'active' : '' }}"> 
                                        <i class="icon-coin-dollar mr-2"></i>
                                        Cashback {{ @trans('cashback::default.reports') }} 
                                        </a>
                                    @endif
                                    <!-- endFoodomaProCashback --> 
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endcan

                    @can('order_view')
                    <li class="nav-item">
                        <a href="{{ route("admin.orders") }}" class="navbar-nav-link {{ Request::is('admin/orders') ? 'active' : '' }}">
                        <i class="icon-basket mr-2"></i>
                        Pedidos
                        </a>
                    </li>
                    @endcan

                    @canany(['promo_sliders_manage', 'store_category_sliders_manage', 'coupons_manage', 'pages_manage', 'popular_location_manage', 'send_notification_manage', 'store_payouts_manage', 'translations_manage', 'delivery_collection_manage', 'delivery_collection_logs_view', 'wallet_transactions_view', 'reports_view'])

                    <li class="nav-item dropdown">
                        <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/sliders') || Request::is('admin/coupons') || Request::is('admin/notifications') ? 'active' : '' }}" data-toggle="dropdown">
                        <i class="icon-strategy mr-2"></i>
                        Extras
                        </a>
                        <div class="dropdown-menu">
                            <div class="row extra-menu">
                                <div class="col-md-6">
                                    @can('promo_sliders_manage')
                                    <a href="{{ route('admin.sliders') }}" class="dropdown-item {{ Request::is('admin/sliders') ? 'active' : '' }}">
                                    <i class="icon-image2 mr-2"></i>
                                    Banners
                                    </a>
                                    @endcan

                                    @can('store_category_sliders_manage')
                                     <a href="{{ route("admin.restaurantCategorySlider") }}" class="dropdown-item {{ Request::is('admin/store-category-slider') ? 'active' : '' }}">
                                    <i class="icon-grid52 mr-2"></i>
                                    Slide de categoria de loja
                                    </a>
                                    @endcan
                                    @can('coupons_manage')
                                    <a href="{{ route('admin.coupons') }}" class="dropdown-item {{ Request::is('admin/coupons') ? 'active' : '' }}">
                                    <i class="icon-price-tags2 mr-2"></i>
                                    Cupons
                                    </a>
                                    @endcan
                                    @can('pages_manage')
                                    <a href="{{ route('admin.pages') }}" class="dropdown-item {{ Request::is('admin/pages') ? 'active' : '' }}">
                                    <i class="icon-files-empty mr-2"></i>
                                    Páginas
                                    </a>
                                    @endcan
                                    @can('popular_location_manage')
                                    <a href="{{ route("admin.popularGeoLocations") }}" class="dropdown-item {{ Request::is('admin/popular-geo-locations') ? 'active' : '' }}">
                                    <i class="icon-location3 mr-2"></i>
                                    Localizações populares
                                    </a>
                                    @endcan
                                    @can('send_notification_manage')
                                    <a href="{{ route('admin.notifications') }}" class="dropdown-item {{ Request::is('admin/notifications') ? 'active' : '' }}">
                                    <i class="icon-bubble-dots4 mr-2"></i>
                                    Enviar notificações push
                                    </a>
                                    @endcan
                                    @role('Admin')
                                    <a href="{{ route("admin.modules") }}" class="dropdown-item {{ Request::is('admin/modules') ? 'active' : '' }}">
                                        <i class="icon-stars mr-2"></i>
                                        Módulos Especiais <span class="badge badge-flat border-grey-800 text-danger text-capitalize ml-1 float-right">EXTRA</span>
                                    </a>
                                    @endrole

                                </div>
                                <div class="col-md-6">

                                    @can('store_payouts_manage')
                                    <a href="{{ route('admin.restaurantpayouts') }}" class="dropdown-item {{ Request::is('admin/store-payouts') ? 'active' : '' }}">
                                    <i class="icon-piggy-bank mr-2"></i>
                                    Pagamentos de lojas
                                    </a>
                                    @endcan
                                    @can('translations_manage')
                                    <a href="{{ route("admin.translations") }}" class="dropdown-item {{ Request::is('admin/translations') ? 'active' : '' }}">
                                    <i class="icon-font-size2 mr-2"></i>
                                    Personalizar traduções
                                    </a>
                                    @endcan
                                    @can('delivery_collection_manage')
                                    <a href="{{ route("admin.deliveryCollections") }}" class="dropdown-item {{ Request::is('admin/delivery-collections') ? 'active' : '' }}">
                                    <i class="icon-cash3 mr-2"></i>
                                    Coleta de Entregadores
                                    </a>
                                    @endcan
                                    @can('delivery_collection_logs_view')
                                    <a href="{{ route("admin.deliveryCollectionLogs") }}" class="dropdown-item {{ Request::is('admin/delivery-collection-logs') ? 'active' : '' }}">
                                    <i class="icon-database-time2 mr-2"></i>
                                    Log de coletas de Entregadores
                                    </a>
                                    @endcan
                                    @can('wallet_transactions_view')
                                    <a href="{{ route("admin.walletTransactions") }}" class="dropdown-item {{ Request::is('admin/wallet/transactions') ? 'active' : '' }}">
                                    <i class="icon-transmission mr-2"></i>
                                    Transações na carteira
                                    </a>
                                    @endcan

                                    @can('reports_view')
                                    <a href="{{ route("admin.viewTopItems") }}" class="dropdown-item {{ Request::is('admin/reports/top-items') ? 'active' : '' }}">
                                    <i class="icon-graph mr-2"></i>
                                    Relatórios Gerais
                                    </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </li>
                    @endcanany

                    @can('settings_manage')
                    <ul class="navbar-nav ml-md-auto">
                        <li class="nav-item">
                            <a href="{{ route('admin.settings') }}" class="navbar-nav-link {{ Request::is('admin/settings') ? 'active' : '' }}" data-popup="tooltip" title="Todas as Configurações" data-placement="bottom">
                            <i class="icon-cog3 mr-2"></i>
                            Configurações
                            </a>
                        </li>
                    </ul>
                    @endcan
                
                @role("Store Owner")
                <li class="nav-item">
                    <a href="{{ route("restaurant.dashboard") }}" class="navbar-nav-link {{ Request::is('/dashboard') ? 'active' : '' }}">
                    <i class="icon-meter-fast mr-2"></i>
                    {{__('storeDashboard.navDashboard')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("restaurant.restaurants") }}" class="navbar-nav-link {{ Request::is('restaurant-owner/restaurants') ? 'active' : '' }}">
                    <i class="icon-store2 mr-2"></i>
                    {{__('storeDashboard.navStores')}}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle {{ Request::is('restaurant-owner/items')  || Request::is('restaurant-owner/addons') ? 'active' : '' }}" data-toggle="dropdown">
                    <i class="icon-stack-star mr-2"></i>
                    {{__('storeDashboard.navItemsMenu')}}
                    </a>
                    <div class="dropdown-menu">
                    <a href="{{ route("restaurant.addonCategories") }}" class="dropdown-item {{ Request::is('restaurant-owner/addoncategories') ? 'active' : '' }}">
                    <i class="icon-tree6 mr-2"></i>
                    {{__('storeDashboard.navSubAddonCat')}}
                    </a>
                    <a href="{{ route("restaurant.addons") }}" class="dropdown-item {{ Request::is('restaurant-owner/addons') ? 'active' : '' }}">
                    <i class="icon-list2 mr-2"></i>
                    {{__('storeDashboard.navSubAddon')}}
                    </a>
                    <a href="{{ route("restaurant.itemcategories") }}" class="dropdown-item {{ Request::is('restaurant-owner/itemcategories') ? 'active' : '' }}">
                    <i class="icon-grid52 mr-2"></i>
                    {{__('storeDashboard.navSubMenuCat')}}
                    </a>
                    <a href="{{ route("restaurant.items") }}" class="dropdown-item {{ Request::is('restaurant-owner/items') ? 'active' : '' }}">
                    <i class="icon-grid mr-2"></i>
                    {{__('storeDashboard.navSubItems')}}
                    </a>
                     </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route("restaurant.orders") }}" class="navbar-nav-link {{ Request::is('restaurant-owner/orders') ? 'active' : '' }}">
                    <i class="icon-basket mr-2"></i>
                    {{__('storeDashboard.navOrders')}}
                    </a>
                </li>

                
                <li class="nav-item">
                    <a href="{{ route("restaurant.earnings") }}" class="navbar-nav-link {{ Request::is('restaurant-owner/earnings/*') ? 'active' : '' }}">
                    <i class="icon-coin-dollar mr-2"></i>
                    {{__('storeDashboard.navEarnings')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("restaurant.ratings") }}" class="navbar-nav-link {{ Request::is('restaurant-owner/ratings/*') ? 'active' : '' }}">
                    <i class="icon-star-full2 mr-2"></i>
                    {{__('storeDashboard.navRatings')}}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="navbar-nav-link dropdown-toggle  {{ Request::is('admin/sliders') || Request::is('admin/coupons') || Request::is('admin/notifications') ? 'active' : '' }}" data-toggle="dropdown">
                        <i class="icon-file-text mr-2"></i>
                        Relatórios
                    </a>
                    <div class="dropdown-menu">
                        <div class="row extra-menu">
                            <div class="col-md-6">
                                <a href="{{ route('restaurant.storeperformance') }}" class="dropdown-item {{ Request::is('reports/store-performance') ? 'active' : '' }}">
                                    <i class="icon-rocket mr-2"></i>
                                    Relatório de desempenho da loja
                                </a>
                                <a href="{{ route('restaurant.storeWiseOrderReport') }}" class="dropdown-item {{ Request::is('reports/store-performancereports/order-report') ? 'active' : '' }}">
                                    <i class="icon-store2 mr-2"></i>
                                    Relatório de pedido da loja
                                </a>
                                <a href="{{ route('restaurant.viewTopItems') }}" class="dropdown-item {{ Request::is('reports/top-restaurant-items') ? 'active' : '' }}">
                                <i class="icon-stack-star mr-2"></i>
                                Itens mais vendidos
                                </a>
                    <a href="{{ url("store-owner/cashback/reports") }}" class="navbar-nav-link {{ Request::is('store-owner/cashback/reports') ? 'active' : '' }}"> 
                    <i class="icon-coin-dollar mr-2"></i> 
                    {{ @trans('cashback::default.reports') }} 
                    </a>

                @if(\Nwidart\Modules\Facades\Module::find('CallAndOrder') && \Nwidart\Modules\Facades\Module::find('CallAndOrder')->isEnabled())
                @can("login_as_customer")
                <li class="nav-item">
                    <a href="{{ route("cao.usersPage") }}" class="navbar-nav-link {{ Request::is('callandorder/users') ? 'active' : '' }}">
                    <i class="icon-phone2 mr-2"></i>
                    {{__('callAndOrderLang.callAndOrderNavMenuLabel')}}
                    </a>
                </li>
                @endcan
                @endif
                @if(\Nwidart\Modules\Facades\Module::find('ThermalPrinter') && \Nwidart\Modules\Facades\Module::find('ThermalPrinter')->isEnabled())
                <li class="nav-item">
                    <a href="{{ route("thermalprinter.settings") }}" class="navbar-nav-link {{ Request::is('thermalprinter/settings') ? 'active' : '' }}">
                    <i class="icon-printer2 mr-2"></i>
                    {{__('thermalPrinterLang.printerSettingsNav')}}
                    </a>
                </li>
                @endif
                @endrole
            </ul>
        </div>
    </div>
</div>