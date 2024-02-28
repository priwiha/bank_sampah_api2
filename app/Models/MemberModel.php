<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class MemberModel extends Model
{
    protected $table = 'mtmember';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['userid','membercode', 'name','address','notelp','mail','totalamt',
                                'aktif','inuserid','chuserid','indate','chdate'];


    protected $validationRules = [
        'userid' => ['label' => 'Userid', 'rules' => 'required|min_length[0]|max_length[150]|is_unique[mtmember.userid]'],

    ];

    protected $validationMessages = [
        'userid' => [
            'is_unique' => 'Sorry. That username has already been taken. Please choose another.',
        ],
    ];


}