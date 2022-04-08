@extends('admin.layouts.master')
@section("title") Nova Categoria de Adicionais - Dashboard
@endsection
@section('content')
<div class="page-header">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Adicionar</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>
<div class="content">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.saveNewAddonCategory') }}" method="POST" enctype="multipart/form-data" enctype="multipart/form-data">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-tree6 mr-2"></i> Nova categoria
                    </legend>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Nome:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="name"
                                placeholder="Nome da categoria" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Type:</label>
                        <div class="col-lg-9">
                            <select name="type" class="form-control form-control-lg select">
                                <option value="SINGLE"> Seleção Única  </option>
                                <option value="MULTI"> Seleção Múltipla </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label">Descrição:</label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control form-control-lg" name="description"
                                placeholder="Short Description (50-80 characters)" >
                                <span class="help-text text-muted"> Importante para conseguir indentificar a categoria no futuro</span>
                        </div>
                    </div>

                    <!--Módulo Complementos PRO -->
                    @if (\Module::find("AddonsPro") && \Module::find("AddonsPro")->isEnabled())
                        <div id="_min_and_max" style="display: none">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Minimo:</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control form-control-lg" name="minimum_qty" placeholder="Seleção mínima" value=""  min="0" max="999">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Máximo:</label>
                                <div class="col-lg-9">
                                    <input type="number" class="form-control form-control-lg" name="maximum_qty" placeholder="Seleção máxima" value="" min="1" max="999">
                                </div>
                            </div>
                        </div>
                        <div id="_required_option" class="checkbox checkbox-switchery ml-1 row" style="padding-top: 0.8rem;display:none;">
                            <label class="col-lg-3 col-form-label">Seleção obrigatória:</label>
                            <label class="col-lg-9">
                                <input name="add_required" value="true" type="checkbox" class="action-switch" checked="checked" data-id="">
                            </label>
                        </div>
                    @endif
                    <!-- Módulo Complementos PRO END -->

                    <div id="addon" class="mt-4">
                        <legend class="font-weight-semibold text-uppercase font-size-sm hidden" id="addonsLegend">
                            <i class="icon-list2 mr-2"></i> Adicionais
                        </legend>
                    </div>

                    <a href="javascript:void(0)" onclick="add(this)" class="btn btn-secondary btn-labeled btn-labeled-left mt-3"> <b><i class="icon-plus22"></i></b>Add adicional</a>
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


<!-- Módulo Complementos PRO -->
@if (\Module::find("AddonsPro") && \Module::find("AddonsPro")->isEnabled()) 
    @php include(base_path('Modules/AddonsPro/includes/javascript/new-addon-category.php')) @endphp
@endif 
<!-- Módulo Complementos PRO END -->

<script>
     $('body').tooltip({selector: '[data-popup="tooltip"]'});
     function add(data) {
        $('#addonsLegend').removeClass('hidden');
        var newAddon = document.createElement("div");
        newAddon.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><input type='text' class='form-control  form-control-lg' placeholder='Addon Name' name='addon_names[]' required> </div> <div class='col-lg-5'> <input type='text' class='form-control  form-control-lg' name='addon_prices[]' placeholder='Addon Price'  required> </div> <div class='col-lg-2'><button class='remove btn btn-danger' data-popup='tooltip' data-placement='right' title='Remove Addon'><i class='icon-cross2'></i></button></div></div>";
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