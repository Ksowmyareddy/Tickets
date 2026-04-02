
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller
{

public function __construct()
{
parent::__construct();

$this->load->database();
$this->load->model('Api_model');
}


public function test()
{
echo "API OK";
}


/* search */

public function search()
{

$text = $this->input->post('search');

$offset = 0;

$data = $this->Api_model->search($text,$offset);

echo json_encode($data);

}


/* load more */

public function loadmore()
{

$text = $this->input->post('search');

$offset = $this->input->post('offset');

$data = $this->Api_model->search($text,$offset);

echo json_encode($data);

}

}