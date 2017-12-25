<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function debit(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'Debit Pajak Masukkan';
			$data['action'] = 'debit';
			// if ($this->session->flashdata('gagalDebit')) {
			// 	$data['gagalDebit'] = $this->session->flashdata('gagalDebit');
			// }
			// if ($this->session->flashdata('sukses')) {
			// 	$data['sukses'] = $this->session->flashdata('sukses');
			// }

			$this->load->view('admin-input',$data);
		}
		else
			redirect('home');
	}

	public function debitKhusus(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'Debit Pajak Masukkan';
			$data['action'] = 'debit-khusus';

			$this->load->view('admin/admin-input-khusus',$data);
		}
		else
			redirect('home');
	}

	public function kredit(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'Kredit Pajak Masukkan';
			$data['action'] = 'kredit';
			// if ($this->session->flashdata('gagalDebit')) {
			// 	$data['gagalDebit'] = $this->session->flashdata('gagalDebit');
			// }
			// if ($this->session->flashdata('sukses')) {
			// 	$data['sukses'] = $this->session->flashdata('sukses');
			// }

			$this->load->view('admin-input',$data);
		}
		else
			redirect('home');
	}

	public function rekonsiliasi(){
		if ($this->session->has_userdata('user_masuk')) {
			$this->load->library('fakturs');
			$data = $this->fakturs->rekon();
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'Rekonsiliasi';

			$this->load->view('rekonsiliasi',$data);
		}
		else
			redirect('home');
	}

	public function user(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'Manage User';
			$this->load->model('user_model');
			$data['users'] = $this->user_model->getalluser();
			if (!empty($data['users'])) {
				$data['users'] = $data['users']->result();
			}
			else
				$data['users'] = '';
			if ($this->session->flashdata('user')) {
				$data['usermessage'] = $this->session->flashdata('user');
			}
			$this->load->view('list-user',$data);
		}
		else
			redirect('home');
	}

	public function edituser(){
		if ($this->session->has_userdata('user_masuk')) {
			// $this->load->view('kosongan',['error' => $this->session->flashdata('error')]);
			$data['posisi'] = 'Profile';
			$username = $this->input->get('username');
			$this->load->model('user_model');
			$data['userdata'] = $this->user_model->getUser($username);
			$data['user'] = $this->session->userdata('user_masuk');
			if (!empty($data['userdata'])) {
				$data['userdata'] = $data['userdata']->result();
				$data['username'] = $username;
				if ($this->session->flashdata('error')) {
					$data['error'] = $this->session->flashdata('error');
				}
				$this->load->view('admin-edituser',$data);
			}
			elseif ($this->session->has_userdata('user_masuk')) {
				redirect('home/dashboard');
			}
			else
				redirect('home');
		}
		else
			redirect('home');
	}

	public function perbaharuiuser(){
		if ($this->session->has_userdata('user_masuk')) {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('username','Username','required|max_length[10]|min_length[3]|strtolower');
			$this->form_validation->set_rules('nama','Name','required|max_length[350]|min_length[3]');
			$this->form_validation->set_rules('password','Password','required|max_length[10]|min_length[5]');
			$this->form_validation->set_rules('avatar','Profile Picture','required');

			$oldUsername = $this->input->get('username');
			if ($this->form_validation->run() == TRUE){
				$name = $this->input->post('nama');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$level = $this->input->post('level');
				$avatar = $this->input->post('avatar');

				$this->load->model('user_model');
				$success = $this->user_model->updateuser($oldUsername,
					[
						'username' => $username,
						'password' => $password,
						'nama_user' => $name,
						'avatar' => $avatar,
						'level' => $level
					]);
				if ($success) {
					$this->session->set_flashdata('user',[
						'username' => $username,
						'pesan' => 'berhasil diperbaharui'
						]);
					redirect('admin/user');
				}
				else{
	            	$error['message']['username'] = form_error('username');
	            	$error['message']['password'] = form_error('password');
	            	$error['message']['nama'] = form_error('nama');
	            	$error['message']['avatar'] = form_error('avatar');
	            	$error['value']['username'] = set_value('username');
	            	$error['value']['password'] = set_value('password');
	            	$error['value']['nama'] = set_value('nama');
	            	$error['value']['avatar'] = set_value('avatar');
	            	$error['value']['level'] = set_value('level');
	            	$this->session->set_flashdata('error',$error);
	            	redirect('admin/tambahuser');
	            }
            }
            else{
            	$error['message']['username'] = form_error('username');
            	$error['message']['password'] = form_error('password');
            	$error['message']['nama'] = form_error('nama');
            	$error['message']['avatar'] = form_error('avatar');
            	$error['value']['username'] = set_value('username');
            	$error['value']['password'] = set_value('password');
            	$error['value']['nama'] = set_value('nama');
            	$error['value']['avatar'] = set_value('avatar');
            	$error['value']['level'] = set_value('level');
            	$this->session->set_flashdata('error',$error);
            	// $this->load->view('kosongan',['error' => $error]);
            	redirect('admin/edituser?username='.$oldUsername);
            }
		}
		else
			redirect('home');
	}

	public function checkusername(){
		$this->load->model('user_model');
		$check = $this->input->get('username');
		if ($this->user_model->checkusernameavailability($check)) {
			$response = array(
				'code' => 204,
				'message' => 'username available'
			);
		}
		else
			$response = array(
				'code' => 205,
				'message' => 'username already exist'
			);

		echo json_encode($response);
	}

	public function tambahuser(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['posisi'] = 'Tambah User';
			$data['user'] = $this->session->userdata('user_masuk');
			if ($this->session->flashdata('error')) {
				$data['error'] = $this->session->flashdata('error');
			}
			$this->load->view('admin-add-user',$data);
		}
		else
			redirect('home');
	}

	public function adduser(){
		if ($this->session->has_userdata('user_masuk')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username','Username','required|max_length[10]|min_length[3]|strtolower');
			$this->form_validation->set_rules('nama','Name','required|max_length[350]|min_length[3]');
			$this->form_validation->set_rules('password','Password','required|max_length[10]|min_length[5]');

			if ($this->form_validation->run() == TRUE){
				$name = $this->input->post('nama');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$level = $this->input->post('level');
				$avatar = $this->input->post('avatar');

				$this->load->model('user_model');
				$succes = $this->user_model->adduser(
					[
						'username' => $username,
						'password' => $password,
						'nama_user' => $name,
						'avatar' => $avatar,
						'level' => $level
					]);

				if ($succes) {
					$this->session->set_flashdata('user',[
						'username' => $username,
						'pesan' => 'berhasil ditambahkan'
						]);
					redirect('admin/user');
				}
				// $this->load->view('kosongan',['id' => $id]);
            }
            else{
            	$error['message']['username'] = form_error('username');
            	$error['message']['password'] = form_error('password');
            	$error['message']['nama'] = form_error('nama');
            	$error['message']['avatar'] = form_error('avatar');
            	$error['value']['username'] = set_value('username');
            	$error['value']['password'] = set_value('password');
            	$error['value']['nama'] = set_value('nama');
            	$error['value']['avatar'] = set_value('avatar');
            	$error['value']['level'] = set_value('level');
            	$this->session->set_flashdata('error',$error);
            	redirect('admin/tambahuser');
            }
		}
		else
			redirect('home');
	}

	public function deleteuser(){
		if ($this->session->has_userdata('user_masuk')) {
			$this->load->model('user_model');
			$username = $this->input->get('username');
			$succes = $this->user_model->deleteuser($username);
			if ($succes) {
				unlink(APPPATH.'../assets/user_images/'.$username.'.jpg');
				$this->session->set_flashdata('user',[
					'username' => $username,
					'pesan' => 'berhasil dihapus'
					]);
			}
			redirect('admin/user');

		}
		else
			redirect('home');
	}

	private function toRP($angka){
		if (is_null($angka)) {
			return "Rp. 0,00";
		}
		$angka = str_split($angka);
		$fixedRp = ",00";
		$index = 0;
		for ($i=count($angka)-1; $i >= 0 ; $i--) {
			if ($index % 3 == 0 && $index != 0) {
				$fixedRp = $angka[$i].".".$fixedRp;
			}
			else
				$fixedRp = $angka[$i].$fixedRp;
			$index++;
		}
		return "Rp. ".$fixedRp;
	}

	public function database(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['posisi'] = 'Manage Database';
			$data['user'] = $this->session->userdata('user_masuk');
			$this->load->model('ModelFaktur','modelfaktur');
			$varDebit = $this->modelfaktur->informationDatabase('faktur_debit');
			$data['ppnDebit'] = $this->toRP($varDebit[0]['PPN']);
			$data['totalDebit'] = $varDebit[0]['JUMLAH_FAKTUR'];
			$varKredit = $this->modelfaktur->informationDatabase('faktur_kredit');
			$data['ppnKredit'] = $this->toRP($varKredit[0]['PPN']);
			$data['totalKredit'] = $varKredit[0]['JUMLAH_FAKTUR'];
			$this->load->view('admin-database',$data);
		}
		else
			redirect('home');
	}

	public function informationDatabaseUpdate(){
		$this->load->model('ModelFaktur','modelfaktur');
		$varDebit = $this->modelfaktur->informationDatabase('faktur_debit');
		$data['ppnDebit'] = $this->toRP($varDebit[0]['PPN']);
		$data['totalDebit'] = $varDebit[0]['JUMLAH_FAKTUR'];
		$varKredit = $this->modelfaktur->informationDatabase('faktur_kredit');
		$data['ppnKredit'] = $this->toRP($varKredit[0]['PPN']);
		$data['totalKredit'] = $varKredit[0]['JUMLAH_FAKTUR'];

		echo json_encode($data);
	}

	public function tesform(){
		$response = array(
			'username' => $this->input->post('username'),
			'nama' =>$this->input->post('nama')
		);
		echo json_encode($response);
	}

}
