<?php
class FuzzyChain
{
    public function  inisialisai()
    {
        $ci = &get_instance();
        $ci->load->model('DataPenerapan_model');

        $min_db = $ci->DataPenerapan_model->minData()->row();
        $max_db = $ci->DataPenerapan_model->maxData()->row();
        $jumlah_data = $ci->DataPenerapan_model->jumlahData()->row();
        $rumus = 1 + 3.322 * (log($jumlah_data->jumlah_data, 10));

        $semesta = round($rumus);
        $interval = $semesta - 1;
        return [
            'interval' => $interval,
            'semesta' => $semesta,
            'min_db' => $min_db,
            'max_db' => $max_db,
        ];
    }
    public function dataAwalPartikel($inisialisasi, $session)
    {

        // // sort part awal
        $data_partikel_awal = [];
        for ($i = 0; $i < $session['jumlah_partikel']; $i++) {
            for ($j = 0; $j < $inisialisasi['interval']; $j++) {
                $data_partikel_awal[$i][$j] = random_float($inisialisasi['min_db']->min, $inisialisasi['max_db']->max);
            }
        }

        // sort data
        $partikel_awal_sort = [];
        foreach ($data_partikel_awal as $i_partikel => $v_interval) {
            asort($v_interval);
            $partikel_awal_sort[$i_partikel] = array_values($v_interval);
        }
        $data_partikel_awal = [];
        $data_partikel_awal = $partikel_awal_sort;

        // inisialisasi awal partikel
        // $data_partikel_awal[0][0] = 90.73;
        // $data_partikel_awal[0][1] = 94.59;
        // $data_partikel_awal[0][2] = 95.75;
        // $data_partikel_awal[0][3] = 98.61;
        // $data_partikel_awal[0][4] = 99.3;

        // $data_partikel_awal[1][0] = 90.52;
        // $data_partikel_awal[1][1] = 93.54;
        // $data_partikel_awal[1][2] = 94.22;
        // $data_partikel_awal[1][3] = 94.57;
        // $data_partikel_awal[1][4] = 94.87;

        // $data_partikel_awal[2][0] = 92.73;
        // $data_partikel_awal[2][1] = 95.09;
        // $data_partikel_awal[2][2] = 97.23;
        // $data_partikel_awal[2][3] = 98.56;
        // $data_partikel_awal[2][4] = 100.78;

        return $data_partikel_awal;
    }

    public function kecepatanAwalPartikel($session, $inisialisasi)
    {
        for ($i = 0; $i < $session['jumlah_partikel']; $i++) {
            for ($j = 0; $j < $inisialisasi['interval']; $j++) {
                $kecepatan_awal_partikel[$i][$j] = 0;
            }
        }
        return $kecepatan_awal_partikel;
    }

    public function membentukHimpunanFuzzy($session, $inisialisasi, $data_partikel_awal, $i)
    {
        // daerah partikel
        $gabung_min_max = [];
        for ($j = 0; $j < $session['jumlah_partikel']; $j++) {
            // daerah himpunan
            $daerah_min = [];
            $daerah_max = [];

            for ($k = 0; $k < $inisialisasi['semesta']; $k++) {
                // min
                if ($k == 0) {
                    $daerah_min[$k] = doubleval($inisialisasi['min_db']->min);
                } else {
                    $daerah_min[$k] = $data_partikel_awal[$j][$k - 1];
                }

                // max
                if ($k == $inisialisasi['semesta'] - 1) {
                    $daerah_max[$k] = doubleval($inisialisasi['max_db']->max);
                } else {
                    $daerah_max[$k] = $data_partikel_awal[$j][$k];
                }
            }

            // gabungkan min dan max nya
            foreach ($daerah_min as $key => $v_min) {
                $gabung_min_max[$j][] = [
                    $v_min,
                    $daerah_max[$key],
                ];
            }
        }

        // partikel iterasi selesai
        $partikel_iterasi[$i] = $gabung_min_max;


        // mencari nilai mid point
        $midPoint = 0;
        $arr_mid_point = [];
        foreach ($partikel_iterasi[$i] as $key => $v_partikel) {
            foreach ($v_partikel as $index_partikel => $min_max) {
                $count_arr = count($min_max);
                $sum_arr = array_sum($min_max);
                $midPoint = $sum_arr / $count_arr;

                $arr_mid_point[$key][$index_partikel] = $midPoint;
            }
        }
        $mid_point_iterasi[$i] = $arr_mid_point;

        return [
            'partikel_iterasi' => $partikel_iterasi,
            'mid_point_iterasi' => $mid_point_iterasi
        ];
    }

