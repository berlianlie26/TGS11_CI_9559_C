<?php
use Restserver \Libraries\REST_Controller ;
Class branches extends REST_Controller{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->model('branchesModel');
        $this->load->library('form_validation');
    }
    public function index_get(){
        return $this->returnData($this->db->get('branches')->result(), false);
    }
    public function index_post($id = null){
        $validation = $this->form_validation;
        $rule = $this->branchesModel->rules();
        if($id == null){
            array_push($rule,[
                    'field' => 'name',
                    'label' => 'name',
                    'rules' => ''
                ],
                [
                    'field' => 'address',
                    'label' => 'address',
                    'rules' => ''
                ],
                [
                    'field' => 'phoneNumber',
                    'label' => 'phoneNumber',
                    'rules' => ''
                ],
                [
                    'field' => 'phoneNumber',
                    'label' => 'created_at',
                    'rules' => ''
                ]
            );
        }
        else{
            // array_push($rule,
            //     [
            //         'field' => 'name',
            //         'label' => 'name',
            //         'rules' => 'required'
            //     ]
            // );
        }
        $validation->set_rules($rule);
		if (!$validation->run()) {
			return $this->returnData($this->form_validation->error_array(), true);
        }
        $branch = new branchesData();
        $branch->name = $this->post('name');
        $branch->address = $this->post('address');
        $branch->phoneNumber = $this->post('phoneNumber');
        $branch->created_at = $this->post('created_at');
        if($id == null){
            $response = $this->branchesModel->store($branch);
        }else{
            $response = $this->branchesModel->update($branches,$id);
        }
        return $this->returnData($response['msg'], $response['error']);
    }
    public function index_delete($id = null){
        if($id == null){
			return $this->returnData('Parameter Id Tidak Ditemukan', true);
        }
        $response = $this->branchesModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }
    public function returnData($msg,$error){
        $response['error']=$error;
        $response['message']=$msg;
        return $this->response($response);
    }
}
Class branchesData{
    public $name;
    public $address;
    public $phoneNumber;
    public $created_at;
}