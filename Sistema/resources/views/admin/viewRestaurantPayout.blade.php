@extends('admin.layouts.master')
@section("title") Pagamentos de Lojas - Dashboard
@endsection
@section('content')
<div class="content">
   <div class="row mt-4">
      <div class="col-xl-8">
         <div class="card">
            <div class="card-body">
               <h4>
                  {{ $restaurantPayout->restaurant->name }} has requested a payout of <strong>{{ config('appSettings.currencyFormat') }}{{ $restaurantPayout->amount }}</strong>
               </h4>
               <form action="{{ route('admin.updateRestaurantPayout') }}" method="POST" enctype="multipart/form-data">
                  <legend class="font-weight-semibold text-uppercase font-size-sm">
                     <i class="icon-piggy-bank mr-2"></i> Pagemento de Loja
                  </legend>
                  <input type="hidden" name="id" value="{{ $restaurantPayout->id }}">
                  <div class="form-group row">
                     <label class="col-lg-3 col-form-label"><span class="text-danger">*</span>Status:</label>
                     <div class="col-lg-9">
                        <select class="form-control select" name="status" required>
                        <option value="PENDING" @if($restaurantPayout->status === "PENDING") selected="selected" @endif>PENDENTE</option>
                        <option value="PROCESSING" @if($restaurantPayout->status === "PROCESSING") selected="selected" @endif>PROCESSANDO</option>
                        <option value="COMPLETED" @if($restaurantPayout->status === "COMPLETED") selected="selected" @endif>CONCLUÍDO</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-lg-3 col-form-label">Modo de transação:</label>
                     <div class="col-lg-9">
                        <input value="{{ $restaurantPayout->transaction_mode }}" type="text" class="form-control form-control-lg" name="transaction_mode"
                           placeholder="Modo">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-lg-3 col-form-label">ID da transação:</label>
                     <div class="col-lg-9">
                        <input value="{{ $restaurantPayout->transaction_id }}" type="text" class="form-control form-control-lg" name="transaction_id"
                           placeholder="ID">
                     </div>
                  </div>
                  <div class="form-group row">
                     <label class="col-lg-3 col-form-label">Mensagem:</label>
                     <div class="col-lg-9">
                        <input value="{{ $restaurantPayout->message }}" type="text" class="form-control form-control-lg" name="message"
                           placeholder="Mensagem">
                     </div>
                  </div>
                  @csrf
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
      <div class="col-xl-4">
         <div class="card">
            <div class="card-body">
               <legend class="font-weight-semibold text-uppercase font-size-sm">
                  <i class="icon-coin-dollar mr-2"></i> Dados da conta de pagamento
               </legend>
               <p>
                  <span class=""><b>Nome do titular: </b></span> <span>@if(!empty($payoutData->bankName)){{ $payoutData->bankName }}@endif</span><br>
               </p>
               <p>
                  <span class=""><b>Tipo de chave Pix (Ex.: CPF): </b></span> <span>@if(!empty($payoutData->bankCode)){{ $payoutData->bankCode }}@endif</span><br>
               </p>
               <p>
                  <span class=""><b>Chave Pix: </b></span> <span>@if(!empty($payoutData->recipientName)){{ $payoutData->recipientName }}@endif</span><br>
               </p>
               <p><span class=""><b>Agência: </b></span> <span>@if(!empty($payoutData->accountNumber)){{ $payoutData->accountNumber }}@endif</span><br></p>
               <p><span class=""><b>Conta bancária: </b></span> <span>@if(!empty($payoutData->paypalId)){{ $payoutData->paypalId }}@endif</span><br></p>
               <p><span class=""><b>Observações: </b></span> <span>@if(!empty($payoutData->upiID)){{ $payoutData->upiID }}@endif</span><br>
               </p>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   $('.select').select2({
       minimumResultsForSearch: Infinity,
   });
</script>
@endsection