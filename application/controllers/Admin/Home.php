<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        place_url();
        check_not_login();
        $this->load->model(['Users_model', 'DataPenerapan_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        // output
        $data['title'] = 'Dashboard';
        $data['breadcrumb'] = $this->breadcrumbs->show();
        $data['users'] = $this->Users_model->joinProfile()->num_rows();
        $data['penerapan'] = $this->DataPenerapan_model->get()->num_rows();
        $this->template->admin('admin/home/main', $data);
    }
}
