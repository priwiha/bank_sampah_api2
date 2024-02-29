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
            
            $totalamt = 0;
            //get saldo akhir member
            $result = $model_m->select('totalamt, userid')
                   ->where('membercode', $membercode)
                   ->get()
                   ->getRow();

            if ($result) {
                $totalamt = $result->totalamt;
                $userid_m = $result->userid;

                // Gunakan nilai $value1 dan $value2 sesuai kebutuhan Anda
            } else {
                // Tidak ada hasil yang ditemukan
            }

            //echo "cek ".$totalamt."-".$userid;

            $totalamt_akhir = $pricetot+$totalamt;   

            ////update saldo member
            $data_update = [
                'totalamt'      =>  $totalamt_akhir,
                'chuserid'      =>  $userid,
                'chdate'        =>  date("Y-m-d h:i:sa"),

            ];

            $model_m->update($userid_m, $data_update);


            $memberUpdated = $model_m->where('membercode', $userid_m)->first();
            
        }

        //insert timbang
        $model = new TransaksiTimbangModel();
        $data =array(
            'membercode' => $membercode,
            'userid'     => $userid_m,
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
        }
    }

    public function delete_timbang(){
        $idgrb = trim($this->request->getVar('idgrb'));
        $userid = trim($this->request->getVar('userid'));

        

        $model = new TransaksiTimbangModel();

        $data_m = $model->where('idgrb', $idgrb)->first();
        
        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan',$idgrb]);
        }
        {
            $results = $model->select('pricetot, userid')
                            ->where('idgrb', $idgrb)
                            ->get()
                            ->getResult();
            
            $pricetot = 0;
            $userid_m = "-";
            
            if (!empty($results)) {
                //echo "ada";
                // Pilih hasil pertama (baris pertama)
                $result = $results[0];
            
                $pricetot = $result->pricetot;
                $userid_m = $result->userid;
            
                // Gunakan nilai $pricetot dan $userid_m sesuai kebutuhan Anda
            } else {
                //echo "kosong";
                // Tidak ada hasil yang ditemukan
            }

            //ambil saldo member
            $model_m = new MemberModel();
            $totalamt = 0;
            //get saldo akhir member
            $result = $model_m->select('totalamt, userid')
                   ->where('userid', $userid_m)
                   ->get()
                   ->getRow();

            if ($result) {
                $totalamt = $result->totalamt;
                // Gunakan nilai $value1 dan $value2 sesuai kebutuhan Anda
            } else {
                // Tidak ada hasil yang ditemukan
            }

            //echo $totalamt." ".$pricetot." ".$userid_m;

            //kurangi saldo
            $data_update = [
                'totalamt'      =>  $totalamt-$pricetot,
                'chuserid'      =>  $userid,
                'chdate'        =>  date("Y-m-d h:i:sa"),

            ];

            $model_m->update($userid_m, $data_update);

            // Contoh penghapusan data berdasarkan kondisi
            $model->where('idgrb', $idgrb)
            ->delete();

            $memberUpdated = $model_m->where('userid', $userid_m)->first();
                        
            if ($memberUpdated)
            {
            
                //$newTimbangData = $model->find($insertedId);
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON(['success' => true, 'message' => 'Data member berhasil diupdate', 
                            'data' => $memberUpdated,]);
            
            }
            else
            {
                    return  json_encode($model->validation->getErrors());
            }
        }

        
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