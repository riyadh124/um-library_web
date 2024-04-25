<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #551212;">
    <div class="container">
      <img src="{{ asset('storage/images/logo_stikom-1.png') }}" style="height: 30px;margin-right:20px" alt="" srcset="">
      <a class="navbar-brand" href="/">Perpustakaan UM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active' : 'text-dark' }}" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('about') ? 'active' : 'text-dark' }}" href="/about">About</a>
          </li>
        </ul>
    
        <ul class="navbar-nav ms-auto">
   
          @auth 
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Welcome back, {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-layout-text-sidebar-reverse"></i> My Dashboard</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="/logout" method="POST">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-right"></i> Logout
                  </button>
                </form>
             </li>
            </ul>
          </li>
          @else
   
          <li class="nav-item">
            <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="/login">
              <i class="bi bi-box-arrow-in-right"></i>
              Login
            </a>
          </li>
   
          @endauth
        </ul>
        

      </div>
    </div>
  </nav>