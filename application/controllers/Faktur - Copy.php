<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('faktur_model');
	}

	private function csvtoarray($filecsv){
		$filecsv = fopen($filecsv, 'r');
		 while (!feof($filecsv) ) {
	        $array[] = fgetcsv($filecsv, 1024);
	    }
	    fclose($filecsv);
		return $array;
	}

	public function debitfaktur(){
		$fakturMasuk = file_get_contents("php://input");
		echo $fakturMasuk;
		$fakturMasuk = json_decode($fakturMasuk);

	}

	public function inputdebit(){
		if ($this->session->has_userdata('user_masuk')) {
			$config['upload_path'] = './file_csv/debit/';
			$config['allowed_types'] = 'csv';
			$this->load->library('upload', $config);			

			$data['user'] = $this->session->userdata('user_masuk');

			if (!$this->upload->do_upload('file-csv')){
				$error = array('error' => $this->upload->display_errors());
				$tes['data'] = $error;
				$this->load->view('kosongan',$tes);
			}else{
				$succes = $this->upload->data();
				$fakturs = $this->csvtoarray($succes['full_path']);
				$this->load->library('fakturs');			
				$response = $this->fakturs->debit($fakturs);
				
				if (isset($response['gagalDebit'])) {
					$this->session->set_flashdata('gagalDebit',$response['gagalDebit']);
				}				
				$this->session->set_flashdata('sukses',$response['countSukses']);
				if ($data['user']['level'] == 1) {
					redirect('admin/debit');
				}
				elseif ($data['user']['level'] == 2) {
					redirect('user/debit');
				}	
			}
		}
		else
			redirect('home');
	}
	public function inputkredit(){
		if ($this->session->has_userdata('user_masuk')) {
			$config['upload_path'] = './file_csv/kredit/';
			$config['allowed_types'] = 'csv';
			$this->load->library('upload', $config);

			$data['user'] = $this->session->userdata('user_masuk');

			if (!$this->upload->do_upload('file-csv')){
				$error = array('error' => $this->upload->display_errors());
				$tes['data'] = $error;
				$this->load->view('kosongan',$tes);
			}else{
				$succes = $this->upload->data();
				$fakturs = $this->csvtoarray($succes['full_path']);
				$this->load->library('fakturs');			
				$response = $this->fakturs->kredit($fakturs,$this->input->post('masa-bulan'),$this->input->post('masa-tahun'));	
				if (isset($response['gagalKredit'])) {
					$this->session->set_flashdata('gagalKredit',$response['gagalKredit']);
				}				
				$this->session->set_flashdata('sukses',$response['countSukses']);
				if ($data['user']['level'] == 1) {
					redirect('admin/kredit');
				}
				elseif ($data['user']['level'] == 3) {
					redirect('user/kredit');
				}			
			}
		}
		else
			redirect('home');
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

			$this->load->library('mpdf/mpdf');
			$mpdf = new mPDF('utf-8', 'A4-L');

			$html = $this->load->view('cetak',$data,true);
			$mpdf->AddPage('L');

	        $mpdf->SetFooter('copyrights©rpm |2017| Direkon pada : '.date('d/m/Y'));
	        $mpdf->WriteHTML($html);
	        $mpdf->Output();
		}
		else
			redirect('home');
	}
	public function search(){
		if ($this->session->has_userdata('user_masuk')) {
			$data['posisi'] = 'Pencarian';
			$data['user'] = $this->session->userdata('user_masuk');
			$table = $this->input->get('table');
			if (empty($table)) {
				$table="debit";
			}
			$name = $this->input->get('nama');
			$nofaktur = $this->input->get('nofaktur');
			$tanggal = $this->input->get('tanggal');
			// perbaikan tanggal
			if (!empty($tanggal)) {
				$temp = explode("/", $tanggal);
				$tempHelp = $temp[0];
				$temp[0] = $temp[2];
				$temp[2] = $temp[1];
				$temp[1] = $tempHelp;
				$tanggal = implode("-", $temp);
			}
			$masa = $this->input->get('masa');
			$this->load->model('faktur_model');
			if (!empty($nofaktur) || !empty($name) || !empty($tanggal) || !empty($masa)) {
				$results = $this->faktur_model->search($table,$name,$nofaktur,$tanggal,$masa);	
				if (!empty($results)) {
					$data['results'] = $results;
				}
				else{
					$data['results'] = "Faktur Tidak Ditemukan";
				}
			}
			$this->load->view('searchpage',$data);
		}
		else
			redirect('home');
	}
}
