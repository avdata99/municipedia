<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Imagenes extends CI_Controller {

    public function index()
	{
        
        $data = array();
        $data["descripcion"] = "Imágenes sobre municipios de Argentina";
        $data["extra_body"] = "";
        $data["title"] = "Municipedia - Imagenes";
        
        $data["user"] = null;
        $data["userurl"] = "<a href='/twtcback/accesstwitter'>LOGIN / REGISTRARSE</a>";
        if ($this->session->userdata("loginuser") != "")
            {
            $this->load->model("user_mdl");
            $data["user"] = $this->user_mdl->load($this->session->userdata("loginiduser"));
            $data["userurl"] = "<a href='/home/user'>@" . $data["user"]->twitter_user."</a>";
            }
        
        $this->load->view('home_head', $data);
        $this->load->view('home_menutop', $data);
        $this->load->view('home_imagenes', $data);
        $this->load->view('home_footer', $data);
	}
        
} 
?>