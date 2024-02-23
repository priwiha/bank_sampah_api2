<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class CategoryModel extends Model
{
    protected $table = 'mtcategory';
    protected $primaryKey = 'idcategory';
    protected $allowedFields = ['namecategory','iduom','inuserid','chuserid','indate','chdate'];

}