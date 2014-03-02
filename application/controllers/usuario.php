<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function index()
	{
        
        $data = array();
        $data["descripcion"] = "Encicplopedia colaborativa sobre municipios de Argentina";
        $data["extra_body"] = "";
        $data["title"] = "Municipedia";
        
        $this->load->view('home_head', $data);
        $this->load->view('home_menutop', $data);
        $this->load->view('home_body', $data);
        $this->load->view('home_footer', $data);
	}
        
}