<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model{
	public function cek_user($username,$pwd){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('user.username',$username);
		$this->db->where('user.password',$pwd);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return 0;
	}

	public function getUser($username){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username',$username);

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result;
		}
	}

	public function updateuser($username,$data){
		$this->db->where('username',$username);
		$result = $this->db->update('user',$data);
		return $result;
	}

	public function getalluser(){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->order_by('level');

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result;
		}
	}

	public function adduser($data){
		$this->db->insert('user',$data);

		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function deleteuser($username){
		return $this->db->delete('user',['username' => $username]);
	}

	public function checkusernameavailability($username){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username',$username);

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return false;
		}	
		else
			return true;
	}
}
