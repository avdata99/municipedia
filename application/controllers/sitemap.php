<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends CI_Controller 
    {
    function index()
        {
        $this->load->model("muni_mdl");
        $data = array("municipios" => $this->muni_mdl->getAll());
        $data["referencias"] = $this->muni_mdl->getAllRefs();
        
        $this->output->set_header("Content-Type:text/xml");
        $this->load->view('sitemap',$data);
        
        }
    }
?>
