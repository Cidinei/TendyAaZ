@extends('admin.layouts.master')
@section('content')
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">Módulo</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Complementos Pro</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements d-none py-0 mb-3 mb-md-0">
            <div class="breadcrumb">

            </div>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><strong>Campos de complemento de banco de dados</strong></td>
                                <td>Verifique se novos campos foram adicionados</td>
                                <td class="text-center">
                                    @if($new_fields)
                                        <span class="badge badge-success border-grey-800 text-white text-capitalize" style="min-width: 100px;"><i class="icon-database-check mr-1"></i> Configurado </span>
                                    @else
                                        <span class="badge badge-flat border-grey-800 text-default text-capitalize" style="min-width: 100px;"><i class="icon-database-remove mr-1"></i> Não configurado </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Traduções</strong></td>
                                <td>Acesse o menu Configurações> Traduções> Editar e traduzir o módulo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @isset($version)
                <div class="card-footer">
                    <div class="version">
                        v{{ $version }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>

    </script>
@endsection
