<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class TransaksiTimbangModel extends Model
{
    protected $table = 'trgrbres';
    protected $primaryKey = 'idgrb';
    protected $allowedFields = ['membercode','userid','idcategory','idprod',
                                'qty','iduom','price','pricetot','inuserid','chuserid','indate','chdate'];


}