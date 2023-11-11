<nav class="navbar navbar-expand-sm navbar-light bg-light border-bottom shadow-sm fixed-top">
  <a class="navbar-brand" href="#">Sentimiento amazonico</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03"
      aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExample03">
      <ul class="navbar-nav ml-auto">
          <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('welcome') }}">
                <i class="fa fa-home"></i>
                Inicio</a>
          </li>
          <li class="nav-item position-relative mr-2 {{ request()->is('cart') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('cart.index') }}">
                  <i class="fa fa-shopping-cart"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                      {{ session('cart') ? count(session('cart')) : 0 }}
                  </span>
              </a>
          </li>
          <li class="nav-item {{ request()->is('purchases') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('purchases.index') }}">
                  <i class="fas fa-shipping-fast"></i> Mis compras
              </a>
          </li>
          <li class="nav-item">
              <a class="btn btn-outline-primary" href="{{ route('login') }}">Intranet</a>
          </li>
      </ul>
  </div>
</nav>