    public function fuzzifikasiDataHistoris($data_penerapan, $bentukHimpunanFuzzy, $i)
    {
        $fuzzifikasi = [];
        foreach ($data_penerapan as $key => $v_penerapan) {
            foreach ($bentukHimpunanFuzzy['partikel_iterasi'][$i] as $partikel => $v_partikel) {
                foreach ($v_partikel as $index_a => $v_min_max) {
                    if ($v_min_max[0] <= $v_penerapan->ntp && $v_penerapan->ntp <= $v_min_max[1]) {
                        $fuzzifikasi[$key][$partikel] = [$index_a, $v_penerapan->id_data_penerapan];
                    }
                }
            }
        }
        $fuzzifikasi_iterasi[$i] = $fuzzifikasi;
        return [
            'fuzzifikasi_iterasi' => $fuzzifikasi_iterasi
        ];
    }

    public function fuzzifikasiLogicRelationShip($fuzzifikasiHistoris, $i)
    {
        $arr_flr = [];
        foreach ($fuzzifikasiHistoris['fuzzifikasi_iterasi'][$i] as $index => $v_partikel) {
            foreach ($v_partikel as $partikel => $v_himpunan_a) {
                // batas bawah
                if ($index == 0) {
                    $v_bawah = '-';
                } else {
                    $v_bawah = ($fuzzifikasiHistoris['fuzzifikasi_iterasi'][$i][$index - 1][$partikel][0]);
                }

                // batas atas
                $v_atas = $v_himpunan_a[0];
                $arr_flr[$index][$partikel] = [
                    $v_bawah,
                    $v_atas,
                    $v_himpunan_a[1]
                ];
            }
        }
        $flr_iterasi[$i] = $arr_flr;
        return [
            'flr_iterasi' => $flr_iterasi
        ];
    }

    public function fuzzifikasiLogicRelationShipGroup($fuzzifikasiLogicRelatioShip, $i)
    {
        $arr_flrg = [];
        foreach ($fuzzifikasiLogicRelatioShip['flr_iterasi'][$i] as $key => $v_partikel) {
            foreach ($v_partikel as $partikel => $value) {
                $arr_flrg[$partikel][$value[0]][] = $value[1];
            }
        }

        // kondisikan ulang
        $cond_arr_flrg = [];
        foreach ($arr_flrg as $partikel => $v_partikel) {
            foreach ($v_partikel as $index_a_himpunan => $v_himpunan_a) {
                $cond_arr_flrg[$partikel][$index_a_himpunan] = (array_values(array_unique($v_himpunan_a)));
            }
        }

        // mengurutkan
        $sort_arr_flrg = [];
        foreach ($cond_arr_flrg as $key => $v_flrg) {
            ksort($v_flrg);
            $sort_arr_flrg[$key] = $v_flrg;
        }

        // hapus array yang tidak guna
        $del_arr_flrg = [];
        foreach ($sort_arr_flrg as $key => $v_flrg) {
            unset($v_flrg['-']);
            $del_arr_flrg[$key] = $v_flrg;
        }

        // sort again flrg
        $sort_again_flrg = [];
        foreach ($del_arr_flrg as $key => $v_flrg) {
            foreach ($v_flrg as $him_a => $v_him_a) {
                asort($v_him_a);
                $sort_again_flrg[$key][$him_a] = (array_values($v_him_a));
            }
        }

        $flrg_iterasi[$i] = $sort_again_flrg;
        return [
            'flrg_iterasi' => $flrg_iterasi
        ];
    }

