<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twtredir extends CI_Controller 
    {
        
    public function index()
        {
        $this->load->library('twitteroauth');
        
        //saber de donde viene para volver
        $ref = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : "/";
        $this->session->set_userdata("redirect", $ref );
        
        /* Build TwitterOAuth object with client credentials. */
        $this->twitteroauth->inits(CONSUMER_KEY, CONSUMER_SECRET);
        $connection = $this->twitteroauth;
        
        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

        /* Save temporary credentials to session. */
        $token = $request_token['oauth_token'];
        $this->session->set_userdata("oauth_token", $token);
        $this->session->set_userdata("oauth_token_secret", $request_token['oauth_token_secret']);
        
        /* If last connection failed don't display authorization link. */
        switch ($connection->http_code) 
            {
            case 200:
                /* Build authorize URL and redirect user to Twitter. */
                $url = $connection->getAuthorizeURL($token);
                redirect($url);
                break;
            default:
                /* Show notification if something went wrong. */
                echo 'Fallo la conexión con Twitter ' . $connection->http_code;
            }
        }
        
    function logout()
        {
        $ref = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : "/";
        $this->session->sess_destroy();
        redirect($ref);
        }
    
    }

?>
