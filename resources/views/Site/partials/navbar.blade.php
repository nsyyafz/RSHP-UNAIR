<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RSHP - Unair Style</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Custom Unair-style Navbar */
    .navbar {
      background: linear-gradient(90deg, #003366, #ffd700);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 1.4rem;
      color: #fff !important;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .navbar-brand img {
      width: 36px;
      height: 36px;
    }

    .navbar-nav {
      margin: 0 auto;
    }

    .navbar-nav .nav-link {
      color: #f8f9fa;
      font-weight: 500;
      margin: 0 0.75rem;
      transition: color 0.3s ease, border-bottom 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
      color: #003366;
      background-color: #ffd700;
      border-radius: 5px;
      padding: 0.3rem 0.6rem;
    }

    .navbar-nav .nav-link.active {
      color: #ffd700;
      font-weight: 600;
      border-bottom: 2px solid #fff;
    }

    .nav-login {
      margin-left: auto;
    }

    .nav-login .nav-link {
      background-color: #fff;
      color: #003366 !important;
      font-weight: bold;
      padding: 0.4rem 0.8rem;
      border-radius: 20px;
      transition: background-color 0.3s ease;
    }

    .nav-login .nav-link:hover {
      background-color: #ffd700;
      color: #003366 !important;
    }

    @media (max-width: 991.98px) {
      .navbar-nav {
        margin: 0;
      }
      .nav-login {
        margin-left: 0;
        margin-top: 1rem;
      }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjujaR9waO9jWfG6hrOXWrz8t6ip-yxbNWtihPgzr3YDxr_yuMptSgOSwJZLrNKJ7E96wgecIQINX5lnG5AjRXkew9bk6L4pJ_Y2gAbBkolPjq0BtFlYT2mgHSNRPT5PG9Bpr-dMHEtp9tQafdrBtdcQ9ULFXEAxFH-tD0how5bU8sJJtcJqn9v9F-DTA/s1561/Logo%20Universitas%20Airlangga.png" alt="Logo Unair">
      RSHP
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('layanan-umum') ? 'active' : '' }}" href="{{ route('layanan-umum') }}">Layanan Umum</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('visi-misi') ? 'active' : '' }}" href="{{ route('visi-misi') }}">Visi & Misi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('struktur') ? 'active' : '' }}" href="{{ route('struktur') }}">Struktur</a>
        </li>
      </ul>
      <div class="nav-login">
        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
      </div>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>