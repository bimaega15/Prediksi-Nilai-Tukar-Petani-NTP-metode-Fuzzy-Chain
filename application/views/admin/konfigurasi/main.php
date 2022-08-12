<?php
$profile = check_profile();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?= $breadcrumb; ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <!-- <?php $this->view('session'); ?> -->
                <div class="card-body" id="onLoad">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="<?= base_url('Admin/Konfigurasi/process') ?>" method="post" enctype="multipart/form-data" class="form-submit">
                                <input type="hidden" name="page" value="<?= $page; ?>">
                                <input type="hidden" name="id_konfigurasi" value="<?= $row->id_konfigurasi; ?>">
                                <div class="form-group">
                                    <label for="">Nama aplikasi</label>
                                    <input type="text" name="nama_aplikasi" class="form-control  <?= form_error('nama_aplikasi') != null ? 'border border-danger' : '' ?>" placeholder="Nama aplikasi" value="<?= $row->nama_aplikasi != null ? $row->nama_aplikasi : set_value('nama_aplikasi') ?>">
                                    <span class="error_nama_aplikasi"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control  <?= form_error('keterangan') != null ? 'border border-danger' : '' ?>" placeholder="Keterangan"><?= $row->keterangan != null ? $row->keterangan : set_value('keterangan') ?></textarea>
                                    <span class="error_keterangan"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">Created By</label>
                                    <input type="text" name="created_by" class="form-control  <?= form_error('created_by') != null ? 'border border-danger' : '' ?>" placeholder="Created By" value="<?= $row->created_by != null ? $row->created_by : set_value('created_by') ?>">
                                    <span class="error_created_by"></span>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Facebook</label>
                                            <input type="text" name="facebook" class="form-control  <?= form_error('facebook') != null ? 'border border-danger' : '' ?>" placeholder="Created By" value="<?= $row->facebook != null ? $row->facebook : set_value('facebook') ?>">
                                            <span class="error_facebook"></span>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Instagram</label>
                                            <input type="text" name="instagram" class="form-control  <?= form_error('instagram') != null ? 'border border-danger' : '' ?>" placeholder="Created By" value="<?= $row->instagram != null ? $row->instagram : set_value('instagram') ?>">
                                            <span class="error_instagram"></span>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Youtube</label>
                                            <input type="text" name="youtube" class="form-control  <?= form_error('youtube') != null ? 'border border-danger' : '' ?>" placeholder="Created By" value="<?= $row->youtube != null ? $row->youtube : set_value('youtube') ?>">
                                            <span class="error_youtube"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Alamat</label>
                                            <textarea id="alamat" name="alamat" class="form-control  <?= form_error('alamat') != null ? 'border border-danger' : '' ?>" placeholder="Alamat"><?= $row->alamat != null ? $row->alamat : set_value('alamat') ?>
                                    </textarea>
                                            <span class="error_alamat"></span>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">No. Handphone</label>
                                            <input type="number" name="no_hp" class="form-control  <?= form_error('no_hp') != null ? 'border border-danger' : '' ?>" placeholder="Created By" value="<?= $row->no_hp != null ? $row->no_hp : set_value('no_hp') ?>">
                                            <span class="error_no_hp"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" >Gambar Aplikasi </label>
                                    <input type="file" name="gambar_konfigurasi" class="form-control">
                                    <?php if ($row->gambar_konfigurasi != null) : ?>
                                        <a href="<?= base_url('public/image/konfigurasi/' . $row->gambar_konfigurasi) ?>" target="_blank">
                                            <img src="<?= base_url('public/image/konfigurasi/' . $row->gambar_konfigurasi) ?>" class="w-25" alt="">
                                        </a>
                                    <?php endif; ?>
                                    <span id="load_image"></span>
                                    <span class="error_gambar_konfigurasi"></span>

                                </div>
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger"> <i class="fas fa-undo"></i> Reset</button>
                                    <button type="submit" class="btn btn-primary btn-submit"> <i class="fas fa-save"></i> Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<script src="<?= base_url('public/template/') ?>vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var pane = $('#alamat');
        pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
            .replace(/(<[^\/][^>]*>)\s*/g, '$1')
            .replace(/\s*(<\/[^>]+>)/g, '$1'));
        var pane = $('#keterangan');
        pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
            .replace(/(<[^\/][^>]*>)\s*/g, '$1')
            .replace(/\s*(<\/[^>]+>)/g, '$1'));

        // submit
        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            clearForm();

            var form = $('.form-submit')[0];
            var data = new FormData(form);
            $.ajax({
                url: '<?= base_url('Admin/Konfigurasi/process') ?>',
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(data) {

                    if (data.status == 'error') {
                        if (data.output.nama_aplikasi != null) {
                            $('input[name="nama_aplikasi"]').addClass('border border-danger');
                            $('.error_nama_aplikasi').html(data.output.nama_aplikasi).addClass('text-danger');
                        }
                        if (data.output.keterangan != null) {
                            $('textarea[name="keterangan"]').addClass('border border-danger');
                            $('.error_keterangan').html(data.output.keterangan).addClass('text-danger');
                        }
                        if (data.output.created_by != null) {
                            $('input[name="created_by"]').addClass('border border-danger');
                            $('.error_created_by').html(data.output.created_by).addClass('text-danger');
                        }
                        if (data.output.facebook != null) {
                            $('input[name="facebook"]').addClass('border border-danger');
                            $('.error_facebook').html(data.output.facebook).addClass('text-danger');
                        }
                        if (data.output.instagram != null) {
                            $('input[name="instagram"]').addClass('border border-danger');
                            $('.error_instagram').html(data.output.instagram).addClass('text-danger');
                        }
                        if (data.output.youtube != null) {
                            $('input[name="youtube"]').addClass('border border-danger');
                            $('.error_youtube').html(data.output.youtube).addClass('text-danger');
                        }
                        if (data.output.alamat != null) {
                            $('textarea[name="alamat"]').addClass('border border-danger');
                            $('.error_alamat').html(data.output.alamat).addClass('text-danger');
                        }
                        if (data.output.no_hp != null) {
                            $('input[name="no_hp"]').addClass('border border-danger');
                            $('.error_no_hp').html(data.output.no_hp).addClass('text-danger');
                        }
                        if (data.output.gambar_konfigurasi != null) {
                            $('#load_image').html(data.gambar);
                            $('.error_gambar_konfigurasi').html(data.output.gambar_konfigurasi).addClass('text-danger');
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

        // reset form
        function clearForm() {
            $('input[name="nama_aplikasi"]').removeClass('border border-danger');
            $('.error_nama_aplikasi').html('').removeClass('text-danger');

            $('textarea[name="keterangan"]').removeClass('border border-danger');
            $('.error_keterangan').html('').removeClass('text-danger');

            $('input[name="created_by"]').removeClass('border border-danger');
            $('.error_created_by').html('').removeClass('text-danger');

            $('input[name="facebook"]').removeClass('border border-danger');
            $('.error_facebook').html('').removeClass('text-danger');

            $('input[name="instagram"]').removeClass('border border-danger');
            $('.error_instagram').html('').removeClass('text-danger');

            $('input[name="youtube"]').removeClass('border border-danger');
            $('.error_youtube').html('').removeClass('text-danger');

            $('input[name="alamat"]').removeClass('border border-danger');
            $('.error_alamat').html('').removeClass('text-danger');

            $('input[name="no_hp"]').removeClass('border border-danger');
            $('.error_no_hp').html('').removeClass('text-danger');

            $('input[name="gambar_konfigurasi"]').removeClass('border border-danger');
            $('.error_gambar_konfigurasi').html('').removeClass('text-danger');

            $('#load_image').html('')
        }

    })
</script>