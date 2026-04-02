
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Auth_model');
    }

    public function login(){

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Auth_model->login($username,$password);

        if(!$user){
            echo json_encode([
                "status"=>false,
                "message"=>"Invalid Login"
            ]);
            return;
        }

        $token = bin2hex(random_bytes(32));

        $this->Auth_model->saveToken($user->id,$token);

        echo json_encode([
            "status"=>true,
            "token"=>$token
        ]);
    }

}