<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
	{
        
        $data = array();
        $data["descripcion"] = "Encicplopedia colaborativa sobre municipios de Argentina";
        $data["extra_body"] = "";
        $data["title"] = "Municipedia";
        
        $data["user"] = null;
        $data["userurl"] = "<a href='/twtcback/accesstwitter'>LOGIN / REGISTRARSE</a>";
        if ($this->session->userdata("loginuser") != "")
            {
            $this->load->model("user_mdl");
            $user = $this->user_mdl->load($this->session->userdata("loginiduser"));
            $data["user"] = $user;
            $data["userurl"] = "<a href='/home/user'>@$user->twitter_user</a>";
            }
            
        $this->load->view('home_head', $data);
        $this->load->view('home_menutop', $data);
        $this->load->view('home_body', $data);
        $this->load->view('home_footer', $data);
	}
        
    public function user()
	{
        
        $data = array();
        
        $data["user"] = null;
        $data["userurl"] = "<a href='/twtcback/accesstwitter'>LOGIN / REGISTRARSE</a>";
        if ($this->session->userdata("loginuser") != "")
            {
            $this->load->model("user_mdl");
            $data["user"] = $this->user_mdl->load($this->session->userdata("loginiduser"));
            $data["userurl"] = "<a href='/home/user'>@" . $data["user"]->twitter_user."</a>";
            }
        
        $data["descripcion"] = "Encicplopedia colaborativa sobre municipios de Argentina. Usuario @".$data["user"]->screen_name;
        $data["extra_body"] = "";
        $data["title"] = "Municipedia @".$data["user"]->screen_name;
            
        $this->load->view('home_head', $data);
        $this->load->view('home_menutop', $data);
        $this->load->view('home_user', $data);
        $this->load->view('adsense', $data);
        $this->load->view('home_footer', $data);
	}    
        
    public function muni($prov, $muni)
        {
        
        $prov = urldecode(str_replace("-", " ", $prov));
        $muni = urldecode(str_replace("-", " ", $muni));
        
        $data = array();
        $data["extra_body"] = 'onload="initialize()"';
        
        $data["user"] = null;
        $data["userurl"] = "<a href='/twtcback/accesstwitter'>LOGIN / REGISTRARSE</a>";
        if ($this->session->userdata("loginuser") != "")
            {
            $this->load->model("user_mdl");
            $data["user"] = $this->user_mdl->load($this->session->userdata("loginiduser"));
            $data["userurl"] = "<a href='/home/user'>@" . $data["user"]->twitter_user."</a>";
            }
        
        $this->load->model("muni_mdl");
        $res = $this->muni_mdl->getByName($prov, $muni);
        
        // if (count($res) == 1) {
            $muni = $res[0];
            $data["descripcion"] = $muni->categoria . " de " . $muni->municipio;
            $data["title"] = "$muni->categoria de $muni->municipio en la provincia de $muni->provincia";
            
            
            $data["municipio"] = $muni->categoria . " de " . $muni->municipio;
            $data["otros"] = "En la provincia de $muni->provincia";
            $data["muni"] = $muni;
            $tels = $this->muni_mdl->getTelefonos($muni->id);
            $data["telefonos"] = $tels;
            $mails = $this->muni_mdl->getEmails($muni->id);
            $data["mails"] = $mails;
            
            $this->load->view('home_head', $data);
            $this->load->view('home_menutop', $data);
            $this->load->view('home_muni', $data);
            $this->load->view('adsense', $data);
            $this->load->view('home_footer', $data);
            // }
        }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */