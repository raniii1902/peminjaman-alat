<h2>Form Peminjaman</h2>

<form action="/peminjaman" method="POST">
    @csrf

    <select name="id_laptop">
        @foreach($laptop as $l)
            <option value="{{ $l->id_laptop }}">
                {{ $l->nama_laptop }} (Stok: {{ $l->stok }})
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">Pinjam</button>
</form>
