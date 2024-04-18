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
                    'aktif'      => "T",
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
            return $this->response->setJSON(['success' => true, 'message' => $model->validation->getErrors()]);
                
            //return  json_encode($model->validation->getErrors());
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

    public function chpass()
    {
        $model = new UserModel();
        $pass_old=trim($this->request->getVar('pass_old'));
        $pass_new=trim($this->request->getVar('pass_new'));
        $user = trim($this->request->getVar('userid'));
        
        $hash_pwd_old = md5("#".$user.$pass_old."#");
        $hash_pwd = md5("#".$user.$pass_new."#");

        //cek user pakai pass
        $data_cek = $model->where('userid', $user)->where('password', $hash_pwd_old)->first();

        if (!$data_cek) {
            return $this->response->setJSON(['success' => false, 'message' => 'Password lama tidak sesuai', 
            'cek_param' => $user.'- pass old:'.$pass_old.'- pass new:'.$pass_new]);
        } else 
        {
            $getuser = $model->select('id, userid')
                ->where('userid', $user)
                ->get()
                ->getRow();

            if ($getuser) {
                $id = $getuser->id;

                // Gunakan nilai $value1 dan $value2 sesuai kebutuhan Anda
            } else {
                // Tidak ada hasil yang ditemukan
            }


            $data = [
                //'name'  => $this->request->getVar('name'),
                //'phone' => $this->request->getVar('phone'),
                //'email'  => $this->request->getVar('email'),
                'password' => $hash_pwd,
                'update_at' => date("Y-m-d h:i:sa")
            ];
            $model->update($id, $data);
            //$model->where('userid', $user)->update($data);
            return $this->response->setJSON([
                'success' => true, 'message' => 'Data user berhasil diubah.'
            ]);
        
        }
    }

    // update
    public function update($userid = null)
    {
        $model = new UserModel();
        //$pass=trim($this->request->getVar('password'));
        $user = trim($this->request->getVar('userid'));
        //$hash_pwd = md5("#".$userid.$pass."#");

        $data = [
            'name'  => $this->request->getVar('name'),
            'phone' => $this->request->getVar('phone'),
            'email'  => $this->request->getVar('email'),
            //'password' => $hash_pwd,
            'update_at' => $this->request->getVar('update_at'),
        ];
        $model->update($user, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data user berhasil diubah.'
            ]
        ];
        return $this->respond($response);
    }

    // update
    public function reset_pass()
    {
        $model = new UserModel();
        $pass=trim($this->request->getVar('password'));
        $user = trim($this->request->getVar('userid'));
        $hash_pwd = md5("#".$user.$pass."#");


        $modeluser = new UserModel();
        //get id user
        $result = $modeluser->select('id')
        ->where('userid', $user)
        ->get()
        ->getRow();

        $iduser="";
        if ($result) {
            $iduser = $result->id;
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'id Member tidak ditemukan',]);
    
        }

        $data = [
            //'name'  => $this->request->getVar('name'),
            //'phone' => $this->request->getVar('phone'),
            //'email'  => $this->request->getVar('email'),
            'password' => $hash_pwd,
            'update_at' => $this->request->getVar('update_at'),
        ];

        $model->update($iduser, $data);
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

        //echo $countuser;
        //var_dump($data);

        if ($countuser>0)
        {
            $model_member = new MemberModel();
            $results = $model->select('role')
                ->where('userid', $userid)
                ->get()
                ->getResult();

            $role = null;

            if (!empty($results)) {
                $result = $results[0];

                $role = $result->role;

                if ($role=='2')
                {
                    $db = \Config\Database::connect();
                    $builder = $db->table('users');
                    $builder->select('users.id,users.userid,users.name,users.phone,
                                    users.email,users.email_verified_at,users.password,
                                    users.remember_token,users.role,users.status,mtmember.membercode');
                    $builder->join('mtmember', 'mtmember.userid = users.userid');
                    $builder->where('users.userid',$userid);
                    $result = $builder->get();
                    $data   = $result->getResult();
                }
                else{
                    $data = $model->where('userid',$data['userid'])
                    ->where('password',$data['password'])
                    ->where('status',"Y")
                    ->first();
                }
                if ($data) {
                    //return $this->respond($data);
                    return $this->response->setJSON(['success' => true, 'message' => 'Berhasil Login!', 
                    'data' => $data]);
                
                }
            } else {
            }


            /*$data = $model->where('userid',$data['userid'])
                        ->where('password',$data['password'])
                        ->where('status',"Y")
                        ->first(); */

            
        }
        else {
            //return $this->failNotFound('Data tidak ditemukan.');
            return $this->response->setJSON(['success' => false, 'message' => 'Data tidak ditemukan!']);
        }
    }
}