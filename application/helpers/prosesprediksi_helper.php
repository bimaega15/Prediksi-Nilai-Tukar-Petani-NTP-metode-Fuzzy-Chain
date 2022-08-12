<?php
class ProsesPrediksi
{

    public function membentukHimpunanFuzzy($pemilihanPbest, $inisialisasi)
    {
        $pbes_terbaik = $pemilihanPbest['pbes_terbaik'];
        $interval = (count($pbes_terbaik) - 1) + 1;

        // daerah partikel
        $gabung_min_max = [];
        // daerah himpunan
        $daerah_min = [];
        $daerah_max = [];

        for ($k = 0; $k < $interval; $k++) {
            // min
            if ($k == 0) {
                $daerah_min[$k] = doubleval($inisialisasi['min_db']->min);
            } else {
                $daerah_min[$k] = $pbes_terbaik[$k - 1];
            }

            // max
            if ($k == $interval - 1) {
                $daerah_max[$k] = doubleval($inisialisasi['max_db']->max);
            } else {
                $daerah_max[$k] = $pbes_terbaik[$k];
            }
        }

        // gabungkan min dan max nya
        foreach ($daerah_min as $key => $v_min) {
            $gabung_min_max[] = [
                $v_min,
                $daerah_max[$key],
            ];
        }

        // partikel iterasi selesai
        $partikel_iterasi[] = $gabung_min_max;

        // mencari nilai mid point
        $midPoint = 0;
        $arr_mid_point = [];
        foreach ($partikel_iterasi as $key => $v_partikel) {
            foreach ($v_partikel as $index_partikel => $min_max) {
                $count_arr = count($min_max);
                $sum_arr = array_sum($min_max);
                $midPoint = $sum_arr / $count_arr;

                $arr_mid_point[$key][$index_partikel] = $midPoint;
            }
        }
        $mid_point_iterasi = $arr_mid_point;

        return [
            'mid_point_iterasi' => $mid_point_iterasi,
            'partikel_iterasi' => $partikel_iterasi
        ];
    }

    public function fuzzifikasiDataHistoris($data_penerapan, $bentukHimpunanFuzzy)
    {
        $fuzzifikasi = [];
        foreach ($data_penerapan as $key => $v_penerapan) {
            foreach ($bentukHimpunanFuzzy['partikel_iterasi'] as $partikel => $v_partikel) {
                foreach ($v_partikel as $index_a => $v_min_max) {
                    if ($v_min_max[0] <= $v_penerapan->ntp && $v_penerapan->ntp <= $v_min_max[1]) {
                        $fuzzifikasi[$key][$partikel] = [$index_a, $v_penerapan->id_data_penerapan];
                    }
                }
            }
        }
        $fuzzifikasi_iterasi = $fuzzifikasi;
        return [
            'fuzzifikasi_iterasi' => $fuzzifikasi_iterasi,
        ];
    }

