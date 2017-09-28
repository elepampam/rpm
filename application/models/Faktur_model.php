<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur_model extends CI_Model{
	public function inputFakturDebit($faktur){
		$this->db->insert('faktur_debit',$faktur);
		if($this->db->affected_rows() > 0)
		{		    
		    return true;
		}
	}

	public function inputFakturKredit($faktur){
		$this->db->insert('faktur_kredit',$faktur);
		if($this->db->affected_rows() > 0)
		{		    
		    return true;
		}
	}
	public function getTotalPpnDebit(){
		$this->db->select('SUM(JUMLAH_PPN) AS total_ppn');
		$this->db->from('faktur_debit');
		$result = $this->db->get();

		if (!is_null($result->result_array()[0]['total_ppn'])) {
			return $result;
		}
		else
			return null;
	}

	public function getTotalPpnKredit(){
		$this->db->select('SUM(JUMLAH_PPN) AS total_ppn');
		$this->db->from('faktur_kredit');
		$result = $this->db->get();

		if (!is_null($result->result_array()[0]['total_ppn'])) {
			return $result;
		}
		else
			return null;
	}

	public function matchingFaktur(){
		$this->db->select('faktur_debit.NO_FAKTUR');
		$this->db->from('faktur_debit');
		$this->db->join('faktur_kredit','faktur_debit.NO_FAKTUR = faktur_kredit.NO_FAKTUR','inner');

		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result;
		}
	}

	public function updateMatchingFaktur($noFaktur){
		$IS_MATCHED = array(
			'IS_MATCHED' => 1
			);
		$this->db->where('NO_FAKTUR',$noFaktur);		
		$this->db->update('faktur_debit',$IS_MATCHED);
		$this->db->where('NO_FAKTUR',$noFaktur);		
		$this->db->update('faktur_kredit',$IS_MATCHED);
	}

	public function getUnmatchedDebit(){
		$this->db->select('*');
		$this->db->from('faktur_debit');
		$this->db->where('IS_MATCHED',0);

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result;
		}
	}

	public function getUnmatchedKredit(){
		$this->db->select('*');
		$this->db->from('faktur_kredit');
		$this->db->where('IS_MATCHED',0);

		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result;
		}
	}

	public function ppnUnmatchedKredit(){
		$this->db->select('SUM(JUMLAH_PPN) AS total_ppn');
		$this->db->from('faktur_kredit');
		$this->db->where('IS_MATCHED',0);

		$result = $this->db->get();
		if (!is_null($result->result_array()[0]['total_ppn'])) {
			return $result;
		}
		else
			return null;
	}

	public function ppnUnmatchedDebit(){
		$this->db->select('SUM(JUMLAH_PPN) AS total_ppn');
		$this->db->from('faktur_debit');
		$this->db->where('IS_MATCHED',0);

		$result = $this->db->get();
		if (!is_null($result->result_array()[0]['total_ppn'])) {
			return $result;
		}
		else
			return null;
	}

	public function getDatabaseFaktur($table){
		$this->db->select('*');
		$this->db->from('faktur_debit');
		$this->db->order_by('date_input','DESC');
		$result = $this->db->get();

		return $result->result();
	}

	public function search($table,$name,$no_faktur,$tanggal,$masa){		
		if ($table == "debitnkredit") {
			$resultDebit = array();
			$resultKredit = array();
			if (!empty($name) || !empty($no_faktur) || !empty($tanggal)) {
				$this->db->select('NO_FAKTUR,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,DATE_INPUT');
				$this->db->from('faktur_debit');	
				if (!empty($name)) {
					$this->db->like('NAMA',$name);
				}			
				if (!empty($no_faktur)) {
					$this->db->like('NO_FAKTUR',$no_faktur);
				}
				if (!empty($tanggal)) {
					$this->db->like('TANGGAL_FAKTUR',$tanggal);
				}		
				$resultDebit = $this->db->get()->result();	
			}			

			$this->db->select('NO_FAKTUR,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,DATE_INPUT');
			$this->db->from('faktur_kredit');
			if (!empty($name)) {
				$this->db->like('NAMA',$name);
			}			
			if (!empty($no_faktur)) {
				$this->db->like('NO_FAKTUR',$no_faktur);
			}
			if (!empty($tanggal)) {
				$this->db->like('TANGGAL_FAKTUR',$tanggal);
			}	
			if (!empty($masa)) {
				$this->db->like('MASA_KREDIT',$masa);
			}			
			$this->db->order_by('date_input','DESC');
			$resultKredit = $this->db->get()->result();

			return  array('debit' => $resultDebit, 'kredit' => $resultKredit);			
		}
		else{			
			$this->db->select('NO_FAKTUR,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,DATE_INPUT');
			if ($table == "debit" && (!empty($name) || !empty($no_faktur) || !empty($tanggal))) {
				$this->db->from('faktur_'.$table);
				if (!empty($name)) {
					$this->db->like('NAMA',$name);
				}			
				if (!empty($no_faktur)) {
					$this->db->like('NO_FAKTUR',$no_faktur);
				}
				if (!empty($tanggal)) {
					$this->db->like('TANGGAL_FAKTUR',$tanggal);
				}
				$this->db->order_by('date_input','DESC');
				$result = $this->db->get();

				return  array('debit' => $result->result());				
			}
			else if ($table == "kredit" && (!empty($name) || !empty($no_faktur) || !empty($tanggal) || !empty($masa))) {
				$this->db->from('faktur_'.$table);
				if (!empty($name)) {
					$this->db->like('NAMA',$name);
				}			
				if (!empty($no_faktur)) {
					$this->db->like('NO_FAKTUR',$no_faktur);
				}
				if (!empty($tanggal)) {
					$this->db->like('TANGGAL_FAKTUR',$tanggal);
				}			
				if (!empty($masa)) {
					$this->db->like('MASA_KREDIT',$masa);
				}
				$this->db->order_by('date_input','DESC');
				$result = $this->db->get();

				return  array('kredit' => $result->result());
			}	

		}
	}
}