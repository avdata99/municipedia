<?php

class User_mdl extends CI_Model
    {
    var $lastError="";
    
    function load($id_str)
        {
        $q = "select at.* from autor_twitter at where at.twitter_id='$id_str'";
        
        $query = $this->db->query($q);
        
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
            
        return $query->row();    
        }
    
    function login($content)
        {
        /*$content->id_str $content->screen_name $content->name $content->profile_image_url_https addslashes($content->description addslashes($content->location */ 
        if (isset($content->error) && $content->error != "")
            {
            $this->lastError = "Error2 validando usuario ".$content->error;
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);
            return false;
            }
        
        return $this->upTwtUser($content);
        }
       
    /**
     * Agregar o actualziar los datos de un usuario
     * @param type $data
     */    
    function upTwtUser($data)
        {
        $q = "Insert into autor_twitter (twitter_id, twitter_user, twitter_name, last_access,token
            , token_secret, followers,following) VALUES ('$data->id_str','$data->screen_name','$data->name',NOW()
            ,'$data->token','$data->token_secret','$data->followers_count','$data->friends_count')
            ON DUPLICATE KEY update 
                twitter_user='$data->screen_name', twitter_name='$data->name', last_access=NOW(), token='$data->token'
            , token_secret='$data->token_secret', followers='$data->followers_count',following='$data->friends_count'";
        
        $query = $this->db->query($q);
        
        if (!$query) 
            {
            $this->lastError = "Error sql ($q)";
            $this->errores->add(__CLASS__.".".__FUNCTION__,"",$this->lastError,5);return false;}
        
        return $data;
        
        
        }
    }


?>
