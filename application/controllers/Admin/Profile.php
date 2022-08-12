<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        place_url();
        check_not_login();
        $this->load->model('Users_model');
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('My Profile', 'Admin/Profile');
        // output
        $data['title'] = 'My Profile';
        $data['breadcrumb'] = $this->breadcrumbs->show();
        $this->template->admin('admin/profile/main', $data);
    }
    public function detail()
    {
        $id_users = $this->input->get('id_users');
        $data = $this->Users_model->joinProfile($id_users)->row();

        $data = [
            'row' => $data,
            'gambar' => '<img src="' . base_url('public/image/user/' . $data->gambar_profile) . '" height="100px;"></img>',
        ];
        echo json_encode($data);
    }

    public function process()
    {
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'Jenis kelamin', 'required');
        $this->form_validation->set_rules('nama_profile', 'Nama', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('username', 'Username', 'callback_validate_username');


        $this->form_validation->set_message('required', '{field} Wajib diisi');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small><br>');



        if ($this->form_validation->run() == false) {
            $data = [
                'status' => 'error',
                'output' => $this->form_validation->error_array()
            ];
            echo json_encode($data);
        } else {
            $id = htmlspecialchars($this->input->post('id_users', true));
            $gambar_profile = $this->uploadGambar($id);

            $password = htmlspecialchars($this->input->post('password', true));
            if ($password != null) {
                $password_fix = md5($password);
            } else {
                $password_fix = htmlspecialchars($this->input->post('password_old', true));
            }

            $data_users = [
                'username' => htmlspecialchars($this->input->post('username', true)),
                'password' => $password_fix,
            ];
            $update_users = $this->Users_model->update_users($data_users, $id);

            $data_profile = [
                'nama_profile' =>  htmlspecialchars($this->input->post('nama_profile', true)),
                'no_hp' =>  htmlspecialchars($this->input->post('no_hp', true)),
                'alamat' =>  htmlspecialchars($this->input->post('alamat', true)),
                'gambar_profile' =>  $gambar_profile,
            ];

            $update_profile = $this->Users_model->update_profile($data_profile, $id);
            if ($update_users > 0 || $update_profile > 0) {
                $data = [
                    'status_db' => 'success',
                    'output' => 'Berhasil update profile'
                ];
                echo json_encode($data);
            } else {
                $data = [
                    'status_db' => 'error',
                    'output' => 'Gagal update profile'
                ];
                echo json_encode($data);
            }
        }
    }

    public function validate_username($str)
    {
        $id_users = $this->input->post('id_users', true);
        $str = $this->input->post('username', true);
        if ($str == '') {
            $this->form_validation->set_message('validate_username', 'Username harus diisi');
            return FALSE;
        }

        $users = $this->Users_model->joinProfile(null, $id_users, null, null, $str)->num_rows();
        if ($users > 0) {
            $this->form_validation->set_message('validate_username', '{field} sudah digunakan pada user lain');
            return FALSE;
        }
        return TRUE;
    }

    private function uploadGambar($id_users = '')
    {
        $gambar = $_FILES["gambar_profile"]['name'];
        if ($gambar != null) {
            $this->removeImage($id_users);
            $config['upload_path'] = './public/image/user';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['overwrite'] = true;
            $new_name = rand(1000, 100000) . time() . $_FILES["gambar_profile"]['name'];
            $config['file_name'] = $new_name;
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
            if ($img->gambar_profile !=  'default.png') {
                $filename = explode('.', $img->gambar_profile)[0];
                return array_map('unlink', glob(FCPATH . "public/image/user/" . $filename . '.*'));
            }
        }
    }
}