    public function fuzzifikasiLogicRelationShip($fuzzifikasiDataHistoris)
    {
        $arr_flr = [];
        foreach ($fuzzifikasiDataHistoris['fuzzifikasi_iterasi'] as $index => $v_partikel) {
            foreach ($v_partikel as $partikel => $v_himpunan_a) {
                // batas bawah
                if ($index == 0) {
                    $v_bawah = '-';
                } else {
                    $v_bawah = ($fuzzifikasiDataHistoris['fuzzifikasi_iterasi'][$index - 1][$partikel][0]);
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
        $flr_iterasi = $arr_flr;
        return [
            'flr_iterasi' => $flr_iterasi
        ];
    }

    public function fuzzifikasiLogicRelationShipGroup($fuzzifikasiLogicRelatioShip)
    {
        $arr_flrg = [];
        foreach ($fuzzifikasiLogicRelatioShip['flr_iterasi'] as $key => $v_partikel) {
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

        $flrg_iterasi = $sort_again_flrg;
        return [
            'flrg_iterasi' => $flrg_iterasi
        ];
    }

    public function defuzifikasi($bentukHimpunanFuzzy, $fuzzifikasiLogicRelationShipGroup)
    {
        $getMidPoint = $bentukHimpunanFuzzy['mid_point_iterasi'];

        $arr_defuzifikasi = [];
        foreach ($fuzzifikasiLogicRelationShipGroup['flrg_iterasi'] as $partikel => $v_partikel) {
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
        $defuzifikasi_iterasi = $arr_defuzifikasi;
        return [
            'defuzifikasi_iterasi' => $defuzifikasi_iterasi
        ];
    }

    public function prediksiDanError($fuzzifikasiDataHistoris, $defuzifikasi)
    {
        $ci = &get_instance();
        $ci->load->model('DataPenerapan_model');

        $var_fuzzifikasi = $fuzzifikasiDataHistoris['fuzzifikasi_iterasi'];
        // mencari nilai flrg partikel
        $arr_nilai_flrg_partikel = [];
        foreach ($var_fuzzifikasi as $key_data => $v_partikel) {
            foreach ($v_partikel as $i_partikel => $v_himp_a) {
                $him_a = $v_himp_a[0];
                if (isset($defuzifikasi['defuzifikasi_iterasi'][$i_partikel][$him_a]['nilai_ramalan'])) {
                    $get_nilai_flrg = $defuzifikasi['defuzifikasi_iterasi'][$i_partikel][$him_a]['nilai_ramalan'];
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
                        $bulan_berikutnya = $getNilaiNow[$key_partikel]['nilai_flrg_partikel'];
                        $arr_ramalan[$key][$key_partikel] = $merge_array;
                    }
                } else {
                    // daerah sebelumnya
                    $getNilaiNow = $arr_nilai_flrg_partikel[$key];
                    $bulan_berikutnya = $getNilaiNow[0]['nilai_flrg_partikel'];

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
        $prediksi_error_iterasi = $arr_mse;

        // mencari nilai fitness mse
        $arr_nilai_fitnes = [];
        foreach ($prediksi_error_iterasi as $key => $v_partikel) {
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
        $nilai_fitnes_iterasi = $total_nilai_fitnes;

        // kondisikan mse
        $nilai_mse = $arr_nilai_fitnes;
        $nilai_ramalan = $arr_ramalan;
        $arr_mse = [];
        foreach ($nilai_ramalan as $key => $v_partikel) {
            foreach ($v_partikel as $i_partikel => $v_himp_a) {
                if ($key > 0) {
                    $merge_array = array_merge($v_himp_a, ['nilai_mse' => $nilai_mse[$i_partikel][$key - 1]]);
                    $arr_mse[$key][$i_partikel] = $merge_array;
                } else {
                    $merge_array = array_merge($v_himp_a, ['nilai_mse' => '-']);
                    $arr_mse[$key][$i_partikel] = $merge_array;
                }
            }
        }
        // end kondisikan mse

        // menghitung nilai mape
        $arr_mape = [];
        foreach ($arr_mse as $key => $v_partikel) {
            foreach ($v_partikel as $i_partikel => $v_himp_a) {
                if ($key > 0) {
                    $ntp = $ci->DataPenerapan_model->get($v_himp_a[1])->row()->ntp;
                    $ramalan = $v_himp_a['nilai_ramalan'];
                    $mape = ($ntp - $ramalan) / $ntp;

                    $merge_array = array_merge($v_himp_a, ['nilai_mape' => $mape]);
                    $arr_mape[$key][$i_partikel] = $merge_array;
                } else {
                    $merge_array = array_merge($v_himp_a, ['nilai_mape' => '-']);
                    $arr_mape[$key][$i_partikel] = $merge_array;
                }
            }
        }
        // end menghitung nilai mape

        // nilai fitnes mse
        $hitung_mse = 0;
        $count = count($arr_mape);
        foreach ($arr_mape as $key => $v_partikel) {
            foreach ($v_partikel as $i_partikel => $v_himp_a) {
                if ($key > 0) {
                    $hitung_mse += $v_himp_a['nilai_mape'];
                }
            }
        }
        $nilai_mape = ($hitung_mse * 100) / $count;
        $persen_mape = $nilai_mape * 100;
        if ($persen_mape > 100) {
            $persen_mape = 100;
        }
        // end nilai fitnes mse

        // end prediksi dan error

        return [
            'arr_mape' => $arr_mape,
            'persen_mape' => $persen_mape,
            'nilai_fitnes_iterasi' => $nilai_fitnes_iterasi,
            'bulan_berikutnya' => $bulan_berikutnya
        ];
    }
}
