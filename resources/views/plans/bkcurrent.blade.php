@extends('layouts.app', ['title' => __('Pages')])

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>


    <div class="container-fluid mt--9">

        @if($currentPlan)

        <!-- Show Current form actions -->
        @include("plans.info",['planAttribute'=> $planAttribute,'showLinkToPlans'=>false])

        
    @endif

        <div class="row">

            

            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                 <!-- Errors display -->
                @if (session('error'))
                 <div role="alert" class="alert alert-danger">{{ session('error') }}</div>
                @endif

            </div>

            @foreach ($plans as $plan)
            <div class="col-md-{{ $col}}">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ $plan['name'] }}</h3>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0">@money($plan['price'], config('settings.cashier_currency'),config('settings.do_convertion'))/{{ $plan['period']==1?__('mês'):__('ano') }}</h3>
                            </div>

                        </div>
                    </div>


                    @if(count($plans))
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Features') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (explode(",",$plan['features']) as $feature)
                                    <tr>
                                        <td>{{ __($feature) }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                    @endif
                    <div class="card-footer py-4">
                        @if($currentPlan&&$plan['id'].""==$currentPlan->id."")
                            <a href="" class="btn btn-primary disabled">{{__('Current Plan')}}</a>
                        @else

                        <!-- Button holder -->
                        <div id="button-container-plan-{{$plan['id']}}"></div>

                            
                            
                            @if(strlen($plan['stripe_id'])>2&&config('settings.subscription_processor')=='Stripe')
                                <a href="javascript:showStripeCheckout({{ $plan['id'] }} , '{{ $plan['name'] }}')" class="btn btn-primary">{{__('Mudar para ').$plan['name']}}</a>
                            @endif

                            @if($plan['price']>0&&(config('settings.subscription_processor')=='Local'||config('settings.subscription_processor')=='local'))
                                <button  data-toggle="modal" data-target="#paymentModal{{ $plan['id']  }}" class="btn btn-primary">{{__('Mudar para ').$plan['name']}}</button>

                                <!-- Modal -->
                                <div class="modal fade" id="paymentModal{{ $plan['id']  }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                        <div class="modal-content bg-gradient-danger">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $plan['name'] }}</h5>


                                        <form class="form-plano-{{ $plan['id']  }}">

                                            <input type="hidden" name="plano" value="{{ $plan['id']  }}" />

                                            <input type="hidden" name="customer_email" value="{{ old('name', auth()->user()->email) }}" />
                                            <input type="hidden" name="client_name" value="{{ old('name', auth()->user()->name) }}" />
                                            <input type="hidden" name="client_phone" value="{{ old('name', auth()->user()->phone) }}" />
                                            <input type="hidden" name="client_cpfcnpj" value="03496545224" />
                                            <input type="hidden" name="whatsapp_address" value="$restorant->address" />
                                            <input type="hidden" name="id" value="32" />
                                            <input type="hidden" name="restorant" value="$restorant->name" />

                                        </form>



                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        {{ config('settings.local_transfer_info')}}
                                        <br /><br />
                                        {{ config('settings.local_transfer_account')}}
                                        <hr />

                                        <form class="form-plano-cartao" method="POST" action="./"> 
                                        <input placeholder="Número do Cartão" type="text" class="cartao-numero" name="cartao-numero" style=" width: 100%; margin-bottom: 5px; "/>
                                        <input placeholder="Nome do Títular do Cartão" type="text" class="cartao-titular" name="cartao-titular" style=" width: 100%; margin-bottom: 5px; "/>
                                        <input placeholder="CPF do Títular do Cartão" type="text" class="cartao-cpf" name="cartao-cpf" style=" width: 100%; margin-bottom: 5px; "/>
                                        <input placeholder="01/2021" type="text" class="cartao-vencimento" name="cartao-vencimento" style=" width: 49%; "/>
                                        <input placeholder="CCV" type="text" class="cartao-ccv" name="cartao-ccv" style=" width: 50%; "/>
                                        </form> <br/>

                                        {{ __('Price')}}<br />
                                        @money($plan['price'], config('settings.cashier_currency'),config('settings.do_convertion'))/{{ $plan['period']==1?__('mês'):__('ano') }}
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-plano-{{ $plan['id']  }} btn-primary" data-dismiss="modal2">{{ __('Comprar') }}</button>
                                        <button type="button" class="btn btn-plano-boleto-{{ $plan['id']  }} btn-success" data-dismiss="modal2">{{ __('Boleto') }}</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Fechar') }}</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endif

                            <!-- END TO BE REMOVED -->

                            
                        @endif
                    </div>
                </div>
            </div>
            @endforeach


        </div>


        <!-- Stripe Subscription form -->
        <div class="row mt-4" id="stripe-payment-form-holder" style="display: none">
            <div class="col-md-12">
                <div class="card bg-secondary shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Subscribe to') }} <span id="plan_name">PLAN_NAME</span></h3>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">

                    <form action="{{ route('plans.subscribe') }}" method="post" id="stripe-payment-form"   >
                            @csrf
                            <input name="plan_id" id="plan_id" type="hidden" />
                            <div style="width: 100%;" class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input name="name" id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __( 'Name on card' ) }}" value="{{auth()->user()?auth()->user()->name:""}}" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form">
                                <div style="width: 100%;" #stripecardelement  id="card-element" class="form-control">

                                <!-- A Stripe Element will be inserted here. -->
                              </div>

                              <!-- Used to display form errors. -->
                              <br />
                              <div class="" id="card-errors" role="alert">

                              </div>
                          </div>
                          <div class="text-center" id="totalSubmitStripe">
                            <button
                                v-if="totalPrice"
                                type="submit"
                                class="btn btn-success mt-4 paymentbutton"
                                >{{ __('Subscribe') }}</button>
                          </div>

                          </form>


                    </div>
                </div>
            </div>
        </div>

       


        @include('layouts.footers.auth')
    </div>
