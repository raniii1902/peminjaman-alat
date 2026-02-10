<h2>Data Peminjaman</h2>

<a href="/peminjaman/create">+ Pinjam Laptop</a>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10">
    <tr>
        <th>No</th>
        <th>Nama Peminjam</th>
        <th>Laptop</th>
        <th>Tgl Pinjam</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach($data as $no => $p)
    <tr>
        <td>{{ $no+1 }}</td>
        <td>{{ $p->user->nama_lengkap }}</td>
        <td>{{ $p->laptop->nama_laptop }}</td>
        <td>{{ $p->tgl_pinjam }}</td>
        <td>{{ $p->status }}</td>
        <td>
            @if($p->status == 'dipinjam')
                <a href="/kembalikan/{{ $p->id_peminjaman }}">Kembalikan</a>
            @endif
        </td>
    </tr>
    @endforeach
</table>
