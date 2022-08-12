<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <?= $breadcrumb; ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-dark text-white text-center">
                    Data Penerapan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="#" data-toggle="modal" data-target="#modalForm" class="btn btn-primary btn-sm btn-tambah">
                                <i class="fas fa-plus"></i> Tambah
                            </a>
                            <a href="#" data-toggle="modal" data-target="#modalImport" class="btn btn-success btn-sm btn-tambah">
                                <i class="far fa-file-excel"></i> Import
                            </a>
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Bulan</th>
                                            <th>NTPP</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="onLoad">
                                        <?php
                                        $no = 1;
                                        foreach ($penerapan as $key => $v_penerapan) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $v_penerapan->tanggal ?></td>
                                                <td><?= $v_penerapan->ntp ?></td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="<?= $v_penerapan->id_data_penerapan; ?>" data-toggle="modal" data-target="#modalForm">
                                                        <i class="fas fa-pencil-alt"></i> Edit
                                                    </a>
                                                    <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="<?= $v_penerapan->id_data_penerapan; ?>">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormLabel">Form Penerapan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data" class="form-submit">
                <input type="hidden" name="page">
                <input type="hidden" name="id_data_penerapan">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Bulan</label>
                        <input type="text" name="tanggal" class="form-control tanggal-picker" placeholder="Bulan...">
                        <span class="error_tanggal"></span>
                    </div>
                    <div class="form-group">
                        <label for="">NTPP</label>
                        <input type="number" name="ntp" class="form-control" placeholder="NTPP..." step="any">
                        <span class="error_ntp"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalImportLabel">Form Import</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/DataPenerapan/import') ?>" method="post" enctype="multipart/form-data" class="form-submit-import">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">File <small class="text-info">* Import dengan file excel (.xlsx)</small> </label>
                        <input type="file" name="import" class="form-control" required>
                        <span class="error_import"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-import">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('public/template/') ?>vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // data table
        $('#dataTable').DataTable();

        // tambah
        $(document).on('click', '.btn-tambah', function() {
            clearForm();
            $('input[name="page"]').val('add');
        })

        // edit
        $(document).on('click', '.btn-edit', function() {
            clearForm();

            $('input[name="page"]').val('edit');
            var id_data_penerapan = $(this).data('id');
            $.ajax({
                url: '<?= base_url('Admin/DataPenerapan/edit'); ?>',
                method: 'get',
                data: {
                    id_data_penerapan: id_data_penerapan
                },
                dataType: 'json',
                success: function(data) {
                    $('input[name="tanggal"]').val(data.tanggal);
                    $('input[name="ntp"]').val(data.ntp);
                    $('input[name="id_data_penerapan"]').val(data.id_data_penerapan);
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })

        // delete
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id_data_penerapan = $(this).data("id");
            Swal.fire({
                title: 'Deleted',
                text: "Yakin ingin menghapus item ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('Admin/DataPenerapan/delete') ?>",
                        dataType: 'json',
                        type: 'get',
                        data: {
                            id_data_penerapan
                        },
                        success: function(data) {
                            if (data.status_db == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Successfully',
                                    text: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $("#onLoad").load("<?= current_url() ?> #onLoad > *")
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Failed',
                                    text: data.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $("#onLoad").load("<?= current_url() ?> #onLoad > *");
                            }

                        },
                        error: function(x, t, m) {
                            console.log(x.responseText);
                        }
                    })
                }
            })
        })


        // submit
        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();

            var form = $('.form-submit')[0];
            var data = new FormData(form);
            $.ajax({
                url: '<?= base_url('Admin/DataPenerapan/process') ?>',
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'error') {
                        if (data.output.tanggal != null) {
                            $('input[name="tanggal"]').addClass('border border-danger');
                            $('.error_tanggal').html(data.output.tanggal).addClass('text-danger');
                        }
                        if (data.output.ntp != null) {
                            $('input[name="ntp"]').addClass('border border-danger');
                            $('.error_ntp').html(data.output.ntp).addClass('text-danger');
                        }
                    }

                    if (data.status_db == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully',
                            text: data.output,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        clearForm();
                        $('#modalForm').modal('hide');
                        $("#onLoad").load("<?= current_url() ?> #onLoad > *");

                    }

                    if (data.status_db == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: data.output,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        clearForm();
                        $('#modalForm').modal('hide');
                        $("#onLoad").load("<?= current_url() ?> #onLoad > *");

                    }

                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            });
        })


        // import
        $(document).on('click', '.btn-import', function(e) {
            e.preventDefault();

            var form = $('.form-submit-import')[0];
            var data = new FormData(form);
            $.ajax({
                url: '<?= base_url('Admin/DataPenerapan/import') ?>',
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    if (data.status == 'error') {
                        if (data.output.import != null) {
                            $('input[name="import"]').addClass('border border-danger');
                            $('.error_import').html(data.output.import).addClass('text-danger');
                        }
                    }

                    if (data.status_db == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully',
                            text: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        clearFormImport();
                        $('#modalImport').modal('hide');
                        $("#onLoad").load("<?= current_url() ?> #onLoad > *");

                    }

                    if (data.status_db == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        clearFormImport();
                        $('#modalImport').modal('hide');
                        $("#onLoad").load("<?= current_url() ?> #onLoad > *");

                    }

                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            });
        })

        // reset form
        function clearForm() {
            $('input[name="tanggal"]').val('');
            $('input[name="tanggal"]').removeClass('border border-danger');
            $('.error_tanggal').html('').removeClass('text-danger');

            $('input[name="ntp"]').val('');
            $('input[name="ntp"]').removeClass('border border-danger');
            $('.error_ntp').html('').removeClass('text-danger');
        }

        // reset form import
        function clearFormImport() {
            $('input[name="import"]').val('');
            $('input[name="import"]').removeClass('border border-danger');
            $('.error_import').html('').removeClass('text-danger');
        }

        // picker
        $(".tanggal-picker").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months",
            autoclose: true

        });
    })
</script>