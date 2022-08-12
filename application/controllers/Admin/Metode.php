<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Metode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        place_url();
        check_not_login();
        $this->load->model('DataPenerapan_model');
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Metode', 'Admin/Metode');
        // output
        $data['title'] = 'Penerapan Metode';
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $this->template->admin('admin/metode/main', $data);
    }
    public function process()
    {
        $this->form_validation->set_rules('jumlah_partikel', 'Jumlah Partikel', 'required');
        $this->form_validation->set_rules('jumlah_iterasi', 'Jumlah Iterasi', 'required');
        $this->form_validation->set_rules('bobot_inersia', 'Bobot inersia', 'required');
        $this->form_validation->set_rules('c1', 'C1', 'required');
        $this->form_validation->set_rules('c2', 'C2', 'required');
        $this->form_validation->set_rules('r1', 'R1', 'required');
        $this->form_validation->set_rules('r2', 'R2', 'required');


        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');



        if ($this->form_validation->run() == false) {
            $data = [
                'status' => 'error',
                'output' => $this->form_validation->error_array()
            ];
            echo json_encode($data);
        } else {
            $data = [
                'inisialisasi' => [
                    'jumlah_partikel' => $this->input->post('jumlah_partikel', true),
                    'jumlah_iterasi' => $this->input->post('jumlah_iterasi', true),
                    'bobot_inersia' => $this->input->post('bobot_inersia', true),
                    'c1' => $this->input->post('c1', true),
                    'c2' => $this->input->post('c2', true),
                    'r1' => $this->input->post('r1', true),
                    'r2' => $this->input->post('r2', true),
                ]

            ];
            $this->session->set_userdata($data);

            $json = [
                'status_db' => 'success',
                'msg' => 'Berhasil inisialisasi data, lanjut ke proses perhitungan',
                'url' => base_url('Admin/Metode/processMetode')
            ];
            echo json_encode($json);
        }
    }

    public function processMetode()
    {
        if (!$this->session->has_userdata('inisialisasi')) {
            $this->session->set_flashdata('error', 'Anda belum menginisialisasikan metode fuzzy chen');
            return redirect(base_url('Admin/Metode'));
        }
        // breadcrumbs
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Inisialisasi', 'Admin/Metode');
        $this->breadcrumbs->push('Proses Fuzzy Chen', 'Admin/processMetode');


        $session = $this->session->userdata()['inisialisasi'];
        $metode = new FuzzyChain();
        // inisialisasi
        $inisialisasi = $metode->inisialisai();

        // data awal partikel
        $data_partikel_awal = $metode->dataAwalPartikel($inisialisasi, $session);
        $partikel_awal_var = $data_partikel_awal;

        // kecepatan awal
        $kecepatan_awal_partikel = $metode->kecepatanAwalPartikel($session, $inisialisasi);
        $kecepatan_awal_var = $kecepatan_awal_partikel;

        // data penerapan
        $data_penerapan = mengurutkanDataPenerapan()['data_row'];

        // proses iterasi
        $partikel_iterasi = [];
        $mid_point_iterasi = [];
        $fuzzifikasi_iterasi = [];
        $flr_iterasi = [];
        $flrg_iterasi = [];
        $defuzifikasi_iterasi = [];
        $prediksi_error_iterasi = [];
        $pembaruan_posisi_iterasi = [];

        for ($i = 0; $i < $session['jumlah_iterasi']; $i++) {

            // membentuk himpunan fuzzy
            $bentukHimpunanFuzzy = $metode->membentukHimpunanFuzzy($session, $inisialisasi, $data_partikel_awal, $i);
            // end membentukan himpunan fuzzy

            // fuzifikasi data historis
            $fuzzifikasiHistoris = $metode->fuzzifikasiDataHistoris($data_penerapan, $bentukHimpunanFuzzy, $i);
            // end fuzifikasi data historis

            // fuzzifikasi logic relationship
            $fuzzifikasiLogicRelatioShip = $metode->fuzzifikasiLogicRelationShip($fuzzifikasiHistoris, $i);
            // end fuzzifikasi logic relationship

            // fuzzy logic relationship group (flrg)
            $fuzzifikasiLogicRelationShipGroup = $metode->fuzzifikasiLogicRelationShipGroup($fuzzifikasiLogicRelatioShip, $i);
            // end fuzzy logic relationship group (flrg)

            // defuzifikasi
            $defuzifikasi = $metode->defuzifikasi($bentukHimpunanFuzzy, $fuzzifikasiLogicRelationShipGroup, $i);
            // end defuzifikasi

            // prediksi dan error
            $prediksiDanError = $metode->prediksiDanError($fuzzifikasiHistoris, $defuzifikasi, $i);
            // end prediksi dan error

            // pemilihan pbest
            $pemilihanPbest = $metode->pemilihanPbest($data_partikel_awal, $prediksiDanError, $i);
            // end pemilihan pbest


            // pembaruan kecepatan partikel
            $pembaruanKecepatanPartikel = $metode->pembaruanKecepatanPartikel($kecepatan_awal_partikel, $session, $pemilihanPbest, $data_partikel_awal, $i);
            // end pembaruan kecepatan partikel

            // pembaruan posisi partikel
            $posisi = [];
            foreach ($pembaruanKecepatanPartikel['pembaruan_kecepatan_iterasi'][$i] as $key => $v_interval) {
                foreach ($v_interval as $interval => $value) {
                    $posisi[$key][$interval] = $data_partikel_awal[$key][$interval] + $value;
                }
            }

            // mengurutkan posisi partikel
            $arr_posisi = [];
            foreach ($posisi as $key => $v_posisi) {
                asort($v_posisi);
                $arr_posisi[$key] = $v_posisi;
            }
            $pembaruan_posisi_iterasi[$i] = $arr_posisi;

            // end pembaruan posisi partikel
            $data_partikel_awal = $pembaruan_posisi_iterasi[$i];
            $kecepatan_awal_partikel = $pembaruanKecepatanPartikel['pembaruan_kecepatan_iterasi'][$i];
        }

        $partikel_awal_akhir = $data_partikel_awal;
        $kecepatan_awal_akhir = $kecepatan_awal_partikel;

        // proses prediksi
        $proses_prediksi = new ProsesPrediksi();

        // membentuk himpunan fuzzy
        $bentukHimpunanFuzzy = $proses_prediksi->membentukHimpunanFuzzy($pemilihanPbest, $inisialisasi);
        // end membentuk himpunan fuzzy

        // fuzzifikasi data historis
        $fuzzifikasiDataHistoris = $proses_prediksi->fuzzifikasiDataHistoris($data_penerapan, $bentukHimpunanFuzzy);
        //  end fuzzifikasi data historis

        // fuzzy logic relationship (flr)
        $fuzzifikasiLogicRelationship = $proses_prediksi->fuzzifikasiLogicRelationShip($fuzzifikasiDataHistoris);
        // end fuzzy logic relationship

        // fuzzy logic relationship group (flrg)
        $fuzzifikasiLogicRelationShipGroup = $proses_prediksi->fuzzifikasiLogicRelationShipGroup($fuzzifikasiLogicRelationship);
        // end fuzzy logic relationship group (flrg)

        // defuzifikasi
        $defuzifikasi = $proses_prediksi->defuzifikasi($bentukHimpunanFuzzy, $fuzzifikasiLogicRelationShipGroup);
        // end defuzifikasi

        // prediksi dan error
        $prediksiDanError = $proses_prediksi->prediksiDanError($fuzzifikasiDataHistoris, $defuzifikasi);
        // end proses prediksi

        // output
        $data['title'] = 'Penerapan Metode';
        $data['breadcrumb'] = $this->breadcrumbs->show();
        $data['bentuk_himpunan_fuzzy'] = $bentukHimpunanFuzzy;
        $data['fuzzifikasi_data_historis'] = $fuzzifikasiDataHistoris;
        $data['fuzzy_logic_relationship'] = $fuzzifikasiLogicRelationship;
        $data['fuzzy_logic_relationship_group'] = $fuzzifikasiLogicRelationShipGroup;
        $data['defuzzifikasi'] = $defuzifikasi;
        $data['prediksi_dan_error'] = $prediksiDanError;
        $data['kecepatan_awal'] = $kecepatan_awal_var;
        $data['partikel_awal'] = $partikel_awal_var;
        $data['kecepatan_akhir'] = $kecepatan_awal_akhir;
        $data['partikel_akhir'] = $partikel_awal_akhir;
        $data['tanggal_grafik'] = mengurutkanDataPenerapan()['label_bulan'];
        $data['data_grafik'] = mengurutkanDataPenerapan()['label_data'];
        $data['inisialisasi_metode'] = $inisialisasi;

        $this->template->admin('admin/metode/hasil', $data);
    }

    private function random_float($min, $max)
    {
        return number_format(random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX), 2, '.', ',');
    }
}
