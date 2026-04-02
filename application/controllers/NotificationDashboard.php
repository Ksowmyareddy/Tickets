<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** @property CI_Input $input
 *  @property CI_Session $session
 *  @property CI_Notification_model $Notification_model
 */


class NotificationDashboard extends CI_Controller {

public function __construct()
{
parent::__construct();

$this->load->model('Notification_model');
$this->load->helper('url');
$this->load->library('session');

}


public function index()
{

$data['notifications'] = [];

$data['from'] = "";
$data['to']   = "";


// ---------- search ----------

if($this->input->post())
{

$from = $this->input->post('from_date');
$to   = $this->input->post('to_date');

$this->session->set_userdata('from_date',$from);
$this->session->set_userdata('to_date',$to);

redirect("dashboard");

}


// ---------- get session ----------

$from = $this->session->userdata('from_date');
$to   = $this->session->userdata('to_date');

$data['from'] = $from;
$data['to']   = $to;


// ---------- get data ----------

if(!empty($from))
{

$data['notifications'] =
$this->Notification_model
->get_notifications($from,$to);

}


// ---------- clear after refresh ----------

if(!$this->input->post() && empty($_POST))
{

$this->session->unset_userdata('from_date');
$this->session->unset_userdata('to_date');

}


$this->load->view(
'notification_dashboard',
$data
);

}

}