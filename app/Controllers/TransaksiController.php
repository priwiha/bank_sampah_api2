<?php
 
namespace App\Controllers;
 
use App\Models\TransaksiTimbangModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SatuanModel;
use App\Models\CategoryModel;
use App\Models\PriceModelModel;
use App\Models\MemberModel;
use CodeIgniter\Database\BaseBuilder;
 
class TransaksiController extends ResourceController
{
    use ResponseTrait;
    protected $validation;
    // all users

    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
    }
    public function index()
    {
        $model = new SatuanModel();
        $data = $model->orderBy('iduom', 'DESC')->findAll();
        //echo json_encode($data);
        //return $this->respond($data);
        return $this->response->setJSON(['success' => true, 'message' => 'Data Satuan berhasil diambil', 
                'data' => $data]);
    }

    public function getcategoryprice()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('mtprice');
        $builder->select('mtprice.price,mtcategory.idcategory,mtcategory.namecategory,mtuom.iduom,mtuom.uomname');
        $builder->join('mtcategory', 'mtcategory.idcategory = mtprice.idcategory');
        $builder->join('mtuom', 'mtuom.iduom = mtcategory.iduom');
        $builder->where('mtprice.status', 'Y');
        $builder->where('DATE_FORMAT(mtprice.begdate, "%d/%m/%Y")', date("d/m/Y"));
        $query= $builder->get(); 
        return $this->response->setJSON(['success' => true, 'message' => 'Data Category berhasil diambil', 
                'data' => $query->getResult()]);
               


    }

    // createtimbang
    public function create_timbang()
    {
        //create timbang
        $idcategory = trim($this->request->getVar('idcategory'));
        $iduom      = trim($this->request->getVar('iduom'));
        $qty        = trim($this->request->getVar('qty'));
        $price      = trim($this->request->getVar('price'));
        $userid     = trim($this->request->getVar('userid'));
        $membercode = trim($this->request->getVar('membercode'));
        $pricetot   = $qty*$price;


        //cek member by code
        $model_m = new MemberModel();
        $data_m = $model_m->where('membercode', $membercode)->first();
        
        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Member tidak ditemukan',$membercode]);
        }
        else{
            
            //get saldo akhir member
            $totalamt_arr = $model_m->where('membercode', $membercode)
                            ->findColumn('totalamt');

            
            $totalamt = 0;
            //jika ada update totalamt_arr
            if (!empty($totalamt_arr)){
                $totalamt = $totalamt_arr[0];
            }

            $totalamt_akhir = $pricetot+$totalamt;   

            ////update saldo member
            $data_update = [
                'totalamt'      =>  $totalamt_akhir,
                'chuserid'      =>  $userid,
                'chdate'        =>  date("Y-m-d h:i:sa"),

            ];

            $model_m->update($membercode, $data_update);

            /* try {
                $model_m->update($membercode, $data_update);
            } catch (\Exception $e) {
                die($e->getMessage());
            } */

            $memberUpdated = $model_m->where('membercode', $membercode)->first();
            echo  $totalamt_akhir;
            var_dump($data_update,$memberUpdated);
        }

        //insert timbang
        /* $model = new TransaksiTimbangModel();
        $data =array(
            'membercode' => $membercode,
            'idcategory' => $idcategory,
            'idprod'     => null,
            'qty'        => $qty,
            'iduom'      => $iduom,
            'price'      => $price,
            'pricetot'   => $pricetot,
            'inuserid'   => $userid,
            'chuserid'   => null,
            'indate'     => date("Y-m-d h:i:sa"),
            'chdate'     => null,

        );

        $insertedId = $model->insert($data);

        if ($insertedId)
        {
        
            $newTimbangData = $model->find($insertedId);
            // Berikan respons JSON sukses dengan data yang baru diinsert
            return $this->response->setJSON(['success' => true, 'message' => 'Data user berhasil disimpan', 
                        'data' => $newTimbangData,]);
        
        }
        else
        {
                return  json_encode($model->validation->getErrors());
        } */
    }


    public function getuom()
    {
        $iduom = trim($this->request->getVar('iduom'));
        //echo $iduom;
        $model = new SatuanModel();
        $data = $model->where('iduom', $iduom)->first();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Data Satuan berhasil diambil', 
                'data' => $data]);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }


}