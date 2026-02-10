<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BookLend</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: #f4f7fe;
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Style */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            font-size: 24px;
            margin-bottom: 40px;
            text-align: center;
            letter-spacing: 1px;
        }

        .nav-menu {
            list-style: none;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: block;
            padding: 12px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 10px;
            transition: 0.3s;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateX(5px);
        }

        /* Main Content Area */
        .main-content {
            flex-grow: 1;
            padding: 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .welcome-text h1 { color: #333; font-size: 28px; }

        /* Grid Menu Berdasarkan Flowchart */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .menu-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            text-align: center;
            transition: 0.3s;
            cursor: pointer;
            border: 1px solid #eee;
        }

        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(118, 75, 162, 0.15);
            border-color: #667eea;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background: #f0f3ff;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
        }

        .menu-card h3 { color: #444; margin-bottom: 10px; }
        .menu-card p { color: #888; font-size: 13px; }

        .logout-btn {
            background: #ff4b5c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>BookLend</h2>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link active">Dashboard</a></li>
            <li class="nav-item"><a href="#" class="nav-link">CRUD User</a></li>
            <li class="nav-item"><a href="#" class="nav-link">CRUD Alat</a></li>
            <li class="nav-item"><a href="#" class="nav-item"><a href="#" class="nav-link">Kategori</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Log Aktifitas</a></li>
        </ul>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; cursor:pointer; opacity:0.7">Logout</button>
        </form>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="welcome-text">
                <h1>Dashboard Admin</h1>
                <p>Selamat datang kembali, <strong>{{ Auth::user()->nama_lengkap }}</strong></p>
            </div>
            <div class="role-badge" style="background:#FFA500; color:white; padding:5px 15px; border-radius:15px; font-size:12px">
                {{ strtoupper(Auth::user()->role) }}
            </div>
        </div>

        <div class="menu-grid">
            <div class="menu-card" onclick="window.location='#user'">
                <div class="icon-box">👥</div>
                <h3>CRUD User</h3>
                <p>Tambah, Ubah, Dan Hapus Data User</p>
            </div>

            <div class="menu-card" onclick="window.location='#alat'">
                <div class="icon-box">🛠️</div>
                <h3>CRUD Alat</h3>
                <p>Kelola Inventaris Alat BookLend</p>
            </div>

            <div class="menu-card" onclick="window.location='#kategori'">
                <div class="icon-box">📁</div>
                <h3>CRUD Kategori</h3>
                <p>Pengelompokan Jenis Alat</p>
            </div>

            <div class="menu-card" onclick="window.location='#pinjam'">
                <div class="icon-box">📤</div>
                <h3>Peminjaman</h3>
                <p>Proses Data Peminjaman Alat</p>
            </div>

            <div class="menu-card" onclick="window.location='#kembali'">
                <div class="icon-box">📥</div>
                <h3>Pengembalian</h3>
                <p>Tambah dan Ubah Data Pengembalian</p>
            </div>

            <div class="menu-card" onclick="window.location='#log'">
                <div class="icon-box">📜</div>
                <h3>Log Aktifitas</h3>
                <p>Melihat Rekaman Semua Kegiatan</p>
            </div>
        </div>
    </div>

</body>
</html>