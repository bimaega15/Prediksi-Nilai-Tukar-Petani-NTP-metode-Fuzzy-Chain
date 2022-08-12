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
                    Grafik Data Aktual
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('public/template/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('node_modules/chart.js/dist/chart.min.js') ?>"></script>

<script>
    $(document).ready(function() {
        const labels = <?= $tanggal_grafik ?>;

        const data = {
            labels: labels,
            datasets: [{
                label: 'Grafik Data Aktual',
                backgroundColor: 'rgb(25, 99, 255)',
                borderColor: 'rgb(25, 99, 255)',
                data: <?= $data_grafik ?>,
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    })
</script>