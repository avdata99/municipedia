<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abra extends CI_Controller 
    {
    public function test($r)
        {
        $data["rr"] = $r;
        $this->load->view('home_menutop', $data);
        }
        
    public function redir()
        {
        exit("sdfnsdf");
        echo "<br/>0";
        $this->load->add_package_path(APPPATH.'third_party/twt/');
        $this->load->library('twitteroauth');
        //saber de donde viene para volver
        $this->session->set_userdata("redirect", $_SERVER['HTTP_REFERER'] );
        echo "<br/>1";
        /* Build TwitterOAuth object with client credentials. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
        echo "<br/>2";
        /* Get temporary credentials. */
        $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

        /* Save temporary credentials to session. */
        $token = $request_token['oauth_token'];
        $this->session->set_userdata("oauth_token", $token);
        $this->session->set_userdata("oauth_token_secret", $request_token['oauth_token_secret']);
        
        /* If last connection failed don't display authorization link. */
        switch ($connection->http_code) {
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
        
    function callback()
        {
        $this->load->add_package_path(APPPATH.'third_party/twt/');
        $this->load->library('twitteroauth');
        /* If the oauth_token is old redirect to the connect page. */
        if ($this->session->userdata('oauth_token') && $this->session->userdata('oauth_token') !== $_REQUEST['oauth_token']) 
            {
            $this->session->sess_destroy();
            $error = "Token viejo o configuracion de OAUTH invalida";
            }

        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET
                , $this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

        /* Remove no longer needed request tokens */
        $this->session->unset_userdata('oauth_token');
        $this->session->unset_userdata('oauth_token_secret');

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code) 
            {
          /* The user has been verified and the access tokens can be saved for future use */
          $this->session->set_userdata("status", 'verified');
          $redirTo = (!isset($this->session->userdata("redirect")) || $this->session->userdata("redirect") == "") ? "/" : $this->session->userdata("redirect");

          $this->session->unset_userdata('redirect');

        //ver si alguien se acaba de loguear
        if ($access_token)
            {

            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

            /* If method is set change API call made. Test is called by default. */
            $content = $connection->get('account/verify_credentials');
            $this->load->model("user_mdl");
            $content->token = $access_token['oauth_token'];
            $content->token_secret = $access_token['oauth_token_secret'];
            $r = $this->user_mdl->login($content);

            $this->session->set_userdata("loginuser", $r);
            }

        redirect($redirTo);
            
            } 
        else 
            {
            $this->session->sess_destroy();
            $error = "No hay Access Token";
            }
        }
    
    }

?>
