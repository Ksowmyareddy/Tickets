
<?php
class Auth_model extends CI_Model {

    public function login($username,$password){

        $this->db->where('username',$username);
        $this->db->where('password',md5($password));

        return $this->db->get('api_users')->row();
    }

    public function saveToken($user_id,$token){

        $this->db->where('id',$user_id);

        $this->db->update('api_users',[
            'api_token'=>$token
        ]);
    }

    public function checkToken($token){

        $this->db->where('api_token',$token);

        return $this->db->get('api_users')->row();
    }

}