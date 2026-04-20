@extends('layouts.peminjam')

@section('title', 'Ajukan Peminjaman')

@section('styles')
<style>
    .submit-page { max-width: 1200px; display: grid; gap: 18px; }
    .hero {
        background: linear-gradient(140deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 16px 34px rgba(15, 23, 42, 0.2);
    }
    .hero h2 { margin: 0 0 6px 0; font-size: 26px; font-weight: 800; }
    .hero p { margin: 0; color: #cbd5e1; font-size: 14px; line-height: 1.6; }
    .alert {
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 600;
    }
    .alert-error { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; }
    .form-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        padding: 22px;
    }
    .form-grid { display: grid; gap: 14px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .field { display: grid; gap: 8px; }
    .field label {
        font-weight: 700;
        color: #334155;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .35px;
    }
    .input {
        width: 100%;
        border: 1px solid #dbe3f0;
        background: #f8fafc;
        border-radius: 10px;
        padding: 11px 12px;
        font-size: 14px;
        color: #0f172a;
        outline: none;
    }
    .input:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
    }
    .error-msg { color: #dc2626; font-size: 12px; font-weight: 600; }
    .stock-info {
        display: flex;
        align-items: center;
        min-height: 44px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1d4ed8;
        font-weight: 700;
    }
    .stock-info.is-empty {
        background: #f8fafc;
        border-color: #dbe3f0;
        color: #64748b;
    }
    .actions { margin-top: 6px; display: flex; justify-content: flex-end; grid-column: 1 / -1; }
    .btn-submit {
        border: none;
        border-radius: 10px;
        padding: 9px 14px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        background: #4f46e5;
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
    }
    .section-head {
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 15px;
        font-weight: 800;
        color: #0f172a;
        background: #f8fafc;
    }
    .table-wrap { overflow-x: auto; }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }
    .data-table thead {
        background: #6C63FF;
        color: #ffffff;
    }
    .data-table th,
    .data-table td {
        padding: 14px 16px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e2e8f0;
    }
    .data-table tbody tr:hover { background: #f8fafc; }
    .cell-strong {
        font-weight: 700;
        color: #0f172a;
    }
    .stock-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        padding: 6px 10px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 12px;
    }
    .stock-ok {
        background: #dcfce7;
        color: #166534;
    }
    .stock-low {
        background: #fee2e2;
        color: #991b1b;
    }
    .empty-state {
        padding: 20px;
        text-align: center;
        color: #64748b;
        font-size: 14px;
        background: #f8fafc;
    }
    @media (max-width: 900px) {
        .form-grid { grid-template-columns: 1fr; }
        .actions { grid-column: auto; }
    }
</style>
@endsection

@section('content')
<div class="submit-page">
    <section class="hero">
        <h2>Ajukan Peminjaman</h2>
        <p>Pilih alat seperti laptop atau proyektor dan tanggal pinjam, lalu kirim pengajuan untuk diproses petugas.</p>
        <p style="margin-top:8px;font-size:13px;color:#dbeafe;">Batas pinjam 7 hari. Jika terlambat mengembalikan, denda Rp 5.000 per hari.</p>
    </section>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <section class="form-card">
        <form action="{{ route('peminjam.ajukan.store') }}" method="POST" class="form-grid">
            @csrf

            <div class="field">
                <label>Pilih Alat</label>
                <select name="id_laptop" id="id_laptop" class="input">
                    <option value="">-- Pilih --</option>
                    @foreach($laptop as $l)
                        <option
                            value="{{ $l->id_laptop }}"
                            data-stok="{{ $l->stok }}"
                            {{ old('id_laptop') == $l->id_laptop ? 'selected' : '' }}
                        >
                            {{ $l->nama_laptop }}
                        </option>
                    @endforeach
                </select>
                @error('id_laptop') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label>Stok Tersedia</label>
                <div id="stock_info" class="input stock-info is-empty">Pilih alat terlebih dahulu</div>
            </div>

            <div class="field">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" value="{{ old('tgl_pinjam') }}" class="input">
                @error('tgl_pinjam') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label>Jumlah Pinjam</label>
                <input
                    type="number"
                    name="jumlah_pinjam"
                    id="jumlah_pinjam"
                    min="1"
                    step="1"
                    value="{{ old('jumlah_pinjam', 1) }}"
                    class="input"
                >
                @error('jumlah_pinjam') <div class="error-msg">{{ $message }}</div> @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Pengajuan</button>
            </div>
        </form>
    </section>

    <section class="table-card">
        <div class="section-head">Stok Alat Tersedia</div>
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laptop as $no => $l)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td class="cell-strong">{{ $l->nama_laptop }}</td>
                        <td>{{ $l->kategori->nama_kategori ?? '-' }}</td>
                        <td>
                            <span class="stock-badge {{ $l->stok > 3 ? 'stock-ok' : 'stock-low' }}">
                                {{ $l->stok }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-state">Tidak ada alat tersedia saat ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const laptopSelect = document.getElementById('id_laptop');
        const stockInfo = document.getElementById('stock_info');
        const jumlahPinjamInput = document.getElementById('jumlah_pinjam');

        const updateStockInfo = () => {
            const selectedOption = laptopSelect.options[laptopSelect.selectedIndex];
            const stok = selectedOption?.dataset?.stok;

            if (!stok) {
                stockInfo.textContent = 'Pilih alat terlebih dahulu';
                stockInfo.classList.add('is-empty');
                jumlahPinjamInput.value = 1;
                jumlahPinjamInput.max = 1;
                return;
            }

            stockInfo.textContent = stok + ' unit tersedia';
            stockInfo.classList.remove('is-empty');

            const maxStok = parseInt(stok, 10);
            jumlahPinjamInput.max = maxStok;

            const current = parseInt(jumlahPinjamInput.value || '1', 10);
            if (isNaN(current) || current < 1) {
                jumlahPinjamInput.value = 1;
                return;
            }
            if (current > maxStok) {
                jumlahPinjamInput.value = maxStok;
            }
        };

        jumlahPinjamInput.addEventListener('input', () => {
            const selectedOption = laptopSelect.options[laptopSelect.selectedIndex];
            const stok = parseInt(selectedOption?.dataset?.stok || '0', 10);
            const current = parseInt(jumlahPinjamInput.value || '1', 10);

            if (isNaN(current) || current < 1) {
                jumlahPinjamInput.value = 1;
                return;
            }
            if (stok > 0 && current > stok) {
                jumlahPinjamInput.value = stok;
            }
        });

        laptopSelect.addEventListener('change', updateStockInfo);
        updateStockInfo();
    });
</script>
@endsection
