<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hpromosi extends CI_Controller
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
                            $data['title'] = "Lihat Promosi";
                            // $data['dpromosi'] = $this->admin->get('dpromosi');
                            // $data['persediaan'] = $this->admin->getPersediaan();
                            $data['title'] = "WASPAS";
                            // $data['benefit'] = $this->admin->getBenefit();
                            $data['nilai'] = $this->admin->getNilai();
                            // $data['hbenefit'] = $this->admin->hitungBenefit();
                            // $data['count'] = $this->hitungBenefit();
                            // $data['cost'] = $this->hitungCost();
                            $data['nilaiBenefit'] = $this->admin->getNilaiBenefit();
                            $data['nilaiCost'] = $this->admin->getNilaiCost();
                            $this->admin->getAllDPengunjung();
                            $data['nilai'] = $this->admin->getNilai();
                            $data['cost'] = $this->admin->hitungCost();
                            $data['benefit'] = $this->admin->hitungBenefit();
                            $data['q'] = $this->admin->hitungQ();
                            $this->template->load('templates/dashboard', 'hpromosi/data', $data);
              }

              public function banyakData()
              {
                            $banyakData = 0;

                            return $banyakData;
              }

              public function bobotkinerja()
              {
                            $data['title'] = "Lihat Promosi";
                            $data['kriteria'] = $this->input->post('kriteria');
                            $bobot = $this->input->post('bobot');
                            $data['judul'] = 'Lihat Promosi';
                            $data['tpengunjung'] = $this->admin->getPengunjung();
                            $data['AllPengunjung'] = $this->admin->getAllDPengunjung();
                            $data['IdPengunjung'] = $this->admin->getIdPengunjung();
                            $data['DPengunjung'] = $this->admin->getDPengunjung();
                            $data['benefit'] = $this->admin->getBenefit();
                            $data['cost'] = $this->admin->getCost();
                            if (null == !($this->input->post('id_pengunjung'))) {
                                          $this->hitungBenefit();
                                          $this->hitungCost();
                                          $this->hitungQ();
                                          $data['status'] = 1;
                            } else {
                                          $data['status'] = 0;
                            }
                            $data['nilaiBenefit'] = $this->admin->getNilaiBenefit();
                            $data['nilaiCost'] = $this->admin->getNilaiCost();
                            $data['nilai'] = $this->admin->getNilai();
                            $this->template->load('templates/dashboard', 'hpromosi/bobotkinerja', $data);

                            // $data1 = array(
                            //               'kriteria' => $kriteria
                            // );

                            $this->template->load('templates/dashboard', 'hpromosi/bobotkinerja', $data);
              }
}
