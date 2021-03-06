@extends('layouts.front', ['class' => ''])

@section('extrameta')
<title>{{ $restorant->name }}</title>
<meta property="og:image" content="{{ $restorant->logom }}">
<meta property="og:image:type" content="image/png">
<meta property="og:image:width" content="590">
<meta property="og:image:height" content="400">
<meta name="og:title" property="og:title" content="{{ $restorant->description }}">
<meta name="description" content="{{ $restorant->description }}">
<style type="text/css">
    #modalPrice {
        display: none;
    }
    .item-current-box #res_title {
        font-size: 18px;
    }
    .footer_restaurante .logo { 
        padding-left: 5%;
        width: 30%;
        float: left;
        margin-bottom: 30px;
    }
    .footer_restaurante .logo-text {
        width: 70%;
        float: left;
        margin-top: 15px;
    } 
    .footer_restaurante .logo-text p {
        margin-bottom: 0px;
        font-family: "Open Sans",sans-serif;
    }
</style>
@endsection

@section('content')
<?php
    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }
?>
@include('restorants.partials.modals')

    <section class="section-profile-cover section-shaped grayscale-05 d-none d-md-none d-lg-block d-lx-block">
      <!-- Circles background -->
      <img class="bg-image" loading="lazy" src="{{ $restorant->coverm }}" style="width: 100%;">
      <!-- SVG separator -->
      <div class="separator separator-bottom separator-skew">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section>

    <section class="section pt-lg-0 mb--5 mt--9 d-none d-md-none d-lg-block d-lx-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title white"  <?php if($restorant->description){echo 'style="border-bottom: 1px solid #f2f2f2;"';} ?> >
                        <h1 class="display-3 text-white" data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;">{{ $restorant->name }}</h1>
                        <p class="display-4" style="margin-top: 120px">{{ $restorant->description }}</p>

                        <p><i class="ni ni-watch-time"></i> @if(!empty($openingTime))<span class="closed_time">{{__('Opens')}} {{ $openingTime }}</span>@endif @if(!empty($closingTime))<span class="opened_time">{{__('Opened until')}} {{ $closingTime }}</span> @endif |    @if(!empty($restorant->phone)) <i class="ni ni-mobile-button"></i> <a href="tel:{{$restorant->phone}}">{{ $restorant->phone }} </a> @endif</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @include('partials.flash')
                </div>
                @if (auth()->user()&&auth()->user()->hasRole('admin'))
                    @include('restorants.admininfo')
                @endif
            </div>
        </div>

    </section>
    <section class="section section-lg d-md-block d-lg-none d-lx-none" style="padding-bottom: 0px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @include('partials.flash')
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="title">
                        <h1 class="display-3 text" data-toggle="modal" data-target="#modal-restaurant-info" style="cursor: pointer;">{{ $restorant->name }}</h1>
                        <p class="display-4 text">{{ $restorant->description }}</p>
                        <p><i class="ni ni-watch-time"></i> @if(!empty($openingTime))<span class="closed_time">{{__('Opens')}} {{ $openingTime }}</span>@endif @if(!empty($closingTime))<span class="opened_time">{{__('Opened until')}} {{ $closingTime }}</span> @endif   @if(!empty($restorant->address))<i class="ni ni-pin-3"></i></i> <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($restorant->address) }}">{{ $restorant->address }}</a>  | @endif @if(!empty($restorant->phone)) <i class="ni ni-mobile-button"></i> <a href="tel:{{$restorant->phone}}">{{ $restorant->phone }} </a> @endif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section pt-lg-0" id="restaurant-content" style="padding-top: 0px">
        <input type="hidden" id="rid" value="{{ $restorant->id }}"/>
        <div class="container container-restorant">



            @if(!$restorant->categories->isEmpty())
        <nav class="tabbable sticky" style="top: {{ config('app.isqrsaas') ? 64:88 }}px;">
                <ul class="nav nav-pills bg-white mb-2">
                    <li class="nav-item nav-item-category ">
                        <a class="nav-link  mb-sm-3 mb-md-0 active" data-toggle="tab" role="tab" href="">{{ __('All categories') }}</a>
                    </li>
                    @foreach ( $restorant->categories as $key => $category)
                        @if(!$category->items->isEmpty())
                            <li class="nav-item nav-item-category" id="{{ 'cat_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">
                                <a class="nav-link mb-sm-3 mb-md-0" data-toggle="tab" role="tab" id="{{ 'nav_'.clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}" href="#{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">{{ $category->name }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>


            </nav>


            @endif




            @if(!$restorant->categories->isEmpty())
            @foreach ( $restorant->categories as $key => $category)
                @if(!$category->aitems->isEmpty())
                <div id="{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}" class="{{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">
                    <h1>{{ $category->name }}</h1><br />
                </div>
                @endif
                <div class="row {{ clean(str_replace(' ', '', strtolower($category->name)).strval($key)) }}">
                    @foreach ($category->aitems as $item)
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                            <div style="cursor: pointer;" onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)" class="strip item-type-{{$item->item_orcamento}} item-current-box item-id-{{$item->id}}">
                                @if(!empty($item->image))
                                <figure>
                                    <a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)"><img src="{{ $item->logom }}" loading="lazy" data-src="{{ config('global.restorant_details_image') }}" class="img-fluid lazy" alt=""></a>
                                </figure>
                                @endif
                                <span class="res_title"><b><a onClick="setCurrentItem({{ $item->id }})" href="javascript:void(0)">{{ $item->name }}</a></b></span><br />
                                <span class="res_description">{{ $item->short_description}}</span><br />
                                @if($item->item_orcamento == 2)
                                <span class="res_mimimum">Or??amento</span>
                                @else
                                <span class="res_mimimum">@money($item->price, config('settings.cashier_currency'),config('settings.do_convertion'))</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

           <!-- ads footer start -->
           </div>
           </section>
           <footer class="footer footer_restaurante">
            <div class="container">
              <div class="row align-items-center justify-content-md-between">
                <div class="col-md-12">
                    <div class="logo">
                        <img src="{{$restorant->logowide}}" />
                    </div>
                    <div class="logo-text">
                        <p><b>{{$restorant->name}}</b> | @if(!empty($restorant->phone)) <a href="tel:{{$restorant->phone}}">{{ $restorant->phone }} </a> @endif</p>
                        <p>@if(!empty($restorant->address))<a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{ urlencode($restorant->address) }}">{{ $restorant->address }}</a> (Veja como chegar) @endif</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="banner-footer">
                    <a href="https://app.zapentrega.com/{{ $restorant->ad1_link }}" target="_blank">
                        <img style="width: 100%; height: 150px;" src="https://app.zapentrega.com/{{ $restorant->ad1_image }}" />
                    </a>
                    </div>
                </div>
              </div>
            </div>
           </footer>
           <!-- ads footer end -->

            @else
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <p class="text-muted mb-0">{{ __('Hmmm... Nothing found!')}}</p>
                        <br/><br/><br/>
                        <div class="text-center" style="opacity: 0.2;">
                            <img src="https://www.jing.fm/clipimg/full/256-2560623_juice-clipart-pizza-box-pizza-box.png" width="200" height="200"></img>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Check if is installed -->
            @if (isset($doWeHaveImpressumApp)&&$doWeHaveImpressumApp)

                <!-- Check if there is value -->
                @if (strlen($restorant->getConfig('impressum_value',''))>5)
                    <h3>{{$restorant->getConfig('impressum_title','')}}</h3>
                    <?php echo $restorant->getConfig('impressum_value',''); ?>
                @endif
            @endif

        </div>

        @if(  !(isset($canDoOrdering)&&!$canDoOrdering)   )
            <div onClick="openNav()" class="callOutShoppingButtonBottom icon icon-shape bg-gradient-red text-white rounded-circle shadow mb-4">
                <i class="ni ni-cart"></i>
            </div>
        @endif

    </section>
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-header bg-transparent pb-2">
                            <h4 class="text-center mt-2 mb-3">{{ __('Call Waiter') }}</h4>
                        </div>
                        <div class="card-body px-lg-5 py-lg-5">
                            <form role="form" method="post" action="{{ route('call.waiter') }}">
                                @csrf
                                @include('partials.fields',$fields)
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">{{ __('Call Now') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@if ($showLanguagesSelector)
    @section('addiitional_button_1')
        <div class="dropdown web-menu">
            <a href="#" class="btn btn-neutral dropdown-toggle " data-toggle="dropdown" id="navbarDropdownMenuLink2">
                <!--<img src="{{ asset('images') }}/icons/flags/{{ strtoupper(config('app.locale'))}}.png" /> --> {{ $currentLanguage }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="">
                @foreach ($restorant->localmenus()->get() as $language)
                    @if ($language->language!=config('app.locale'))
                        <li>
                            <a class="dropdown-item" href="?lang={{ $language->language }}">
                                <!-- <img src="{{ asset('images') }}/icons/flags/{{ strtoupper($language->language)}}.png" /> --> {{$language->languageName}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endsection

    @section('addiitional_button_1_mobile')
        <div class="dropdown mobile_menu">

            <a type="button" class="nav-link  dropdown-toggle" data-toggle="dropdown"id="navbarDropdownMenuLink2">
                <span class="btn-inner--icon">
                  <i class="fa fa-globe"></i>
                </span>
                <span class="nav-link-inner--text">{{ $currentLanguage }}</span>
              </a>
            <ul class="dropdown-menu" aria-labelledby="">
                @foreach ($restorant->localmenus()->get() as $language)
                    @if ($language->language!=config('app.locale'))
                        <li>
                            <a class="dropdown-item" href="?lang={{ $language->language }}">
                               <!-- <img src="{{ asset('images') }}/icons/flags/{{ strtoupper($language->language)}}.png" /> ---> {{$language->languageName}}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endsection
@endif

@section('js')
    <script>
        var CASHIER_CURRENCY = "<?php echo  config('settings.cashier_currency') ?>";
        var LOCALE="<?php echo  App::getLocale() ?>";
        var IS_POS=false;
    </script>


    <script type="text/javascript">

    var itemAtualOrcamento = false;

    $(".item-current-box").on("click", function(){
        console.log("ItemCurrentBox Click");
        if($(this).hasClass("item-type-2")){
            itemAtualOrcamento = true;
        }
    });

    setInterval(function(){ 

    $('.res_mimimum').each(function(){

        var textDot = $(this).html();
        console.log(textDot);
        textDot = textDot.replace(".", ",");

        if(textDot.indexOf("R$") !== -1) {
          $(this).html(textDot);
        }

     });


    $('.new-price').each(function(){
        var textDot = $(this).html();
        console.log(textDot);
        textDot = textDot.replace(".", ",");

        if(textDot.indexOf("R$") !== -1) {
          $(this).html(textDot);
          $(this).attr('style', 'display: block');
        }

        if(itemAtualOrcamento == true) {
            $(this).html('Or??amento');
            $(this).attr('style', 'display: block');
            itemAtualOrcamento = false;
        }

     });


    $('.product-item_quantity').each(function(){

        var textDot = $(this).html();
        console.log(textDot);
        textDot = textDot.replace(".", ",");

        if(textDot.indexOf("R$") !== -1) {
          $(this).html(textDot);
        }

     });

     


    }, 500);


    </script>



    <script src="{{ asset('custom') }}/js/order.js"></script>
    @include('restorants.phporderinterface')
@endsection

