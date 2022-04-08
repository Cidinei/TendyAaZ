@extends('admin.layouts.master')
@section('content')
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4>
                <span class="font-weight-bold mr-2">{{ @trans('cashback::default.modules') }}</span>
                <i class="icon-circle-right2 mr-2"></i>
                <span class="font-weight-bold mr-2">{{ @trans('cashback::default.reports') }}</span>
            </h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        <div class="header-elements">
            <form action="{{ route('cashback.reports') }}" method="GET">
                <div class="form-group row mb-0">
                    <div class="col-lg-5">
                        <select class="form-control selectRest" name="restaurant_id" style="width: 300px;">
                            <option></option>
                            @foreach ($restaurants as $restaurant_select)
                                <option value="{{ $restaurant_select->id }}" @if( app('request')->input('restaurant_id') == $restaurant_select->id) selected @endif class="text-capitalize">{{ $restaurant_select->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5">
                        <select class="form-control selectRange" name="range" required>
                            <option value="1" @if(app('request')->input('range') == '1') selected @endif class="text-capitalize">{{ @trans('cashback::default.This Week') }}</option>
                            <option value="2" @if(app('request')->input('range') == '2') selected @endif class="text-capitalize">{{ @trans('cashback::default.Last 7 Days') }}</option>
                            <option value="3" @if(app('request')->input('range') == '3') selected @endif class="text-capitalize">{{ @trans('cashback::default.This Month') }} ({{ \Carbon\Carbon::now()->format('F')}})</option>
                            <option value="4" @if(app('request')->input('range') == '4') selected @endif class="text-capitalize">{{ @trans('cashback::default.Last 30 Days') }}</option>
                            <option value="5" @if(app('request')->input('range') == '5') selected @endif class="text-capitalize">{{ @trans('cashback::default.All Time') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="icon-search4"></i>
                        </button>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>

    <div class="content">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>{{ @trans('cashback::default.restaurant') }}</th>
                        <th>{{ @trans('cashback::default.user') }}</th>
                        <th>{{ @trans('cashback::default.order') }}</th>
                        <th>{{ @trans('cashback::default.percentage') }}</th>
                        <th>{{ @trans('cashback::default.amount_real') }}</th>
                        <th>{{ @trans('cashback::default.amount_paid') }}</th>
                        <th>{{ @trans('cashback::default.created_at') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cashbackReport as $cr)
                        <tr>
                            <td>{{ $cr->restaurant->name ?? '' }}</td>
                            <td>{{ $cr->user->name ?? '' }}</td>
                            <td>{{ $cr->order->unique_order_id ?? '' }}</td>
                            <td>{{ $cr->percentage }}</td>
                            <td>{{ @trans('cashback::default.prefix_money') }} {{ $cr->amount_real }}</td>
                            <td>{{ @trans('cashback::default.prefix_money') }} {{ $cr->amount_paid }}</td>
                            @if(app()->getLocale() == 'en')
                                <td>{{ $cr->created_at }}</td>
                            @endif

                            @if(app()->getLocale() == 'pt-BR')
                                <td>{{ \Carbon\Carbon::parse($cr->created_at)->format('d/m/Y H:i') }}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Vazio</td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfooter>
                        <div class="row mb-2">
                            <div class="col mt-2">
                                <div class="col-xl-12 dashboard-display p-3" style="box-shadow: 0 1px 6px 1px rgb(0 0 0 / 14%);">
                                    <a class="block block-link-shadow text-left" href="javascript:void(0)">
                                        <div class="block-content block-content-full clearfix">
                                            <div class="float-right mt-10 d-none d-sm-block">
                                                <i class="dashboard-display-icon icon-coin-dollar"></i>
                                            </div>
                                            <div class="dashboard-display-number"> {{ @trans('cashback::default.prefix_money') }} {{ number_format($cashbackReport->sum('amount_real'), 2)  }}</div>
                                            <div class="font-size-sm text-uppercase text-muted">Ganhos Totais</div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col mt-2">
                                <div class="col-xl-12 dashboard-display p-3" style="box-shadow: 0 1px 6px 1px rgb(0 0 0 / 14%);">
                                    <a class="block block-link-shadow text-left" href="javascript:void(0)">
                                        <div class="block-content block-content-full clearfix">
                                            <div class="float-right mt-10 d-none d-sm-block">
                                                <i class="dashboard-display-icon icon-coin-dollar"></i>
                                            </div>
                                            <div class="dashboard-display-number"> {{ @trans('cashback::default.prefix_money') }} {{ number_format($cashbackReport->sum('amount_paid'), 2)  }}</div>
                                            <div class="font-size-sm text-uppercase text-muted">Ganho Total</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </tfooter>
                </table>

                <div class="mt-3 text-center">
                    {!! $cashbackReport->links() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.selectRest').select2({
            placeholder: "{{ @trans('cashback::default.select_store') }}",
            allowClear: true,
            width: "300px"
        });

        $('.selectRange').select2();

        $('.daterange-single').daterangepicker({
            singleDatePicker: true,
        });
        $('.daterange-single1').daterangepicker({
            singleDatePicker: true,
        });
    </script>
@endsection
