<div class="card card-profile shadow">
    <div class="px-4">
      <div class="mt-5">
        <h3><?php echo e(__('Delivery')); ?> / Reserva<span class="font-weight-light"></span></h3>
      </div>
      <div class="card-content border-top">
        <br />

        <div class="custom-control custom-radio mb-3">
          <input name="deliveryType" class="custom-control-input" id="deliveryTypeDeliver" type="radio" value="delivery" checked>
          <label class="custom-control-label" for="deliveryTypeDeliver"><?php echo e(__('Delivery')); ?></label>
        </div>
        <div class="custom-control custom-radio mb-3">
          <input name="deliveryType" class="custom-control-input" id="deliveryTypePickup" type="radio" value="pickup">
          <label class="custom-control-label" for="deliveryTypePickup"><?php echo e(__('Reservar mesa')); ?></label>
        </div>

      </div>
      <br />
      <br />
    </div>
  </div>
  <br />
<?php /**PATH /var/www/test.com/html/laravel/resources/views/cart/delivery.blade.php ENDPATH**/ ?>