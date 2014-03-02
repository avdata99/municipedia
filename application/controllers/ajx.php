<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajx extends CI_Controller 
    {

    public function index()
	{
        
        }
        
    function searchMuni($smuni="")
        {
        $muni = ($this->input->post('muni') != null) ? $this->input->post('muni') : $smuni;
        $this->load->model("muni_mdl");
        $res = $this->muni_mdl->searchMuni($muni);
        $data = array("munis"=>$res, "error"=>$this->muni_mdl->lastError);
        
        $this->output->set_content_type("application/json");//application/x-www-form-urlencoded;charset=UTF-8");
        $this->output->set_output(json_encode($data));
        
        }    

    /**
     * agregar un set de datos al sistema
     */    
    function addDataSet()
        {
        $data=array();
        $this->output->set_content_type("application/json");//application/x-www-form-urlencoded;charset=UTF-8");
        
        //salir si no esta logueado
        if ($this->session->userdata("loginuser") != "")
            {
            $pst = $this->input->post();
            $this->load->model("data_mdl");
            $data = $this->data_mdl->addDataSet($pst);
            }
        else
            {
            $data["error"] = "No ha iniciado sesion";
            }
            
            
        if ($data["resultado"] == 1)
            {
            //actualizar la plataforma 
            $this->load->model("muni_mdl");
            $r = $this->muni_mdl->updateAllResumes();
            $r2 = ($r) ? "1" : 0;
            $data["upplataforma"] = $r2;
            $data["error_upplataforma"] = $this->muni_mdl->lastError;
            }
            
        $this->errores->add(__CLASS__.".".__FUNCTION__,$this->session->userdata("loginiduser"),print_r($data, true),3);
        $this->output->set_output(json_encode($data));
        
        }
        
    }
