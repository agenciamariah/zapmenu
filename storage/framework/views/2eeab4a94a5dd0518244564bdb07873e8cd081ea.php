<br />
<h6 class="heading-small text-muted mb-4"><?php echo e(__('Accepting Payments')); ?></h6>
<!-- Payment explanation -->
<?php echo $__env->make('partials.fields',['fields'=>[
    ['required'=>false,'ftype'=>'input','placeholder'=>"Informações de pagamento",'name'=>'Informações de pagamento', 'additionalInfo'=>'Exemplo: Aceitamos dinheiro na entrega', 'id'=>'payment_info', 'value'=>$restorant->payment_info]
]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<?php /**PATH /var/www/test.com/html/laravel/resources/views/restorants/partials/social_info.blade.php ENDPATH**/ ?>