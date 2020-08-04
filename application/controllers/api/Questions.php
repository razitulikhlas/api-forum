<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
date_default_timezone_set("Asia/Jakarta");

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Questions extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Questions_model','question');
        $this->__resTraitConstruct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    // Get Pertanyaan
    public function index_get(){
        $id_category = $this->get('id_category');
        if($id_category === null ){
            $ask = $this->question->get();
        }else{
            $ask = $this->question->get($id_category);
        }
        

        if($ask){
            $this->response([
                'status' => true,
                'data' => $ask
            ], 200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'kd not found'
            ], 404);
        }
    }

    // post pertanyaan
    public function index_post(){
        $id_user 	 = $this->post('id_user');
		$id_category = $this->post('id_category');	
		$questions	 = $this->post('questions');
        
        $data = [
            'id_user'		=> $id_user,
			'id_category'	=> $id_category,
            'pertanyaan'	=> $questions,
            'like' => 0,
            'comment' => 0,
			'is_delete'	=> "0"
        ];

        if($this->question->insert($data) > 0){
            $this->response([
                'status' => true,
                'message' => 'postingan success'
            ], 201);
        }else{
            $this->response([
                'status' => false,
                'message' => 'postingan failled'
            ], 400);
        }        
    }

    // update pertanyaan
    public function index_put(){
        $id_ask = $this->put('id_questions');
        $id_category = $this->put('id_category');
        $ask = $this->put('ask');
        $update_by = $this->put('update_by');

        $data = [
            'id_category' => $id_category,
            'pertanyaan' => $ask,
            'created_by_updated_at' => date("Y-m-d H:i:s",time()),
            'updated_by' => $update_by,
        ];

        $update = $this->question->update($data,$id_ask);

        if($update > 0){
            $this->response([
                'status' => true,
                'message' => 'success'
            ],201);
        }else{
            $this->response([
                'status' => false,
                'message'=> 'updated posting failed'
            ],400);

        }


    }

      // delete questions
      public function del_put(){
        $id_questions = $this->put('id_quetions');
 

        $data = [
            'is_delete' => 1,
            'created_by_updated_at' => date("Y-m-d H:i:s",time())
        ];


        $update = $this->question->update($data,$id_questions);

        if($update > 0){
            $this->response([
                'status' => true,
                'message' => 'delete success'
            ],201);
        }else{
            $this->response([
                'status' => false,
                'message'=> 'delete posting failed'
            ],400);

        }


    }

}