<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('faktur_model');
    } 


    public function autocompletenpwp(){
    	$npwp = trim($this->input->get('term')); //get term parameter sent via text field. Not sure how secure get() is

        $query = $this->faktur_model->autocompletefaktur($npwp);

        if ($query->num_rows() > 0) 
        {
            $data['response'] = 'true'; //If username exists set true
            $data['message'] = array(); 

            foreach ($query->result() as $row)
            {
                $data['message'][] = array(  
                    'label' => $row->npwp,
                    'nama_perusahaan' => $row->nama_perusahaan
                );
            }    
        } 
        else
        {
            $data['response'] = 'false'; //Set false if user not valid
        }

        echo json_encode($data);
    }

	public function create(){
		if ($this->session->userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'masukkan faktur';
			$this->load->view('header',$data);
			$this->load->view('form-faktur');
			$this->load->view('footer');
			// $this->load->view('view_livesearch');
		}
		else
			redirect('home');
		
	}

	function ubahformatTgl($tanggal) {
        $pisah = explode('/',$tanggal);
        $urutan = array($pisah[2],$pisah[1],$pisah[0]);
        $satukan = implode('-',$urutan);
        return $satukan;
    }

    function formatbalik($tanggal){
    	$pisah = explode('-', $tanggal);
    	$urutan = array($pisah[2],$pisah[1],$pisah[0]);
    	$satukan = implode('/', $urutan);
    	return $satukan;
    }
    public function randomNoFaktur($len)
    {
	    $result = "";
	    $chars = "0123456789";
	    $charArray = str_split($chars);
	    for($i = 0; $i < $len; $i++){
		    $randItem = array_rand($charArray);
		    if ($i == 3 || $i == 10) {
		    	$result .= ".";
		    }
		    elseif ($i == 7) {
		    	$result .= "-";
		    }
		    else{
		    	$result .= "".$charArray[$randItem];
		    }
	    }
	    return $result;
    }

	public function insert(){
		if ($this->session->userdata('user_masuk')) {
			$this->load->library('form_validation');

			$this->form_validation->set_message('required', '%s is Required.');
			$this->form_validation->set_message('greater_than', '%s values must be greater than 0');

			$this->form_validation->set_rules('nofaktur','No faktur','trim|required|min_length[19]');
			$this->form_validation->set_rules('nonpwp','No NPWP','trim|required|min_length[20]');
			$this->form_validation->set_rules('namapt','Lawan transaksi','trim|required');
			$this->form_validation->set_rules('dpp','DPP','required|greater_than[0]|numeric');
			$this->form_validation->set_rules('ppn','PPN','numeric');
			$this->form_validation->set_rules('ppnbm','PPNBM','numeric');
			if ($this->form_validation->run() == false) {
				$this->create();
			}
			else{
				$user = $this->session->userdata('user_masuk');
				$nofaktur = $this->input->post('nofaktur');
				$nonpwp = $this->input->post('nonpwp');
				if (!isset($nofaktur)) {
					$nofaktur = $this->randomNoFaktur(19);
				}
				$tanggal = $this->ubahformatTgl($this->input->post('date'));
				$masa = explode('-',$tanggal);

				$inputFaktur = array(
					'no_faktur' => $nofaktur,
					'kode_transaksi' => $this->input->post('kodetransaksi'),
					'npwp' => $nonpwp,
					'tanggal_faktur' => $tanggal,
					'masa' => $masa[1] - 10 + 10,
					'uraian' => $this->input->post('uraian'),
					'jenis_kedatangan' => $this->input->post('jeniskedatangan'),
					'status' => 1
					);
				$this->faktur_model->input_faktur($inputFaktur);

				$inputPt = array(
					'npwp' => $nonpwp,
					'nama_perusahaan' => $this->input->post('namapt')
					);
				if ($this->faktur_model->ceknpwp($nonpwp)) { //jika npwp dari perusahaan ada maka akan melakukan update terhadap nama perusahaan
					$this->faktur_model->update_perusahaan($inputPt);
				}
				else{
					$this->faktur_model->insert_perusahaan($inputPt);
				}

				$inputPajak = array(
					'no_faktur' => $nofaktur,
					'dpp' => $this->input->post('dpp'),
					'ppn' => $this->input->post('ppn'),
					'ppnbm' => $this->input->post('ppnbm')
					);
				$this->faktur_model->input_pajak_faktur($inputPajak);

				$inputFakturMasuk = array(
					'no_faktur' => $nofaktur,
					'tanggal_masuk' => date("y-m-d"),
					'user_input' => $user['id']
					);
				$this->faktur_model->input_taggal_masuk($inputFakturMasuk);
				$this->session->set_flashdata('pesan', 'berhasil');
				redirect('home/dashboard');
			}
		}
		else
			redirect('home');
	}

	public function cek(){
		if($this->session->userdata('user_masuk')){
			$data['result'] = $this->faktur_model->getlatestfaktur();
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'cek faktur';
			$this->load->view('header',$data);
			$this->load->view('cek_faktur');
			$this->load->view('footer');
		}
		else{
			redirect('home');
		}
	}

	public function cari(){
		if ($this->session->userdata('user_masuk')) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('faktur','No faktur','trim|required|min_length[19]');
			if ($this->form_validation->run() == false) {
				redirect('home/dashboard');
			}
			else{
				$data['user'] = $this->session->userdata('user_masuk');
				$data['posisi'] = 'detail faktur';
				$nofaktur = $this->input->post('faktur');
				$data['hasilfaktur'] =$this->faktur_model->cari($nofaktur);
				if (is_array($data['hasilfaktur'])) {
					foreach ($data['hasilfaktur'] as $key) {
						$data['tanggal_masuk'] = $key -> tanggal_masuk;
						$data['tanggal_faktur'] = $key -> tanggal_faktur;
						$kodeT = $key -> kode_transaksi;
					}
					if ($kodeT == 'wapu') {
						$pisah = explode('-', $data['tanggal_faktur']);
						$data['masa'] = $pisah[1];
					}
					else{
						$data['masa'] =  date("m");
					}
					$data['tanggal_masuk'] = $this -> formatbalik($data['tanggal_masuk']);
					$data['tanggal_faktur'] = $this ->formatbalik($data['tanggal_faktur']);
					$this->load->view('header',$data);
					$this->load->view('detail_faktur');
					$this->load->view('footer');
				}
				else{
					$this->session->set_flashdata('pesan', 'gagal');
					redirect('home/dashboard');
				}

			}
		}
		else
			redirect('home');
	}

	public function kredit(){
		if ($this->session->userdata('user_masuk')) {
			$nofaktur = $this->input->get('nofaktur');
			$user = $this->session->userdata('user_masuk');
			$status = array(
				'user_kredit' => $user['id'],
				'tanggal_keluar' => date("y-m-d"),
				'masa' => $this->input->post('masa'),
				'status' => 'SK'
				);
			$this->faktur_model->kreditFaktur($nofaktur,$status);
			// redirect('home/dashboard');
		}
		else
			redirect('home');
	}
	public function listfaktur(){
		if ($this->session->userdata('user_masuk')) {
			$data['user'] = $this->session->userdata('user_masuk');
			$data['posisi'] = 'list faktur';
			$data['faktur'] = $this->faktur_model->getfaktur();
			foreach ($data['faktur'] as $key) {
					$key -> tanggal_masuk = $this->formatbalik($key ->tanggal_masuk);
				}
			$this->load->view('header',$data);
			$this->load->view('list_faktur');
			$this->load->view('footer');
		}
		else
			redirect('home');
	}

	public function search(){
		if ($this->session->userdata('user_masuk')) {
			$input_search = $this->input->post('input_search');
			if (!isset($input_search) || trim($input_search) == '') {
				echo "asodkasod";
			}
			// if (strlen($input_search) == 19) {
			// 	if (substr($input_search, 3,1) == '.') {
			// 		echo "npwp";
			// 	}				
			// }
			// elseif (strlen($input_search) == 10) {
			// 	if (substr($input_search,2,1) == '/') {
			// 		echo "tanggal";
			// 	}
			// }
			// elseif (strlen($input_search) >= 4 && strlen($input_search) <= 9) {
			// 	echo "asdajf";
			// }
			// elseif (strlen($input_search) == 2) {
			// 	# code...
			// }
		}
		else
			redirect('home');
	}

	public function rpm(){
		if ($this->session->userdata('user_masuk')) {
			$jenisstatus = $this->input->post('jenisstatus');
			$user = $this->input->post('user');
			$date1 = $this->input->post('date1');
			$date2 = $this->input->post('date2');


			$query = "F.status = '".$jenisstatus;
			if (isset($user)) {
				$query.= "' AND U.nama_user = '".$user."'";
			}
			if ($jenisstatus == "SK") {
				if (isset($date1) && $date1 != "") {
				$date1 = $this->ubahformatTgl($date1);
				$query.= " AND F.tanggal_keluar >= '".$date1."'";
				}
				if (isset($date2) && $date2 != "") {
					$date2 = $this->ubahformatTgl($date2);
					$query.= " AND F.tanggal_keluar <= '".$date2."'";
				}			
			}
			elseif ($jenisstatus == "SS" ||$jenisstatus == 'S') {
				if (isset($date1) && $date1 != "") {
					$date1 = $this->ubahformatTgl($date1);
					$query.= " AND F.tanggal_masuk >= '".$date1."'";
				}
				if (isset($date2) && $date2 != "") {
					$date2 = $this->ubahformatTgl($date2);
					$query.= " AND F.tanggal_masuk <= '".$date2."'";
				}
			}
			

			// $query = "F.status = '".$jenisstatus."' AND U.nama_user = '".$user."'AND F.tanggal_masuk >= '".$date1."'
			// 		 AND F.tanggal_masuk <= '".$date2."'";
			$data['faktur'] = $this->faktur_model->getFakturRpm($query);
			if (is_array($data['faktur'])) {
				$data['user'] = $this->session->userdata('user_masuk');
				$data['posisi'] = 'rekonsliasi';
				$data['query'] = $query;
				$this->load->view('header',$data);
				$this->load->view('list_rpm');
				$this->load->view('footer');
			}
			else{
					$this->session->set_flashdata('pesan', 'gagal');
					redirect('home/dashboard');
				}
			}
		else
			redirect('home');
	}

    public function download(){

    	$query = $this->input->get('print');
		$faktur = $this->faktur_model->getFakturRpm($query);
    	header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=myCSV.csv");



		$content = "HeaderA1,HeaderB,HeaderC\n";
		foreach ($faktur_model as $key) {
			$content .= $key -> no_faktur.','.$key -> kode_transaksi.','.$key -> P.npwp;
		}
		echo $content;
		// echo $query;
    }

    // public function search(){
    // 	if (isset($_GET['term'])) {
    // 		$result =$this->faktur_model->npwpAutoSearch($_GET['term']);
	   //  	if (count($result) > 0) {
	   //  		foreach ($result as $key) {
	   //  			$arr_result[] = $key -> npwp;
	   //  		}
	   //  		echo json_encode($arr_result);
	   //  	}
    // 	}
    	
    // }
}
