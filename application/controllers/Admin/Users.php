<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Users_model']);
        place_url();
        check_not_login();
        $profile = check_profile();
    }
    public function index()
    { // add breadcrumbs
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Users', 'Admin/Users');
        // output
        $data['title'] = 'Management Users';
        $data['breadcrumb'] = $this->breadcrumbs->show();
        $id_users = $this->session->userdata('id_users');
        $data['result'] = $this->Users_model->joinProfile(null, $id_users)->result();
        $this->template->admin('admin/users/main', $data);
    }
    public function process()
    {
        if (($_POST['page']) == 'add') {
            $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|min_length[6]|matches[password]');
        } else {
            $password = htmlspecialchars($this->input->post('password', true));
            $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_username_check');
            if ($password != null) {
                $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|min_length[6]|matches[password]');
            }
        }
        $this->form_validation->set_rules('gambar_profile', 'Gambar profile', 'callback_validate_image');
        $this->form_validation->set_rules('nama_profile', 'Nama profile', 'required|trim');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis kelamin', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No. handphone', 'required|trim');
        $this->form_validation->set_rules('level', 'Level', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_message('min_length', '{field} harus berisi {param} karakter');
        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');

        if (($_POST['page']) == 'add') {
            if ($this->form_validation->run() == false) {
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $jenis_kelamin = htmlspecialchars($this->input->post('jenis_kelamin', true));
                $gambar_profile = $this->uploadGambar($jenis_kelamin);
                $data_users = [
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => md5(htmlspecialchars($this->input->post('password', true))),
                    'level' =>  htmlspecialchars($this->input->post('level', true)),
                ];
                $insert_users = $this->Users_model->insert_users($data_users);

                $data_profile = [
                    'jenis_kelamin' =>  $jenis_kelamin,
                    'nama_profile' =>  htmlspecialchars($this->input->post('nama_profile', true)),
                    'no_hp' =>  htmlspecialchars($this->input->post('no_hp', true)),
                    'alamat' =>  htmlspecialchars($this->input->post('alamat', true)),
                    'gambar_profile' =>  $gambar_profile,
                    'users_id' => $insert_users,
                ];
                $insert_profile = $this->Users_model->insert_profile($data_profile);
                if ($insert_profile > 0 || $insert_users > 0) {
                    $data = [
                        'status' => 'success',
                        'output' => 'Berhasil menambah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_error' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        } else if (($_POST['page']) == 'edit') {
            if ($this->form_validation->run() == false) {
                $id = htmlspecialchars($this->input->post('id_users', true));
                $data = [
                    'status' => 'error',
                    'output' => $this->form_validation->error_array()
                ];
                echo json_encode($data);
            } else {
                $id = htmlspecialchars($this->input->post('id_users', true));
                $jenis_kelamin = htmlspecialchars($this->input->post('jenis_kelamin', true));
                $gambar_profile = $this->uploadGambar($jenis_kelamin, $id);
                $password = htmlspecialchars($this->input->post('password', true));
                if ($password != null) {
                    $password_fix = md5($password);
                } else {
                    $password_fix = htmlspecialchars($this->input->post('password_old', true));
                }
                $data_users = [
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'password' => $password_fix,
                    'level' =>  htmlspecialchars($this->input->post('level', true)),
                ];
                $update_users = $this->Users_model->update_users($data_users, $id);

                $data_profile = [
                    'jenis_kelamin' =>  $jenis_kelamin,
                    'nama_profile' =>  htmlspecialchars($this->input->post('nama_profile', true)),
                    'no_hp' =>  htmlspecialchars($this->input->post('no_hp', true)),
                    'alamat' =>  htmlspecialchars($this->input->post('alamat', true)),
                    'gambar_profile' =>  $gambar_profile,
                ];
                $update_profile = $this->Users_model->update_profile($data_profile, $id);
                if ($update_users > 0 || $update_profile > 0) {
                    $data = [
                        'status' => 'success',
                        'output' => 'Berhasil mengubah data'
                    ];
                    echo json_encode($data);
                } else {
                    $data = [
                        'status_error' => 'error',
                        'output' => 'Gagal mengubah data'
                    ];
                    echo json_encode($data);
                }
            }
        }
    }
    public function edit($id)
    {

        $get = $this->Users_model->joinProfile($id)->row();

        $data = [
            'row' => $get,
        ];
        echo json_encode($data);
    }

    public function delete()
    {
        $id_users = htmlspecialchars_decode($this->input->post('id_users', true));
        $this->removeImage($id_users);
        $delete = $this->Users_model->delete($id_users);
        if ($delete) {
            $data = [
                'status' => "success",
                'msg' => 'Success hapus data'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "error",
                'msg' => 'Error hapus data'
            ];
            echo json_encode($data);
        }
    }

    private function uploadGambar($jenis_kelamin = '', $id_users = '')
    {
        $gambar = $_FILES["gambar_profile"]['name'];
        if ($gambar != null) {
            $this->removeImage($id_users);
            $config['upload_path'] = './public/image/user';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['overwrite'] = true;
            $new_name = rand(1000, 100000) . time() . $_FILES["gambar_profile"]['name'];
            $config['file_name'] = $new_name;
            // $config['max_size'] = 1024;
            // $config['max_width'] = 1024;
            // $config['max_height'] = 768;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('gambar_profile')) {
                echo $this->upload->display_errors();
            } else {
                $gambar = $this->upload->data();
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = './public/image/user/' . $gambar['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '50%';
                $config['new_image'] = './public/image/user/' . $gambar['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                return $gambar['file_name'];
            }
        } else {
            $users = $this->Users_model->joinProfile($id_users)->row();
            if ($users->gambar_profile != 'default.png') {
                return $users->gambar_profile;
            } else {
                return 'default.png';
            }
        }
    }

    private function removeImage($id)
    {
        if ($id != null) {
            $img = $this->Users_model->joinProfile($id)->row();
            if ($img->gambar_profile != 'default.png') {
                $filename = explode('.', $img->gambar_profile)[0];
                return array_map('unlink', glob(FCPATH . "public/image/user/" . $filename . '.*'));
            }
        }
    }
    public function username_check($str)
    {
        $id_users = $this->input->post('id_users', true);
        $str = $this->input->post('username', true);
        $users = $this->Users_model->joinProfile(null, $id_users, null, null, $str)->num_rows();
        if ($users > 0) {
            $this->form_validation->set_message('username_check', '{field} sudah digunakan pada user lain');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function validate_image()
    {
        $check = TRUE;
        if ((!($_FILES['gambar_profile'])) || $_FILES['gambar_profile']['size'] == 0 && $_POST['page'] == 'add') {
            $this->form_validation->set_message('validate_image', '{field} harus di upload');
            $check = FALSE;
        } else if (($_FILES['gambar_profile']) && $_FILES['gambar_profile']['size'] != 0) {
            $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "JPEG", "GIF", "PNG");
            $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $extension = pathinfo($_FILES["gambar_profile"]["name"], PATHINFO_EXTENSION);
            $detectedType = exif_imagetype($_FILES['gambar_profile']['tmp_name']);
            $type = $_FILES['gambar_profile']['type'];
            if (!in_array($detectedType, $allowedTypes)) {
                $this->form_validation->set_message('validate_image', 'Type Gambar tidak didukung');
                $check = FALSE;
            }
            if (filesize($_FILES['gambar_profile']['tmp_name']) > 1000000) {
                $this->form_validation->set_message('validate_image', 'Gambar melebihi 1 MB');
                $check = FALSE;
            }
            if (!in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('validate_image', "Tidak didukung format {$extension}");
                $check = FALSE;
            }
        }
        return $check;
    }
}
