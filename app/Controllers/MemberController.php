<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\MemberModel;
use App\Models\UserModel;
use CodeIgniter\Database\BaseBuilder;
 
class MemberController extends ResourceController
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
        $model = new MemberModel();
        $data = $model->orderBy('idmember', 'DESC')->findAll();
        //echo json_encode($data);
        //return $this->respond($data);
        return $this->response->setJSON(['success' => true, 'message' => 'Data Member berhasil diambil', 
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
    
    public function getbycode()
    {
        $membercode = trim($this->request->getVar('membercode'));
        //echo $iduom;
        $model = new MemberModel();
        $data = $model->where('membercode', $membercode)->first();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Data Member berhasil diambil', 
                'data' => $data]);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    public function updatemember()
    {
        //updarte member
        $userid = $this->request->getVar('userid');
        $model = new MemberModel();
        $data = [
            'name'          =>  $this->request->getVar('name'),
            'aktif'         =>  $this->request->getVar('aktif'),
            'notelp'        =>  $this->request->getVar('notelp'),
            'mail'          =>  $this->request->getVar('mail'),
            'chuserid'      =>  $this->request->getVar('chuserid'),
            'chdate'        =>  date("Y-m-d h:i:sa"),

        ];
        $model->update($userid, $data);

        $data = $model->where('userid', $userid)->first();

        //update user
        $modeluser = new UserModel();
        $datauser = [
            'name'  => $this->request->getVar('name'),
            'phone' => $this->request->getVar('notelp'),
            'email'  => $this->request->getVar('mail'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        $model->update($userid, $data);

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