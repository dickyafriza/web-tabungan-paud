@extends('layouts.app')

@section('site-name', 'Sistem Informasi SPP')
@section('page-name', 'Kelas')

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            @yield('page-name')
        </h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('page-name')</h3>
                    <a href="{{ route('kelas.create') }}" class="btn btn-outline-primary btn-sm ml-5">Tambah Kelas</a>
                </div>
                @if (session()->has('msg'))
                    <div class="card-alert alert alert-{{ session()->get('type') }}" id="message"
                        style="border-radius: 0px !important">
                        @if (session()->get('type') == 'success')
                            <i class="fe fe-check mr-2" aria-hidden="true"></i>
                        @else
                            <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i>
                        @endif
                        {{ session()->get('msg') }}
                    </div>
                @endif
                <div class="table-responsive">

                    <table class="table card-table table-hover table-vcenter text-nowrap">
                        <thead>
                            <tr>
                                <th class="w-1">No.</th>
                                <th>Tahun Ajaran</th>
                                <th>Nama</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelas as $index => $item)
                                <tr>
                                    <td><span class="text-muted">{{ $index + 1 }}</span></td>
                                    <td>{{ isset($item->periode) ? $item->periode->nama : '-' }}</td>
                                    <td>
                                        <a href="#!" class="btn-detail-kelas" data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}">
                                            {{ $item->nama }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a class="icon" href="{{ route('kelas.edit', $item->id) }}" title="edit item">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <a class="icon btn-delete" href="#!" data-id="{{ $item->id }}"
                                            title="delete item">
                                            <i class="fe fe-trash"></i>
                                        </a>
                                        <form action="{{ route('kelas.destroy', $item->id) }}" method="POST"
                                            id="form-{{ $item->id }}">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <div class="ml-auto mb-0">
                            {{ $kelas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Kelas -->
    <div class="modal fade" id="modalDetailKelas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Kelas: <span id="kelas-nama"></span></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-siswa">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Total Saldo Tabungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center">Memuat data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="ml-auto">
                        <a href="#!" id="btn-export-excel" class="btn btn-success btn-sm">
                            <i class="fe fe-download"></i> Export Excel
                        </a>
                        <a href="#!" id="btn-print" class="btn btn-primary btn-sm">
                            <i class="fe fe-printer"></i> Cetak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.btn-delete', function() {
                formid = $(this).attr('data-id');
                swal({
                    title: 'Anda yakin ingin menghapus?',
                    text: 'kelas yang dihapus tidak dapat dikembalikan',
                    dangerMode: true,
                    buttons: {
                        cancel: true,
                        confirm: true,
                    },
                }).then((result) => {
                    if (result) {
                        $('#form-' + formid).submit();
                    }
                })
            });


            // Detail kelas (popup siswa)
            // Detail kelas (popup siswa)
            $(document).on('click', '.btn-detail-kelas', function() {
                let kelasId = $(this).data('id');
                let kelasNama = $(this).data('nama');

                $("#kelas-nama").text(kelasNama);
                $("#table-siswa tbody").html(
                    `<tr><td colspan="3" class="text-center">Memuat data...</td></tr>`);

                // Set link cetak dan export sesuai ID kelas
                $("#btn-export-excel").attr("href", `{{ url('kelas') }}/${kelasId}/export`);
                $("#btn-print").attr("href", `{{ url('kelas') }}/${kelasId}/print`);

                // Ambil data siswa via AJAX
                $.get("{{ url('kelas') }}/" + kelasId + "/siswa", function(res) {
                    let rows = '';
                    if (res.length > 0) {
                        res.forEach((siswa, index) => {
                            rows += `<tr>
                        <td>${index+1}</td>
                        <td>${siswa.nama}</td>
                        <td>Rp. ${Number(siswa.saldo).toLocaleString('id-ID')}</td>
                     </tr>`;
                        });
                    } else {
                        rows = `<tr><td colspan="3" class="text-center">Tidak ada siswa</td></tr>`;
                    }
                    $("#table-siswa tbody").html(rows);
                });

                $("#modalDetailKelas").modal('show');
            });


        });
    </script>
@endsection
