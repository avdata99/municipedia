<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datos extends CI_Controller {

    public function index()
	{
        
        $data = array();
        $data["descripcion"] = "Datos de municipedia";
        $data["extra_body"] = "";
        $data["title"] = "Municipedia - Datos";
        
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
        $this->load->view('home_datos', $data);
        $this->load->view('adsense', $data);
        $this->load->view('home_footer', $data);
	}
        
    public function referencia($ref)
	{
        
        $data = array();
        $this->load->model("muni_mdl");
        $ref = urldecode(str_replace("-", " ", $ref));
        $data["ref"] = $this->muni_mdl->getRefByTitle($ref);
        if (!$data["ref"]) exit("NO EXISTE $ref");
        $data["descripcion"] = $ref;
        $data["extra_body"] = "";
        $data["title"] = $ref;
        
        $this->load->view('home_head', $data);
        $this->load->view('home_menutop', $data);
        $this->load->view('home_referencia', $data);
        $this->load->view('adsense', $data);
        $this->load->view('home_footer', $data);
	}    
        
    public function referencias()
	{
        
        $data = array();
        $this->load->model("data_mdl");
        
        $data["refs"] = $this->data_mdl->getListaSets();
        
        $data["descripcion"] = "Set de datos cargados a municipedia";
        $data["extra_body"] = "";
        $data["title"] = "Set de datos cargados a municipedia";
        
        $this->load->view('home_head', $data);
        $this->load->view('home_menutop', $data);
        $this->load->view('home_referencias', $data);
        $this->load->view('adsense', $data);
        $this->load->view('home_footer', $data);
	}        
        
    /** permite descarga de archivo. Si no existen los crea y los graba */
    public function download($ref, $id=0, $format="json")
	{
        
        //$data = array();
        $this->load->model("muni_mdl");
        $ref = urldecode(str_replace("-", " ", $ref));
        $refs = $this->muni_mdl->getRefByTitle($ref);
        if (!$refs) exit("NO EXISTE $ref");
        
        $filename = "$refs->tabla-$id.$format";
        $fileNameNice = "$ref.$id.$format";
        $pth = "/home/municipa/public_html/assets/datas/$filename";
        if (!file_exists($pth))
            {
        
            $data = $this->muni_mdl->getDataSet($refs->tabla, $id);
            //$data["query"] = $this->muni_mdl->lastQuery;
            
            $f = fopen($pth, "w");
            if ($format == "json") $f2 = fwrite($f, json_encode($data));
            
            if ($format == "csv" || $format == "xls")
                {
                $ardata = (array)$data;
                $campos = (array)$ardata[0];
                fputcsv($f, array_keys($campos));
                foreach ($ardata as $dat) 
                    {fputcsv($f, (array)$dat);}
                }
            $f3 = fclose($f);
            }
        
        
        $this->load->helper('download');
        force_download($fileNameNice, file_get_contents($pth));
        /*
        //$this->output->set_header('Pragma: public');     // required
        //$this->output->set_header('Expires: 0');         // no cache
        //$this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        //$this->output->set_header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
        //$this->output->set_header('Cache-Control: private',false);
        $this->output->set_header('Content-Disposition: attachment; filename="'.basename($pth).'"');  // Add the file name
        $this->output->set_header('Content-Transfer-Encoding: binary');
        $this->output->set_header('Content-Length: '.filesize($pth)); // provide file size
        //$this->output->set_header('Connection: close');
        
        $this->output->set_content_type("application/json");//application/x-www-form-urlencoded;charset=UTF-8");
        //readfile($path); // push it out
        
        $this->output->set_output(readfile($pth));
         * 
         */
	}
        
} 
?>