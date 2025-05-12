@extends('layouts.template')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan_detail/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('penjualan_detail/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Filter dropdown --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="filter_barang">Filter:</label>
                <select id="filter_barang" class="form-control">
                    <option value="">- Semua Barang -</option>
                    @foreach ($barang as $item)
                        <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-secondary mt-4" onclick="filterTable()">Terapkan</button>
            </div>
            <div class="col-md-2">
                <button class="btn btn-sm btn-light mt-4" onclick="resetFilter()">Reset</button>
            </div>
        </div>

        {{-- Tabel --}}
        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan_detail">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Penjualan ID</th>
                    <th>Barang ID</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
</div>
@endsection

@push('js')
<script>
    function modalAction(url = '') {
        $('#myModal').load(url, function () {
            $('#myModal').modal('show');
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var dataPenjualanDetail;

    $(document).ready(function () {
        dataPenjualanDetail = $('#table_penjualan_detail').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('penjualan_detail/list') }}",
                type: "POST",
                data: function (d) {
                    d.barang_id = $('#filter_barang').val(); // Kirim filter ke server
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "penjualan_id" },
                { data: "barang_id" },
                { data: "harga" },
                { data: "jumlah" },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });
    });

    function filterTable() {
        dataPenjualanDetail.ajax.reload();
    }

    function resetFilter() {
        $('#filter_barang').val('');
        dataPenjualanDetail.ajax.reload();
    }
</script>
@endpush
