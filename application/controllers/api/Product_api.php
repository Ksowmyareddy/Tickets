
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_api extends CI_Controller {

    private $API_TOKEN = "AZ123TOKEN";

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Search_model');
    }

    private function checkAuth()
    {
        $headers = $this->input->request_headers();

        if(!isset($headers['Authorization']))
        {
            echo json_encode([]);
            exit;
        }

        $token = str_replace("Bearer ","",$headers['Authorization']);

        if($token != $this->API_TOKEN)
        {
            echo json_encode([]);
            exit;
        }
    }

    public function search_products()
    {
        $this->checkAuth();

        $keyword = $this->input->get('keyword');
        $limit   = $this->input->get('limit');
        $offset  = $this->input->get('offset');

        $data = $this->Search_model->search_products($keyword,$limit,$offset);

        if(!$data) $data = [];

        echo json_encode($data);
    }

    public function get_fitment()
    {
        $this->checkAuth();

        $product_id = $this->input->get('product_id');

        $data = $this->Search_model->get_fitment($product_id);

        if(!$data) $data = [];

        echo json_encode($data);
    }

}