<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tole extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	// public function index()
	// {
	// 	$this->load->view('header');
	// 	$this->load->view('dashboard');
	// 	$this->load->view('footer');
	// }
	public function __construct()
    {
        parent::__construct();
        $this->load->model('faktur_model');
    } 

    public function index(){
    	$this->load->view('fuckingshit');
    }
     public function autocomplete() {
        $search_data = $this->input->post('search_data');
        $query = $this->faktur_model->npwpAutoSearch($search_data);

        foreach ($query->result() as $row):
            echo "<li><a href='" . base_url() . "domhos/view/" . "'>" . $row->npwp . "</a></li>";
        endforeach;
    }
	
}
