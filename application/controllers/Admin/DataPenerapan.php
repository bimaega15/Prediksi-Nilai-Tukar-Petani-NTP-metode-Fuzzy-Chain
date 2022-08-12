<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Xlsximport;

class DataPenerapan extends CI_Controller
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
        $this->breadcrumbs->push('Data Penerapan', 'Admin/Profile');
        // output
        $data['title'] = 'Data Penerapan';
        $data['breadcrumb'] = $this->breadcrumbs->show();
        $data['penerapan'] = $this->DataPenerapan_model->get()->result();
        $this->template->admin('admin/data_penerapan/main', $data);
    }


    public function process()
    {
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('ntp', 'NTP', 'required');

        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');



        if ($this->form_validation->run() == false) {
            $data = [
                'status' => 'error',
                'output' => $this->form_validation->error_array()
            ];
            echo json_encode($data);
        } else {
            if ($_POST['page'] == 'add') {
                $data_penerapan = [
                    'tanggal' =>  htmlspecialchars($this->input->post('tanggal', true)),
                    'ntp' =>  htmlspecialchars($this->input->post('ntp', true)),
                ];

                $insert_penerapan = $this->DataPenerapan_model->insert($data_penerapan);
                if ($insert_penerapan > 0) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil insert data penerapan'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal insert data penerapan'
                    ];
                    echo json_encode($data);
                }
            } else {
                $id_data_penerapan = htmlspecialchars($this->input->post('id_data_penerapan', true));
                $data_penerapan = [
                    'tanggal' =>  htmlspecialchars($this->input->post('tanggal', true)),
                    'ntp' =>  htmlspecialchars($this->input->post('ntp', true)),
                ];

                $update_penerapan = $this->DataPenerapan_model->update($data_penerapan, $id_data_penerapan);
                if ($update_penerapan > 0) {
                    $data = [
                        'status_db' => 'success',
                        'output' => 'Berhasil update data penerapan'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => 'error',
                        'output' => 'Gagal update data penerapan'
                    ];
                    echo json_encode($data);
                }
            }
        }
    }

    public function edit()
    {
        $id_data_penerapan = $this->input->get('id_data_penerapan');
        $data = $this->DataPenerapan_model->get($id_data_penerapan)->row();
        echo json_encode($data);
    }

    public function delete()
    {
        $id_data_penerapan = $this->input->get('id_data_penerapan', true);
        $delete = $this->DataPenerapan_model->delete($id_data_penerapan);
        if ($delete) {
            $data = [
                'status_db' => "success",
                'msg' => 'Success hapus data'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status_db' => "error",
                'msg' => 'Error hapus data'
            ];
            echo json_encode($data);
        }
    }

    public function import()
    {
        $this->form_validation->set_rules('import', 'File Import', 'callback_validate_import');

        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');
        if ($this->form_validation->run() == false) {
            $data = [
                'status' => 'error',
                'output' => $this->form_validation->error_array()
            ];
            echo json_encode($data);
        } else {
            $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');


            if (isset($_FILES['import']['name']) && in_array($_FILES['import']['type'], $file_mimes)) {
                $arr_file = explode('.', $_FILES['import']['name']);
                $extension = end($arr_file);

                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new Xlsximport;
                }


                $spreadsheet = $reader->load($_FILES['import']['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                $arr_tanggal = [];
                for ($i = 1; $i < count($sheetData); $i++) {
                    $cek = $sheetData[$i]['0'];
                    if ($cek != null) {
                        $count[] = $i;
                        $bulan = convertBulan($sheetData[$i]['2']);
                        $arr_tanggal[0] = $bulan;
                        $arr_tanggal[1] = $sheetData[$i][1];
                        $tanggal = implode('-', $arr_tanggal);

                        $data = [
                            'tanggal' => $tanggal,
                            'ntp' => $sheetData[$i][3],
                        ];
                        $insert[] = $this->DataPenerapan_model->insert($data);
                    }
                }
                if (count($insert) > 0) {
                    $data = [
                        'status_db' => "success",
                        'msg' => 'Success import ' . count($insert) . ' data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_db' => "error",
                        'msg' => 'Gagal import data'
                    ];
                    echo json_encode($data);
                }
            }
        }
    }

    public function validate_import()
    {
        $file = $_FILES['import']['name'];
        if ($file == '') {
            $this->form_validation->set_message('validate_import', 'File import excel harus diisi');
            return FALSE;
        }

        $allowedExts = array("xlsx", "xls");
        $extension = pathinfo($_FILES["import"]["name"], PATHINFO_EXTENSION);

        if (!in_array($extension, $allowedExts)) {
            $this->form_validation->set_message('validate_import', "Tidak didukung format {$extension}");
            return FALSE;
        }
    }

    public function grafik()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Grafik', 'Admin/DataPenerapan/Grafik');
        // output
        $data['title'] = 'Grafik Data';
        $data['breadcrumb'] = $this->breadcrumbs->show();

        $data_penerapan = mengurutkanDataPenerapan();

        $data['tanggal_grafik'] = $data_penerapan['label_bulan'];
        $data['data_grafik'] = $data_penerapan['label_data'];

        $this->template->admin('admin/data_penerapan/grafik', $data);
    }
}