    public function defuzifikasi($bentukHimpunanFuzzy, $fuzzifikasiLogicRelationShipGroup, $i)
    {
        $getMidPoint = $bentukHimpunanFuzzy['mid_point_iterasi'][$i];
        $arr_defuzifikasi = [];
        foreach ($fuzzifikasiLogicRelationShipGroup['flrg_iterasi'][$i] as $partikel => $v_partikel) {
            foreach ($v_partikel as $in_him_a => $v_him_a) {
                $count = count($v_him_a);
                $hitung_defuzi = 0;
                foreach ($v_him_a as $index => $value_himpunan) {
                    $hitung_defuzi += $getMidPoint[$partikel][$value_himpunan];
                }
                $fix_defuzi = ($hitung_defuzi / $count);
                $merge_array = array_merge($v_him_a, ['nilai_ramalan' => $fix_defuzi]);

                $arr_defuzifikasi[$partikel][$in_him_a] = $merge_array;
            }
        }
        $defuzifikasi_iterasi[$i] = $arr_defuzifikasi;
        return [
            'defuzifikasi_iterasi' => $defuzifikasi_iterasi
        ];
    }
    public function prediksiDanError($fuzzifikasiHistoris, $defuzifikasi, $i)
    {
        $ci = &get_instance();
        $ci->load->model('DataPenerapan_model');

        $var_fuzzifikasi = $fuzzifikasiHistoris['fuzzifikasi_iterasi'][$i];
        // mencari nilai flrg partikel
        $arr_nilai_flrg_partikel = [];
        foreach ($var_fuzzifikasi as $key_data => $v_partikel) {
            foreach ($v_partikel as $i_partikel => $v_himp_a) {
                $him_a = $v_himp_a[0];
                if (isset($defuzifikasi['defuzifikasi_iterasi'][$i][$i_partikel][$him_a]['nilai_ramalan'])) {
                    $get_nilai_flrg = $defuzifikasi['defuzifikasi_iterasi'][$i][$i_partikel][$him_a]['nilai_ramalan'];
                } else {
                    $get_nilai_flrg = 0;
                }
                $merge_array = array_merge($v_himp_a, ['nilai_flrg_partikel' => $get_nilai_flrg]);

                $arr_nilai_flrg_partikel[$key_data][$i_partikel] = $merge_array;
            }
        }

        // mencari nilai ramalan partikel
        $arr_ramalan = [];
        foreach ($arr_nilai_flrg_partikel as $key => $v_partikel) {
            foreach ($v_partikel as $i_partikel => $v_himp_a) {
                if ($key > 0) {
                    $getNilai = ($arr_nilai_flrg_partikel[$key - 1]);
                    $getNilaiNow = $arr_nilai_flrg_partikel[$key];

                    foreach ($getNilai as $key_partikel => $v_nilai) {
                        $nilai_ramalan = $v_nilai['nilai_flrg_partikel'];
                        $merge_array = array_merge(
                            [
                                $getNilaiNow[$key_partikel][0],
                                $getNilaiNow[$key_partikel][1],
                                'nilai_flrg_partikel' => $getNilaiNow[$key_partikel]['nilai_flrg_partikel'],
                                'nilai_ramalan' => $nilai_ramalan
                            ]
                        );
                        $arr_ramalan[$key][$key_partikel] = $merge_array;
                    }
                } else {
                    // daerah sebelumnya
                    $prev = '-';
                    $merge_array = array_merge($v_himp_a, ['nilai_ramalan' => $prev]);
                    $arr_ramalan[$key][$i_partikel] = $merge_array;
                }
            }
        }

        $arr_mse = [];
        foreach ($arr_ramalan as $key => $v_partikel) {
            foreach ($v_partikel as $i_partikel => $v_nilai) {
                if ($key > 0) {
                    $penerapan = $ci->DataPenerapan_model->get($v_nilai[1])->row()->ntp;
                    $hitung = pow(($v_nilai['nilai_ramalan'] - $penerapan), 2);
                    $merge_array = array_merge($v_nilai, ['nilai_mse' => $hitung]);
                    $arr_mse[$key][$i_partikel] = $merge_array;
                } else {
                    $merge_array = array_merge($v_nilai, ['nilai_mse' => '-']);
                    $arr_mse[$key][$i_partikel] = $merge_array;
                }
            }
        }
        $prediksi_error_iterasi[$i] = $arr_mse;

        // mencari nilai fitness mse
        $arr_nilai_fitnes = [];
        foreach ($prediksi_error_iterasi[$i] as $key => $v_partikel) {
            $arr_mse = array_column($v_partikel, 'nilai_mse');
            foreach ($arr_mse as $partikel => $value) {
                if (is_numeric($value)) {
                    $arr_nilai_fitnes[$partikel][] = $arr_mse[$partikel];
                }
            }
        }
        // hitung total fitness
        $total_nilai_fitnes = [];
        foreach ($arr_nilai_fitnes as $partikel => $value) {
            $count = count($arr_nilai_fitnes[$partikel]) + 1;
            $total_nilai_fitnes[$partikel] = array_sum($arr_nilai_fitnes[$partikel]) / $count;
        }
        $nilai_fitnes_iterasi[$i] = $total_nilai_fitnes;

        return [
            'nilai_fitnes_iterasi' => $nilai_fitnes_iterasi
        ];
    }

