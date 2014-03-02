<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Errores
    {

    var $debugLevel=1; //a partir de que nivel de error se va a grabar en base
    
    var $id=0;
    /** nivel de error. Uso nivel 5 para muy critico my cero opara logs comunes que a veces se agraban y otras no segun si estoy e desarrollo o produccion */
    var $level=0;
    
    /** parte en el programa donde fue el error __CLASS__ y __FUNCTION__ son de ayuda*/
    var $seccion=0;
    
    /** si hay alguien loguado algo que lo identifique*/
    var $usuario="";
    
    /** descripcion de lo que paso */
    var $error = "";
    
    /** datos que se acumulan para grabar datos mas completos*/
    var $log = "";
    
    /**
     * Agregar un regisotro a la tabla errores
     * @param type $seccion
     * @param type $usuario
     * @param type $error
     * @param type $level
     * @return boolean
     * 
     * UN EJEMPLO
     * $this->errores->add(__CLASS__.".".__FUNCTION__,$this->session->userdata('user_id'),"Probando",1);
     */    
    function add($seccion="", $usuario="", $error="", $level=0)
        {
        if ($level < $this->debugLevel) return true;
        
        $this->CI =& get_instance();
        $this->CI->load->database();
        
        if ($seccion != "") $this->seccion = $seccion;
        if ($usuario != "") $this->usuario = $usuario;
        $this->level = $level;
        if ($error != "") $this->error = $error;
        
        $this->seccion = addslashes($this->seccion);
        $this->usuario = addslashes($this->usuario);
        
        if ($this->usuario == "") $this->usuario = $this->CI->session->userdata('user');
        
        $this->error .= "<br/>LOG:$this->log";
        
        $this->error = addslashes($this->error);
        
        $ahora = date("Y-m-d H:i:s");
        $q1 = "insert into errores (seccion,usuario,error,fecha,level) VALUES ";
        $q1 .= "('$this->seccion', '$this->usuario','$this->error','$ahora','$this->level')";
        
        $ret = $this->CI->db->query($q1);
        if (!$ret) 
            {
            //supongo que no existe todavia la tabla
            $r = $this->createErrorsTable();
            if ($r) //tratar de nuevo
                {
                $r = $this->add($seccion, $usuario, $error, $level);
                return $r;
                }
            else
                {return false;}
            }
        
        return $ret;
        }
        
     /**
      * ir agregando datos para al momento de grabar el error tener mas info
      * no en uso todavia
      */   
     function addlog($txt)
        {
        $now = new DateTime("NOW"); 
        $this->log .= "<br/>".$now->format("Y-m-d H:i:s").": $txt";
        }
        
        
    /**
     * Solo la primera ver que se ejecuta
     * @return boolean
     */    
    private function createErrorsTable()
        {
        $q = "DROP TABLE IF EXISTS errores;
            CREATE TABLE IF NOT EXISTS `errores` (
              id int(11) NOT NULL AUTO_INCREMENT,
              seccion varchar(80) DEFAULT NULL,
              usuario varchar(80) DEFAULT NULL,
              error text,
              fecha datetime DEFAULT NULL,
              level int(11) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
                
        $this->CI =& get_instance();
        $this->CI->load->database();        
        $ret = $this->CI->db->query($q);
        
        return $ret;
                
        }
        
    }
