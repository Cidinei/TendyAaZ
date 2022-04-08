@extends('admin.layouts.master')
@section("title") Settings - Order Schedule
@endsection
@section('content')

<div class="page-header">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4>
				<span class="font-weight-bold mr-2">Módulos</span>
				<i class="icon-circle-right2 mr-2"></i>
				<span class="font-weight-bold mr-2">Agendamento de Pedidos</span>
			</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>
	</div>
</div>

<div class="content">
	<div class="card">
		<div class="card-body">
			<form action="{{ route('orderschedule.saveSettings') }}" method="POST" enctype="multipart/form-data">

				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h3 class="font-weight-semibold text-uppercase font-size-sm mb-0">
							<i class="icon-calendar2 mr-1"></i> Configurações de Agendamento de Pedidos
						</h3>
					</div>
					<div>
						<div class="float-right">
							<a href="#" target="_blank" class="btn btn-warning btn-md">
								<i class="icon-file-text2 mr-1"></i> Peça ajuda ao suporte
							</a>
						</div>
					</div>
				</div>
				<hr>

				<div class="form-group row">
					<label class="col-lg-3 col-form-label"><strong>Agendamento de Pedidos
					</strong></label>
					<div class="col-lg-9">
						<div class="checkbox checkbox-switchery mt-2">
							<label>
							<input value="true" type="checkbox" class="switchery-primary"
							@if(config('appSettings.enableOrderSchedulingOnCustomer') == "true") checked="checked" @endif
							name="enableOrderSchedulingOnCustomer">
							</label>
							<br>
							<small><mark>Isso precisa ser habilitado para permitir a programação de pedidos globalmente.</mark></small>
						</div>
					</div>
				</div>

				<hr>

				<div class="form-group row">
					<label class="col-lg-3 col-form-label"><strong>Minutos antes do pedido ser processado</strong></label>
					<div class="col-lg-9">
						 <input type="text" class="form-control form-control-lg minsBeforeScheduleOrderProcessed" name="minsBeforeScheduleOrderProcessed" value="{{ config('appSettings.minsBeforeScheduleOrderProcessed') }}" required="required">
						<p class="mt-1"><small><mark>Defina os minutos antes dos quais o pedido programado será processado automaticamente.</mark></small></p>
						<p>
							<b>Exemplo</b><br>
							Se o pedido foi agendado para <b>1:00pm - 1:30pm</b>, e se você definir o valor do campo acima para <b>30</b> minutos, <br>
							<b>Então: </b><br>
							<ul>
								<li>
								se o pedido programado já foi confirmado pela loja, então em <b>12:30pm</b>, o pedido será marcado como em preparação e será encaminhado a todos os entregadores designados para aquela loja em particular.
								</li>
								<br>
								<li>
								se o pedido programado NÃO for confirmado pela loja, então em <b>12:30pm</b>, o pedido será marcado como novo pedido e será mostrado ao proprietário da loja para aceitar o pedido.
								</li>
								<br>
								<li>
								se o pedido programado NÃO for confirmado pela loja, então em <b>12:30pm</b>, e se a Loja tiver configurações de Aceitação Automática do Pedido habilitadas, o pedido será Marcado como Em Preparação e será encaminhado a todos os Entregadores designados para aquela loja específica.
								</li>
							</ul>
						</p>
					</div>
				</div>

				<div class="form-group row">
					<label class="col-lg-3 col-form-label"><strong>Número personalizado de dias
					</strong></label>
					<div class="col-lg-9">
						<div class="checkbox checkbox-switchery mt-2">
							<label>
							<input value="true" type="checkbox" class="switchery-primary"
							@if(config('appSettings.enFixedNumberOfDays') == "true") checked="checked" @endif
							name="enFixedNumberOfDays">
							</label>
							<br>
							<small><mark>Se desativado, datas futuras de 7 dias são consideradas como padrão</mark></small>
						</div>
					</div>
				</div>

				@if(config('appSettings.enFixedNumberOfDays') == "true")
					<div class="form-group row">
						<label class="col-lg-3 col-form-label"><strong>Número de dias futuros: </strong></label>
						<div class="col-lg-9">
							 <input type="text" class="form-control form-control-lg orderSchedulingFutureDays" name="orderSchedulingFutureDays" value="{{ config('appSettings.orderSchedulingFutureDays') }}" required="required">
							<p class="mt-1"><small><mark>Máximo de 8 dias podem ser definidos</mark></small></p>
						</div>
					</div>
				@endif

				@csrf
				<div class="text-right mt-5">
					<button type="submit" class="btn btn-primary btn-labeled btn-labeled-left btn-lg">
					<b><i class="icon-database-insert ml-1"></i></b>
					{{ __('thermalPrinterLang.saveSettings') }}
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	"use strict";
	$(function() {
		var elems = document.querySelectorAll('.switchery-primary');
		for (var i = 0; i < elems.length; i++) {
			var switchery = new Switchery(elems[i], { color: '#8360c3' });
		}

		$('.select').select2({
			minimumResultsForSearch: -1,
		});

		$('.orderSchedulingFutureDays').numeric({
			allowThouSep:false, 
			maxDecimalPlaces: 0, 
			allowMinus: false, 
			min: 1, 
			max: 8 
		});
		$('.minsBeforeScheduleOrderProcessed').numeric({
			allowThouSep:false,
			maxDecimalPlaces: 0,
			allowMinus: false,
			min: 1,
			max: 1440
		});
	})
</script>
@endsection
