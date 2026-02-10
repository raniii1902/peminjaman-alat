@extends('layouts.admin')

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-left">
            <h1 class="welcome-text">Dashboard Admin</h1>
            <p class="subtitle">Sistem Peminjaman Laptop</p>
        </div>
        <div class="header-right">
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6C63FF&color=fff" alt="User">
                <span>{{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card card-blue">
            <div class="stat-icon">
                <i class="fas fa-laptop"></i>
            </div>
            <div class="stat-info">
                <h3>125</h3>
                <p>Total Laptop</p>
            </div>
        </div>

        <div class="stat-card card-purple">
            <div class="stat-icon">
                <i class="fas fa-hand-holding"></i>
            </div>
            <div class="stat-info">
                <h3>67</h3>
                <p>Sedang Dipinjam</p>
            </div>
        </div>

        <div class="stat-card card-green">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>58</h3>
                <p>Tersedia</p>
            </div>
        </div>
    </div>


<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.dashboard-container {
    background: #F5F6FA;
    min-height: 100vh;
    padding: 30px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.welcome-text {
    font-size: 28px;
    font-weight: 700;
    color: #2D3436;
    margin-bottom: 5px;
}

.subtitle {
    font-size: 14px;
    color: #636E72;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    background: white;
    padding: 10px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.user-profile img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
}

.user-profile span {
    font-weight: 600;
    color: #2D3436;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-bottom: 35px;
}

.stat-card {
    background: white;
    padding: 30px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: white;
}

.card-blue .stat-icon {
    background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
}

.card-purple .stat-icon {
    background: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);
}

.card-green .stat-icon {
    background: linear-gradient(135deg, #56AB2F 0%, #A8E063 100%);
}

.stat-info h3 {
    font-size: 36px;
    font-weight: 700;
    color: #2D3436;
    margin-bottom: 5px;
}

.stat-info p {
    font-size: 15px;
    color: #636E72;
}

/* Menu Grid */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

.menu-card {
    background: white;
    padding: 35px;
    border-radius: 16px;
    text-align: center;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: all 0.3s;
}

.menu-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
}

.menu-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 35px;
    color: white;
}

.bg-blue {
    background: linear-gradient(135deg, #667EEA 0%, #764BA2 100%);
}

.bg-purple {
    background: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);
}

.bg-orange {
    background: linear-gradient(135deg, #FA709A 0%, #FEE140 100%);
}

.bg-green {
    background: linear-gradient(135deg, #56AB2F 0%, #A8E063 100%);
}

.bg-teal {
    background: linear-gradient(135deg, #11998E 0%, #38EF7D 100%);
}

.bg-pink {
    background: linear-gradient(135deg, #FF6B9D 0%, #FFA5C0 100%);
}

.menu-card h3 {
    font-size: 18px;
    font-weight: 700;
    color: #2D3436;
    margin-bottom: 8px;
}

.menu-card p {
    font-size: 13px;
    color: #636E72;
}

/* Responsive */
@media (max-width: 1200px) {
    .menu-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .menu-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection