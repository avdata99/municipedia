<?php

class Otros_mdl extends CI_Model
    {
    var $lastError="";
    
    function getFundacion($limit=30)
        {
        $q = "select id, municipio, fecha_fundacion from municipios order by municipio limit $limit";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        $res = $query->result();    
        $ff_final = array();
        foreach ($res as $muni) 
            {
            $ffu = $muni->fecha_fundacion;
            $fs = explode(" ", $ffu);
            
            $fecha = trim($fs[0]);
            if ($fecha == "S/D") $fecha = "0/0/0";
            $descr = trim(substr($ffu, strlen($fecha)));
            
            $error = "";
            $anio = 0;
            $mes = 0;
            $dia = 0;
            if (strlen($fecha) == 4) 
                {$anio = $fecha; }
            else
                {
                $s1 = explode("/", $fecha);
                if (count($s1) <=1) $s1 = explode("-", $fecha);
                if (count($s1) <=1) $error = "****ERROR**$muni->id***$muni->municipio*";
                else
                    {
                    $dia = $s1[0];
                    $mes = (isset($s1[1])) ? $s1[1] : 0;
                    $anio = (isset($s1[2])) ? $s1[2] : 0;
                    }
                }
            
            $otro = array("original"=>$ffu, "fecha"=>$fecha,"descr"=>$descr, "muni_id"=>$muni->id, "muni"=>$muni->municipio
                    ,"q2" => "$error $ffu, $fecha, $anio, $mes, $dia, $descr"
                    ,"q" => "update municipios set fundacion_anio=$anio, fundacion_mes=$mes, fundacion_dia=$dia, fundacion_descripcion='$descr' where id=$muni->id;");
            $ff_final[] = $otro;
            
            }
         
            /*
             update municipios set emails = replace(emails, ".net .ar", ".net.ar")
             */
        return $ff_final;
        }
    
    function getPhones($limit=30)
        {
        
        $q = "select id, municipio, telefonos from municipios order by municipio limit $limit";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        $res = $query->result();    
        $tels_final = array();
        foreach ($res as $muni) 
            {
            $tel = $muni->telefonos;
            $tels = explode(")", $tel);
            foreach ($tels as $t) 
                {
                $ts = explode("(", $t);
                $nro = trim($ts[0]);
                $descr = (isset($ts[1]))? trim($ts[1]) : "";
                $descr = str_replace("'", "", $descr);
                
                if ($nro != "")
                    {
                    $otro = array("nro"=>$nro, "descr"=>$descr, "muni_id"=>$muni->id, "muni"=>$muni->municipio
                            ,"q" => "INSERT INTO telefonos (muni_id, telefono, descripcion) VALUES ($muni->id, '$nro', '$descr');");
                    $tels_final[] = $otro;
                    }
                }
            } 
            
        return $tels_final;    
        }
        
    /**
     * Obytener solo UN municipio segun provincia y ciudad
     * @param type $prov
     * @param type $muni
     * @return boolean
     */    
    function getMails($limit=30)
        {
        $q = "select id, municipio, emails from municipios order by municipio limit $limit";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        $res = $query->result();    
        $mails_final = array();
        foreach ($res as $muni) 
            {
            $mailes = $muni->emails;
            $mails = explode(" ", $mailes);
            foreach ($mails as $m) 
                {
                $test = explode("@", $m);
                if (count($test) > 2 || ($m != "" && $m != ".ar" && count($test) < 2))
                    {
                    $mails_final = array(array(
                        "ERROR"=>"Error en $muni->municipio ($muni->id)",
                        "q"=> "Error en $muni->municipio ($muni->id) ($m)"));
                    return $mails_final;
                    }
                    
                if ($m != "" && $m != ".ar")
                    {
                    $otro = array("mail"=>$m, "muni_id"=>$muni->id, "muni"=>$muni->municipio
                                ,"q" => "INSERT INTO emails (muni_id, email) VALUES ($muni->id, '$m');");
                    $mails_final[] = $otro;
                    }
                }
            }
         
            /*
             update municipios set emails = replace(emails, ".net .ar", ".net.ar")
             */
        return $mails_final;
        }
    }


?>
