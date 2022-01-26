<?php if(config('app.ordering')): ?>
    <h6 class="heading-small text-muted mb-4"><?php echo e(__('Orders')); ?></h6>


    <?php echo $__env->make('partials.fields',['fields'=>[
        ['required'=>true,'ftype'=>'input','type'=>'number','placeholder'=>"Minimum order",'name'=>'Quantidade mínima', 'additionalInfo'=>'Enter Minimum order value', 'id'=>'minimum', 'value'=>$restorant->minimum],
        ['required'=>true,'ftype'=>'select','placeholder'=>"",'name'=>'Tempo estimado para preparar um pedido, em minutos', 'id'=>'custom[time_to_prepare_order_in_minutes]','data'=>[0=>0,5=>5,10=>10,15=>15,20=>20,25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,60=>60,90=>90,120=>120],'value'=>$restorant->getConfig('time_to_prepare_order_in_minutes',config('settings.time_to_prepare_order_in_minutes'))],
        ['required'=>true,'ftype'=>'select','placeholder'=>"",'name'=>'Tempo de intervalo entre pedidos', 'id'=>'custom[delivery_interval_in_minutes]','data'=>[5=>5,10=>10,15=>15,20=>20,25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,60=>60,90=>90,120=>120],'value'=>$restorant->getConfig('delivery_interval_in_minutes',config('settings.delivery_interval_in_minutes'))]
    ]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    
            <?php endif; ?>
<?php /**PATH /var/www/test.com/html/laravel/resources/views/restorants/partials/ordering.blade.php ENDPATH**/ ?>