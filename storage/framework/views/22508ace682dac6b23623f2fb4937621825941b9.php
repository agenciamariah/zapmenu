<div class="card card-profile shadow" id="addressBox">
    <div class="px-4">
      <div class="mt-5">
        <h3><?php echo e(__('Delivery Info')); ?><span class="font-weight-light"></span></h3>
      </div>
      <div class="card-content border-top">
            <div id="address-info-area">
              <div id="form-group-addressNewIDNumber1" class="form-group  ">
                 <label class="form-control-label" for="addressNewIDNumber1"></label>
                  
                  <input placeholder="Infome seu CEP" class="form-control form-control"  name="cep" type="text" onkeyup="atualizaForm();" id="cep" value="" onblur="pesquisacep(this.value);" /><br />
                 
                  <input placeholder="Infome sua rua" class="form-control form-control"  name="rua" type="text" onkeyup="atualizaForm();" id="rua"  /><br />

                  <input placeholder="Infome o número" class="form-control form-control"  name="numero" type="text" onkeyup="atualizaForm();" id="numero"  /><br />
                  
                  <input placeholder="Infome um complemento" class="form-control form-control"  name="complemento" type="text" onkeyup="atualizaForm();" id="complemento" /><br />
                  
                  <input placeholder="Infome seu bairro" class="form-control form-control"  name="bairro" type="text" onkeyup="atualizaForm();" id="bairro" /><br />
                  
                  <input placeholder="Infome sua cidade" class="form-control form-control"  name="cidade" type="text" onkeyup="atualizaForm();" id="cidade" /><br />
                  
                  <input placeholder="Infome seu estado" class="form-control form-control"  name="uf" type="text" onkeyup="atualizaForm();" id="uf" /><br />

                  <input placeholder="Observação (Ex: Tocar campainha apenas uma vez)" class="form-control form-control"  name="observacao" type="text" onkeyup="atualizaForm();" id="observacao" /><br />
                  
                  

              </div>
            </div>
        <?php echo $__env->make('partials.fields',
        ['fields'=>[
          ['ftype'=>'input','name'=>"", 'id'=>"addressID",'placeholder'=>"Your delivery address here ...",'required'=>true],
          ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="" style="display: none;">
        <label><?php echo e(__('Delivery area')); ?></label>
          <select name="delivery_area" id="delivery_area" class="noselecttwo form-control<?php echo e($errors->has('deliveryAreas') ? ' is-invalid' : ''); ?>" >
            <option  value="0"><?php echo e(__('Select delivery area')); ?></option>
            <?php $__currentLoopData = $restorant->deliveryAreas()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $simplearea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option data-cost="<?php echo e($simplearea->cost); ?>" value="<?php echo e($simplearea->id); ?>"><?php echo e($simplearea->getPriceFormated()); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

      </div>
    </div>
</div>

<style type="text/css">
  #addressID {
    display: none;
  }
</style>

 <script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
            

        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function atualizaForm() {

            var conteudoNumber = document.getElementById('numero').value;
            var conteudoLogradouro = document.getElementById('rua').value;
            var conteudoBairro = document.getElementById('bairro').value;
            var conteudocidade = document.getElementById('cidade').value;
            var conteudoUF = document.getElementById('uf').value;
            var conteudoComplemento = document.getElementById('complemento').value;
            var conteudoObservacao = document.getElementById('observacao').value;
            var fullAddress = conteudoLogradouro + ", " + conteudoNumber  + " - " + conteudoBairro + " - " + conteudocidade + " - " + conteudoUF + " - Complemento: " + conteudoComplemento + " - Observação na entrega: " + conteudoObservacao;
            document.getElementById('addressID').value=fullAddress;

    }
        

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>

    <script type="text/javascript">

    setTimeout(function(){ 

    $('.product-item_quantity').each(function(){

        var textDot = $(this).html();
        console.log(textDot);
        textDot = textDot.replace(".", ",");

        if(textDot.indexOf("R$") !== -1) {
          $(this).html(textDot);
        }

     });


    }, 1000);


    </script>
<?php /**PATH /var/www/test.com/html/laravel/resources/views/cart/newaddress.blade.php ENDPATH**/ ?>