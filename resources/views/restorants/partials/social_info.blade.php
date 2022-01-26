<br />
<h6 class="heading-small text-muted mb-4">{{ __('Accepting Payments') }}</h6>
<!-- Payment explanation -->
@include('partials.fields',['fields'=>[
    ['required'=>false,'ftype'=>'input','placeholder'=>"Informações de pagamento",'name'=>'Informações de pagamento', 'additionalInfo'=>'Exemplo: Aceitamos dinheiro na entrega', 'id'=>'payment_info', 'value'=>$restorant->payment_info]
]])



