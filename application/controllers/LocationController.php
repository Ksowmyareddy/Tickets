<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Search_model');
    }

    public function index(){
        $this->load->view('search_view');
    }

    public function get_products(){

        $keyword = $this->input->post('keyword');
        $limit   = $this->input->post('limit');
        $offset  = $this->input->post('offset');

        if(empty($limit))  $limit  = 10;
        if(empty($offset)) $offset = 0;

        if(empty($keyword)){
            echo json_encode([]);
            return;
        }

        $data = $this->Search_model->search_products($keyword,$limit,$offset);

        echo json_encode($data);
    }

    public function get_fitment(){

        $product_id = $this->input->post('product_id');

        if(empty($product_id)){
            echo json_encode([]);
            return;
        }

        $data = []; // TEMPORARY SAFE

        echo json_encode($data);
    }
}