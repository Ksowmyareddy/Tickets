<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SmartSearch extends CI_Controller {

    public function index()
    {
        $this->load->view('smart_search_view');
    }

}