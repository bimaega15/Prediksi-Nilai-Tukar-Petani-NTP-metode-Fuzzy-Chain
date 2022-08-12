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
                <?php $this->view('session'); ?>
                <div class="card-body" id="onLoad">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <form action="<?= base_url('Admin/Metode/process') ?>" method="post" class="form-submit">
                                <div class="form-group">
                                    <label for="">Jumlah Partikel</label>
                                    <input type="number" step="any" name="jumlah_partikel" class="form-control" placeholder="Jumlah partikel...">
                                    <span class="error_jumlah_partikel"></span>
                                </div>
                                <div class="form-group">
                                    <label for="">Jumlah Iterasi</label>
                                    <input type="number" step="any" name="jumlah_iterasi" class="form-control" placeholder="Jumlah iterasi...">
                                    <span class="error_jumlah_iterasi"></span>

                                </div>
                                <div class="form-group">
                                    <label for="">Bobot Inersia</label>
                                    <input type="number" step="any" name="bobot_inersia" class="form-control" placeholder="Bobot inersia...">
                                    <span class="error_bobot_inersia"></span>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">C1</label>
                                            <input type="number" step="any" name="c1" class="form-control" placeholder="C1...">
                                            <span class="error_c1"></span>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">C2</label>
                                            <input type="number" step="any" name="c2" class="form-control" placeholder="C2...">
                                            <span class="error_c2"></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">R1 <small class="text-info">(* Input dari 0 - 1)</small> </label>
                                            <input type="number" min="0" max="1" step="any" name="r1" class="form-control input-r1" placeholder="R1...">
                                            <span class="error_r1"></span>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">R2 <small class="text-info">(* Input dari 0 - 1)</small></label>
                                            <input type="number" min="0" max="1" step="any" name="r2" class="form-control input-r2" placeholder="R2...">
                                            <span class="error_r2"></span>

                                        </div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary btn-sm btn-submit">
                                        Submit
                                    </button>
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
        // submit
        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            clearForm();

            var form = $('.form-submit')[0];
            var data = new FormData(form);
            $.ajax({
                url: '<?= base_url('Admin/Metode/process') ?>',
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
                        if (data.output.jumlah_partikel != null) {
                            $('input[name="jumlah_partikel"]').addClass('border border-danger');
                            $('.error_jumlah_partikel').html(data.output.jumlah_partikel).addClass('text-danger');
                        }
                        if (data.output.jumlah_iterasi != null) {
                            $('input[name="jumlah_iterasi"]').addClass('border border-danger');
                            $('.error_jumlah_iterasi').html(data.output.jumlah_iterasi).addClass('text-danger');
                        }
                        if (data.output.bobot_inersia != null) {
                            $('input[name="bobot_inersia"]').addClass('border border-danger');
                            $('.error_bobot_inersia').html(data.output.bobot_inersia).addClass('text-danger');
                        }
                        if (data.output.c1 != null) {
                            $('input[name="c1"]').addClass('border border-danger');
                            $('.error_c1').html(data.output.c1).addClass('text-danger');
                        }
                        if (data.output.c2 != null) {
                            $('input[name="c2"]').addClass('border border-danger');
                            $('.error_c2').html(data.output.c2).addClass('text-danger');
                        }
                        if (data.output.r1 != null) {
                            $('input[name="r1"]').addClass('border border-danger');
                            $('.error_r1').html(data.output.r1).addClass('text-danger');
                        }
                        if (data.output.r2 != null) {
                            $('input[name="r2"]').addClass('border border-danger');
                            $('.error_r2').html(data.output.r2).addClass('text-danger');
                        }

                    }

                    if (data.status_db == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully',
                            text: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location = data.url;
                        });

                        clearForm();

                    }

                    if (data.status_db == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        clearForm();

                    }

                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            });

        })

        // reset form
        function clearForm() {
            $('input[name="jumlah_partikel"]').removeClass('border border-danger');
            $('.error_jumlah_partikel').html('').removeClass('text-danger');

            $('input[name="jumlah_iterasi"]').removeClass('border border-danger');
            $('.error_jumlah_iterasi').html('').removeClass('text-danger');

            $('input[name="bobot_inersia"]').removeClass('border border-danger');
            $('.error_bobot_inersia').html('').removeClass('text-danger');

            $('input[name="c1"]').removeClass('border border-danger');
            $('.error_c1').html('').removeClass('text-danger');

            $('input[name="c2"]').removeClass('border border-danger');
            $('.error_c2').html('').removeClass('text-danger');

            $('input[name="r1"]').removeClass('border border-danger');
            $('.error_r1').html('').removeClass('text-danger');

            $('input[name="r2"]').removeClass('border border-danger');
            $('.error_r2').html('').removeClass('text-danger');
        }

        // input r1
        $(document).on('input', '.input-r1', function() {
            var value = $(this).val();
            if (value > 1) {
                $(this).val(0);
            } else if (value < 0) {
                $(this).val(0);
            }
        })

        // input r2
        $(document).on('input', '.input-r2', function() {
            var value = $(this).val();
            if (value > 1) {
                $(this).val(0);
            } else if (value < 0) {
                $(this).val(0);
            }
        })
    })
</script>