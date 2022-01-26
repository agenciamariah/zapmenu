<?php $__env->startSection('content'); ?>
	
    <style type="text/css">
    .price-plan-font {
        margin-left: -12px;
        font-size: 15px;
    }
    </style>

	<div class="iframe-box-all" style="display: none; position: absolute; z-index: 999999; width: 100%; height: 100%; background: white;"></div>

    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    </div>


    <div class="container-fluid mt--9">

        <?php if($currentPlan): ?>

        <!-- Show Current form actions -->
        <?php echo $__env->make("plans.info",['planAttribute'=> $planAttribute,'showLinkToPlans'=>false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php endif; ?>

        <div class="row">



            <div class="col-12">
                <?php if(session('status')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('status')); ?>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                 <!-- Errors display -->
                <?php if(session('error')): ?>
                 <div role="alert" class="alert alert-danger"><?php echo e(session('error')); ?></div>
                <?php endif; ?>

            </div>

            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-<?php echo e($col); ?>">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0"><?php echo e($plan['name']); ?></h3>
                            </div>
                            <div class="col-4">
                                <h3 class="mb-0 price-plan-font"><?php echo money($plan['price'], config('settings.cashier_currency'),config('settings.do_convertion')); ?>/<?php echo e($plan['period']==1?__('mês'):__('ano')); ?></h3>
                            </div>

                        </div>
                    </div>


                    <?php if(count($plans)): ?>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col"><?php echo e(__('Features')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = explode(",",$plan['features']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(__($feature)); ?> </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>


                    </div>
                    <?php endif; ?>
                    <div class="card-footer py-4">
                        <?php if($currentPlan&&$plan['id'].""==$currentPlan->id.""): ?>
                            <a href="" class="btn btn-primary disabled"><?php echo e(__('Current Plan')); ?></a>
                        <?php else: ?>

                        <!-- Button holder -->
                        <div id="button-container-plan-<?php echo e($plan['id']); ?>"></div>



                            <?php if(strlen($plan['stripe_id'])>2&&config('settings.subscription_processor')=='Stripe'): ?>
                                <a href="javascript:showStripeCheckout(<?php echo e($plan['id']); ?> , '<?php echo e($plan['name']); ?>')" class="btn btn-primary"><?php echo e(__('Mudar para ').$plan['name']); ?></a>
                            <?php endif; ?>

                            <?php if($plan['price']>0&&(config('settings.subscription_processor')=='Local'||config('settings.subscription_processor')=='local')): ?>
                                <button  data-toggle="modal" data-target="#paymentModal<?php echo e($plan['id']); ?>" class="btn btn-primary"><?php echo e(__('Mudar para ').$plan['name']); ?></button>

                                <!-- Modal -->
                                <div class="modal fade" id="paymentModal<?php echo e($plan['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                        <div class="modal-content bg-gradient-danger">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e($plan['name']); ?></h5>


                                        <form class="form-plano-<?php echo e($plan['id']); ?>">

                                            <input type="hidden" name="plano" value="<?php echo e($plan['id']); ?>" />

                                            <input type="hidden" name="customer_email" value="<?php echo e(old('name', auth()->user()->email)); ?>" />
                                            <input type="hidden" name="client_name" value="<?php echo e(old('name', auth()->user()->name)); ?>" />
                                            <input type="hidden" name="client_phone" value="<?php echo e(old('name', auth()->user()->phone)); ?>" />
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
                                        	<div>
                                        		<p class="plano-payment-title-<?php echo e($plan['id']); ?>">Sua assinatura será feita na plataforma de pagamento ASAAS, caso haja qualquer problema consulte nosso suporte clicando em <a style="color: white; font-weight: bold;" href="https://was.ws/cardapeme/assinatura" target="_blank">was.ws/cardapeme/assinatura</a></p>
                                        	</div>
                                        <hr />

                                        <form class="form-plano-cartao-<?php echo e($plan['id']); ?>" method="POST" action="./">

                                        <input type="hidden" name="plano" value="<?php echo e($plan['id']); ?>" />

                                        <input type="hidden" name="customer_email" value="<?php echo e(old('name', auth()->user()->email)); ?>" />
                                        <input type="hidden" name="client_name" value="<?php echo e(old('name', auth()->user()->name)); ?>" />
                                        <input type="hidden" name="client_phone" value="<?php echo e(old('name', auth()->user()->phone)); ?>" />
                                        <input type="hidden" name="client_cpfcnpj" value="03496545224" />
                                        <input type="hidden" name="whatsapp_address" value="$restorant->address" />
                                        <input type="hidden" name="id" value="32" />
                                        <input type="hidden" name="restorant" value="$restorant->name" />

                                        <input placeholder="Número do Cartão" type="text" class="cartao-numero" name="cartao-numero" style="display: none !important; width: 100%; margin-bottom: 5px; "/>
                                        <input placeholder="Nome do Títular do Cartão" type="text" class="cartao-titular" name="cartao-titular" style="display: none !important; width: 100%; margin-bottom: 5px; "/>
                                        <input placeholder="CPF do Títular do Cartão" type="text" class="cartao-cpf" name="cartao-cpf" style="display: none !important; width: 100%; margin-bottom: 5px; "/>
                                        <input placeholder="01/2021" type="text" class="cartao-vencimento" name="cartao-vencimento" style="display: none !important; width: 49%; "/>
                                        <input placeholder="CCV" type="text" class="cartao-ccv" name="cartao-ccv" style="display: none !important; width: 50%; "/>
                                        </form> <br/>

                                        <div class="price-box">
                                        <?php echo e(__('Price')); ?><br />
                                        <?php echo money($plan['price'], config('settings.cashier_currency'),config('settings.do_convertion')); ?>/<?php echo e($plan['period']==1?__('mês'):__('ano')); ?>

                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-plano-<?php echo e($plan['id']); ?> btn-primary" data-dismiss="modal2"><?php echo e(__('Cartão de Crédito')); ?></button>
                                        <button type="button" class="btn btn-plano-boleto-<?php echo e($plan['id']); ?> btn-success" data-dismiss="modal2"><?php echo e(__('Boleto')); ?></button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Fechar')); ?></button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- END TO BE REMOVED -->


                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </div>


        <!-- Stripe Subscription form -->
        <div class="row mt-4" id="stripe-payment-form-holder" style="display: none">
            <div class="col-md-12">
                <div class="card bg-secondary shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0"><?php echo e(__('Subscribe to')); ?> <span id="plan_name">PLAN_NAME</span></h3>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">

                    <form action="<?php echo e(route('plans.subscribe')); ?>" method="post" id="stripe-payment-form"   >
                            <?php echo csrf_field(); ?>
                            <input name="plan_id" id="plan_id" type="hidden" />
                            <div style="width: 100%;" class="form-group<?php echo e($errors->has('name') ? ' has-danger' : ''); ?>">
                                <input name="name" id="name" type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" placeholder="<?php echo e(__( 'Name on card' )); ?>" value="<?php echo e(auth()->user()?auth()->user()->name:""); ?>" required>
                                <?php if($errors->has('name')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                <?php endif; ?>
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
                                ><?php echo e(__('Subscribe')); ?></button>
                          </div>

                          </form>


                    </div>
                </div>
            </div>
        </div>




        <?php echo $__env->make('layouts.footers.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.11.2/jquery.mask.min.js"></script>

<script type="text/javascript">


    function setCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/; domain=app.zapentrega.com";
    }

        setCookie("zapentrega-cliente-plano-atual", "<?php echo e($currentPlan->id); ?>",7);



		<?php
		if(isset($_COOKIE['zapentrega-cliente-pagamento'])) {

			$varCookieURL = $_COOKIE['zapentrega-cliente-pagamento'];
			if($varCookieURL != "") {

                if($_COOKIE['zapentrega-cliente-pagamento-aguardando-plano'] == "2") {

     			echo '$("#paymentModal3 .btn-plano-2").attr("style", "display: none;");';
                echo '$("#paymentModal3 .plano-payment-title-2").html("Estamos analisando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");';
                echo '$("#paymentModal3 .price-box").attr("style", "display: none;");';
                echo '$("#paymentModal3 .modal-footer").html(\'<a target="_blank" href="' . $varCookieURL . '"><button type="button" class="btn btn-success" data-dismiss="modal2">Verificar</button></a>\');';
    			echo '$("#paymentModal3 .modal-footer").append(\'<button type="button" class="btn btn-warning btn-payment-cancelar" data-dismiss="modal2">Cancelar pagamento</button>\');';
    		
                }
                else {

                echo '$("#paymentModal3 .btn-plano-3").attr("style", "display: none;");';
                echo '$("#paymentModal3 .plano-payment-title-3").html("Estamos analisando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");';
                echo '$("#paymentModal3 .price-box").attr("style", "display: none;");';
                echo '$("#paymentModal3 .modal-footer").html(\'<a target="_blank" href="' . $varCookieURL . '"><button type="button" class="btn btn-success" data-dismiss="modal2">Verificar</button></a>\');';
                echo '$("#paymentModal3 .modal-footer").append(\'<button type="button" class="btn btn-warning btn-payment-cancelar" data-dismiss="modal2">Cancelar pagamento</button>\');';
               
                }

            }
		}
		?>



		<?php
		if(isset($_COOKIE['zapentrega-cliente-pagamento-boleto'])) {

			$varCookieURL = $_COOKIE['zapentrega-cliente-pagamento-boleto'];
			if($varCookieURL != "") {

                if($_COOKIE['zapentrega-cliente-pagamento-aguardando-plano'] == "2") {
     			echo '$("#paymentModal2 .btn-plano-2").attr("style", "display: none;");';
                echo '$("#paymentModal2 .plano-payment-title-2").html("Estamos aguardando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");';
                echo '$("#paymentModal2 .price-box").attr("style", "display: none;");';
                echo '$("#paymentModal2 .modal-footer").html(\'<a target="_blank" href="' . $varCookieURL . '"><button type="button" class="btn btn-success" data-dismiss="modal2">2ª Via</button></a>\');';
    			echo '$("#paymentModal2 .modal-footer").append(\'<button type="button" class="btn btn-warning btn-payment-cancelar" data-dismiss="modal2">Cancelar pagamento</button>\');';
    		    }
                else {
                echo '$("#paymentModal3 .btn-plano-3").attr("style", "display: none;");';
                echo '$("#paymentModal3 .plano-payment-title-3").html("Estamos aguardando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");';
                echo '$("#paymentModal3 .price-box").attr("style", "display: none;");';
                echo '$("#paymentModal3 .modal-footer").html(\'<a target="_blank" href="' . $varCookieURL . '"><button type="button" class="btn btn-success" data-dismiss="modal2">2ª Via</button></a>\');';
                echo '$("#paymentModal3 .modal-footer").append(\'<button type="button" class="btn btn-warning btn-payment-cancelar" data-dismiss="modal2">Cancelar pagamento</button>\');';
                }

            }
		}
		?>

		$(".btn-payment-cancelar").attr("onclick", "javascript:setCookie('zapentrega-cliente-pagamento-boleto', '',7);setCookie('zapentrega-cliente-pagamento', '',7);location.reload();");

        var boletoAberto = false;
        var Credito1Aberto = false;

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
                                    $(".btn-plano-2").attr("style", "display: none;");
                                    $(".plano-payment-title-2").html("Estamos aguardando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");
                                    $(".price-box").attr("style", "display: none;");
                                    // $(".iframe-box-all").css("display", "block");

                                    // start code iframe
        							setCookie("zapentrega-cliente-pagamento-boleto", urlCheckout,7);
                                    setCookie("zapentrega-cliente-pagamento-aguardando-plano", "2",7);
                                    
                                    // end code iframe

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
















        $(".btn-plano-2").on('click', function(){


                $(".btn-plano-2").html("Aguarde...");

                $('input[name=restorant]').val($(".navbar-nav span.text-sm").html());
                var RestId = $("ul.navbar-nav li:nth-child(4) a").attr('href');
                RestId = RestId.replace("https://app.zapentrega.com/restaurants/", "");
                RestId = RestId.replace("/edit", "");
                $('input[name=id]').val(RestId);

                console.log("Btn plano clicked! Number 2. POST AJAX now!");


                var form = $('.form-plano-2');
                var formSucesso = false;
                var url = 'https://app.clube14pontos.com/uploads/integration_asaas_assinatura.php';
                url = 'https://app.zapentrega.com/plan/createapicredit';

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



                                  console.log("Plan crédito form: " + data);
                                  if(data.indexOf("Falha") == -1) {
                                    var urlCheckout = data.replace("Assinatura criada com sucesso. URL: ", "");
                                    window.open(urlCheckout, '_blank').focus();
                                    if(Credito1Aberto == false) {
                                    $(".btn-plano-2").attr("style", "display: none;");
                                    $(".plano-payment-title-2").html("Estamos analisando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");
                                    $(".price-box").attr("style", "display: none;");
                                    // $(".iframe-box-all").css("display", "block");
                                    $(".iframe-box-all").html('<iframe id="iframe-payment" src="' + urlCheckout + '" style="width: 100%; height: 100%;"></iframe>');

                                    // start code iframe
        							setCookie("zapentrega-cliente-pagamento", urlCheckout,7);
                                    setCookie("zapentrega-cliente-pagamento-aguardando-plano", "2",7);
                                    $(".modal-footer").html('<a target="_blank" href="' + urlCheckout + '"><button type="button" class="btn btn-success" data-dismiss="modal2">Verificar</button></a>');
			
                                    // end code iframe

                                    Credito1Aberto = true;
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
                                $(".btn-plano-2").html("Aguarde...");
                                console.log("START POST...");
                                if(formSucesso == false) {
                                    IniciaAJAX();
                                formSucesso = true;
                                }
                                console.log("END POST...");
                }, 3000);




        });















// plano 3


        $(".btn-plano-boleto-3").on('click', function(){
                $(".btn-plano-boleto-3").html("Aguarde...");

                $('input[name=restorant]').val($(".navbar-nav span.text-sm").html());
                var RestId = $("ul.navbar-nav li:nth-child(4) a").attr('href');
                RestId = RestId.replace("https://app.zapentrega.com/restaurants/", "");
                RestId = RestId.replace("/edit", "");
                $('input[name=id]').val(RestId);

                console.log("Btn plano clicked! Number 2. POST AJAX now!");


                var form = $('.form-plano-3');
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
                                    $(".btn-plano-boleto-3").attr("style", "display: none;");
                                    $(".btn-plano-3").attr("style", "display: none;");
                                    $(".plano-payment-title-3").html("Estamos aguardando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");
                                    $(".price-box").attr("style", "display: none;");
                                    // $(".iframe-box-all").css("display", "block");

                                    // start code iframe
                                    setCookie("zapentrega-cliente-pagamento-boleto", urlCheckout,7);
                                    setCookie("zapentrega-cliente-pagamento-aguardando-plano", "3",7);
                                    // end code iframe

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
                                $(".btn-plano-boleto-3").html("Aguarde...");
                                console.log("START POST...");
                                if(formSucesso == false) {
                                    IniciaAJAX();
                                formSucesso = true;
                                }
                                console.log("END POST...");
                }, 3000);





        });
















        $(".btn-plano-3").on('click', function(){


                $(".btn-plano-3").html("Aguarde...");

                $('input[name=restorant]').val($(".navbar-nav span.text-sm").html());
                var RestId = $("ul.navbar-nav li:nth-child(4) a").attr('href');
                RestId = RestId.replace("https://app.zapentrega.com/restaurants/", "");
                RestId = RestId.replace("/edit", "");
                $('input[name=id]').val(RestId);

                console.log("Btn plano clicked! Number 2. POST AJAX now!");


                var form = $('.form-plano-3');
                var formSucesso = false;
                var url = 'https://app.clube14pontos.com/uploads/integration_asaas_assinatura.php';
                url = 'https://app.zapentrega.com/plan/createapicredit';

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



                                  console.log("Plan crédito form: " + data);
                                  if(data.indexOf("Falha") == -1) {
                                    var urlCheckout = data.replace("Assinatura criada com sucesso. URL: ", "");
                                    window.open(urlCheckout, '_blank').focus();
                                    if(Credito1Aberto == false) {
                                    $(".btn-plano-3").attr("style", "display: none;");
                                    $(".plano-payment-title-3").html("Estamos analisando seu pagamento, assim que obtivermos a aprovação seu plano será alterado automaticamente");
                                    $(".price-box").attr("style", "display: none;");
                                    // $(".iframe-box-all").css("display", "block");
                                    $(".iframe-box-all").html('<iframe id="iframe-payment" src="' + urlCheckout + '" style="width: 100%; height: 100%;"></iframe>');

                                    // start code iframe
                                    setCookie("zapentrega-cliente-pagamento", urlCheckout,7);
                                    setCookie("zapentrega-cliente-pagamento-aguardando-plano", "3",7);
                                    $(".modal-footer").html('<a target="_blank" href="' + urlCheckout + '"><button type="button" class="btn btn-success" data-dismiss="modal2">Verificar</button></a>');
            
                                    // end code iframe

                                    Credito1Aberto = true;
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
                                $(".btn-plano-3").html("Aguarde...");
                                console.log("START POST...");
                                if(formSucesso == false) {
                                    IniciaAJAX();
                                formSucesso = true;
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

<?php if(config('settings.subscription_processor') == "Stripe"): ?>
<!-- Stripe -->
<script src="https://js.stripe.com/v3/"></script>

<script>
  "use strict";
  var STRIPE_KEY="<?php echo e(config('settings.stripe_key')); ?>";
  var ENABLE_STRIPE="<?php echo e(config('settings.subscription_processor')=='Stripe'); ?>";
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
<?php else: ?>
    <?php if(!(config('settings.subscription_processor') == "Local")): ?>
        <!-- Payment Processors JS Modules -->
        <?php echo $__env->make($subscription_processor.'-subscribe::subscribe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

<?php endif; ?>







<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => __('Pages')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/test.com/html/laravel/resources/views/plans/current.blade.php ENDPATH**/ ?>