@extends('admin.layouts.master')
@section('content')
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">{{ @trans('cashback::default.modules') }}</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ @trans('cashback::default.settings') }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('cashback.settings.store') }}" method="POST">
                    @csrf
                    {{ method_field('POST') }}
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><strong>{{ @trans('cashback::default.Cashback options in-Store') }}: </strong> </label>
                        <div class="col-lg-9">
                            <div class="checkbox checkbox-switchery mt-2">
                                <label>
                                    <input value="true" type="checkbox" class="switchery-primary" @if(isset($setting->restaurant_edit) && $setting->restaurant_edit == 1) checked="checked" @endif name="restaurant_edit">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-3 col-form-label"><strong>{{ @trans('cashback::default.Cashback on the total order amount') }}: </strong> </label>
                        <div class="col-lg-9">
                            <div class="checkbox checkbox-switchery mt-2">
                                <label>
                                    <input value="true" type="checkbox" class="switchery-primary" @if(isset($setting->sum_total_amount) && $setting->sum_total_amount == 1) checked="checked" @endif name="sum_total_amount">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-right mt-3">
                            <button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg pull-right">
                                <b><i class="icon-database-insert ml-1"></i></b>
                                {{ @trans('cashback::default.Save Settings') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <div class="version">
                    v 2.8.2.1
                </div>
            </div>

        </div>
    </div>
    <script>
        $(function() {
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
        })
    </script>
@endsection
