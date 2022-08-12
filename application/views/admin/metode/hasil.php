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
                <div class="card-header text-center">
                    Hasil Perhitungan Metode
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <!-- membentuk himpunan fuzzy -->
                                    <div class="card">
                                        <div class="card-header text-center">
                                            Inisialisasi Awal
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            $inisialisasi = ($this->session->userdata('inisialisasi'));
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-6 mx-auto">
                                                    <table class="table">
                                                        <tr>
                                                            <td>Jumlah Partikel</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi['jumlah_partikel']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jumlah Iterasi</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi['jumlah_iterasi']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bobot Inersia</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi['bobot_inersia']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>C1</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi['c1']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>C2</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi['c2']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>R1</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi['r1']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>R2</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi['r2']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Min</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi_metode['min_db']->min; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Max</td>
                                                            <td>:</td>
                                                            <td class="text-right"><?= $inisialisasi_metode['max_db']->max; ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <div class="card ">
                                        <div class="card-header text-center">
                                            Kecepatan Awal
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <?php
                                                $count_kecepatan_awal = (count($kecepatan_awal[0]) + 1);

                                                ?>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="<?= $count_kecepatan_awal; ?>">Kecepatan Awal Partikel</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Partikel</th>
                                                        <?php foreach ($kecepatan_awal[0] as $partikel => $v_partikel) { ?>
                                                            <th>X<?= $partikel + 1; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($kecepatan_awal as $key => $v_partikel) { ?>
                                                        <tr>
                                                            <td><?= $key + 1; ?></td>
                                                            <?php foreach ($v_partikel as $key => $value) { ?>
                                                                <td><?= $value; ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card mt-2">
                                        <div class="card-header text-center">
                                            Posisi Awal
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <?php
                                                $count_partikel_awal = (count($partikel_awal[0]) + 1);

                                                ?>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="<?= $count_partikel_awal; ?>">Posisi Awal Partikel</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Partikel</th>
                                                        <?php foreach ($partikel_awal[0] as $partikel => $v_partikel) { ?>
                                                            <th>X<?= $partikel + 1; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($partikel_awal as $key => $v_partikel) { ?>
                                                        <tr>
                                                            <td><?= $key + 1; ?></td>
                                                            <?php foreach ($v_partikel as $key => $value) { ?>
                                                                <td><?= $value; ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            Kecepatan Akhir
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <?php
                                                $count_kecepatan_akhir = (count($kecepatan_akhir[0]) + 1);

                                                ?>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="<?= $count_kecepatan_akhir; ?>">Kecepatan Akhir Partikel</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Partikel</th>
                                                        <?php foreach ($kecepatan_akhir[0] as $partikel => $v_partikel) { ?>
                                                            <th>X<?= $partikel + 1; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($kecepatan_akhir as $key => $v_partikel) { ?>
                                                        <tr>
                                                            <td><?= $key + 1; ?></td>
                                                            <?php foreach ($v_partikel as $key => $value) { ?>
                                                                <td><?= number_format($value, 2); ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card mt-2">
                                        <div class="card-header text-center">
                                            Posisi Akhir
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <?php
                                                $count_partikel_akhir = (count($partikel_akhir[0]) + 1);

                                                ?>
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="<?= $count_partikel_akhir; ?>">Posisi Akhir Partikel</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Partikel</th>
                                                        <?php foreach ($partikel_akhir[0] as $partikel => $v_partikel) { ?>
                                                            <th>X<?= $partikel + 1; ?></th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($partikel_akhir as $key => $v_partikel) { ?>
                                                        <tr>
                                                            <td><?= $key + 1; ?></td>
                                                            <?php foreach ($v_partikel as $key => $value) { ?>
                                                                <td><?= number_format($value, 2); ?></td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-lg-6 mb-3">
                                    <!-- membentuk himpunan fuzzy -->
                                    <div class="card">
                                        <div class="card-header text-center">
                                            1. Membentuk Himpunan Fuzzy
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Gbest</th>
                                                        <th colspan="3" class="text-center">Himpunan</th>
                                                        <th>Midpoint</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $himpunan = ($bentuk_himpunan_fuzzy['partikel_iterasi'][0]);
                                                    $midpoint = ($bentuk_himpunan_fuzzy['mid_point_iterasi'][0]);

                                                    foreach ($himpunan as $i_himpunan => $v_himpunan) { ?>
                                                        <tr>
                                                            <td>A<?= $i_himpunan + 1; ?></td>
                                                            <?php
                                                            foreach ($v_himpunan as $index => $value) { ?>
                                                                <?php if ($index == 1) : ?>
                                                                    <td>,</td>
                                                                <?php endif; ?>
                                                                <td><?= $value; ?></td>

                                                            <?php
                                                            }
                                                            ?>
                                                            <td><?= $midpoint[$i_himpunan] ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            2. Fuzzifikasi Data Historis
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered" id="dataTableFuzzyHistoris">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Tanggal</th>
                                                        <th>NTP</th>
                                                        <th>Fuzzifikasi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $fuzzifikasiDataHistoris = ($fuzzifikasi_data_historis['fuzzifikasi_iterasi']);

                                                    foreach ($fuzzifikasiDataHistoris as $index => $v_fuzzifikasi_historis) {
                                                        $data = check_data_penerapan($v_fuzzifikasi_historis[0][1]);

                                                    ?>

                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= bulanString($data->tanggal); ?></td>
                                                            <td><?= $data->ntp; ?></td>
                                                            <td>A<?= $v_fuzzifikasi_historis[0][0] + 1; ?></td>
                                                        </tr>

                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            3. Fuzzy Logic Relationship (FLR)
                                        </div>
                                        <div class="card-body">

                                            <table class="table table-bordered" id="flr">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Tanggal</th>
                                                        <th>NTP</th>
                                                        <th>FLR</th>
                                                        <th>FLR</th>
                                                        <th>FLR</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = 1;
                                                    $data = ($fuzzy_logic_relationship['flr_iterasi']);
                                                    foreach ($data as $i_partikel => $v_partikel) {
                                                        $penerapan = check_data_penerapan($v_partikel[0][2]);

                                                    ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= bulanString($penerapan->tanggal); ?></td>
                                                            <td><?= $penerapan->ntp; ?></td>

                                                            <td>
                                                                <?php
                                                                $flr1 = ($v_partikel[0][0]);
                                                                if (is_numeric($flr1)) {
                                                                    echo 'A' . ($flr1 + 1);
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td> --> </td>
                                                            <td>
                                                                <?php
                                                                $flr2 = ($v_partikel[0][1]);
                                                                if (is_numeric($flr2)) {
                                                                    echo 'A' . ($flr2 + 1);
                                                                } else {
                                                                    echo '-';
                                                                }
                                                                ?> </td>
                                                        </tr>

                                                    <?php
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            4. Fuzzy Logic Relationship Group
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center">FLRG</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $flrg = ($fuzzy_logic_relationship_group['flrg_iterasi'][0]);
                                                    foreach ($flrg as $key => $v_flrg) { ?>
                                                        <tr>
                                                            <td>A<?= $key + 1 ?></td>
                                                            <td> --> </td>
                                                            <td>
                                                                <?php
                                                                foreach ($v_flrg as $index => $value) { ?>
                                                                    A<?= $value + 1 ?>, &nbsp;
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="card">
                                        <div class="card-header">
                                            5. Defuzifikasi
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center">FLR</th>
                                                        <th>Nilai Peramalan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $defuzifikasi = ($defuzzifikasi['defuzifikasi_iterasi'][0]);
                                                    foreach ($defuzifikasi as $key => $v_defuzifikasi) {
                                                        $v_def = $v_defuzifikasi;
                                                        unset($v_def['nilai_ramalan']);


                                                    ?>
                                                        <tr>
                                                            <td>A<?= $key + 1 ?></td>
                                                            <td> --> </td>
                                                            <td>
                                                                <?php
                                                                foreach ($v_def as $key => $value) { ?>
                                                                    A<?= $value + 1; ?>,
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo number_format($v_defuzifikasi['nilai_ramalan'], 3);
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            6. Prediksi dan Error
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="prediksi_error">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Tanggal</th>
                                                            <th>NTP</th>
                                                            <th>Fuzzifikasi</th>
                                                            <th>FLRG</th>
                                                            <th>Ramalan</th>
                                                            <th>MSE</th>
                                                            <th>MAPE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $grafik_ramalan = [];
                                                        $no = 1;
                                                        $prediksi_error = ($prediksi_dan_error['arr_mape']);
                                                        foreach ($prediksi_error as $key => $v_p_error) {
                                                            $penerapan = check_data_penerapan($v_p_error[0][1]);
                                                        ?>
                                                            <tr>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= bulanString($penerapan->tanggal); ?></td>
                                                                <td><?= $penerapan->ntp; ?></td>
                                                                <td>A<?= $v_p_error[0][0] + 1; ?></td>
                                                                <td><?= number_format($v_p_error[0]['nilai_flrg_partikel'], 3) ?></td>
                                                                <td>
                                                                    <?php
                                                                    $v_ramalan = $v_p_error[0]['nilai_ramalan'];
                                                                    if ($v_ramalan != '-') {
                                                                        echo number_format($v_ramalan, 3);
                                                                        $grafik_ramalan[] = doubleval(number_format($v_ramalan, 3));
                                                                    } else {
                                                                        echo '-';
                                                                        $grafik_ramalan[] = 0;
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $v_mse = $v_p_error[0]['nilai_mse'];
                                                                    if ($v_mse != '-') {
                                                                        echo number_format($v_mse, 3);
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>

                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    $v_mape = $v_p_error[0]['nilai_mape'];
                                                                    if ($v_mape != '-') {
                                                                        echo number_format($v_mape, 3);
                                                                    } else {
                                                                        echo '-';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="6">Nilai Fitnes (MSE)</td>
                                                            <td>
                                                                <?php
                                                                echo (number_format($prediksi_dan_error['nilai_fitnes_iterasi'][0], 3));
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo (number_format($prediksi_dan_error['persen_mape'], 2)) . '%';
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            Grafik Metode
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            Kesimpulan
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            $index_terakhir = (count($prediksi_dan_error['arr_mape']) - 1);
                                            $penerapan = check_data_penerapan($prediksi_dan_error['arr_mape'][$index_terakhir][0][1]);
                                            $tanggal = ($penerapan->tanggal);
                                            $exp = explode('-', $tanggal);
                                            $bulan = $exp[0];
                                            $tahun = $exp[1];
                                            $next = ($bulan + 1);

                                            if ($next > 12) {
                                                $tahun = $tahun + 1;
                                                $bulan = 1;
                                            } else {
                                                $bulan = $next;
                                            }
                                            $tanggal_fix = $bulan . '-' . $tahun;
                                            $bulan_berikutnya = (bulanString($tanggal_fix));
                                            ?>
                                            <p>Prediksi NTP pada bulan berikutnya: <br>
                                                <strong>Bulan: <?= $bulan_berikutnya ?><br>
                                                    NTP: <?= number_format($prediksi_dan_error['bulan_berikutnya'], 3) ?>
                                                </strong>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- /.content -->
</div>

<script src="<?= base_url('public/template/') ?>vendor/jquery/jquery.min.js"></script>
<script src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>
<script src="<?= base_url('node_modules/chart.js/dist/chart.min.js') ?>"></script>


<script>
    $(document).ready(function() {
        $('#dataTableFuzzyHistoris').DataTable();
        $('#flr').DataTable();
        $('#prediksi_error').DataTable();

        // grafik
        const data = {
            labels: <?= $tanggal_grafik ?>,
            datasets: [{
                    label: 'Data Aktual',
                    data: <?= $data_grafik ?>,
                    borderColor: 'rgb(75, 255, 192)',
                    backgroundColor: 'rgb(75, 255, 192)',
                    yAxisID: 'y',
                },
                {
                    label: 'Nilai Ramalan',
                    data: <?= json_encode($grafik_ramalan) ?>,
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgb(54, 162, 235)',
                    yAxisID: 'y',
                }
            ]
        };


        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Perbandingan Metode'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',

                        // grid line settings
                        grid: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    },
                }
            },
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );


    })
</script>