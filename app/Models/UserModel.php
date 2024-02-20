<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['userid', 'name','phone','email','password',
                                'role','status','created_at','updated_at'];
    /* protected $data_array = array("1","2");
    protected $user = $model->find('role',$data_array); */

    protected $validationRules = [
        'userid' => ['label' => 'Userid', 'rules' => 'required|min_length[0]|max_length[150]|is_unique[users.userid]'],
        'password' => ['label' => 'Password', 'rules' => 'required|min_length[0]'],
        //'confirm_password' => ['label' => 'Confirm Password', 'rules' => 'required|min_length[0]|matches[password]'],
        'email' => ['label' => 'Email', 'rules' => 'required|valid_email|min_length[0]|max_length[150]|is_unique[users.email]'],
        //'avatar' => ['label' => 'Avatar', 'rules' => 'permit_empty|min_length[0]'],
        'phone' => ['label' => 'No telp', 'rules' => 'required|min_length[0]|max_length[50]'],
        'role'     =>  ['label' => 'Role', 'rules' => 'required|in_list[1,2]'],


    ];
    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.',
        ],
        'userid' => [
            'is_unique' => 'Sorry. That username has already been taken. Please choose another.',
        ],
    ];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = md5($data['data']['password']);


        return $data;
    }
}
