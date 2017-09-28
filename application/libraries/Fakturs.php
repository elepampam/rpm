<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fakturs {

    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('faktur_model');
    }

	public function debit($fakturs){
		array_shift($fakturs);
		$response['countSukses'] = 0;
		for ($i=0; $i < count($fakturs); $i++) { 
			if (!empty($fakturs[$i])) {
				$date = explode('/', $fakturs[$i][6]);
				$temp = $date[0];
				$date[0] = $date[2];
				$date[2] = $temp;
				$faktur = array(
					'NO_FAKTUR' => $fakturs[$i][1].$fakturs[$i][2].$fakturs[$i][3],
					'FM' => $fakturs[$i][0],
					'KD_JENIS' => $fakturs[$i][1],
					'FG_PENGGANTI' => $fakturs[$i][2],
					'NOMOR_FAKTUR' => $fakturs[$i][3],
					'MASA_PAJAK' => $fakturs[$i][4],
					'TAHUN_PAJAK' => $fakturs[$i][5],
					'TANGGAL_FAKTUR' => implode('-', $date),
					'NPWP' => $fakturs[$i][7],
					'NAMA' => $fakturs[$i][8],
					'ALAMAT_LENGKAP' => $fakturs[$i][9],
					'JUMLAH_DPP' => $fakturs[$i][10],
					'JUMLAH_PPN' => $fakturs[$i][11],
					'JUMLAH_PPNBM' => $fakturs[$i][12],
					'IS_CREDITABLE' => $fakturs[$i][13],
					'USER_INPUT' => 1,
					'DATE_INPuT' => date("Y-m-d"),
					'IS_MATCHED' => 0
					 );
				if (!$this->CI->faktur_model->inputFakturDebit($faktur)) {
					$response['gagalDebit'][] = $faktur;
				}
				else
					$response['countSukses']++;
			}
			
		}
		return $response;
	}
	public function kredit($fakturs,$bulan,$tahun){
		array_shift($fakturs);
		$response['countSukses'] = 0;
		for ($i=0; $i < count($fakturs); $i++) { 
			if (!empty($fakturs[$i])) {
				$date = explode('/', $fakturs[$i][6]);
				$temp = $date[0];
				$date[0] = $date[2];
				$date[2] = $temp;
				$faktur = array(
					'NO_FAKTUR' => $fakturs[$i][1].$fakturs[$i][2].$fakturs[$i][3],
					'FM' => $fakturs[$i][0],
					'KD_JENIS' => $fakturs[$i][1],
					'FG_PENGGANTI' => $fakturs[$i][2],
					'NOMOR_FAKTUR' => $fakturs[$i][3],
					'MASA_PAJAK' => $fakturs[$i][4],
					'TAHUN_PAJAK' => $fakturs[$i][5],
					'TANGGAL_FAKTUR' => implode('-', $date),
					'NPWP' => $fakturs[$i][7],
					'NAMA' => $fakturs[$i][8],
					'ALAMAT_LENGKAP' => $fakturs[$i][9],
					'JUMLAH_DPP' => $fakturs[$i][10],
					'JUMLAH_PPN' => $fakturs[$i][11],
					'JUMLAH_PPNBM' => $fakturs[$i][12],
					'IS_CREDITABLE' => $fakturs[$i][13],
					'MASA_KREDIT' => $bulan,
					'TAHUN_KREDIT' => $tahun,
					'USER_INPUT' => 1,
					'DATE_INPuT' => date("Y-m-d"),
					'IS_MATCHED' => 0
					 );
				if (!$this->CI->faktur_model->inputFakturKredit($faktur)) {
					$response['gagalDebit'][] = $faktur;
				}
				else
					$response['countSukses']++;
			}
			
		}
		return $response;
	}

	public function rekon(){
		if (!is_null($this->CI->faktur_model->getTotalPpnDebit())) {
			$data['ppnDebit'] = $this->CI->faktur_model->getTotalPpnDebit()->result_array()[0]['total_ppn'];
		}
		else
			$data['ppnDebit'] = 0;			
		
		if (!is_null($this->CI->faktur_model->getTotalPpnKredit())) {
			$data['ppnKredit'] = $this->CI->faktur_model->getTotalPpnKredit()->result_array()[0]['total_ppn'];
		}
		else
			$data['ppnKredit'] = 0;

		$data['selisihPpn'] = ($data['ppnDebit'] - $data['ppnKredit']);
		if ($data['selisihPpn'] < 0) {
			$data['selisihPpn'] *= -1;
		}
		// fixed
		
		if (!empty($this->CI->faktur_model->matchingFaktur())) {
			$noFakturs = $this->CI->faktur_model->matchingFaktur()->result();
			foreach ($noFakturs as $noFaktur) {
				$this->CI->faktur_model->updateMatchingFaktur($noFaktur->NO_FAKTUR);
			}
		}

		// fixed

		$kredit = $this->CI->faktur_model->getUnmatchedKredit();
		$debit = $this->CI->faktur_model->getUnmatchedDebit();

		if (!is_null($this->CI->faktur_model->ppnUnmatchedKredit())) {
			$data['ppnUnKredit'] = $this->CI->faktur_model->ppnUnmatchedKredit()->result_array()[0]['total_ppn'];
		}
		else
			$data['ppnUnKredit'] = 0;

		if (!is_null($this->CI->faktur_model->ppnUnmatchedDebit())) {
			$data['ppnUnDebit']= $this->CI->faktur_model->ppnUnmatchedDebit()->result_array()[0]['total_ppn'];
		}
		else
			$data['ppnUnDebit'] = 0;

		$data['kontrolRekon'] = ($data['ppnUnDebit'] - $data['ppnUnKredit']);
		if ($data['kontrolRekon'] < 0) {
			$data['kontrolRekon'] *= -1;
		}
		// fixed
		if (!empty($kredit)) {
			$data['totalKredit'] = count($kredit->result_array());
			$data['fakturKredit'] = $kredit->result();
		}
		else
			$data['totalKredit'] = 0;

		if (!empty($debit)) {
			$data['totalDebit'] = count($debit->result_array());
			$data['fakturDebit'] = $debit->result();
		}
		else
			$data['totalDebit'] = 0;

		return $data;
	}
}