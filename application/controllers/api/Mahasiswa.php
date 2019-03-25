<?php 

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends REST_Controller 
{

     function __construct()
     {
          parent::__construct();

          // Configure limits on our controller methods
          // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
          $this->methods['index_get']['limit'] = 500; // 500 requests per hour per user/key
          $this->methods['index_post']['limit'] = 100; // 100 requests per hour per user/key
          $this->methods['index_delete']['limit'] = 50; // 50 requests per hour per user/key
          $this->methods['index_put']['limit'] = 70; // 70 requests per hour per user/key

          $this->load->model('mahasiswa_model','ms');
     }

     public function index_get()
     {
          $id = $this->get('id');

          if( $id === null ) {

               $mahasiswa = $this->ms->fetch_mahasiswa();

          } else {

               $id = (int) $id;

               if( $id <= 0 ) {

                    $this->response([
                         'status' => false,
                         'message' => 'Invalid id'
                    ], REST_Controller::HTTP_BAD_REQUEST);

               } else {

                    $mahasiswa = $this->ms->fetch_mahasiswa($id);

               }

          }

         
          if( $mahasiswa ) {
               
               $this->response([
                    'status' => true,
                    'data' => $mahasiswa
               ], REST_Controller::HTTP_OK);

          } else {
               
               $this->response([
                    'status' => false,
                    'message' => 'No data'
               ], REST_Controller::HTTP_NOT_FOUND);

          }

     }

     public function index_delete()
     {

          $id = $this->delete('id');

          if( $id === null ) {

               $this->response([
                    'status' => false,
                    'message' => 'Provide an id'
               ], REST_Controller::HTTP_BAD_REQUEST);

          } else {

               $id = (int) $id;

               if( $id <= 0 ) {

                    $this->response([
                         'status' => false,
                         'message' => 'Invalid id'
                    ], REST_Controller::HTTP_BAD_REQUEST);

               } else {

                    if( $this->ms->delete_mahasiswa($id) > 0 ) {

                         $this->response([
                              'status' => true,
                              'message' => 'deleted',
                              'id' => $id
                         ], REST_Controller::HTTP_OK);

                    } else {

                         $this->response([
                              'status' => false,
                              'message' => 'Id not found'
                         ], REST_Controller::HTTP_BAD_REQUEST);

                    }

               }

          }

     }

     public function index_post()
     {

          $data = [
               'nrp' => $this->post('nrp'),
               'nama' => $this->post('nama'),
               'email' => $this->post('email'),
               'jurusan' => $this->post('jurusan')
          ];

          if( $this->ms->insert_mahasiswa($data) > 0 ) {

               $this->response([
                    'status' => true,
                    'message' => 'mahasiswa has been inserted'
               ], REST_Controller::HTTP_CREATED);

          } else {

               $this->response([
                    'status' => false,
                    'message' => 'Failed insert'
               ], REST_Controller::HTTP_BAD_REQUEST);

          }

     }

     public function index_put()
     {

          $id = $this->put('id');

          if($id === null ) {

               $this->response([
                    'status' => false,
                    'message' => 'Provide an id'
               ], REST_Controller::HTTP_BAD_REQUEST);

          } else {

               $id = (int)$id;

               if($id <= 0) {

                     $this->response([
                         'status' => false,
                         'message' => 'Invalid id'
                    ], REST_Controller::HTTP_BAD_REQUEST);

               } else {

                    $data = [
                         'nrp' => $this->put('nrp'),
                         'nama' => $this->put('nama'),
                         'email' => $this->put('email'),
                         'jurusan' => $this->put('jurusan')
                    ];

                    if($this->ms->update_mahasiswa($data, $id) > 0) {

                         $this->response([
                              'status' => true,
                              'message' => 'mahasiswa has been updated'
                         ], REST_Controller::HTTP_OK);
                    } else {

                         $this->response([
                              'status' => false,
                              'message' => 'Failed update'
                         ], REST_Controller::HTTP_BAD_REQUEST);

                    }

               }

          }

     }

}