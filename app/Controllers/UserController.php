<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use CodeIgniter\Database\BaseBuilder;
use App\Models\MemberModel;
 
class UserController extends ResourceController
{
    use ResponseTrait;
    protected $validation;
    // all users

    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
    }
    public function index()//http://localhost:8080/user/index
    {
        $model = new UserModel();
        $data['users'] = $model->orderBy('id', 'DESC')->findAll();
        //echo json_encode($data);
        return $this->respond($data);
    }
    // create
    public function create()//http://localhost:8080/user/create
    {
        $model = new UserModel();
        
        $userid=trim($this->request->getVar('userid'));
        $pass=trim($this->request->getVar('password'));
        $membercode=$this->request->getVar('membercode');
        $hash_pwd = md5("#".$userid.$pass."#");

        $data =array(
            'userid'     => $userid,//$this->request->getVar('userid'),
            'name'       => $this->request->getVar('name'),
            'phone'      => $this->request->getVar('phone'),
            'email'      => $this->request->getVar('email'),
            'password'   => $hash_pwd,
            'role'       => $this->request->getVar('role'),
            'status'     => "Y",//$this->request->getVar('status'),
            'created_at' => date("Y-m-d h:i:sa"),//$this->request->getVar('create_at'),
            'updated_at' => null,

        );
        //var_dump($data);


        $insertedId = $model->insert($data);

        if ($insertedId)
        {
            $newUserData = $model->find($insertedId);
            if  ($this->request->getVar('role')==2)
            {
                //echo "member";
                //insert mtmember
                $model_member = new MemberModel();
                $data_member =array(
                    'userid'     => $userid,//$this->request->getVar('userid'),
                    'membercode' => $membercode,
                    'name'       => $this->request->getVar('name'),
                    'address'    => null,// $this->request->getVar('address'),
                    'notelp'     => $this->request->getVar('phone'),
                    'mail'       => $this->request->getVar('email'),
                    'totalamt'   => 0,
                    'aktif'      => "Y",
                    'inuserid'   => "Register",//$this->request->getVar('status'),
                    'chuserid'   => null,
                    'indate'     => date("Y-m-d h:i:sa"),//$this->request->getVar('create_at'),
                    'chdate'     => null,
                    );
                
                    $insertedId_member = $model_member->insert($data_member);
                    
                    $newUserData_member = $model_member->find($insertedId_member);
                
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON(['success' => true, 'message' => 'Data user berhasil disimpan', 
                            'data' => $newUserData,'membercode' => $membercode,
                            /*'data member'=>newUserData_member */]);
     
            }
            else
            {
               //echo "masuk";  
               return $this->response->setJSON(['success' => true, 'message' => 'Data user berhasil disimpan', 'data' => $newUserData]);
            }   
        }
        else
        {
                return  json_encode($model->validation->getErrors());
        }
    }



    
    // single user
    public function show($userid = null)
    {
        $model = new UserModel();
        $data = $model->where('userid', $userid)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
    // update
    public function update($userid = null)
    {
        $model = new UserModel();
        $pass=trim($this->request->getVar('password'));
        $userid = trim($this->request->getVar('userid'));
        $hash_pwd = md5("#".$userid.$pass."#");

        $data = [
            'name'  => $this->request->getVar('name'),
            'phone' => $this->request->getVar('phone'),
            'email'  => $this->request->getVar('email'),
            'password' => $hash_pwd,
            'update_at' => $this->request->getVar('update_at'),
        ];
        $model->update($userid, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data user berhasil diubah.'
            ]
        ];
        return $this->respond($response);
    }
    // delete
    public function delete($userid = null)
    {
        $model = new UserModel();
        $userid = $this->request->getVar('userid');
        $data = [
            'status' => $this->request->getVar('status'),
            'update_at' => $this->request->getVar('update_at'),
        ];

        $model->update($userid, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data user berhasil diubah.'
            ]
        ];
        return $this->respond($response);
    }

    public function login()
    {
        $userid = trim($this->request->getVar('userid'));
        $pass=trim($this->request->getVar('password'));
        
        $hash_pwd = md5("#".$userid.$pass."#");

        $data = array(
			'userid'		=> $userid,
			'password'	    => $hash_pwd,
            'status'	    => "Y"
		);

        $model = new UserModel();
        $countuser = $model->where('userid',$data['userid'])
        ->where('password',$data['password'])
        ->where('status',"Y")
        ->countAllResults();

        //echo $countuser;
        //var_dump($data);

        if ($countuser>0)
        {
            $data = $model->where('userid',$data['userid'])
                        ->where('password',$data['password'])
                        ->where('status',"Y")
                        ->first();

            if ($data) {
                //return $this->respond($data);
                return $this->response->setJSON(['success' => true, 'message' => 'Berhasil Login!', 
                'data' => $data]);
            
            }
        }
        else {
            //return $this->failNotFound('Data tidak ditemukan.');
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan!']);
        }
    }
}