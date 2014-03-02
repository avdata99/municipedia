<?php

class Muni_mdl extends CI_Model
    {
    var $lastError="";
    var $lastQuery = "";
    
    function searchMuni($txt, $limit=16)
        {
        if (strlen($txt) < 3) return array(); // array vacio
        
        $q = "select m.id, m.municipio, p.provincia
                from municipios m 
                join provincias p on m.provincia_id = p.id
                where m.municipio like '%$txt%' 
                order by m.municipio limit $limit";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->result();
        }
        
    /**
     * Obytener solo UN municipio segun provincia y ciudad
     * @param type $prov
     * @param type $muni
     * @return boolean
     */    
    function getByName($prov, $muni)
        {
        $q = "select m.*, p.provincia
                from municipios m 
                join provincias p on m.provincia_id = p.id
                where p.provincia = '$prov' and m.municipio='$muni' 
                order by m.municipio";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->result();
        }
        
    function getTelefonos($muni_id)
        {
        $q = "select * from telefonos where muni_id='$muni_id'";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->result();
        }    
        
    /**
     * Obtener los datos de una referencia o set de datos subida
     * @param type $ref
     * @return boolean
     */    
    function getRefByTitle($ref)
        {
        $q = "select lr.*, at.twitter_user, at.twitter_name
                from link_refs lr 
                join autor_twitter at ON lr.autor_id=at.id
                where lr.titulo='$ref'";
        
        $this->lastQuery = $q;
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->row();
        } 
        
    /**
     * obtener en un formato descargable un set de datos
     * @param type $ref
     * @return boolean
     */    
    function getDataSet($tabla_set, $muni_id=0)
        {
        //en el dataset vamos a poner el nombre de la ciudad y de la provincia
        $fs = $this->db->list_fields($tabla_set);
        $link = $fs[0];
        //si es link_0 se usaron nuestros mismo IDs
        if (strtolower($link) == "link_0")
            {
            $q = "Select p.provincia, m.municipio, t.link_0 id, t.*
                    from $tabla_set t
                    join municipios m ON t.link_0 = m.id
                    join provincias p ON m.provincia_id=p.id ";
            }
        else
            {
            $q = "Select p.provincia, m.municipio, li.id, t.*
                    from $tabla_set t
                    join $link li ON t.$link = li.$link 
                    join municipios m ON li.id = m.id
                    join provincias p ON m.provincia_id=p.id ";
            }
        
        if ($muni_id > 0) $q .= " where m.id=$muni_id ";    
            
        $this->lastQuery = $q;    
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->result();
        }     
        
    function getAllRefs()
        {
        $q = "select * from link_refs order by titulo";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->result();
        }     
        
    function getEmails($muni_id)
        {
        $q = "select * from emails where muni_id='$muni_id'";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->result();
        }      
        
    /**
     * Para el sitemap
     * @return boolean
     */    
    function getAll()
        {
        $q = "select m.*, p.*, m.id muni_id, p.id prov_id from municipios m join provincias p on m.provincia_id = p.id";
        
        $query = $this->db->query($q);
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $query->result();
        }
        
        
    function updateAllResumes()
        {
        $all = $this->getAll();
        foreach ($all as $m) 
            {
            $r = $this->writeResume($m->muni_id);
            if (!$r) {return false;}
            }
        return true;    
        }
        
    /**
     * Escribir a disco un resumen de los datos de un municipio revisando todos los sets activos
     * 
     */    
    function writeResume($muni_id)
        {
        $ret = "Listando tablas";
        $data=array();
        $tablas = $this->db->list_tables();
        foreach ($tablas as $tabla) 
            {
            $ret .= "<br/>TABLA:$tabla";
            if (substr($tabla, 0,4) == "set_") 
                {
                $ret .= " --> OK";
                $f = $tablas = $this->db->list_fields($tabla);
                $link = $f[0];
                $ret .= "<br/> -----> Tabla: $link";
                
                //si es link_0 se usaron nuestros mismo IDs
                if (strtolower($link) == "link_0")
                    {
                    $q = "Select t.*, t.link_0 id, lr.* 
                            from $tabla t
                            join link_refs lr ON lr.tabla='$tabla'
                            where t.link_0=$muni_id ";
                    }
                else
                    {
                    $q = "Select t.*, li.id, lr.* 
                            from $tabla t
                            join $link li ON t.$link = li.$link 
                            join link_refs lr ON lr.tabla='$tabla'
                            where li.id=$muni_id ";
                    }
                $query = $this->db->query($q);
                if (!$query) 
                    {
                    $this->lastError = "Error sql ($q)";
                    $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
                    
                $ress = $query->result();
                //sacar campos que no se publicaran
                unset($ress->autor_id);
                unset($ress->reference_id);
                
                $data["final"][] = $ress;
                $data[$tabla."_Q"] = $q;
                
                }
            }
            
        $f = fopen("/home/municipa/public_html/assets/datas/$muni_id.json", "w");
        $data[$tabla."_F0"] = $f;
        $data[$tabla."_F1"] = fwrite($f, json_encode($data["final"]));
        $data[$tabla."_F2"] = fclose($f);

            
        $data["log"] = $ret;    
        return $data;
        }
    }


?>
