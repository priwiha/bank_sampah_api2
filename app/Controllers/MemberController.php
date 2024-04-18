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
            return $this->response->setJSON(['success' => true, 'message' => 'Data tidak ditemukan', 
                'data' => $data]);
        }
    }

    public function updatemember()
    {
        //update member
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

        $modeluser = new UserModel();
        //get id user
        $result = $modeluser->select('id')
        ->where('userid', $userid)
        ->get()
        ->getRow();

        $iduser="";
        if ($result) {
            $iduser = $result->id;
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'id Member tidak ditemukan',]);
    
        }

        //update user
        $datauser = [
            'name'  => $this->request->getVar('name'),
            'phone' => $this->request->getVar('notelp'),
            'email'  => $this->request->getVar('mail'),
            'update_at' => $this->request->getVar('update_at'),
        ];
        $modeluser->update($iduser, $datauser);

        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Data member berhasil diubah', 
                'data' => $data]);
        } else {
            return $this->response->setJSON(['success' => true, 'message' => 'Data member gagal diubah', 
                'data' => $data]);
        }
    }

    public function chstatus_member()
    {
        
        $membercode = $this->request->getVar('membercode');
        $model = new MemberModel();

        //cek member by code
        $data_m = $model->where('membercode', $membercode)->first();
        $userid="";
        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Member tidak ditemukan', $membercode]);
        } else 
        {
            //get status member
            $result = $model->select('aktif,userid')
                ->where('membercode', $membercode)
                ->get()
                ->getRow();

            if ($result) {
                $status = $result->aktif;
                $userid = $result->userid;
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Status Member tidak ditemukan', $membercode]);
        
            }
            
            
            if ($status=='Y'){
                $status_new='T';
            }
            else{
                $status_new='Y';
            }

            
    

            $data = [
                'aktif'         =>  $status_new,
                'chuserid'      =>  $this->request->getVar('chuserid'),
                'chdate'        =>  date("Y-m-d h:i:sa"),
            ];
            $model->update($userid, $data);
    
            $data = $model->where('userid', $userid)->first();

            

            $modeluser = new UserModel();
            //get id user
            $result = $modeluser->select('id')
            ->where('userid', $userid)
            ->get()
            ->getRow();

            $iduser="";
            if ($result) {
                $iduser = $result->id;
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'id Member tidak ditemukan',]);
        
            }
    
            //update user
            $datauser = [
                'status'  => $status_new,
                'update_at' => date("Y-m-d h:i:sa"),
            ];
            $modeluser->update($iduser, $datauser);
    
            if ($data) {
                //return $this->respond($data);
                return $this->response->setJSON(['success' => true, 'message' => 'Status member berhasil diubah', 
                    'data' => $data]);
            } else {
                return $this->response->setJSON(['success' => true, 'message' => 'Status member gagal diubah', 
                    'data' => $data]);
            }

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

    public function reject_member()
    {
        
       
    }

}