<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ModelFaktur extends CI_Model{

	// revisi start here
	public function checkKolomNomorFaktur($noFaktur, $tabel){
		$this->db->select("NOMOR_FAKTUR");
	}
	// revisi end here
	public function debitFaktur($faktur){
		if ($this->db->insert('faktur_debit', $faktur)) {
			return true;
		}
		return false;
	}

	public function kreditFaktur($faktur){
		if ($this->db->insert('faktur_kredit', $faktur)) {
			return true;
		}
		return false;
	}

	public function notRekon(){
		$this->db->select('faktur_debit.NO_FAKTUR');
		$this->db->from("faktur_debit");
		$this->db->join("faktur_kredit","faktur_debit.NO_FAKTUR = faktur_kredit.NO_FAKTUR");
		$this->db->where('faktur_debit.IS_MATCHED',0);
		$this->db->where('faktur_kredit.IS_MATCHED',0);
		$this->db->limit(1);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return true;
		}
		else
			return false;
	}

	public function dataPpnDebit(){
		$result = $this->db->query("
			SELECT `ppn_kotor`, `total_faktur_debit_beban`, `sum_faktur_debit_beban` FROM
			(SELECT IFNULL(SUM(`JUMLAH_PPN`),0) AS `ppn_kotor`, '1' AS 'key' FROM `faktur_debit`) AS `tabel_ppn`
			JOIN
			(SELECT COUNT(`JUMLAH_PPN`) AS `total_faktur_debit_beban`, '1' AS 'key' FROM `faktur_debit` where `faktur_debit`.`IS_MATCHED` = 0) AS `tabel_count_beban`
			JOIN
			(SELECT IFNULL(SUM(`JUMLAH_PPN`),0) AS `sum_faktur_debit_beban`, '1' AS 'key' FROM `faktur_debit` where `faktur_debit`.`IS_MATCHED` = 0) AS `tabel_sum_beban`
			WHERE `tabel_ppn`.`key` = `tabel_count_beban`.`key` AND `tabel_ppn`.`key` = `tabel_sum_beban`.`key`
		")->result_array();

		return $result;
	}

	public function dataPpnKredit(){
		$result = $this->db->query("
			SELECT `ppn_kotor`, `total_faktur_kredit_beban`, `sum_faktur_kredit_beban` FROM
			(SELECT IFNULL(SUM(`JUMLAH_PPN`),0) AS `ppn_kotor`, '1' AS 'key' FROM `faktur_kredit`) AS `tabel_ppn`
			JOIN
			(SELECT COUNT(`JUMLAH_PPN`) AS `total_faktur_kredit_beban`, '1' AS 'key' FROM `faktur_kredit` where `faktur_kredit`.`IS_MATCHED` = 0) AS `tabel_count_beban`
			JOIN
			(SELECT IFNULL(SUM(`JUMLAH_PPN`),0) AS `sum_faktur_kredit_beban`, '1' AS 'key' FROM `faktur_kredit` where `faktur_kredit`.`IS_MATCHED` = 0) AS `tabel_sum_beban`
			WHERE `tabel_ppn`.`key` = `tabel_count_beban`.`key` AND `tabel_ppn`.`key` = `tabel_sum_beban`.`key`
		")->result_array();

		return $result;
	}

	public function getBebanDebit(){
		$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT');
		$this->db->from('faktur_debit');
		$this->db->where('IS_MATCHED',0);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;
	}

	public function getBebanKredit(){
		$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT');
		$this->db->from('faktur_kredit');
		$this->db->where('IS_MATCHED',0);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;
	}

	public function getBeban($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where('IS_MATCHED',0);
		$result = $this->db->get()->result_array();
		return $result;
	}

	// serverside beban
	public function allBebanCount($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->where('IS_MATCHED',0);
		$result = $this->db->get()->num_rows();
		return $result;
	}

	public function allBeban($tabel, $limit, $start, $col, $dir){
		$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT');
		$this->db->from($tabel);
		$this->db->where('IS_MATCHED',0);
		$this->db->limit($limit, $start);
		$this->db->order_by($col, $dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else{
			return null;
		}
	}

	public function bebanSearch($tabel, $limit, $start, $col, $dir, $search){
		$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT');
		$this->db->from($tabel);
		$this->db->like("NO_FAKTUR", $search);
		$this->db->or_like("FM", $search);
		$this->db->or_like("KD_JENIS", $search);
		$this->db->or_like("FG_PENGGANTI", $search);
		$this->db->or_like("NOMOR_FAKTUR", $search);
		$this->db->or_like("MASA_PAJAK", $search);
		$this->db->or_like("TAHUN_PAJAK", $search);
		$this->db->or_like("TANGGAL_FAKTUR", $search);
		$this->db->or_like("NPWP", $search);
		$this->db->or_like("NAMA", $search);
		$this->db->or_like("ALAMAT_LENGKAP", $search);
		$this->db->or_like("JUMLAH_DPP", $search);
		$this->db->or_like("JUMLAH_PPN", $search);
		$this->db->or_like("JUMLAH_PPNBM", $search);
		$this->db->or_like("USER_INPUT", $search);
		$this->db->or_like("DATE_INPUT", $search);
		$this->db->where('IS_MATCHED',0);
		$this->db->limit($limit, $start);
		$this->db->order_by($col, $dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else{
			return null;
		}
	}

	public function bebanSearchCount($tabel, $search){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->like("NO_FAKTUR", $search);
		$this->db->or_like("FM", $search);
		$this->db->or_like("KD_JENIS", $search);
		$this->db->or_like("FG_PENGGANTI", $search);
		$this->db->or_like("NOMOR_FAKTUR", $search);
		$this->db->or_like("MASA_PAJAK", $search);
		$this->db->or_like("TAHUN_PAJAK", $search);
		$this->db->or_like("TANGGAL_FAKTUR", $search);
		$this->db->or_like("NPWP", $search);
		$this->db->or_like("NAMA", $search);
		$this->db->or_like("ALAMAT_LENGKAP", $search);
		$this->db->or_like("JUMLAH_DPP", $search);
		$this->db->or_like("JUMLAH_PPN", $search);
		$this->db->or_like("JUMLAH_PPNBM", $search);
		$this->db->or_like("USER_INPUT", $search);
		$this->db->or_like("DATE_INPUT", $search);
		$this->db->where('IS_MATCHED',0);
		$result = $this->db->get();

		return $result->num_rows();
	}

	// server side for search
	public function allFakturCount($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$result = $this->db->get()->num_rows();
		return $result;
	}

	public function allFaktur($tabel, $limit, $start, $col, $dir){
		if ($tabel == 'faktur_debit') {
			$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT,STATUS');
		}
		elseif ($tabel == 'faktur_kredit') {
			$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT,STATUS,MASA_KREDIT,TAHUN_KREDIT');
		}
		$this->db->from($tabel);
		$this->db->join('status_rekon',"$tabel.IS_MATCHED = status_rekon.IS_MATCHED");
		$this->db->limit($limit, $start);
		$this->db->order_by($col, $dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else{
			return null;
		}
	}

	public function fakturSearch($tabel, $limit, $start, $col, $dir, $search){
		if ($tabel == 'faktur_debit') {
			$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT,STATUS');
		}
		elseif ($tabel == 'faktur_kredit') {
			$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT,STATUS,MASA_KREDIT,TAHUN_KREDIT');
		}
		$this->db->from($tabel);
		$this->db->join('status_rekon',"$tabel.IS_MATCHED = status_rekon.IS_MATCHED");
		$this->db->like("NO_FAKTUR", $search);
		$this->db->or_like("FM", $search);
		$this->db->or_like("KD_JENIS", $search);
		$this->db->or_like("FG_PENGGANTI", $search);
		$this->db->or_like("NOMOR_FAKTUR", $search);
		$this->db->or_like("MASA_PAJAK", $search);
		$this->db->or_like("TAHUN_PAJAK", $search);
		$this->db->or_like("TANGGAL_FAKTUR", $search);
		$this->db->or_like("NPWP", $search);
		$this->db->or_like("NAMA", $search);
		$this->db->or_like("ALAMAT_LENGKAP", $search);
		$this->db->or_like("JUMLAH_DPP", $search);
		$this->db->or_like("JUMLAH_PPN", $search);
		$this->db->or_like("JUMLAH_PPNBM", $search);
		$this->db->or_like("USER_INPUT", $search);
		$this->db->or_like("DATE_INPUT", $search);
		$this->db->or_like("STATUS",$search);
		$this->db->limit($limit, $start);
		$this->db->order_by($col, $dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else{
			return null;
		}
	}


	public function fakturSearchCount($tabel, $search){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->join('status_rekon',"$tabel.IS_MATCHED = status_rekon.IS_MATCHED");
		$this->db->like("NO_FAKTUR", $search);
		$this->db->or_like("FM", $search);
		$this->db->or_like("KD_JENIS", $search);
		$this->db->or_like("FG_PENGGANTI", $search);
		$this->db->or_like("NOMOR_FAKTUR", $search);
		$this->db->or_like("MASA_PAJAK", $search);
		$this->db->or_like("TAHUN_PAJAK", $search);
		$this->db->or_like("TANGGAL_FAKTUR", $search);
		$this->db->or_like("NPWP", $search);
		$this->db->or_like("NAMA", $search);
		$this->db->or_like("ALAMAT_LENGKAP", $search);
		$this->db->or_like("JUMLAH_DPP", $search);
		$this->db->or_like("JUMLAH_PPN", $search);
		$this->db->or_like("JUMLAH_PPNBM", $search);
		$this->db->or_like("USER_INPUT", $search);
		$this->db->or_like("DATE_INPUT", $search);
		$this->db->or_like("STATUS",$search);
		$result = $this->db->get();

		return $result->num_rows();
	}

	public function getMatchedFaktur(){
		$this->db->select('faktur_debit.NO_FAKTUR');
		$this->db->from('faktur_debit');
		$this->db->join('faktur_kredit','faktur_debit.NO_FAKTUR = faktur_kredit.NO_FAKTUR');
		$this->db->where('faktur_debit.IS_MATCHED',0);
		$this->db->where('faktur_kredit.IS_MATCHED',0);
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else
			return null;
	}
	public function rekonsiliasi($nofaktur){
		$this->db->set('IS_MATCHED',1);
		$this->db->where_in('NO_FAKTUR',$nofaktur);
		$this->db->update('faktur_debit');

		$this->db->set('IS_MATCHED',1);
		$this->db->where_in('NO_FAKTUR',$nofaktur);
		$this->db->update('faktur_kredit');
	}

	// serverside for database
	public function informationDatabase($tabel){
		$this->db->select('COUNT(NO_FAKTUR) AS JUMLAH_FAKTUR, SUM(JUMLAH_PPN) AS PPN');
		$this->db->from($tabel);
		$result = $this->db->get();
		return $result->result_array();
	}

	public function deleteFaktur($input){
		if (isset($input['NO_FAKTUR'])) {
			// check if faktur already rekon or not
			$checkIsRekon = $this->db->query("SELECT IS_MATCHED FROM ".$input['TABEL']." WHERE NO_FAKTUR = ".$input['NO_FAKTUR'])->result();

			if ($checkIsRekon[0]->IS_MATCHED == 1) {
				if ($input['TABEL'] == 'faktur_debit') {
					$oppositeTable = 'faktur_kredit';
				}
				else
					$oppositeTable = 'faktur_debit';

				$this->db->where('NO_FAKTUR', $input['NO_FAKTUR']);
				$resultOpposite = $this->db->delete($oppositeTable);
			}

			$this->db->where('NO_FAKTUR', $input['NO_FAKTUR']);
			$result = $this->db->delete($input['TABEL']);
			return $result;
		}
		else{
			if ($input['TABEL'] == 'faktur_debit') {
				$oppositeTable = 'faktur_kredit';
			}
			else
				$oppositeTable = 'faktur_debit';

			$allNoFaktur = $this->db->query("SELECT NO_FAKTUR FROM ".$input['TABEL']." WHERE IS_MATCHED = 1");
			if ($allNoFaktur->num_rows() > 0) {
				$tempFaktur = array();
				foreach ($allNoFaktur->result() as $faktur) {
					array_push($tempFaktur, $faktur->NO_FAKTUR);
				}
				$this->db->where_in('NO_FAKTUR',$tempFaktur);
				$this->db->delete($oppositeTable);
			}
			$result = $this->db->empty_table($input['TABEL']);
			return $result;
		}
	}

	public function allDatabaseCount($tabel){
		$this->db->select('*');
		$this->db->from($tabel);
		$result = $this->db->get()->num_rows();
		return $result;
	}

	public function allDatabase($tabel, $limit, $start, $col, $dir){
		$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT');
		$this->db->from($tabel);
		$this->db->limit($limit, $start);
		$this->db->order_by($col, $dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else{
			return null;
		}
	}

	public function databaseSearch($tabel, $limit, $start, $col, $dir, $search){
		$this->db->select('NO_FAKTUR,FM,KD_JENIS,FG_PENGGANTI,NOMOR_FAKTUR,MASA_PAJAK,TAHUN_PAJAK,TANGGAL_FAKTUR,NPWP,NAMA,ALAMAT_LENGKAP,JUMLAH_DPP,JUMLAH_PPN,JUMLAH_PPNBM,USER_INPUT,DATE_INPUT');
		$this->db->from($tabel);
		$this->db->like("NO_FAKTUR", $search);
		$this->db->or_like("FM", $search);
		$this->db->or_like("KD_JENIS", $search);
		$this->db->or_like("FG_PENGGANTI", $search);
		$this->db->or_like("NOMOR_FAKTUR", $search);
		$this->db->or_like("MASA_PAJAK", $search);
		$this->db->or_like("TAHUN_PAJAK", $search);
		$this->db->or_like("TANGGAL_FAKTUR", $search);
		$this->db->or_like("NPWP", $search);
		$this->db->or_like("NAMA", $search);
		$this->db->or_like("ALAMAT_LENGKAP", $search);
		$this->db->or_like("JUMLAH_DPP", $search);
		$this->db->or_like("JUMLAH_PPN", $search);
		$this->db->or_like("JUMLAH_PPNBM", $search);
		$this->db->or_like("USER_INPUT", $search);
		$this->db->or_like("DATE_INPUT", $search);
		$this->db->limit($limit, $start);
		$this->db->order_by($col, $dir);
		$result = $this->db->get();

		if ($result->num_rows() > 0) {
			return $result->result();
		}
		else{
			return null;
		}
	}

	public function databaseSearchCount($tabel, $search){
		$this->db->select('*');
		$this->db->from($tabel);
		$this->db->like("NO_FAKTUR", $search);
		$this->db->or_like("FM", $search);
		$this->db->or_like("KD_JENIS", $search);
		$this->db->or_like("FG_PENGGANTI", $search);
		$this->db->or_like("NOMOR_FAKTUR", $search);
		$this->db->or_like("MASA_PAJAK", $search);
		$this->db->or_like("TAHUN_PAJAK", $search);
		$this->db->or_like("TANGGAL_FAKTUR", $search);
		$this->db->or_like("NPWP", $search);
		$this->db->or_like("NAMA", $search);
		$this->db->or_like("ALAMAT_LENGKAP", $search);
		$this->db->or_like("JUMLAH_DPP", $search);
		$this->db->or_like("JUMLAH_PPN", $search);
		$this->db->or_like("JUMLAH_PPNBM", $search);
		$this->db->or_like("USER_INPUT", $search);
		$this->db->or_like("DATE_INPUT", $search);
		$result = $this->db->get();

		return $result->num_rows();
	}

}
