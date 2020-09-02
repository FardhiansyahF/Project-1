<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Acara extends CI_Controller
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
        $data['title'] = "Jenis Acara";
        $data['jenis'] = $this->admin->get('jenis');
        $this->template->load('templates/dashboard', 'acara/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_acara', 'Nama Jenis Acara', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Jenis Acara";
            $this->template->load('templates/dashboard', 'acara/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('jenis', $input);
            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('acara');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('acara/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Merek";
            $data['jenis'] = $this->admin->get('jenis', ['id_jenis_acara' => $id]);
            $this->template->load('templates/dashboard', 'acara/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('jenis', 'id_jenis_acara', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('acara');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('acara/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('jenis', 'id_jenis_acara', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('acara');
    }
}
