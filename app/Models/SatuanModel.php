<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class SatuanModel extends Model
{
    protected $table = 'mtuom';
    protected $primaryKey = 'iduom';
    protected $allowedFields = ['uomname'];



}