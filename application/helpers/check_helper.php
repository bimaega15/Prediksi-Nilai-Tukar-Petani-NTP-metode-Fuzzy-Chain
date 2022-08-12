<?php
function timeZone()
{
    $ci = &get_instance();
    date_default_timezone_set('Asia/Jakarta');
}

function place_url()
{
    $ci = &get_instance();
    $url_now = current_url();
    $ci->session->set_userdata([
        'url' => $url_now
    ]);
}

function check_not_login()
{
    $ci = &get_instance();

    if (!$ci->session->has_userdata('id_users')) {
        return redirect(base_url('Login'));
    }
}
function check_already_login()
{
    $ci = &get_instance();
    $ci->load->model('Users_model');
    if (get_cookie('cookie')) {
        $cookie = get_cookie('cookie');
        $get = $ci->Users_model->getCookie($cookie)->row();
        $data = [
            'id_users' => $get->id_users
        ];
        $ci->session->set_userdata($data);
    }
    $session = $ci->session->userdata('id_users');
    if ($session != null) {
        $url = $ci->session->userdata('url');
        return redirect($url);
    }
}
function check_konfigurasi()
{
    $ci = &get_instance();
    $ci->load->model('Konfigurasi_model');
    $row = $ci->Konfigurasi_model->get()->row();
    return $row;
}

function check_profile()
{
    $ci = &get_instance();
    $id_users = $ci->session->userdata('id_users');
    $ci->load->model('Users_model');
    $row = $ci->Users_model->joinProfile($id_users)->row();
    return $row;
}


function rupiah($nominal)
{
    return number_format($nominal, 0, '.', ',');
}

function check_users($id_users = null)
{
    $ci = &get_instance();
    $ci->load->model('Users_model');
    if ($id_users != null) {
        $row = $ci->Users_model->joinProfile($id_users)->row();
    } else {
        $row = $ci->Users_model->joinProfile($id_users)->result();
    }
    return $row;
}

function wordText($text, $limit)
{
    if (strlen($text) > $limit) {
        $word = strip_tags($text);
        $word = mb_substr($word, 0, $limit) . " ... ";
    } else {
        $word = $text;
    }
    return ($word);
}

function checkTanggalWaktu($tanggal)
{
    $exp = explode('-', $tanggal);
    $exp2 = explode(' ', $exp[2]);
    return $exp2[0] . '-' . $exp[1] . '-' . $exp[0] . ' ' . $exp2[1];
}

function convertBulan($bulan)
{
    switch ($bulan) {
        case 'Januari':
            return '01';
            break;
        case 'Februari':
            return '02';
            break;
        case 'Maret':
            return '03';
            break;
        case 'April':
            return '04';
            break;
        case 'Mei':
            return '05';
            break;
        case 'Juni':
            return '06';
            break;
        case 'Juli':
            return '07';
            break;
        case 'Agustus':
            return '08';
            break;
        case 'September':
            return '09';
            break;
        case 'Oktober':
            return '10';
            break;
        case 'November':
            return '11';
            break;
        case 'Desember':
            return '12';
            break;
    }
}

function convertAngkaBulan($bulan)
{
    switch ($bulan) {
        case '01':
            return 'Januari';
            break;
        case '02':
            return 'Februari';
            break;
        case '03':
            return 'Maret';
            break;
        case '04':
            return 'April';
            break;
        case '05':
            return 'Mei';
            break;
        case '06':
            return 'Juni';
            break;
        case '07':
            return 'Juli';
            break;
        case '08':
            return 'Agustus';
            break;
        case '09':
            return 'September';
            break;
        case '10':
            return 'Oktober';
            break;
        case '11':
            return 'November';
            break;
        case '12':
            return 'Desember';
            break;
    }
}

function check_data_penerapan($id)
{
    $ci = &get_instance();
    $ci->load->model('DataPenerapan_model');
    $data = $ci->DataPenerapan_model->get($id)->row();
    return $data;
}

function bulanString($bulanTahun)
{
    $exp = explode('-', $bulanTahun);
    $bulan = convertAngkaBulan($exp[0]);
    $tahun = $exp[1];
    return $bulan . ' ' . $tahun;
}
function random_float($min, $max)
{

    $angka_random =  number_format(random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX), 2, '.', ',');

    do {
        $angka_random =  number_format(random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX), 2, '.', ',');
    } while (!($min <= $angka_random && $angka_random <= $max));

    return $angka_random;
}
function mengurutkanDataPenerapan()
{
    $ci = &get_instance();
    $ci->load->model('DataPenerapan_model');

    $penerapan = $ci->DataPenerapan_model->grafikPenerapan()->result();

    // tanggal
    $tanggal = array_column($penerapan, 'tanggal');
    $id_penerapan = array_column($penerapan, 'id_data_penerapan');

    // initial
    $tahun = [];
    $bulan = [];
    $tanggalFix = [];
    $id_data_penerapan = [];

    // sort tahun
    foreach ($tanggal as $key => $v_tanggal) {
        $exp_tanggal = explode('-', $v_tanggal);
        $tahun[] = $exp_tanggal[1];
    }
    asort($tahun);

    $tahun = (array_values(array_unique($tahun)));
    foreach ($tahun as $key1 => $v_tahun) {
        foreach ($tanggal as $key2 => $v_tanggal) {
            $exp_tanggal = explode('-', $v_tanggal);
            if ($v_tahun == $exp_tanggal[1]) {
                $bulan[$v_tahun][] = $exp_tanggal[0];
                $id_data_penerapan[$v_tahun][] = [
                    $id_penerapan[$key2],
                    $exp_tanggal[0]
                ];
            }
        }
    }

    // sort bulan
    foreach ($bulan as $tahun => $v_bulan) {
        asort($v_bulan);
        $tanggalFix[$tahun] = $v_bulan;
    }


    // id data penerapan diurutkan juga
    $sort_id_data_penerapan = [];
    foreach ($tanggalFix as $tahun => $data_bulan) {
        foreach ($data_bulan as $index => $v_bulan) {
            foreach ($id_data_penerapan[$tahun] as $index => $id_and_bulan) {
                if ($id_and_bulan[1] == $v_bulan) {
                    $sort_id_data_penerapan[$tahun][] = [
                        $id_and_bulan[0],
                        $id_and_bulan[1],
                    ];
                }
            }
        }
    }

    // get row yang sudah di urut
    $data_row = [];
    foreach ($sort_id_data_penerapan as $tahun => $v_index) {
        foreach ($v_index as $index => $v_bulan) {
            $id_data_penerapan = ($v_bulan[0]);
            $data_row[] = check_data_penerapan($id_data_penerapan);
        }
    }

    // convert tanggal
    $tanggal = '';
    $label_bulan = [];
    $arr_ntp = [];
    $tanggal = array_column($data_row, 'tanggal');
    $jumlah_ntp = array_column($data_row, 'ntp');

    foreach ($tanggal as $key => $v_tanggal) {
        $exp = explode('-', $v_tanggal);
        $convert_bulan = convertAngkaBulan($exp[0]);
        $label_bulan[] = $convert_bulan . '-' . $exp[1];
        $arr_ntp[] = $jumlah_ntp[$key];
    }
    $label_bulan = json_encode($label_bulan);
    $label_data = json_encode($arr_ntp);

    return [
        'label_bulan' => $label_bulan,
        'label_data' => $label_data,
        'data_row' => $data_row,
    ];
}
