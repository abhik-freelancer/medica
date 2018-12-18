<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Logout extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }
    public function index(){
        $this->session->unset_userdata('user_data');
    }

    public function __destruct() {
        redirect('login');
    }
}
