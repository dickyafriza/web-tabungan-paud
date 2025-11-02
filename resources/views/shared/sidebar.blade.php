<div class="sidebar bg-light" style="min-width: 300px">
    <div class="p-3">
        <div class="list-group">
            <a href="{{ route('web.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['web.*'], 'active') }}">
                <i class="fe fe-home mr-2"></i> Dashboard
            </a>
            {{-- <a href="{{ route('spp.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['spp.*'], 'active') }}">
                <i class="fe fe-repeat mr-2"></i> Transaksi SPP
            </a> --}}
            <a href="{{ route('tabungan.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['tabungan.*'], 'active') }}">
                <i class="fe fe-repeat mr-2"></i> Tabungan
            </a>
            {{-- <a href="{{ route('keuangan.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['keuangan.*'], 'active') }}">
                <i class="fe fe-repeat mr-2"></i> Keuangan
            </a> --}}
            {{-- <a href="{{ route('tagihan.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['tagihan.*'], 'active') }}">
                <i class="fe fe-box mr-2"></i> Tagihan
            </a> --}}
            <a href="{{ route('siswa.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['siswa.*'], 'active') }}">
                <i class="fe fe-users mr-2"></i> Siswa
            </a>
            <a href="{{ route('kelas.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['kelas.*'], 'active') }}">
                <i class="fe fe-box mr-2"></i> Kelas
            </a>
            <a href="{{ route('periode.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['periode.*'], 'active') }}">
                <i class="fe fe-box mr-2"></i> Periode
            </a>
            {{-- <a href="{{ route('kuitansi.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['kuitansi.*'], 'active') }}">
                <i class="fe fe-folder mr-2"></i> Kuitansi
            </a> --}}
            @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'SuperAdmin')
            <a href="{{ route('user.index') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['user.*'], 'active') }}">
                <i class="fe fe-box mr-2"></i> Pengguna
            </a>
            @endif
            {{-- <a href="{{ route('buku.panduan') }}" class="list-group-item p-5 list-group-item-action {{ set_active(['buku.*'], 'active') }}">
                <i class="fe fe-book mr-2"></i> Buku Panduan
            </a> --}}
        </div>
    </div>
</div>