@endsection
@section('js')


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>

<script type="text/javascript">

	var boletoAberto = false;

        $(".cartao-numero").mask("0000 0000 0000 0000");
        $(".cartao-vencimento").mask("00/0000");
        $(".cartao-ccv").mask("000");
        $(".cartao-cpf").mask("000.000.000-00");

        $(".btn-plano-boleto-2").on('click', function(){
                $(".btn-plano-boleto-2").html("Aguarde...");

                $('input[name=restorant]').val($(".navbar-nav span.text-sm").html());
                var RestId = $("ul.navbar-nav li:nth-child(4) a").attr('href');
                RestId = RestId.replace("https://app.zapentrega.com/restaurants/", "");
                RestId = RestId.replace("/edit", "");
                $('input[name=id]').val(RestId);

                console.log("Btn plano clicked! Number 2. POST AJAX now!");


                var form = $('.form-plano-2');
                var formSucesso = false;
                var url = 'https://app.clube14pontos.com/uploads/integration_asaas_assinatura.php';
		url = 'https://app.zapentrega.com/plan/createapi';
                
                function IniciaAJAX() {
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});


                    $.ajax({
                           type: "POST",
                           url: url,
                           data: form.serialize(), // serializes the form's elements.
                           success: function(data)
                           {



                                  console.log("Plan form: " + data);
                                  if(data.indexOf("Falha") == -1) {
                                    var urlCheckout = data.replace("Assinatura criada com sucesso. URL: ", "");
                                    window.open(urlCheckout, '_blank').focus();
                                    if(boletoAberto == false) {
                                    $(".btn-plano-boleto-2").attr("style", "display: none;");
                                    boletoAberto = true;  
                                    }
				    formSucesso = true;
                                    return true;

                                  }
                                  else {
                                    console.log("API Falhou");
                                    formSucesso = false;
                                    formSucesso = true;
				    return false;
                                  }


                           }
                         });
                    
                }


                setInterval(function(){ 
                                $(".btn-plano-boleto-2").html("Aguarde...");
                                console.log("START POST...");
                                if(formSucesso == false) {
                                    IniciaAJAX();
                                formSucesso = true;
				}
                                console.log("END POST...");
                }, 3000);

                



        });




        $(".btn-plano-boleto-3").on('click', function(){


                $(".btn-plano-boleto-3").html("Aguarde...");

                $('input[name=restorant]').val($(".navbar-nav span.text-sm").html());
                var RestId = $("ul.navbar-nav li:nth-child(4) a").attr('href');
                RestId = RestId.replace("https://app.zapentrega.com/restaurants/", "");
                RestId = RestId.replace("/edit", "");
                $('input[name=id]').val(RestId);

                console.log("Btn plano clicked! Number 3. POST AJAX now!");


                var form = $('.form-plano-3');
                var formSucesso = false;
                var url = 'https://app.clube14pontos.com/uploads/integration_asaas_assinatura.php';
		url = 'https://app.zapentrega.com/plan/createapi';

                
                function IniciaAJAX() {

                    $.ajax({
                           type: "POST",
                           url: url,
                           data: form.serialize(), // serializes the form's elements.
                           success: function(data)
                           {



                                  console.log("Plan form: " + data);
                                  if(data.indexOf("Falha") == -1) {
                                    var urlCheckout = data.replace("Assinatura criada com sucesso. URL: ", "");
                                    window.open(urlCheckout, '_blank').focus();
                                    if(boletoAberto == false) {
                                    $(".btn-plano-boleto-3").attr("style", "display: none;");
                                    boletoAberto = true;  
                                    }
				    formSucesso = true;
                                    return true;

                                  }
                                  else {
                                    console.log("API Falhou");
                                    formSucesso = false;
                                    return false;
                                  }


                           }
                         });
                    
                }


                setInterval(function(){ 
                                $(".btn-plano-3").html("Aguarde...");
                                console.log("START POST...");
                                if(formSucesso == false) {
                                    IniciaAJAX();
                                }
                                console.log("END POST...");
                }, 3000);

                


        });





</script>

<script type="text/javascript">
    $(".btn-sub-actions").click(function() {
        var action = $(this).attr('data-action');

        $('#action').val(action);
        document.getElementById('form-subscription-actions').submit();
    });

    function showLocalPayment(plan_name,plan_id){
        alert(plan_name);
    }
    
    var plans = <?php echo json_encode($plans) ?>;
    var user = <?php echo json_encode(auth()->user()) ?>;
    var payment_processor = <?php echo json_encode(config('settings.subscription_processor')) ?>;

    
</script>

@if (config('settings.subscription_processor') == "Stripe")
<!-- Stripe -->
<script src="https://js.stripe.com/v3/"></script>

<script>
  "use strict";
  var STRIPE_KEY="{{ config('settings.stripe_key') }}";
  var ENABLE_STRIPE="{{ config('settings.subscription_processor')=='Stripe' }}";
  if(ENABLE_STRIPE){
      js.initStripe(STRIPE_KEY,"stripe-payment-form");
  }

  function validateOrderFormSubmit(){
      return true;
  }

  function showStripeCheckout(plan_id,plan_name){
   $('#plan_id').val(plan_id);
   $('#plan_name').html(plan_name);
   $('#stripe-payment-form-holder').show();
  }
</script>
@else 
    @if (!(config('settings.subscription_processor') == "Local"))
        <!-- Payment Processors JS Modules -->
        @include($subscription_processor.'-subscribe::subscribe')
    @endif

@endif







@endsection
