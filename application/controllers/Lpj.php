<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lpj extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index()
    {
        
        $data=array(
			'title' => 'Data Pencairan Program',
			'isi' => 'isi/lpj/index',
			'navbar' => 'layout/navbar',
			'footer' => 'layout/footer'
		);
        $this->load->view('index',$data);
    }
}