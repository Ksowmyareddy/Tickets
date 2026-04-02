
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/** @property User_model $User_model
 * @property Location_model $Location_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Upload $upload
 */



class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Location_model');
        $this->load->library(['session','upload']);
        $this->load->helper(['url','form','dob']);
    }

    // ================= LOGIN PAGE =================
    public function index(){
        if($this->session->userdata('username')){
            redirect('auth/profile');
        }
        $this->load->view('login');
    }

    // ================= LOGIN PROCESS =================
    public function login(){

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->User_model->login($username);

        if($user && password_verify($password,$user->password)){
            $this->session->set_userdata('username',$username);
            redirect('auth/profile');
        }else{
            echo "<script>alert('Invalid Login');history.back();</script>";
        }
    }

    // ================= REGISTER PAGE =================
    public function register(){

        $data['countries'] = $this->Location_model->getCountries();
        $this->load->view('register',$data);
    }

    // ================= REGISTER PROCESS =================
    public function save(){

        $username = $this->input->post('username');

        if($this->User_model->checkUsername($username)){
            echo "<script>alert('Username Exists');history.back();</script>";
            return;
        }

        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $this->upload->initialize($config);

        $image="";
        if($this->upload->do_upload('image')){
            $image = $this->upload->data('file_name');
        }

        $data = [
            'fullname'=>$this->input->post('fullname'),
            'contact'=>$this->input->post('contact'),
            'dob'=>$this->input->post('dob'),
            'email'=>$this->input->post('email'),
            'address'=>$this->input->post('address'),
            'country_id'=>$this->input->post('country'),
            'state_id'=>$this->input->post('state'),
            'city_id'=>$this->input->post('city'),
            'username'=>$username,
            'password'=>password_hash($this->input->post('password'),PASSWORD_DEFAULT),
            'image'=>$image
        ];

        $this->User_model->insertUser($data);
        $this->session->set_userdata('username',$username);

        redirect('auth/profile');
    }

    // ================= PROFILE =================
    public function profile(){

        if(!$this->session->userdata('username')){
            redirect('auth');
        }

        $data['user']=$this->User_model->getUser(
            $this->session->userdata('username')
        );

        $this->load->view('profile',$data);
    }

    // ================= EDIT PAGE =================
    public function edit(){

        if(!$this->session->userdata('username')){
            redirect('auth');
        }

        $data['user']=$this->User_model->getUser(
            $this->session->userdata('username')
        );

        $data['countries']=$this->Location_model->getCountries();

        $this->load->view('update',$data);
    }

    // ================= UPDATE PROCESS =================
    public function update(){

        $id=$this->input->post('id');

        $data=[
            'fullname'=>$this->input->post('fullname'),
            'contact'=>$this->input->post('contact'),
            'dob'=>$this->input->post('dob'),
            'email'=>$this->input->post('email'),
            'address'=>$this->input->post('address'),
            'country_id'=>$this->input->post('country'),
            'state_id'=>$this->input->post('state'),
            'city_id'=>$this->input->post('city')
        ];

        $config['upload_path']='./uploads/';
        $config['allowed_types']='jpg|jpeg|png';
        $this->upload->initialize($config);

        if($this->upload->do_upload('image')){
            $data['image']=$this->upload->data('file_name');
        }

        $this->User_model->updateUser($id,$data);

        redirect('auth/profile');
    }

    // ================= LOGOUT =================
    public function logout(){
        $this->session->sess_destroy();
        redirect('auth');
    }
}