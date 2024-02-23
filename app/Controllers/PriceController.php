<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PriceModel;
use App\Models\CategoryModel;
use CodeIgniter\Database\BaseBuilder;
 
class PriceController extends ResourceController
{
    use ResponseTrait;
    protected $validation;


    public function __construct()
    {
        $this->validation =  \Config\Services::validation();
    
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('mtprice');
        $builder->select('mtprice.idprice,DATE_FORMAT(mtprice.begdate, "%d/%m/%Y") as begdate,mtprice.idcategory, mtcategory.namecategory, 
                        mtprice.price,mtprice.status, 
                        mtuom.iduom, mtuom.uomname');
        $builder->join('mtcategory', 'mtcategory.idcategory = mtprice.idcategory');
        $builder->join('mtuom', 'mtuom.iduom = mtcategory.iduom');
        $result = $builder->get(); 

        if ($result->getResult()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data Price berhasil diambil',
                'data'    => $result->getResult()
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada data Price ditemukan'
            ]);
        }
    }


    // create
    public function create()
    {
        
        $idcategory  = $this->request->getVar('idcategory');
        
        ////cari iduom terkait $idcategory
        $modelSat = new CategoryModel();
        $iduom_arr = $modelSat->where('idcategory', $idcategory)
                ->findColumn('iduom');
        $iduom = $iduom_arr[0];


        ////cari pricelist tanggal yang sama
        $model = new PriceModel();
        $price_arr = $model->where('idcategory', $idcategory)
                    ->where('begdate', date("Y-m-d"))
                    ->where('iduom', $iduom)
                    //->countAll()
                    ->findColumn('idprice') ;
        
        if (!empty($price_arr)) {
            $idprice = $price_arr[0];
        
            $data = [
                'price'       => $this->request->getVar('price'),
                'chuserid'    => $this->request->getVar('inuserid'),
                'chdate'      => date("Y-m-d h:i:sa")
            ];
            
            $model->update($idprice, $data);

            $newPriceData = $model->find($idprice);

            return $this->response->setJSON(['success' => true, 'message' => 'Data pricelist berhasil diupdate', 
                            'data' => $newPriceData,
                            ]);
        }
        else{
            $data =array(
                'idcategory' => $idcategory,
                'idprod'  => null,
                'price' => $this->request->getVar('price'),
                'iduom'  => $iduom,
                'begdate' => date("Y-m-d"),
                'enddate'  => null,
                'status'  => null,
                'inuserid'  => $this->request->getVar('inuserid'),
                'chuserid'  => null,
                'indate'  => date("Y-m-d h:i:sa"),
                'chdate'  => null,
    
            );
            //var_dump($data);
    
    
            $insertedId = $model->insert($data);
    
            if ($insertedId)
            {
                $newPriceData = $model->find($insertedId);
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON(['success' => true, 'message' => 'Data pricelist berhasil disimpan', 
                            'data' => $newPriceData,
                            ]);
         
            }
            else
            {
                    return  json_encode($model->validation->getErrors());
            }
        }
        
        
    }


    
    // single user
    public function show($id=null)
    {
        
    }
    
    //single category
    public function getcategory()
    {
        $idcategory = trim($this->request->getVar('idcategory'));
        //echo $iduom;
        $model = new PriceModel();
        $data = $model->where('idcategory', $idcategory)->first();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Data Satuan berhasil diambil', 
                'data' => $data]);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }


    public function categorychange(){
        $idcategory = $this->request->getVar('idcategory');
        $model = new PriceModel();
        $data = [
            'namecategory'  =>  $this->request->getVar('namecategory'),
            'iduom'         =>  $this->request->getVar('iduom'),
            'chuserid'      =>  $this->request->getVar('chuserid'),
            'chdate'        =>  date("Y-m-d h:i:sa"),
        ];
        $model->update($idcategory, $data);

        $data = $model->where('idcategory', $idcategory)->first();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Data Satuan berhasil diambil', 
                'data' => $data]);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }


    }

    // update
    public function update($userid = null)
    {
        
    }
    // delete
    public function delete($userid = null)
    {
       
    }

}