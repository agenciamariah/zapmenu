<div class="card card-profile shadow mt--300">
    <div class="px-4">
      <div class="mt-5">
        <h3>{{ __('Items') }}<span class="font-weight-light"></span></h3>
      </div>
      <style type="text/css">
      .info-block .item-type-2 {
        display: none;
      }
      </style>
        <!-- List of items -->
        <div  id="cartList" class="border-top">
            <br />
            <div  v-for="item in items" class="items col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
                <div class="info-block block-info clearfix" v-cloak>
                    <p style="display: none;" id="erase-all">@{{ item.attributes.item_orcamento }}</p>
                    <div class="square-box pull-left">
                    <figure>
                        <img :src="item.attributes.image" :data-src="item.attributes.image"  class="productImage" width="100" height="105" alt="">
                    </figure>
                    </div>
                    <h6 class="product-item_title">@{{ item.name }}</h6>
                    <p class="product-item_quantity item-type-1">@{{ item.quantity }} x @{{ item.attributes.friendly_price }}</p>
                    <p class="product-item_quantity item-type-2">@{{ item.quantity }} x Orçamento</p>
                    <div class="row">
                        <button type="button" v-on:click="decQuantity(item.id)" :value="item.id" class="btn btn-outline-primary btn-icon btn-sm page-link btn-cart-radius">
                            <span class="btn-inner--icon btn-cart-icon"><i class="fa fa-minus"></i></span>
                        </button>
                        <button type="button" v-on:click="incQuantity(item.id)" :value="item.id" class="btn btn-outline-primary btn-icon btn-sm page-link btn-cart-radius">
                            <span class="btn-inner--icon btn-cart-icon"><i class="fa fa-plus"></i></span>
                        </button>
                        <button type="button" v-on:click="remove(item.id)"  :value="item.id" class="btn btn-outline-primary btn-icon btn-sm page-link btn-cart-radius">
                            <span class="btn-inner--icon btn-cart-icon"><i class="fa fa-trash"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End List of items -->
    </div>
</div>
<br />

@section('js')
<script type="text/javascript">
console.log("item type code init: orcamento");
$("document").ready(function(){

$(".items").each(function(){
    var erasePrice = $(this).find("#erase-all");
    console.log(erasePrice);
    erasePrice = erasePrice.html();
    if(erasePrice == "2"){
        var itemText1 = $(this).find(".item-type-1");
        itemText1.attr("style", "display: none;")
        var itemText2 = $(this).find(".item-type-2");
        itemText2.attr("style", "display: block;")

        var itemBtn1 = $(this).find(".row > button:first-child");
        itemBtn1.remove();
        var itemBtn2 = $(this).find(".row > button:first-child");
        itemBtn2.remove();

    }
});

});
</script>
@endsection