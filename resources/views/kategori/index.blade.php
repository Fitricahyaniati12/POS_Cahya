@extends('layouts.template') 

@section('content') 
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('kategori/create') }}">Tambah</a>
                <button onclick="modalAction('{{ url('kategori/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah
                    Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="form-group">
                <label for="filter_nama_kategori">Filter:</label>
                <select class="form-control" id="filter_nama_kategori">
                    <option value="">Semua</option>
                    @foreach (\App\Models\KategoriModel::select('nama_kategori')->distinct()->get() as $kategori)
                        <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            
            <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
                <thead>
                    <tr>
                        <th>ID Kategori</th>
                        <th>nama_kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

    @push('css') 
    @endpush

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function () {
                    $('#myModal').modal('show');
                });
            }
            var dataKategori;
            $(document).ready(function () {
            dataKategori = $('#table_kategori').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('kategori/list') }}",
                type: "POST",
                data: function (d) {
                d.nama_kategori = $('#filter_nama_kategori').val();
            }
        },
                    columns: [
                        {  // nomor urut dari laravel datatable addIndexColumn() 
                            data: "DT_RowIndex",
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        }, {
                            data: "kategori_id",
                            className: "",
                            // orderable: true, jika ingin kolom ini bisa diurutkan  
                            orderable: true,
                            // searchable: true, jika ingin kolom ini bisa dicari 
                            searchable: true
                        }, {
                            data: "nama_kategori",
                            className: "",
                            orderable: true,
                            searchable: true
                        }, {
                            data: "aksi",
                            className: "",
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
                $('#filter_nama_kategori').on('change', function () {
                dataKategori.ajax.reload();
    });

            }); 
        </script>
    @endpush