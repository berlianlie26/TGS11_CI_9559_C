<?php

use Restserver \Libraries\REST_Controller;

Class branches extends REST_Controller {
    public function __construct() { 
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Methods:GET,OPTIONS,POST,DELETE");
        header("Access-Control-Allow-Headers:Content-Type,Content-Length,Accept-Encoding");
        
        parent::__construct();
        $this->load->model('branchesModel');
        $this->load->library('form_validation');
    }
    public function index_get() {
        return$this->returnData($this->db->get('branches')->result(),false);
    }
    public function index_post($id=null) {
        $validation=$this->form_validation;
        $rule=$this->branchesModel->rules();
        if($id==null) {
                
            array_push($rule,
            [
                
            ],
            [
                
            ]
        );
    }
        else {
            array_push($rule,
            [
                
            ]
        );
    }
    $validation->set_rules($rule);
    if(!$validation->run()) {
        return$this->returnData($this->form_validation->error_array(),true);
    }
    $branches=new branchesData();
    
    $branches->name=$this->post('name');
    $branches->address=$this->post('address');
    $branches->phoneNumber=$this->post('phoneNumber');
    $branches->created_at=$this->post('created_at');
    if($id==null) {
        $response=$this->branchesModel->store($branches);
    }else{
        $response=$this->branchesModel->update($branches,$id);
    }
    return$this->returnData($response['msg'],$response['error']);
}
    public function index_delete($id=null) {
        if($id==null){ 
            return$this->returnData('Parameter Id Tidak Ditemukan',true);
        }
        $response=$this->branchesModel->destroy($id);
        return$this->returnData($response['msg'],$response['error']);
    }
    public function returnData($msg,$error) {
        $response['error']=$error;
        $response['message']=$msg;
        return$this->response($response);
    }
}
Class branchesData {
    public $id;
    public $name;
    public $address;
    public $phoneNumber;
    public $created_at;
}