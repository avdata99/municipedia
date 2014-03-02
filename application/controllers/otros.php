<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Otros extends CI_Controller 
    {

    public function index()
	{
        
        }
        
    function upMuniData($muni_id=0)
        {
        $this->load->model("muni_mdl");
        if ($muni_id == 0)
            $r = $this->muni_mdl->updateAllResumes();
        else
            $r = $this->muni_mdl->writeResume($muni_id);
        
        $r = ($r) ? "1" : 0;
        $res = array("result"=>$r,"error"=>$this->muni_mdl->lastError);
        $this->output->set_header("Content-Type:application/json");
        $this->output->set_output(json_encode($res));
        
        
        }
        
    function fundacion($limit=10)
        {
        $this->load->model("otros_mdl");
        $res = $this->otros_mdl->getFundacion($limit);
        $data = array("funda"=>$res, "error"=>$this->otros_mdl->lastError);
        if ($limit < 30)
            {
            $this->output->set_header("Content-Type:application/json");
            echo json_encode($data);
            }
        else // mostrar el sql
            {
            foreach ($res as $sql) 
                {
                echo $sql["q"] . "<br/>";
                }
            }
        }        
        
    function telefonos($limit=10)
        {
        $this->load->model("otros_mdl");
        $res = $this->otros_mdl->getPhones($limit);
        $data = array("tels"=>$res, "error"=>$this->otros_mdl->lastError);
        if ($limit < 30)
            {
            $this->output->set_header("Content-Type:application/json");
            echo json_encode($data);
            }
        else // mostrar el sql
            {
            foreach ($res as $sql) 
                {
                echo $sql["q"] . "<br/>";
                }
            }
        }    
        
    function emails($limit=10)
        {
        $this->load->model("otros_mdl");
        $res = $this->otros_mdl->getMails($limit);
        $data = array("mails"=>$res, "error"=>$this->otros_mdl->lastError);
        if ($limit < 30)
            {
            $this->output->set_header("Content-Type:application/json");
            echo json_encode($data);
            }
        else // mostrar el sql
            {
            foreach ($res as $sql) 
                {
                echo $sql["q"] . "<br/>";
                }
            }
        }    

    }
