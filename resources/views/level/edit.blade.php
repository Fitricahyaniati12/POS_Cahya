@extends('layouts.template') 

@section('content')
<div class="card card-outline card-primary"> 
    <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"></div> 
    </div> 
    <div class="card-body"> 
        @empty($level) 
            <!-- Menampilkan pesan error jika data level tidak ditemukan -->
            <div class="alert alert-danger alert-dismissible"> 
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> 
                Data yang Anda cari tidak ditemukan. 
            </div> 
            <!-- Tombol kembali ke halaman level -->
            <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a> 
        @else 
            <!-- Form untuk mengedit data level -->
            <form method="POST" action="{{ url('/level/'.$level->level_id) }}" class="form-horizontal"> 
                @csrf 
                {!! method_field('PUT') !!}  <!-- Method PUT digunakan untuk proses update data --> 
                
                <div class="form-group row"> 
                    <label class="col-1 control-label col-form-label">Kode Level</label>
                    <div class="col-11">
                        <input type="text" class="form-control" id="level_kode" name="level_kode" 
                            value="{{ old('level_kode', $level->level_kode) }}" required> 
                        @error('level_kode') 
                            <small class="form-text text-danger">{{ $message }}</small> 
                        @enderror 
                    </div> 
                </div> 

                <div class="form-group row"> 
                    <label class="col-1 control-label col-form-label">Nama Level</label> 
                    <div class="col-11"> 
                        <input type="text" class="form-control" id="level_nama" name="level_nama" 
                            value="{{ old('level_nama', $level->level_nama) }}" required> 
                        @error('level_nama') 
                            <small class="form-text text-danger">{{ $message }}</small> 
                        @enderror 
                    </div> 
                </div>  

                <div class="form-group row"> 
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11"> 
                        <!-- Tombol untuk menyimpan perubahan -->
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button> 
                        <!-- Tombol kembali ke halaman level -->
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('level') }}">Kembali</a> 
                    </div> 
                </div> 
            </form> 
        @endempty 
    </div> 
</div> 
@endsection 

@push('css') 
@endpush 

@push('js') 
@endpush 
