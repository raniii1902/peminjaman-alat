<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- HEADER -->
<div class="header">
    <h2>Dashboard Admin</h2>
    <a href="{{ route('logout') }}">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="{{ route('dashboard.admin') }}"><i class="fa fa-gauge"></i> Dashboard</a>
        <a href="{{ route('user.index') }}"><i class="fa fa-users"></i> User</a>
        <a href="{{ route('kategori.index') }}"><i class="fa fa-tags"></i> Kategori</a>
        <a href="{{ route('laptop.index') }}"><i class="fa fa-laptop"></i> Laptop</a>
        <a href="{{ route('peminjaman.index') }}"><i class="fa fa-book"></i> Peminjaman</a>
    </div>

    <!-- CONTENT -->
    <div class="content">
        @yield('content')
    </div>

</div>

</body>
</html>
