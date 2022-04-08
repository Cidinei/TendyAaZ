@extends('admin.layouts.master')
@section('content')
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">Module</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">Store Dashboard Pro</span>
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
                                <td><strong>Translations</strong></td>
                                <td>The translations are performed in the file Modules > StoreDashBoardPro > Resouces > lang > en > default.php</td>
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

