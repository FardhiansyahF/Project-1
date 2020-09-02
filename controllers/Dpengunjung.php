<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dpengunjung extends CI_Controller
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
        $data['title'] = "Pengunjung";
        $data['dpengunjung'] = $this->admin->get('dpengunjung');
        $data['tpengunjung'] = $this->admin->getPengunjung();
        $data['n'] = $this->admin->getIdPengunjung();
        $this->template->load('templates/dashboard', 'dpengunjung/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tamu', 'Nama Tamu', 'required|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|trim');
        $this->form_validation->set_rules('paket', 'Paket', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('jarak', 'Jarak', 'required|trim');
        $this->form_validation->set_rules('fasilitas', 'Fasilitas', 'required|trim');
        $this->form_validation->set_rules('merchandise', 'merchandise', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengunjung";
            $data['jenispengunjung'] = $this->admin->getJenisPengunjung();
            $this->template->load('templates/dashboard', 'dpengunjung/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('dpengunjung', $input);
            if ($insert) {
                set_pesan('data berhasil disimpan');
                $input2 = array(
                    'id_pengunjung' => $this->admin->getIdPengunjung(),
                    'jumlah' => $this->input->post('jumlah')
                );
                $input3 = array(
                    'id_pengunjung' => $this->admin->getIdPengunjung(),
                    'jarak' => $this->input->post('jarak')
                );
                $insert1 = $this->admin->insert('benefit', $input2);
                $insert2 = $this->admin->insert('cost', $input3);
                redirect('dpengunjung');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('dpengunjung/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Pengunjung";
            $data['dpengunjung'] = $this->admin->get('dpengunjung', ['id_pengunjung' => $id]);
            $this->template->load('templates/dashboard', 'dpengunjung/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('dpengunjung', 'id_pengunjung', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('dpengunjung');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('dpengunjung/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('dpengunjung', 'id_pengunjung', $id)) {
            set_pesan('data berhasil dihapus.');
            $this->admin->delete('benefit', 'id_pengunjung', $id);
            $this->admin->delete('cost', 'id_pengunjung', $id);
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('dpengunjung');
    }
}
