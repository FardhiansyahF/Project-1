<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $data['title'] = "Home";

        $data['jenis'] = $this->admin->count('jenis');
        $data['promosi'] = $this->admin->count('promosi');
        $data['pengunjung'] = $this->admin->count('pengunjung');
        $data['user'] = $this->admin->count('user');
        $data['dpengunjung'] = $this->admin->count('dpengunjung');

        $this->template->load('templates/dashboard', 'dashboard', $data);
    }
}
