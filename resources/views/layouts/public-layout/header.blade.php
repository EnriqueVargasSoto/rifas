<nav class="navbar navbar-expand-sm navbar-light bg-light border-bottom shadow-sm fixed-top">
    <a class="navbar-brand" href="#">Sentimiento amazonico</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03"
        aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav ml-auto mr-4">
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('welcome') }}">
                    <i class="fa fa-home"></i>
                    Inicio</a>
            </li>

            @auth('client')
                <li class="nav-item position-relative mr-2 {{ request()->is('cart') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                            {{ session('cart') ? count(session('cart')) : 0 }}
                        </span>
                        &nbsp;&nbsp;Carrito
                    </a>
                </li>
                <li class="nav-item {{ request()->is('purchases') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('purchases.index') }}">
                        <i class="fas fa-shipping-fast"></i> Mis compras
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <div class="header-media">
                                    <i class="fas fa fa-user"></i>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item" href="{{route('client-update-view')}}" >
                                {{ auth('client')->user()->name  }}
                            </a>
                            <a href="{{ route('logout-client') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item ai-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="var(--primary)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ms-2">Logout </span>
                            </a>
                            <form id="logout-form" action="{{ route('logout-client') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            @endauth
            <li class="nav-item">
                <a class="btn btn-outline-primary" href="{{ route('login') }}">Intranet</a>
            </li>
        </ul>
    </div>
</nav>
