<?php

class Data_mdl extends CI_Model
    {
    var $lastError = "";
    
    function addDataSet($data)
        {
        $data["resultado"] = 0;//FAlla x defecto
        //$data["urldrive"] = "https://docs.google.com/spreadsheet/pub?key=0AqoXO8bgQMjwdE9aVjU0cHNDTzd0U1R1aHVwV3VwUEE&output=csv";
        $json = $this->csvToJson($data["urldrive"], "array");
        $data["json"] = $json;
        if (!$data["json"])
            {
            $data["error"] = "No pudimos leer el archivo CSV";
            return $data;
            }
            
        $newTable = $this->getDataSetNameFree();
        
        //agregar la referencia al set de datos
        $this->load->model("user_mdl");
        $user = $this->user_mdl->load($this->session->userdata("loginiduser"));
        $r = $this->addReferencia($newTable, $data["titulo"], $data["descripcion"], $data["urlref"], $user->id, 1);
        if (!$r)
            {
            $data["error"] = "No pudimos agregar la referencia a $newTable ($this->lastError)";
            return $data;
            }
            
        // agregar los datos    
        
        $fields = array();
        $reg = $json[0];//tomar uno cualquiera para leer sus campos
        $nameFiledIds = "link_0"; // aqui se pueden definir y ya funcionan tablas accesorias con otros IDs que permite traer muchos set que esten basados en otros IDs, aqui no lo aplico todavia
        $campos_str = $nameFiledIds; //para usar en los inserts
        foreach (array_keys($reg) as $fld) 
            {
            //if (strtolower($fld) == "id") $fld = $nameFiledIds;//a futuro permitir link_X con mas IDs posibles de otras sets
            if (strtolower($fld) == "id") continue;
            $este = array("nombre"=>$fld, "tipo"=>"VARCHAR", "size"=>90);
            $fields[] = (object)$este;
            $campos_str .= ",`$fld`";
            }
            
        $r = $this->createTableDataSet($newTable, $fields);
        if (!$r)
            {
            $data["error"] = "No pudimos crear la tabla $newTable (<pre>".print_r($fields, true)."</pre>)";
            return $data;
            }
            
        //cargar los datos a la tabla
        $ins = 0;
        foreach ($json as $fila) 
            {
            $ins++;
            //limpiar los datos
            foreach ($fila as $key => $value) {$fila[$key] = addslashes($value);}
                
            $q = "Insert into $newTable ($campos_str) VALUES ";
            $q .= "('" . implode("','", $fila) . "')";
            
            $query = $this->db->query($q);
        
            if (!$query) 
                {
                $this->lastError = "Error insertando registro ($ins/".count($json).") ($q)";
                $data["error"] = $this->lastError;
                $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);
                return $data;}
            }
            
        $data["error"] = "";
        $data["resultado"] = 1;
        return $data;
        
        }
    
    function getDataSetNameFree()
        {
        $c = 0;
        while ($c < 100)
            {
            $r = "set_" . date("YmdH") . rand(1000, 9999);
            if (!$this->db->table_exists($r))
                {return $r;}
            $c++;    
            }
        }
        
    function createTableDataSet($tabla, $fields, $nameFiledIds = "link_0")
        {
        $q = "CREATE TABLE `$tabla` (`$nameFiledIds` int(11) NOT NULL";
        
        foreach ($fields as $fld) // ,`casas añatuyas` int(11) NOT NULL, `pomelos ninjas` varchar(90) NOT NULL";
            {
            $q .= ", `$fld->nombre` $fld->tipo($fld->size) NULL";
            }
            
        $q .= ",UNIQUE KEY `$nameFiledIds` (`$nameFiledIds`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8";
        
        $query = $this->db->query($q);
        
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
            
        return true;    
        
        }
    
    function csvToJson($csv, $return="array", $ignoreFields = array("provincia", "municipio", "id_process_unique"))
        {
        // Arrays we'll use later
        $keys = array();
        $newArray = array();
        $dataTypes=array();
        
        $delimiter = ",";
        $data = array();
        
        if (($handle = fopen($csv, 'r')) !== FALSE) 
            { 
            $i = 0; 
            while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) 
                { 
                for ($j = 0; $j < count($lineArray); $j++) 
                    {$data[$i][$j] = $lineArray[$j];} 
                $i++; 
                }
            fclose($handle); 
            }
        else return false;
            
            
        // Set number of elements (minus 1 because we shift off the first row)
        $count = count($data) - 1;

        //Use first row for names  
        $labels = array_shift($data);  

        foreach ($labels as $label) 
            {$keys[] = $label;}

        // Add Ids, just in case we want them later
        $keys[] = 'id_process_unique';
        for ($i = 0; $i < $count; $i++) {$data[$i][] = $i;}

        // Bring it all together
        for ($j = 0; $j < $count; $j++) 
            {
            $d = array_combine($keys, $data[$j]);
            
            //sacar los campos que no van
            foreach (array_keys($d) as $dat) {if (in_array($dat, $ignoreFields)) unset($d[$dat]);}
            
            $newArray[$j] = $d;
            /* TODO detectar los tipos de datos de cada campos
            foreach (array_keys($d) as $dat)
                {
                if (!is_numeric($d[$dat])) $dataTypes[$dat]["type"] = "VARCHAR";
                
                }
             * 
             */
            }
            
        
            
        if ($return == "array") return $newArray;
        if ($return == "json") return json_encode($newArray);
        if ($return == "string") return "<pre>".print_r($newArray, true)."</pre>";
        }
        
    function addReferencia($tabla, $titulo, $descripcion, $url="", $autor_id=3, $referente_id=1)
        {
        $tabla = addslashes($tabla);
        $titulo = addslashes(str_replace(array("-","'",'"',"/",",",";","?","&","!"), " ", $titulo));//TODO aqui una linda funcion de limpieza de strings
        if ($this->referenciaTituloExist($titulo)) 
            {
            $this->lastError = "Ya existe el titulo ($titulo)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;
            }
        $descripcion = addslashes($descripcion);
        $url = addslashes($url);
        $q = "INSERT INTO  link_refs (tabla ,autor_id ,referente_id ,titulo ,descripcion ,url, fecha_carga)
                VALUES ('$tabla',  '$autor_id',  '$referente_id',  '$titulo',  '$descripcion',  '$url', '".date("Y-m-d")."');";
        
        $query = $this->db->query($q);
        
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
            
        return true;
        }
        
    //como quiero urls amigables quiero que el titulo sea unico y limpio    
    function referenciaTituloExist($titulo)
        {
        $q = "select * from link_refs where titulo='$titulo'";
        
        $query = $this->db->query($q);
        
        return ($query->num_rows() > 0);
        }    
        
    function getListaSets()
        {
        $q ="SELECT lr.titulo, lr.fecha_carga fecha FROM  link_refs lr ORDER BY fecha_carga DESC ";
        $query = $this->db->query($q);
        return $query->result();
        }
        
    }
?>
