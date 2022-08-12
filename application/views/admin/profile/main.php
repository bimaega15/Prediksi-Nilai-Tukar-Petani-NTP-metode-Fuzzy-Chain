<?php
$profile = check_profile();
?>
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
                    My Profile
                </div>
                <div class="card-body" id="onLoad">
                    <div class="text-center">
                        <img src="<?= base_url('public/image/user/' . $profile->gambar_profile) ?>" height="150px;" alt="" class="rounded ">
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-7 mx-auto">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Nama</td>
                                            <td class="mx-3" width="20px;">:</td>
                                            <td class="text-right"><?= $profile->nama_profile; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td class="mx-3" width="20px;">:</td>
                                            <td class="text-right"><?= $profile->jenis_kelamin == "L" ? "Laki-laki" : "Perempuan"; ?></td>
                                        </tr>
                                        <tr>
                                            <td>No. HP</td>
                                            <td class="mx-3" width="20px;">:</td>
                                            <td class="text-right"><?= $profile->no_hp; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td class="mx-3" width="20px;">:</td>
                                            <td class="text-right"><?= $profile->alamat; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td class="mx-3" width="20px;">:</td>
                                            <td class="text-right"><?= $profile->username; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Password</td>
                                            <td class="mx-3" width="20px;">:</td>
                                            <td class="text-right"><?= $profile->password; ?></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="text-center">
                                <a href="#" class="btn-edit btn-success btn btn-sm" data-id="<?= $profile->id_users; ?>" data-toggle="modal" data-target="#modalForm" class="btn btn-success btn-sm">
                                    <i class="fas fa-pencil-alt"></i> Edit Profile
                                </a>
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
                <h5 class="modal-title" id="modalFormLabel">Form Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" enctype="multipart/form-data" class="form-submit">
                <input type="hidden" name="id_users" value="<?= $profile->id_users; ?>">
                <input type="hidden" name="id_profile" value="<?= $profile->id_profile; ?>">
                <input type="hidden" name="page" value="edit">

                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username...">
                        <span class="error_username"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <small class="text-info">(*) Kosongkan jika tidak ingin diubah - min 6 karakter</small>
                        <input type="password" name="password" class="form-control" placeholder="Password...">
                        <input type="hidden" name="password_old" value="<?= $profile->password; ?>">
                        <span class="error_password"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Nama</label>
                        <input type="text" name="nama_profile" class="form-control" placeholder="Nama...">
                        <span class="error_nama_profile"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Kelamin</label> <br>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="L" value="L">
                            <label class="form-check-label" for="L">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="P" value="P">
                            <label class="form-check-label" for="P">
                                Perempuan
                            </label>
                        </div> <br>
                        <span class="error_jenis_kelamin"></span>

                    </div>
                    <div class="form-group">
                        <label for="">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="No. Handphone...">
                        <span class="error_no_hp"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Alamat</label>
                        <textarea name="alamat" class="form-control" placeholder="Alamat..."></textarea>
                        <span class="error_alamat"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Gambar</label>
                        <input type="file" name="gambar_profile" class="form-control">
                        <span id="load_image"></span>
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
<script src="<?= base_url('public/template/') ?>vendor/jquery/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // edit
        $(document).on('click', '.btn-edit', function() {
            var id_users = $(this).data('id');
            $.ajax({
                url: '<?= base_url('Admin/Profile/detail'); ?>',
                method: 'get',
                data: {
                    id_users: id_users
                },
                dataType: 'json',
                success: function(data) {
                    const {
                        row
                    } = data;

                    $('input[name="username"]').val(row.username);
                    $('input[name="nama_profile"]').val(row.nama_profile);
                    $('input[name="jenis_kelamin"][value="' + row.jenis_kelamin + '"]').attr('checked', true);
                    $('input[name="no_hp"]').val(row.no_hp);
                    $('textarea[name="alamat"]').val(row.alamat);
                    $('#load_image').html(data.gambar);
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })

        // submit
        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            clearForm();


            var form = $('.form-submit')[0];
            var data = new FormData(form);
            $.ajax({
                url: '<?= base_url('Admin/Profile/process') ?>',
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'error') {
                        if (data.output.username != null) {
                            $('input[name="username"]').addClass('border border-danger');
                            $('.error_username').html(data.output.username).addClass('text-danger');
                        }
                        if (data.output.password != null) {
                            $('input[name="password"]').addClass('border border-danger');
                            $('.error_password').html(data.output.password).addClass('text-danger');
                        }
                        if (data.output.nama_profile != null) {
                            $('input[name="nama_profile"]').addClass('border border-danger');
                            $('.error_nama_profile').html(data.output.nama_profile).addClass('text-danger');
                        }
                        if (data.output.jenis_kelamin != null) {
                            $('.error_jenis_kelamin').html(data.output.jenis_kelamin).addClass('text-danger');
                        }
                        if (data.output.no_hp != null) {
                            $('input[name="no_hp"]').addClass('border border-danger');
                            $('.error_no_hp').html(data.output.no_hp).addClass('text-danger');
                        }
                        if (data.output.alamat != null) {
                            $('textarea[name="alamat"]').addClass('border border-danger');
                            $('.error_alamat').html(data.output.alamat).addClass('text-danger');
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
            $('input[name="username"]').removeClass('border border-danger');
            $('.error_username').html('').removeClass('text-danger');

            $('input[name="nama_profile"]').removeClass('border border-danger');
            $('.error_nama_profile').html('').removeClass('text-danger');

            $('input[name="no_hp"]').removeClass('border border-danger');
            $('.error_no_hp').html('').removeClass('text-danger');

            $('.error_jenis_kelamin').html('').removeClass('text-danger');

            $('textarea[name="alamat"]').html('');
            $('.error_alamat').html('').removeClass('text-danger');

            $('#load_image').html('')
        }

    })
</script>