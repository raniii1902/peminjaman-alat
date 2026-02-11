<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Peminjam') - Peminjaman Laptop</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fb;
            color: #2d3748;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header h2 {
            font-size: 24px;
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
        }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .wrapper {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        .sidebar {
            width: 260px;
            background: white;
            padding: 30px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 80px;
            height: calc(100vh - 80px);
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .sidebar-title {
            padding: 0 20px;
            font-size: 12px;
            font-weight: 700;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 20px 0 10px 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            margin: 0 10px;
            border-radius: 10px;
            text-decoration: none;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background: #f0f4ff;
            color: #667eea;
            padding-left: 24px;
        }

        .sidebar a.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .sidebar a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                top: 0;
            }

            .header {
                flex-direction: column;
                gap: 16px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

<div class="header">
    <h2><i class="fas fa-laptop-code"></i> Peminjaman Laptop</h2>
    <div class="header-actions">
        <div class="user-info">
            <div class="user-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="user-name">{{ auth()->user()->nama_lengkap ?? 'Peminjam' }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>

<div class="wrapper">
    <div class="sidebar">
        @php
            $menuItems = [
                ['label' => 'Dashboard', 'route' => 'peminjam.dashboard', 'active' => 'peminjam.dashboard', 'icon' => 'fas fa-home'],
                ['label' => 'Daftar Alat', 'route' => 'peminjam.alat', 'active' => 'peminjam.alat', 'icon' => 'fas fa-laptop'],
                ['label' => 'Ajukan Peminjaman', 'route' => 'peminjam.ajukan', 'active' => 'peminjam.ajukan', 'icon' => 'fas fa-plus'],
                ['label' => 'Pengembalian', 'route' => 'peminjam.pengembalian', 'active' => 'peminjam.pengembalian', 'icon' => 'fas fa-rotate-left'],
                ['label' => 'Status Peminjaman', 'route' => 'peminjam.peminjaman', 'active' => 'peminjam.peminjaman', 'icon' => 'fas fa-list-check'],
            ];
        @endphp

        <div class="sidebar-title">Menu Utama</div>
        @foreach($menuItems as $item)
            <a href="{{ route($item['route']) }}" @if(request()->routeIs($item['active'])) class="active" @endif>
                <i class="{{ $item['icon'] }}"></i> {{ $item['label'] }}
            </a>
        @endforeach
    </div>

    <div class="content">
        @yield('content')
    </div>
</div>

</body>
</html>
