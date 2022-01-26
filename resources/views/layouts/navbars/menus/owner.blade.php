<ul class="navbar-nav">
    @if(config('app.ordering'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/live">
                <i class="ni ni-basket text-success"></i> {{ __('Live Orders') }}<div class="blob red"></div>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <i class="ni ni-basket text-orangse"></i> {{ __('Orders') }}
            </a>
        </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.restaurants.edit',  auth()->user()->restorant->id) }}">
            <i class="ni ni-shop text-info"></i> {{ __('Restaurant') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('items.index') }}">
            <i class="ni ni-collection text-pink"></i> {{ __('Menu') }}
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('items.index') }}?importar=csv">
            <i class="ni ni-collection text-pink"></i> {{ __('Importar') }} {{ __('items') }}
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="https://app.zapentrega.com/?aff=teste123" target="_blank">
            <i class="fas fa-users text-info" style="color: lightgreen !important;"></i> Afiliados
        </a>
    </li>

    @if (config('app.isqrsaas') && (!config('settings.qrsaas_disable_odering') || config('settings.enable_guest_log')))
        @if(!config('settings.is_whatsapp_ordering_mode'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.restaurant.tables.index') }}">
                    <i class="ni ni-ungroup text-red"></i> {{ __('Tables') }}
                </a>
            </li>
        @endif
    @endif

    @if (config('app.isqrsaas')&&!config('settings.is_whatsapp_ordering_mode'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('qr') }}">
                <i class="ni ni-mobile-button text-red"></i> {{ __('QR Builder') }}
            </a>
        </li>
        @if(config('settings.enable_guest_log'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.restaurant.visits.index') }}">
                <i class="ni ni-calendar-grid-58 text-blue"></i> {{ __('Customers log') }}
            </a>
        </li>
        @endif
    @endif

    @if (config('app.isqrsaas')&&(config('settings.is_whatsapp_ordering_mode')||config('settings.is_pos_cloud')))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.restaurant.simpledelivery.index') }}">
                <i class="ni ni-pin-3 text-blue"></i> {{ __('Delivery areas') }}
            </a>
        </li>
    @endif

    @if(config('settings.enable_pricing'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('plans.current') }}">
                <i class="ni ni-credit-card text-orange"></i> {{ __('Plan') }}
            </a>
        </li>
    @endif

        @if(config('app.ordering')&&config('settings.enable_finances_owner'))
            <li class="nav-item">
                <a class="nav-link" href="{{ route('finances.owner') }}">
                    <i class="ni ni-money-coins text-blue"></i> {{ __('Finances') }}
                </a>
            </li>
        @endif

        <!--
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.restaurant.coupons.index') }}">
                <i class="ni ni-tag text-pink"></i> {{ __('Coupons') }}
            </a>
        </li>
    -->


    <li class="nav-item">
            <a class="nav-link" href="{{ route('share.menu') }}">
                <i class="ni ni-send text-green"></i> {{ __('Share') }}
            </a>
    </li>

    @foreach (auth()->user()->getExtraMenus() as $menu)
            <li class="nav-item">
                <a class="nav-link" href="{{ route($menu['route']) }}">
                    <i class="{{ $menu['icon'] }}"></i> {{ __($menu['name']) }}
                </a>
        </li>
    @endforeach

</ul>



    <script type="text/javascript">

    var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
    };


    var urlParam = getUrlParameter('importar');

    if(urlParam == "csv") {
        
        setTimeout(function(){ 

            $("#modal-import-items").addClass("show");
            $("#modal-import-items").attr("style", "display: block;background: #0000003d;");

            $(".modal-header button").on("click", function(){
                $("#modal-import-items").attr("style", "display: none;background: #0000003d;");
            });
        }, 1000);


        
    }


    </script>
