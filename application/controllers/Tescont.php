<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tescont extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function tesajax(){
		$userToken = $this->input->get('token');
		// if ($userToken != "234kfq1n1i401v0tjgm") {
		// 	exit("no direct script allowed");
		// }

		$input = file_get_contents("php://input");			
		$input = json_decode($input,true);
		// $input  = array(
		// 	'faktur' => array("FM", "01", "0", "0011740189804", "1", "2017", "29/01/2017", "211433768906000", "CV AKAMEDIA", "JL. MUDING INDAH VII NO.1 RT.000 RW.000, KEROBOKAN , BADUNG", "900000", "90000", "0", "1"),
		// 	'user' => "1"
		// );
		$tanggal = explode("/", $input['faktur'][6]);
		$temp = $tanggal[0];
		$tanggal[0] = $tanggal[2];
		$tanggal[2] = $temp;
		$inputFaktur = array(
			'NO_FAKTUR' => $input['faktur'][1].$input['faktur'][2].$input['faktur'][3],			
			'FM' => $input['faktur'][0],
			'KD_JENIS' => $input['faktur'][1],
			'FG_PENGGANTI' => $input['faktur'][2],
			'NOMOR_FAKTUR' => $input['faktur'][3],
			'MASA_PAJAK' => $input['faktur'][4],
			'TAHUN_PAJAK' => $input['faktur'][5],
			'TANGGAL_FAKTUR' => implode('-', $tanggal),
			'NPWP' => $input['faktur'][7],
			'NAMA' => $input['faktur'][8],
			'ALAMAT_LENGKAP' => $input['faktur'][9],
			'JUMLAH_DPP' => $input['faktur'][10],
			'JUMLAH_PPN' => $input['faktur'][11],
			'JUMLAH_PPNBM' => $input['faktur'][12],
			'IS_CREDITABLE' => $input['faktur'][13],
			'USER_INPUT' => 1,
			'DATE_INPuT' => date("Y-m-d"),
			'IS_MATCHED' => 0
		);

		$this->load->model("modelfaktur");
		$queryStatus = $this->modelfaktur->debitFaktur($inputFaktur);
		if ($queryStatus) {
			$response = array(
				'code' => 200,
				'status' => 'sukses debit' 
			);
		}
		else{
			$response = array(
				'code' => 422,
				'status' => 'gagal debit' 
			);	
		}

		// print_r($input['faktur']);
		// echo $queryStatus;
		echo json_encode($response);

		// $data = json_decode($data);				
		// $balikan = json_encode($data);
		// echo $balikan;
	}

	public function debit(){
		$userToken = $this->input->get('token');
		// if ($userToken != "234kfq1n1i401v0tjgm") {
		// 	exit("no direct script allowed");
		// }

		$input = file_get_contents("php://input");			
		$input = json_decode($input,true);
	}	

}
