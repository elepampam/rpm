<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    } 
	public function index()
	{
		if ($this->session->flashdata('pesan') == 'gagal' ) {
			$data['pesan'] = "gagal";
			$this->load->view('form_login',$data);
		}
		else
			$this->load->view('form_login');
	}

	public function login(){
		$username = $this->input->post('username');
		$pwd = $this->input->post('pwd');
		//login for admin
		if ($username == "superadmin" && $pwd == "superpass") {
			$array = array(
				'username'=> "superadmin",
				'nama_user' => "superadmin",
				'avatar' => "default-pp",
				'level' => 1
			);					
		}
		else{
			$result = $this->user_model->cek_user($username,$pwd);
			if (is_array($result)) {
				foreach ($result as $key) {
					$array = array(
						'username'=> $key->username,
						'nama_user' => $key->nama_user,
						'avatar' => $key->avatar,
						'level' => $key->level
					);									
				}
			}
			else{
				$this->session->set_flashdata('pesan', 'gagal');
				redirect('home');
			}			
		}
		$this->session->set_userdata('user_masuk',$array);			
		redirect('home/dashboard');
	}

	public function dashboard(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'dashboard';

			if ($this->session->flashdata('pesan') == 'berhasil' ) {
				$data['pesan'] = "Faktur tersimpan";
			}
			$this->load->view('dashboard',$data);			
		}
		else
			redirect('home');
		
	}

	public function logout(){
		if ($this->session->has_userdata('user_masuk')) {
			$this->session->sess_destroy();
		}
		redirect('home');
	}

}
