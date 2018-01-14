<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('faktur_model');
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

			$this->load->view('user-input',$data);
		}
		else
			redirect('home');
	}

	public function debitKhusus(){
		if (!isset($_POST['faktur'])) {
			exit('No Direct Script Allowed!');
		}
		else{
			$faktur = array(
				'NO_FAKTUR' => $_POST['faktur']['no-faktur'],
				'MASA_PAJAK' => $_POST['faktur']['masa-pajak'],
				'TAHUN_PAJAK' => $_POST['faktur']['tahun-pajak'],
				'TANGGAL_FAKTUR' => $_POST['faktur']['tanggal-faktur'],
				'NPWP' => $_POST['faktur']['npwp'],
				'NAMA' => $_POST['faktur']['nama'],
				'ALAMAT_LENGKAP' => $_POST['faktur']['alamat-faktur'],
				'JUMLAH_DPP' => $_POST['faktur']['dpp-faktur'],
				'JUMLAH_PPN' => $_POST['faktur']['ppn-faktur'],
				'JUMLAH_PPNBM' => $_POST['faktur']['ppnbm-faktur']
			);
		}
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

			$this->load->view('user-input',$data);
		}
		else
			redirect('home');
	}

	public function debitfaktur(){
		$userToken = $this->input->get('token');
		if ($userToken != "234kfq1n1i401v0tjgm") {
			exit("no direct script allowed");
		}

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
			'USER_INPUT' => $input['user'],
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

	public function kreditfaktur(){
		$userToken = $this->input->get('token');
		if ($userToken != "234kfq1n1i401v0tjgm") {
			exit("no direct script allowed");
		}

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
			'MASA_KREDIT' => $input['masa_kredit'],
			'TAHUN_KREDIT' => $input['masa_kredit'],
			'USER_INPUT' => $input['user'],
			'DATE_INPuT' => date("Y-m-d"),
			'IS_MATCHED' => 0
		);

		$this->load->model("modelfaktur");
		$queryStatus = $this->modelfaktur->kreditFaktur($inputFaktur);
		if ($queryStatus) {
			$response = array(
				'code' => 200,
				'status' => 'sukses kredit'
			);
		}
		else{
			$response = array(
				'code' => 422,
				'status' => 'gagal kredit'
			);
		}
		// print_r($input['faktur']);
		// echo $queryStatus;
		echo json_encode($response);

		// $data = json_decode($data);
		// $balikan = json_encode($data);
		// echo $balikan;
	}

	public function cetak(){
		if ($this->session->has_userdata('user_masuk')) {
			ini_set("max_execution_time", 300);
			$ppnKredit = $this->faktur_model->getTotalPpnKredit();
			$ppnDebit = $this->faktur_model->getTotalPpnDebit();
			$matchFaktur = $this->faktur_model->matchingFaktur();

			if (!is_null($ppnDebit)) {
				$data['ppnDebit'] = $ppnDebit->result_array()[0]['total_ppn'];
			}
			else
				$data['ppnDebit'] = 0;

			if (!is_null($ppnKredit)) {
				$data['ppnKredit'] = $ppnKredit->result_array()[0]['total_ppn'];
			}
			else
				$data['ppnKredit'] = 0;

			$data['selisihPpn'] = ($data['ppnDebit'] - $data['ppnKredit']);
			if ($data['selisihPpn'] < 0) {
				$data['selisihPpn'] *= -1;
			}
			$data['selisihPpn'] = 'Rp '.number_format($data['selisihPpn'], 2, ',', '.');
			$data['ppnDebit'] = 'Rp '.number_format($data['ppnDebit'], 2, ',', '.');
			$data['ppnKredit'] = 'Rp '.number_format($data['ppnKredit'], 2, ',', '.');
			// fixed

			if (!empty($matchFaktur)) {
				$noFakturs = $matchFaktur->result();
				foreach ($noFakturs as $noFaktur) {
					$this->faktur_model->updateMatchingFaktur($noFaktur->NO_FAKTUR);
				}
			}

			// fixed

			$kredit = $this->faktur_model->getUnmatchedKredit();
			$debit = $this->faktur_model->getUnmatchedDebit();
			$ppnKredit = $this->faktur_model->ppnUnmatchedKredit();
			$ppnDebit = $this->faktur_model->ppnUnmatchedDebit();

			if (!is_null($ppnKredit)) {
				$data['ppnUnKredit'] = $ppnKredit->result_array()[0]['total_ppn'];
			}
			else
				$data['ppnUnKredit'] = 0;

			if (!is_null($ppnDebit)) {
				$data['ppnUnDebit']= $ppnDebit->result_array()[0]['total_ppn'];
			}
			else
				$data['ppnUnDebit'] = 0;

			$data['kontrolRekon'] = ($data['ppnUnDebit'] - $data['ppnUnKredit']);
			if ($data['kontrolRekon'] < 0) {
				$data['kontrolRekon'] *= -1;
			}

			$data['ppnUnDebit'] = 'Rp '.number_format($data['ppnUnDebit'], 2, ',', '.');
			$data['ppnUnKredit'] = 'Rp '.number_format($data['ppnUnKredit'], 2, ',', '.');
			$data['kontrolRekon'] = 'Rp '.number_format($data['kontrolRekon'], 2, ',', '.');
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

			// $data = unserialize($this->input->get('debit'));
			print_r($data);

			// $this->load->library('mpdf/mpdf');
			// $mpdf = new mPDF('utf-8', 'A4-L');

			// $html = $this->load->view('cetak',$data,true);
			// $mpdf->AddPage('L');

	  //       $mpdf->SetFooter('copyrights©rpm |2017| Direkon pada : '.date('d/m/Y'));
	  //       $mpdf->WriteHTML($html);
	  //       $mpdf->Output();
		}
		else
			redirect('home');
	}

	public function rekonsiliasi(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'Rekonsiliasi';
			$this->load->model('modelfaktur');
			$data['notRekon'] = $this->modelfaktur->notRekon();//1

			$varDebit = $this->modelfaktur->dataPpnDebit();//2
			$data['ppnDebit'] = $varDebit[0]['ppn_kotor'];
			$data['totalBebanDebit'] = $varDebit[0]['total_faktur_debit_beban'];
			$data['sumBebanDebit'] = $varDebit[0]['sum_faktur_debit_beban'];

			$varKredit = $this->modelfaktur->dataPpnKredit();//3
			$data['ppnKredit'] = $varKredit[0]['ppn_kotor'];
			$data['totalBebanKredit'] = $varKredit[0]['total_faktur_kredit_beban'];
			$data['sumBebanKredit'] = $varKredit[0]['sum_faktur_kredit_beban'];

			$data['selisihPpn'] = abs($varDebit[0]['ppn_kotor'] - $varKredit[0]['ppn_kotor']);
			$data['kontrolRekon'] = abs($data['sumBebanDebit'] - $data['sumBebanKredit']);
			$this->load->view('rekonsiliasi',$data);
		}
		else
			redirect('home');
	}

	function getFakturBeban(){
		$this->load->model('modelfaktur');
		$columns = array(
			0 => "NO_FAKTUR",
			1 => "FM",
			2 => "KD_JENIS",
			3 => "FG_PENGGANTI",
			4 => "NOMOR_FAKTUR",
			5 => "MASA_PAJAK",
			6 => "TAHUN_PAJAK",
			7 => "TANGGAL_FAKTUR",
			8 => "NPWP",
			9 => "NAMA",
			10 => "ALAMAT_LENGKAP",
			11 => "JUMLAH_DPP",
			12 => "JUMLAH_PPN",
			13 => "JUMLAH_PPNBM",
			14 => "IS_CREDITABLE",
			15 => "USER_INPUT",
			16 => "DATE_INPUT",
			17 => "IS_MATCHED"
		);
		$tabel = $this->input->get('tabel');
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $this->input->post('order')[0]['column'];
		$order = $columns[$order];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->modelfaktur->allBebanCount($tabel);

		$totalFiltered = $totalData;
		if (empty($this->input->post('search')['value'])) {
				$posts = $this->modelfaktur->allBeban($tabel,$limit,$start,$order,$dir);
		}
		else{
			$search = $this->input->post('search')['value'];
			$posts = $this->modelfaktur->bebanSearch($tabel,$limit,$start,$order,$dir, $search);
			$totalFiltered = $this->modelfaktur->bebanSearchCount($tabel, $search);
		}

		$data = array();
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$nestedData["NO_FAKTUR"] = $post->NO_FAKTUR;
				$nestedData["FM"] = $post->FM;
				$nestedData["KD_JENIS"] = $post->KD_JENIS;
				$nestedData["FG_PENGGANTI"] = $post->FG_PENGGANTI;
				$nestedData["NOMOR_FAKTUR"] = $post->NOMOR_FAKTUR;
				$nestedData["MASA_PAJAK"] = $post->MASA_PAJAK;
				$nestedData["TAHUN_PAJAK"] = $post->TAHUN_PAJAK;
				$nestedData["TANGGAL_FAKTUR"] = $this->fixingDate($post->TANGGAL_FAKTUR);
				$nestedData["NPWP"] = $post->NPWP;
				$nestedData["NAMA"] = $post->NAMA;
				$nestedData["ALAMAT_LENGKAP"] = $post->ALAMAT_LENGKAP;
				$nestedData["JUMLAH_DPP"] = $this->toRP($post->JUMLAH_DPP);
				$nestedData["JUMLAH_PPN"] = $this->toRP($post->JUMLAH_PPN);
				$nestedData["JUMLAH_PPNBM"] = $this->toRP($post->JUMLAH_PPNBM);
				$nestedData["USER_INPUT"] = $post->USER_INPUT;
				$nestedData["DATE_INPUT"] = $this->fixingDate($post->DATE_INPUT);
				array_push($data, $nestedData);
			}
		}

		$jsonData = array(
			   "draw"            => intval($this->input->post('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
		);
		echo json_encode($jsonData);
	}

	function getFakturDatabase(){
		$this->load->model('modelfaktur');
		$columns = array(
			0 => "NO_FAKTUR",
			1 => "FM",
			2 => "KD_JENIS",
			3 => "FG_PENGGANTI",
			4 => "NOMOR_FAKTUR",
			5 => "MASA_PAJAK",
			6 => "TAHUN_PAJAK",
			7 => "TANGGAL_FAKTUR",
			8 => "NPWP",
			9 => "NAMA",
			10 => "ALAMAT_LENGKAP",
			11 => "JUMLAH_DPP",
			12 => "JUMLAH_PPN",
			13 => "JUMLAH_PPNBM",
			14 => "IS_CREDITABLE",
			15 => "USER_INPUT",
			16 => "DATE_INPUT",
			17 => "IS_MATCHED"
		);
		$tabel = $this->input->get('tabel');
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $this->input->post('order')[0]['column'];
		$order = $columns[$order];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->modelfaktur->allDatabaseCount($tabel);

		$totalFiltered = $totalData;
		if (empty($this->input->post('search')['value'])) {
				$posts = $this->modelfaktur->allDatabase($tabel,$limit,$start,$order,$dir);
		}
		else{
			$search = $this->input->post('search')['value'];
			$posts = $this->modelfaktur->databaseSearch($tabel,$limit,$start,$order,$dir, $search);
			$totalFiltered = $this->modelfaktur->databaseSearchCount($tabel, $search);
		}

		$data = array();
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$nestedData["NO_FAKTUR"] = $post->NO_FAKTUR;
				$nestedData["FM"] = $post->FM;
				$nestedData["KD_JENIS"] = $post->KD_JENIS;
				$nestedData["FG_PENGGANTI"] = $post->FG_PENGGANTI;
				$nestedData["NOMOR_FAKTUR"] = $post->NOMOR_FAKTUR;
				$nestedData["MASA_PAJAK"] = $post->MASA_PAJAK;
				$nestedData["TAHUN_PAJAK"] = $post->TAHUN_PAJAK;
				$nestedData["TANGGAL_FAKTUR"] = $this->fixingDate($post->TANGGAL_FAKTUR);
				$nestedData["NPWP"] = $post->NPWP;
				$nestedData["NAMA"] = $post->NAMA;
				$nestedData["ALAMAT_LENGKAP"] = $post->ALAMAT_LENGKAP;
				$nestedData["JUMLAH_DPP"] = $this->toRP($post->JUMLAH_DPP);
				$nestedData["JUMLAH_PPN"] = $this->toRP($post->JUMLAH_PPN);
				$nestedData["JUMLAH_PPNBM"] = $this->toRP($post->JUMLAH_PPNBM);
				$nestedData["USER_INPUT"] = $post->USER_INPUT;
				$nestedData["DATE_INPUT"] = $this->fixingDate($post->DATE_INPUT);
				$nestedData["ACTION"] = "<button data-id='".$nestedData["NO_FAKTUR"]."' data-tabel='".$tabel."' class='btn btn-danger delete-faktur'>Delete</button>";
				array_push($data, $nestedData);
			}
		}

		$jsonData = array(
			   "draw"            => intval($this->input->post('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
		);
		echo json_encode($jsonData);
	}


	private function fixingDate($date){
		$date = explode('-', $date);
		$temp = $date[0];
		$date[0] = $date[2];
		$date[2] = $temp;
		return implode("/", $date);
	}

	private function toRP($angka){
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

	public function rekon(){
		$this->load->model('modelfaktur');
		$matchedFaktur = $this->modelfaktur->getMatchedFaktur();
		if ($matchedFaktur == null) {
			$response = array(
				'code' => 201,
				'response' => 'seluruh faktur telah di rekon sebelumnya'
			);
			echo json_encode($response);
		}
		else{
			$updateFaktur = array();
			foreach ($matchedFaktur as $faktur) {
				array_push($updateFaktur, $faktur->NO_FAKTUR);
			}
			$this->modelfaktur->rekonsiliasi($updateFaktur);
			$response = array(
				'code' => 202,
				'response' => 'rekonsiliasi selesai'
			);
			echo json_encode($response);
		}
	}

	public function updateRekon(){
		$this->load->model('modelfaktur');
		$data['notRekon'] = $this->modelfaktur->notRekon();//1

		$varDebit = $this->modelfaktur->dataPpnDebit();//2
		$data['ppnDebit'] = $this->toRP($varDebit[0]['ppn_kotor']);
		$data['totalBebanDebit'] = $varDebit[0]['total_faktur_debit_beban'];
		$data['sumBebanDebit'] = $this->toRP($varDebit[0]['sum_faktur_debit_beban']);

		$varKredit = $this->modelfaktur->dataPpnKredit();//3
		$data['ppnKredit'] = $this->toRP($varKredit[0]['ppn_kotor']);
		$data['totalBebanKredit'] = $varKredit[0]['total_faktur_kredit_beban'];
		$data['sumBebanKredit'] = $this->toRP($varKredit[0]['sum_faktur_kredit_beban']);

		$data['selisihPpn'] = $this->toRP(abs($varDebit[0]['ppn_kotor'] - $varKredit[0]['ppn_kotor']));
		$data['kontrolRekon'] = $this->toRP(abs($data['sumBebanDebit'] - $data['sumBebanKredit']));
		echo json_encode($data);
	}

	public function printpdf(){
		if ($this->session->has_userdata('user_masuk')) {
			$data = array();
			$tabel = $this->input->get('tabel');
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'print pdf';
			$this->load->model('modelfaktur');

			$varDebit = $this->modelfaktur->dataPpnDebit();//1
			$data['ppnDebit'] = $this->toRP($varDebit[0]['ppn_kotor']);
			$data['totalBebanDebit'] = $varDebit[0]['total_faktur_debit_beban'];
			$data['sumBebanDebit'] = $this->toRP($varDebit[0]['sum_faktur_debit_beban']);

			$varKredit = $this->modelfaktur->dataPpnKredit();//2
			$data['ppnKredit'] = $this->toRP($varKredit[0]['ppn_kotor']);
			$data['totalBebanKredit'] = $varKredit[0]['total_faktur_kredit_beban'];
			$data['sumBebanKredit'] = $this->toRP($varKredit[0]['sum_faktur_kredit_beban']);

			$data['selisihPpn'] = $this->toRP(abs($varDebit[0]['ppn_kotor'] - $varKredit[0]['ppn_kotor']));
			if ($tabel == 'faktur_debit') {
				$fakturs = $this->modelfaktur->getBebanDebit();
			}
			elseif ($tabel == 'faktur_kredit') {
				$fakturs = $this->modelfaktur->getBebanKredit();
			}
			foreach ($fakturs as $faktur) {
				$faktur->TANGGAL_FAKTUR = $this->fixingDate($faktur->TANGGAL_FAKTUR);
				$faktur->DATE_INPUT = $this->fixingDate($faktur->DATE_INPUT);
				$faktur->JUMLAH_DPP = $this->toRP($faktur->JUMLAH_DPP);
				$faktur->JUMLAH_PPN = $this->toRP($faktur->JUMLAH_PPN);
				$faktur->JUMLAH_PPNBM = $this->toRP($faktur->JUMLAH_PPNBM);
			}
			$data['fakturs'] = $fakturs;
			$data['kontrolRekon'] = $this->toRP(abs($varKredit[0]['sum_faktur_kredit_beban'] - $varDebit[0]['sum_faktur_debit_beban']));
			// print_r($data);

			// $this->load->view('cetak',$data);
			$this->load->library('mpdf/mpdf');
			$mpdf = new mPDF('utf-8', 'A4-L');

			$html = $this->load->view('cetak',$data,true);
			$mpdf->AddPage('L');
			$mpdf->SetCreator('eLepampam machine');
			$mpdf->SetFooter('copyrights©rpm |{PAGENO}| Direkon pada : '.date('d/m/Y'));
			$mpdf->WriteHTML($html);
			$mpdf->Output('hasil rekon.pdf','I');
		}
		else
			redirect('home');
	}

	public function pencarian(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'Rekonsiliasi';

			$this->load->view('searchpage',$data);
		}
		else
			redirect('home');
	}

	public function search(){
		$this->load->model('modelfaktur');
		$columns = array(
			0 => "NO_FAKTUR",
			1 => "FM",
			2 => "KD_JENIS",
			3 => "FG_PENGGANTI",
			4 => "NOMOR_FAKTUR",
			5 => "MASA_PAJAK",
			6 => "TAHUN_PAJAK",
			7 => "TANGGAL_FAKTUR",
			8 => "NPWP",
			9 => "NAMA",
			10 => "ALAMAT_LENGKAP",
			11 => "JUMLAH_DPP",
			12 => "JUMLAH_PPN",
			13 => "JUMLAH_PPNBM",
			14 => "IS_CREDITABLE",
			15 => "USER_INPUT",
			16 => "DATE_INPUT",
			17 => "IS_MATCHED"
		);

		$months = array(
			"Januari", "Februari", "Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"
		);
		$tabel = $this->input->get('tabel');
		$limit = $this->input->post('length');
		$start = $this->input->post('start');
		$order = $this->input->post('order')[0]['column'];
		$dir = $this->input->post('order')[0]['dir'];

		$totalData = $this->modelfaktur->allFakturCount($tabel);

		$totalFiltered = $totalData;
		if (empty($this->input->post('search')['value'])) {
				$posts = $this->modelfaktur->allFaktur($tabel,$limit,$start,$order,$dir);
		}
		else{
			$search = $this->input->post('search')['value'];
			$posts = $this->modelfaktur->fakturSearch($tabel,$limit,$start,$order,$dir, $search);
			$totalFiltered = $this->modelfaktur->fakturSearchCount($tabel, $search);
		}

		$data = array();
		if (!empty($posts)) {
			foreach ($posts as $post) {
				$nestedData["NO_FAKTUR"] = $post->NO_FAKTUR;
				$nestedData["FM"] = $post->FM;
				$nestedData["KD_JENIS"] = $post->KD_JENIS;
				$nestedData["FG_PENGGANTI"] = $post->FG_PENGGANTI;
				$nestedData["NOMOR_FAKTUR"] = $post->NOMOR_FAKTUR;
				$nestedData["MASA_PAJAK"] = $post->MASA_PAJAK;
				$nestedData["TAHUN_PAJAK"] = $post->TAHUN_PAJAK;
				$nestedData["TANGGAL_FAKTUR"] = $this->fixingDate($post->TANGGAL_FAKTUR);
				$nestedData["NPWP"] = $post->NPWP;
				$nestedData["NAMA"] = $post->NAMA;
				$nestedData["ALAMAT_LENGKAP"] = $post->ALAMAT_LENGKAP;
				$nestedData["JUMLAH_DPP"] = $this->toRP($post->JUMLAH_DPP);
				$nestedData["JUMLAH_PPN"] = $this->toRP($post->JUMLAH_PPN);
				$nestedData["JUMLAH_PPNBM"] = $this->toRP($post->JUMLAH_PPNBM);
				$nestedData["USER_INPUT"] = $post->USER_INPUT;
				$nestedData["DATE_INPUT"] = $this->fixingDate($post->DATE_INPUT);
				$nestedData['STATUS'] = $post->STATUS;
				if ($tabel == 'faktur_kredit') {
					$nestedData['MASA_KREDIT'] = $months[$post->MASA_KREDIT];
					$nestedData['TAHUN_KREDIT'] = $post->TAHUN_KREDIT;
				}
				array_push($data, $nestedData);
			}
		}

		$jsonData = array(
			   "draw"            => intval($this->input->post('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
		);
		echo json_encode($jsonData);
	}

	public function delete(){
		$input = file_get_contents("php://input");
		$input = json_decode($input,true);
		$this->load->model('modelfaktur');
		$success = $this->modelfaktur->deleteFaktur($input);
		if ($success) {
			if (isset($input['NO_FAKTUR'])) {
				$response = array(
					'code' => 202,
					'message' => 'faktur berhasil dihapus'
				);
			}
			else{
				$response = array(
					'code' => 202,
					'message' => 'database '.$input["TABEL"].' berhasil dikosongkan'
				);
			}
		}
		else{
			if (isset($input["NO_FAKTUR"])) {
				$response = array(
					'code' => 403,
					'message' => 'faktur gagal dihapus, silahkan coba lagi'
				);
			}
			else{
				$response = array(
					'code' => 403,
					'message' => 'database '.$input["TABEL"].' gagal dihapus, silahkan coba lagi'
				);
			}
		}
		echo json_encode($response);
	}
}
