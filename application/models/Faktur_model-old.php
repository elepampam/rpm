<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur_model extends CI_Model{
	public function input_faktur($data){
		$this->db->insert('faktur',$data);
	}

	public function insert_perusahaan($data){
		$this->db->insert('perusahaan',$data);
	}

	public function ceknpwp($nonpwp){
		$this->db->select('npwp');
		$this->db->from('perusahaan');
		$this->db->where('perusahaan.npwp',$nonpwp);
		$result = $this->db->get();

		if ($result -> num_rows() > 0) {
			return true;
		}
		else
			return false;
	}
	public function update_perusahaan($data){
		$this->db->where('npwp',$data['npwp']);
		$this->db->update('perusahaan',$data);
	}

	public function input_pajak_faktur($data){
		$this->db->insert('pajak_faktur',$data);
	}

	public function input_taggal_masuk($data){
		$this->db->insert('faktur_masuk',$data);
	}

    public function autocompletefaktur($npwp){
    	$this->db->select('npwp,nama_perusahaan'); 
        $this->db->from('perusahaan');
        $this->db->like('npwp', $npwp);
        $this->db->limit('5');
        return $this->db->get();
    }

    public function getlatestfaktur(){
    	$query = "select * from `faktur` JOIN `faktur_masuk` ON `faktur`.`no_faktur` = `faktur_masuk`.`no_faktur` ORDER BY `faktur_masuk`.`tanggal_masuk` DESC";
    	$result = $this->db->query($query);
    	return $result->result();
    }

	public function cari($nofaktur){
		$this->db->select('no_faktur,kode_transaksi,F.npwp,nama_perusahaan,tanggal_faktur,dpp,ppn,ppnbm,nama_user,tanggal_masuk,uraian,status');
		$this->db->from('faktur F');
		$this->db->join('perusahaan P','P.npwp = F.npwp');
		$this->db->join('user U','F.user_input = U.id_user');
		$this->db->where('F.no_faktur',$nofaktur);
		$this->db->where('F.status','BK');
		$result = $this->db->get();

		if ($result-> num_rows() > 0) {
			return $result -> result();
		}
		else
			return 0;
	}

	public function getfaktur(){
		$this->db->select('no_faktur,kode_transaksi,F.npwp,nama_perusahaan,tanggal_faktur,tanggal_masuk,status');
		$this->db->from('faktur F');
		$this->db->join('perusahaan P','P.npwp = F.npwp');
		$this->db->join('user U','F.user_input = U.id_user');
		$result = $this->db->get();

		if ($result-> num_rows() > 0) {
			return $result -> result();
		}
		else
			return 0;
	}

	public function kreditFaktur($nofaktur,$status){
		$this->db->where('no_faktur',$nofaktur);
		$this->db->update('faktur',$status);
	}

	public function getFakturRpm($query){
		$this->db->select('*');
		$this->db->from('faktur F');
		$this->db->join('perusahaan P','P.npwp = F.npwp');
		$this->db->join('user U','F.user_input = U.id_user');
		$this->db->where($query);
		$result = $this->db->get();

		if ($result-> num_rows() > 0) {
			return $result -> result();
		}
		else
			return 0;
	}
}
