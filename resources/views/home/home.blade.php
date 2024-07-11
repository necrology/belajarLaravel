<!DOCTYPE html>
<html lang="en">
@include('head')

<body>
    <div class="wrapper">
        @include('sidebar')
        <div class="main-panel">
            @include('tophead')
            <div class="container">
                <div class="page-inner">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h4 class="card-title">Data Barang</h4>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-round ms-auto"
                                        id="btn-insert">
                                        <i class="fa fa-plus"></i>
                                        Tambah
                                        Data</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tbl_list" class="table table-striped table-bordered" cellspacing="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>QTY</th>
                                            <th>Harga</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('footer')
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-insert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA BARANG</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="nama_barang" class="control-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-barang"></div>
                    </div>

                    <div class="form-group">
                        <label for="qty" class="control-label">QTY</label>
                        <input type="number" class="form-control" id="qty" name="qty">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-qty"></div>
                    </div>

                    <div class="form-group">
                        <label for="harga" class="control-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                    <button type="button" class="btn btn-primary" id="insert">SIMPAN</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDIT DATA BARANG</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id_edit">

                    <div class="form-group">
                        <label for="nama_barang" class="control-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang_edit" name="nama_barang">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-barang-edit"></div>
                    </div>

                    <div class="form-group">
                        <label for="qty" class="control-label">QTY</label>
                        <input type="number" class="form-control" id="qty_edit" name="qty">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-qty-edit"></div>
                    </div>

                    <div class="form-group">
                        <label for="harga" class="control-label">Harga</label>
                        <input type="number" class="form-control" id="harga_edit" name="harga">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga-edit"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                    <button type="button" class="btn btn-primary" id="edit">EDIT</button>
                </div>
            </div>
        </div>
    </div>
</body>
@include('js')
<script type="text/javascript">
    $(document).ready(function() {

        $('body').on('click', '#btn-insert', function() {
            $('#modal-insert').modal('show');
        });

        $('#tbl_list').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url()->current() }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_barang',
                    name: 'nama_barang'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ]
        });

        $('#insert').click(function(e) {
            e.preventDefault();

            //define variable
            let nama_barang = $('#nama_barang').val();
            let qty = $('#qty').val();
            let harga = $('#harga').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/insert`,
                type: "POST",
                cache: false,
                data: {
                    "nama_barang": nama_barang,
                    "qty": qty,
                    "harga": harga,
                    "_token": token
                },
                success: function(response) {

                    //show success message
                    swal({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    //clear form
                    $('#nama_barang').val('');
                    $('#qty').val('');
                    $('#harga').val('');

                    //close modal
                    $('#modal-insert').modal('hide');

                    //Refresh Datatable
                    $('#tbl_list').DataTable().ajax.reload();
                },
                error: function(error) {

                    if (error.responseJSON.nama_barang) {

                        //show alert
                        $('#alert-nama-barang').removeClass('d-none');
                        $('#alert-nama-barang').addClass('d-block');

                        //add message to alert
                        $('#alert-nama-barang').html(error.responseJSON.nama_barang[0]);
                    }

                    if (error.responseJSON.qty) {

                        //show alert
                        $('#alert-qty').removeClass('d-none');
                        $('#alert-qty').addClass('d-block');

                        //add message to alert
                        $('#alert-qty').html(error.responseJSON.qty[0]);
                    }

                    if (error.responseJSON.harga) {

                        //show alert
                        $('#alert-harga').removeClass('d-none');
                        $('#alert-harga').addClass('d-block');

                        //add message to alert
                        $('#alert-harga').html(error.responseJSON.harga[0]);
                    }

                }

            });

        });

        $('body').on('click', '#btn-delete', function() {

            let id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            swal({
                title: "Apakah Kamu Yakin?",
                text: "ingin menghapus data ini!",
                type: "warning",
                buttons: {
                    confirm: {
                        text: "YA, HAPUS!",
                        className: "btn btn-success",
                    },
                    cancel: {
                        visible: true,
                        className: "btn btn-danger",
                    },
                },
            }).then((Delete) => {
                if (Delete) {
                    $.ajax({

                        url: `/delete/${id}`,
                        type: "POST",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            swal({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            //Refresh Datatable
                            $('#tbl_list').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });


        $('body').on('click', '#btn-edit', function() {

            let id = $(this).data('id');

            //fetch detail post with ajax
            $.ajax({
                url: `/getData/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    // console.log(response.data[0].id);
                    //fill data to form
                    $('#id_edit').val(response.data[0].id);
                    $('#nama_barang_edit').val(response.data[0].nama_barang);
                    $('#qty_edit').val(response.data[0].qty);
                    $('#harga_edit').val(response.data[0].harga);

                    //open modal
                    $('#modal-edit').modal('show');
                }
            });
        });


        $('#edit').click(function(e) {

            e.preventDefault();

            //define variable
            let nama_barang = $('#nama_barang_edit').val();
            let qty = $('#qty_edit').val();
            let harga = $('#harga_edit').val();
            let id = $('#id_edit').val();
            let token = $("meta[name='csrf-token']").attr("content");

            //ajax
            $.ajax({

                url: `/update/${id}`,
                type: "POST",
                cache: false,
                data: {
                    "nama_barang": nama_barang,
                    "qty": qty,
                    "harga": harga,
                    "_token": token
                },
                success: function(response) {

                    //show success message
                    swal({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });

                    //clear form
                    $('#nama_barang_edit').val('');
                    $('#qty_edit').val('');
                    $('#harga_edit').val('');

                    //close modal
                    $('#modal-edit').modal('hide');

                    //Refresh Datatable
                    $('#tbl_list').DataTable().ajax.reload();
                },
                error: function(error) {

                    if (error.responseJSON.nama_barang) {

                        //show alert
                        $('#alert-nama-barang-edit').removeClass('d-none');
                        $('#alert-nama-barang-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-nama-barang-edit').html(error.responseJSON.nama_barang[
                        0]);
                    }

                    if (error.responseJSON.qty) {

                        //show alert
                        $('#alert-qty-edit').removeClass('d-none');
                        $('#alert-qty-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-qty-edit').html(error.responseJSON.qty[0]);
                    }

                    if (error.responseJSON.harga) {

                        //show alert
                        $('#alert-harga-edit').removeClass('d-none');
                        $('#alert-harga-edit').addClass('d-block');

                        //add message to alert
                        $('#alert-harga-edit').html(error.responseJSON.harga[0]);
                    }

                }

            });

        });
    });
</script>

</html>
