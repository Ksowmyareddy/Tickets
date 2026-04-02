

<?php
class User_model extends CI_Model {

    public function insertUser($data){
        return $this->db->insert('users',$data);
    }

    public function checkUsername($username){
        return $this->db->where('username',$username)
                        ->get('users')->row();
    }

    public function login($username){
        return $this->db->where('username',$username)
                        ->get('users')->row();
    }

    public function getUser($username){

        $this->db->select('users.*, 
            c.country,
            s.state,
            ci.city');

        $this->db->from('users');

        $this->db->join(
            'cscart_country_descriptions c',
            'c.country_id = users.country_id',
            'left'
        );

        $this->db->join(
            'cscart_az_states s',
            's.state_id = users.state_id',
            'left'
        );

        $this->db->join(
            'cscart_az_cities ci',
            'ci.city_id = users.city_id',
            'left'
        );

        $this->db->where('users.username',$username);

        return $this->db->get()->row();
    }

    public function updateUser($id,$data){
        return $this->db->where('id',$id)
                        ->update('users',$data);
    }
}