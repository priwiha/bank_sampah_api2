<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SatuanModel;
use CodeIgniter\Database\BaseBuilder;
 
class UomController extends ResourceController
{
    use ResponseTrait;
    protected $validation;
    // all users

    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
    }
    public function index()
    {
        $model = new SatuanModel();
        $data = $model->orderBy('iduom', 'DESC')->findAll();
        //echo json_encode($data);
        //return $this->respond($data);
        return $this->response->setJSON(['success' => true, 'message' => 'Data Satuan berhasil diambil', 
                'data' => $data]);
    }
    // create
    public function create()
    {
        
    }


    
    // single user
    public function show($id=null)
    {
        
    }
    
    public function getuom()
    {
        $iduom = trim($this->request->getVar('iduom'));
        //echo $iduom;
        $model = new SatuanModel();
        $data = $model->where('iduom', $iduom)->first();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Data Satuan berhasil diambil', 
                'data' => $data]);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // update
    public function update($userid = null)
    {
        
    }
    // delete
    public function delete($userid = null)
    {
       
    }

}