    public function pemilihanPbest($data_partikel_awal, $prediksiDanError, $i)
    {
        $merge_array = [];
        $partikel_awal = ($data_partikel_awal);
        $min = (min($prediksiDanError['nilai_fitnes_iterasi'][$i]));
        $error_terkecil = array_search($min, $prediksiDanError['nilai_fitnes_iterasi'][$i]);

        $pemilihan_gbest = $partikel_awal[$error_terkecil];
        $merge_array[$error_terkecil] = array_merge($pemilihan_gbest, ['mse' => $min]);
        $pemilihan_pbest[$i] = $merge_array;

        return [
            'pemilihan_pbest' => $pemilihan_pbest,
            'error_terkecil' => $error_terkecil,
            'partikel_awal' => $partikel_awal,
            'pbes_terbaik' => $merge_array[$error_terkecil],
        ];
    }

    public function pembaruanKecepatanPartikel($kecepatan_awal_partikel, $session, $pemilihanPbest, $data_partikel_awal, $i)
    {
        $kecepatan_awal = $kecepatan_awal_partikel;
        $inisialisasi_awal = $session;
        $pbest = $pemilihanPbest['pemilihan_pbest'][$i][$pemilihanPbest['error_terkecil']];

        $pembaruan = [];
        foreach ($kecepatan_awal as $key => $v_kecepatan_awal) {
            foreach ($v_kecepatan_awal as $interval => $value) {
                $pembaruan[$key][$interval] = $inisialisasi_awal['bobot_inersia'] * $value + $inisialisasi_awal['c1'] * $inisialisasi_awal['r1'] * ($pemilihanPbest['partikel_awal'][$key][$interval] - $data_partikel_awal[$key][$interval]) + $inisialisasi_awal['c2'] * $inisialisasi_awal['r2'] * ($pbest[$interval] - $data_partikel_awal[$key][$interval]);
            }
        }
        $pembaruan_kecepatan_iterasi[$i] = $pembaruan;
        return [
            'pembaruan_kecepatan_iterasi' => $pembaruan_kecepatan_iterasi
        ];
    }
}
