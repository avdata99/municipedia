<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Twtcback extends CI_Controller 
    {
    
    public function accesstwitter()
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
        $this->session->sess_destroy();
        redirect("/");
        }
    
    /**
     * callback que llega desde twitter
     */
    public function index()
        {
        $gtq = $this->input->get();
        
        /* If the oauth_token is old redirect to the connect page. */
        if ($this->session->userdata('oauth_token') && $this->session->userdata('oauth_token') !== $gtq['oauth_token']) 
            {
            $this->session->sess_destroy();
            exit("Token viejo o configuracion de OAUTH invalida");
            }

        $this->load->library('twitteroauth');
        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
        $this->twitteroauth->inits(CONSUMER_KEY, CONSUMER_SECRET, $this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));
        $connection = $this->twitteroauth;

        /* Request access tokens from twitter */
        $access_token = $connection->getAccessToken($gtq['oauth_verifier']);

        /* Remove no longer needed request tokens */
        $this->session->unset_userdata('oauth_token');
        $this->session->unset_userdata('oauth_token_secret');

        /* If HTTP response is 200 continue otherwise send to connect page to retry */
        if (200 == $connection->http_code) 
            {
            /* The user has been verified and the access tokens can be saved for future use */
            $this->session->set_userdata("status", "verified");
            $redirTo = ($this->session->userdata("redirect")) ? $this->session->userdata("redirect") : "/" ;

            $this->session->unset_userdata('redirect');

          //ver si alguien se acaba de loguear
          if ($access_token)
                {
                //$this->twitteroauth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
                //$connection = $this->twitteroauth;

                /* If method is set change API call made. Test is called by default. */
                $content = $connection->get('account/verify_credentials');
                $this->load->model("user_mdl");
                $content->token = $access_token['oauth_token'];
                $content->token_secret = $access_token['oauth_token_secret'];
                $r = $this->user_mdl->login($content);

                if ($r) 
                    {$this->session->set_userdata("loginuser", $r->screen_name);
                    $this->session->set_userdata("loginiduser", $r->id_str);
                    }
                else 
                    {$this->session->set_userdata("loginuser", "");
                    $this->session->set_userdata("loginiduser", 0);
                    }
                }

            redirect($redirTo);
            
            } 
        else 
            {
            $this->session->sess_destroy();
            exit("No hay Access Token");
            }
        }
    
    }

?>
