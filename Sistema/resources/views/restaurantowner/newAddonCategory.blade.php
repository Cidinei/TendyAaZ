@extends('admin.layouts.master')
@section("title") {{__('storeDashboard.addonCategoryPageTitle')}}
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
           {{--  <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Add</span>
            </h4> --}}
            {{-- <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a> --}}
        </div>
    </div>
</div>
<div class="content">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('restaurant.saveNewAddonCategory') }}" method="POST" enctype="multipart/form-data" enctype="multipart/form-data">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-tree6 mr-2"></i>{{__('storeDashboard.addonCategoryBlockTitle')}}
                    </legend>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>{{__('storeDashboard.newAddonCategoryNameLabel')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="name"
                                placeholder="Addon Category Name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>{{__('storeDashboard.newAddonCategoryTypeLabel')}}</label>
                        <div class="col-lg-9">
                            <select name="type" class="form-control form-control-lg select">
                                <option value="SINGLE"> Single Selection  </option>
                                <option value="MULTI"> Multiple Selection </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">{{__('storeDashboard.newAddonCategoryDescriptionLabel')}}</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="description"
                                placeholder="{{__('storeDashboard.newAddonCategoryDescriptionPlaceholder')}}">
                                <span class="help-text text-muted">{{__('storeDashboard.newAddonCategoryDescriptionSubTitle')}}</span>
                        </div>
                    </div>

                    <!-- FoodomaProAddonsPro -->
                    @if (\Module::find("AddonsPro") && \Module::find("AddonsPro")->isEnabled()) 
                        <div id="_min_and_max" style="display: none">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Minimum Qty:</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control form-control-lg" name="minimum_qty" placeholder="" value=""  min="1" max="999">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Maximum Qty:</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control form-control-lg" name="maximum_qty" placeholder="" value="" min="1" max="999">
                                </div>
                            </div>
                        </div>
                        <div id="_required_option" class="checkbox checkbox-switchery ml-1 row" style="padding-top: 0.8rem;display:none;">
                            <label class="col-lg-3 col-form-label">Required Selection:</label>
                            <label class="col-lg-9">
                                <input name="add_required" value="true" type="checkbox" class="action-switch" checked="checked" data-id="">
                            </label>
                        </div>
                    @endif 
                    <!-- endFoodomaProAddonsPro -->

                    <div id="addon" class="mt-4">
                        <legend class="font-weight-semibold text-uppercase font-size-sm hidden" id="addonsLegend">
                            <i class="icon-list2 mr-2"></i> {{ __('storeDashboard.newAddonCategoryAddonsBlockTitle') }}
                        </legend>
                    </div>

                    <a href="javascript:void(0)" onclick="add(this)" class="btn btn-secondary btn-labeled btn-labeled-left mt-3"> <b><i class="icon-plus22"></i></b>{{__('storeDashboard.newAddonCategoryAddAddonButton')}}</a>
                    @csrf
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                        SAVE
                        <i class="icon-database-insert ml-1"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FoodomaProAddonsPro -->
@if (\Module::find("AddonsPro") && \Module::find("AddonsPro")->isEnabled()) 
    @php include(base_path('Modules/AddonsPro/includes/javascript/new-addon-category.php')) @endphp
@endif 
<!-- endFoodomaProAddonsPro -->

<script>
    $('body').tooltip({selector: '[data-popup="tooltip"]'});
    var addonNamePlaceholder = "{{ __('storeDashboard.newAddonCategoryAddonPlaceholderName') }}";
    var addonPricePlaceholder = "{{ __('storeDashboard.newAddonCategoryAddonPlaceholderPrice') }}";
    var addonRemoveTitle = "{{ __('storeDashboard.newAddonCategoryAddonRemove') }}";

    function add(data) {
        $('#addonsLegend').removeClass('hidden');
        var newAddon = document.createElement("div");
        newAddon.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><input type='text' class='form-control  form-control-lg' placeholder='"+addonNamePlaceholder+"' name='addon_names[]' required> </div> <div class='col-lg-5'> <input type='text' class='form-control  form-control-lg' name='addon_prices[]' placeholder='"+addonPricePlaceholder+"'  required> </div> <div class='col-lg-2'><button class='remove btn btn-danger' data-popup='tooltip' data-placement='right' title='"+addonRemoveTitle+"'><i class='icon-cross2'></i></button></div></div>";
        document.getElementById('addon').appendChild(newAddon);
    }

    $(function() {
        $('.select').select2({
            minimumResultsForSearch: -1,
        });

        $(document).on("click", ".remove", function() {
            $(this).tooltip('hide')
            $(this).parent().parent().remove();
        });
    });   
</script>

@endsection