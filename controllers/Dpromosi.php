<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dpromosi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Data Promosi";
        $data['dpromosi'] = $this->admin->get('dpromosi');
        $data['persediaan'] = $this->admin->getPersediaan();
        $this->template->load('templates/dashboard', 'dpromosi/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('id_jenis_promosi', 'PromoAdli', 'required');
        $this->form_validation->set_rules('id_jenis_acara', 'AcaraAdli', 'required');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Promosi";
            $data['jenisacara'] = $this->admin->getJenisAcara();
            $data['jenispromosi'] = $this->admin->getJenisPromosi();
            $this->template->load('templates/dashboard', 'dpromosi/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('dpromosi', $input);
            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('dpromosi');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('dpromosi/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('dpromosi', 'id_promosi', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('dpromosi');
    }
}
