<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		// $this->load->model('faktur_model');
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

	public function profile(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['posisi'] = 'Profile';	
			$data['user'] = $this->session->userdata('user_masuk');
			$username = $this->input->get('username');
			$this->load->model('user_model');
			$data['userdata'] = $this->user_model->getUser($username);			
			if (!empty($data['userdata'] && $data['user']['username'] == $username)) {
				$data['userdata'] = $data['userdata']->result();
				$this->load->view('user-profile',$data);
			}
			elseif ($this->session->has_userdata('user_masuk')) {
				redirect('home/dashboard'); //penyebab
			}
			else
				redirect('home');
		}
		else
			redirect('home');
	}

	public function edit(){
		if ($this->session->has_userdata('user_masuk')) {			
			$data['posisi'] = 'Edit Profile';	
			$data['user'] = $this->session->userdata('user_masuk');
			$username = $this->input->get('username');
			if ($username == "admin") {
				redirect('user/profile?username=admin');
			}
			$this->load->model('user_model');
			$data['userdata'] = $this->user_model->getUser($username);
			if (!empty($data['userdata'] && $data['user']['username'] == $username)) {
				$data['userdata'] = $data['userdata']->result();				
				if($this->session->flashdata('error')) {
					$data['error'] = $this->session->flashdata('error');
				}
				$this->load->view('user-edit-profile',$data);
			}
			elseif ($this->session->has_userdata('user_masuk')) {
				redirect('home/dashboard');
			}
			else
				redirect('home');
		}
		else
			redirect('home/dashboard');
	}

	public function editprofile(){
		if ($this->session->has_userdata('user_masuk')) {
			$this->load->library('form_validation');

			$this->form_validation->set_rules('username','Username','required|max_length[10]|min_length[3]|strtolower');
			$this->form_validation->set_rules('nama','Name','required|max_length[350]|min_length[3]');
			$this->form_validation->set_rules('password','Password','required|max_length[10]|min_length[5]');
			$this->form_validation->set_rules('avatar','User Avatar','required');			

			$oldUsername = $this->input->get('username');
			if ($this->form_validation->run() == TRUE){				
				$name = $this->input->post('nama');
				$username = $this->input->post('username');
				$password = $this->input->post('password');	
				$avatar = $this->input->post('avatar');
				if (!empty($this->input->post('level') && $this->session->userdata('user_masuk')['level'] == 1)) {
					$level = $this->input->post('level');
				}
				else
					$level = $this->session->userdata('user_masuk')['level'];			
				$this->session->set_userdata('user_masuk',[
					'username' => $username,
					'nama_user' => $name,
					'avatar' =>$avatar,
					'level' => $level
				]);			
				$this->load->model('user_model');
				$this->user_model->updateuser($oldUsername,
					[
						'username' => $username,
						'password' => $password,
						'nama_user' => $name,
						'avatar' =>$avatar,
						'level' => $level
					]);
				// $this->load->view('kosongan',['id' => $id]);
				redirect('user/profile?username='.$username);
				$this->load->view('kosongan',['msg' => $message]);
            }
            else
            {
            	$error['message']['username'] = form_error('username');
            	$error['message']['password'] = form_error('password');
            	$error['message']['nama'] = form_error('nama');
            	$error['message']['avatar'] = form_error('avatar');
            	$error['value']['username'] = set_value('username');
            	$error['value']['password'] = set_value('password');
            	$error['value']['nama'] = set_value('nama');
            	$error['value']['avatar'] = set_value('avatar');
            	if ($this->session->userdata('user_masuk')['level'] == 1) {
            		$error['value']['level'] = set_value('level');
            	}
            	else           		
            		$error['value']['level'] = $this->session->userdata('user_masuk')['level'];
            	$this->session->set_flashdata('error',$error);
                redirect('user/edit?username='.$oldUsername);
            }
		}
		else
			redirect('home');
	}

}
