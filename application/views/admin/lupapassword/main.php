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
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th width="5%;">No.</th>
                                            <th>Username</th>
                                            <th>No. HP</th>
                                            <th>Level</th>
                                            <th>Nama</th>
                                            <th>J.K</th>
                                            <th width="10%;">Gambar</th>
                                            <th width="10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($result as $row) :
                                        ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $row->username; ?></td>
                                                <td><?= $row->no_hp; ?></td>
                                                <td><?= $row->level; ?></td>
                                                <td><?= $row->nama_profile; ?></td>
                                                <td><?= $row->jenis_kelamin; ?></td>
                                                <td>
                                                    <a href="<?= base_url('public/image/users/' . $row->gambar_profile) ?>" target="_blank">
                                                        <img src="<?= base_url('public/image/users/' . $row->gambar_profile) ?>" alt="" width="100%;">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-success btn-reset" data-id_users="<?= $row->id_users; ?>" href="#"><i class="fas fa-pencil-alt"></i> Reset</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>
<script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-reset', function(e) {
            e.preventDefault();
            const id_users = $(this).data("id_users");
            Swal.fire({
                title: 'Reset',
                text: "Yakin ingin mereset password akun ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('Admin/Lupapassword/process') ?>",
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id_users
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                $('.btn-delete[data-id_users="' + id_users + '"]').closest('tr').load("<?= current_url() ?> .btn-delete[data-id_users='" + id_users + "']");
                            } else {
                                Swal.fire(
                                    'Fail!',
                                    'Your file has been not deleted.',
                                    'error'
                                )
                            }

                        },
                        error: function(x, t, m) {
                            console.log(x.responseText);
                        }
                    })
                }
            })

        })
    })
</script>