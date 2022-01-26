<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md  navbar-dark" id="navbar-main">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block">@yield('admin_title')</a>
        
        <!-- Form -->
        <form method="GET" class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
           
        </form>
       
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            
            @if(isset($availableLanguages)&&count($availableLanguages)>1&&isset($locale))
            <li class="nav-item dropdown">
              <a href="#" class="nav-link" data-toggle="dropdown" role="button">
                <i class="ni ni-world-2"></i>
                @foreach ($availableLanguages as $short => $lang)
                  @if(strtolower($short) == strtolower($locale))<span class="nav-link-inner--text">{{ $lang }}</span>@endif
                @endforeach
              </a>
              <div class="dropdown-menu">
                @foreach ($availableLanguages as $short => $lang)
                <a href="{{ route('home',$short)}}" class="dropdown-item">
                  <img src="{{ asset('images') }}/icons/flags/{{ strtoupper($short)}}.png" />
                  {{ $lang }}</a>
                @endforeach
              </div>
            </li>
          @endif

            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            
                            <img id="profile-image-nav" alt="..." src="{{'https://www.gravatar.com/avatar/'.md5(auth()->user()->email) }}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>

    </div>

</nav>

<!-- 7 dias pop-up -->

@php
if($_SERVER['REQUEST_URI'] != "/profile" & $_SERVER['REQUEST_URI'] != "/plan") {
@endphp
<div class="modal fade show" id="freeTrialModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;">
                                    <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                        <div class="modal-content bg-gradient-danger">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Período Esgotado</h5>


                                        </div>
                                        <div class="modal-body">
                                            <div>
                                                <p class="plano-payment-title-2">Seu plano de teste de 7 dias infelizmente acabou. <br/> Estamos no aguardo do seu pagamento para continuar usufruindo de nosso sistema</p>
                                            </div>
                                        <hr>


                                        <div class="price-box" style="display: none;">
                                        Seleciona a opção desejada
                                        </div>
                                        </div>
                                        <div class="modal-footer"><a href="https://app.zapentrega.com/plan"><button type="button" class="btn btn-success" data-dismiss="modal2">Efetuar pagamento</button></a><a href="https://app.zapentrega.com/profile#close_acc_btn"><button type="button" class="btn btn-warning btn-payment-cancelar">Cancelar conta</button></a></div>
                                    </div>
                                    </div>
                                </div>
<script type="text/javascript">

   


        @if (auth()->user()->email != "zapentregasolucoes@gmail.com" && auth()->user()->email != "lucasbritoweb123456@gmail.com" && auth()->user()->email != "owner@example.com")
        @php
        if(isset($_COOKIE['zapentrega-cliente-plano-atual'])) {

            $varCookiePano = $_COOKIE['zapentrega-cliente-plano-atual'];
            if($varCookiePano == "1") {
            echo 'setInterval(function(){ $("#freeTrialModal").attr("style", "display: block; padding-right: 19px;display: block;background: #969696e0;"); }, 1000);';
            }
        }
        @endphp
        @endif





</script>
@php
}
@endphp
