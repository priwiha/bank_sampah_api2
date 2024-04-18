<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class TransaksiRedeemModel extends Model
{
    protected $table = 'trredeem';
    protected $primaryKey = 'idredeem';
    protected $allowedFields = ['membercode','userid','redeemamt','redeemdate','approved','approveddate','userapproved','inuserid',
                                'chuserid','indate','chdate'];
	
}