
<?php
class Location_model extends CI_Model {

    public function getCountries() {
        return $this->db->select('country_id, country')
                        ->group_by('country_id')
                        ->order_by('country', 'ASC')
                        ->get('cscart_country_descriptions')
                        ->result();
    }

    public function getStates($country_id) {
        return $this->db->where('country_id', $country_id)
                        ->get('cscart_az_states')
                        ->result();
    }

    public function getCities($state_id) {
        return $this->db->where('state_id', $state_id)
                        ->get('cscart_az_cities')
                        ->result();
    }

    public function stateExists($state, $country_id) {
        return $this->db->where('state', $state)
                        ->where('country_id', $country_id)
                        ->get('cscart_az_states')
                        ->row();
    }

    public function cityExists($city, $state_id) {
        return $this->db->where('city', $city)
                        ->where('state_id', $state_id)
                        ->get('cscart_az_cities')
                        ->row();
    }

    public function insertState($data) {
        return $this->db->insert('cscart_az_states', $data);
    }

    public function insertCity($data) {
        return $this->db->insert('cscart_az_cities', $data);
    }
}