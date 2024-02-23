<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class PriceModel extends Model
{
    protected $table = 'mtprice';
    protected $primaryKey = 'idprice';
    protected $allowedFields = ['idcategory','idprod','price','iduom',
                                'begdate','enddate','status','inuserid','chuserid','indate','chdate'];

}