<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
 
class UserController extends ResourceController
{
    use ResponseTrait;
    // all users
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }
    // create
    public function create()
    {
        $model = new UserModel();
        $data = [
            'userid' => $this->request->getVar('userid'),
            'name'  => $this->request->getVar('name'),
            'phone' => $this->request->getVar('phone'),
            'email'  => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
            'role'  => $this->request->getVar('role'),
            'status' => $this->request->getVar('status'),
            'create_at'  => $this->request->getVar('create_at'),

        ];
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data user berhasil ditambahkan.'
            ]
        ];
        return $this->respondCreated($response);
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
        $userid = $this->request->getVar('userid');
        $data = [
            'name'  => $this->request->getVar('name'),
            'phone' => $this->request->getVar('phone'),
            'email'  => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
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
}