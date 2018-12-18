<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        $this->load->model("Employee_model","employee");
        
    }
  public function index(){
      header("Access-Control-Allow-Origin: *");
        $data = [
                "personalinfo"=>["name"=>"abhik","Age"=>37],
                "official"=>["add"=>'asasada']
                
            ];
        $this->template->set('title', 'Abhik Dashboard');
        $this->template->load('default_layout', 'contents', 'dashboard/dashboard', $data);
  }
}
