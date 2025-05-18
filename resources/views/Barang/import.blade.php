<div class="container">
    <h1>Import Data Barang</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ url('/barang/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-info btn-sm" download>
                        <i class="fa fa-file-excel"></i> Download
                    </a>
                </div>
                
                <div class="form-group">
                    <label>Pilih File Excel</label>
                <input type="file" name="file_barang" class="form-control" required>


                    <small class="text-muted">Format file harus .xlsx</small>
                    <small id="error-file_barang" class="error-text text-danger"></small>
                </div>
                
                <div class="form-group">
                    <button type="submit" id="btn-upload" class="btn btn-primary">
                        <i class="fa fa-upload"></i> Upload
                    </button>
                    <a href="{{ url('/barang') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // CSRF Setup untuk Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form Validation + Submit
    $("#form-import").validate({
        rules: {
            file_barang: {
                required: true,
                extension: "xlsx",
            },
        },
        submitHandler: function(form) {
            var formData = new FormData(form);
            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    $('#btn-upload').prop('disabled', true).text('Mengunggah...');
                    $('.error-text').text(''); // clear error
                },
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide'); // tutup modal
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        dataBarang.ajax.reload(); // reload table ✅
                    } else {
                        // Tampilkan error validasi
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                complete: function () {
                    $('#btn-upload').prop('disabled', false).text('Upload');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'Terjadi kesalahan server.'
                    });
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>
