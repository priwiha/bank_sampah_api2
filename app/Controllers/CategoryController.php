<?php
 
namespace App\Controllers;
 
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CategoryModel;
use CodeIgniter\Database\BaseBuilder;
 
class CategoryController extends ResourceController
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
        $builder = $db->table('mtcategory');
        $builder->select('mtcategory.idcategory,mtcategory.namecategory,mtuom.iduom,mtuom.uomname');
        $builder->join('mtuom', 'mtuom.iduom = mtcategory.iduom');
        $builder->orderBy('idcategory', 'DESC');
        $query= $builder->get(); 
        return $this->response->setJSON(['success' => true, 'message' => 'Data Category berhasil diambil', 
                'data' => $query->getResult()]);
               

        /* $model = new CategoryModel();
        $data['data'] = $model->orderBy('idcategory', 'DESC')->findAll();
        return $this->response->setJSON(['success' => true, 'message' => 'Data Category berhasil diambil', 
                'data' => $data]); */


    }
    // create
    public function create()
    {
        $model = new CategoryModel();

        $data =array(
            'namecategory' => $this->request->getVar('namecategory'),
            'iduom'  => $this->request->getVar('iduom'),
            'inuserid' => $this->request->getVar('inuserid'),
            'chuserid'  => null,
            'indate' => date("Y-m-d h:i:sa"),
            'chdate'  => null,

        );
        //var_dump($data);


        $insertedId = $model->insert($data);

        if ($insertedId)
        {
            $newCategoryData = $model->find($insertedId);
            // Berikan respons JSON sukses dengan data yang baru diinsert
            return $this->response->setJSON(['success' => true, 'message' => 'Data user berhasil disimpan', 
                        'data' => $newCategoryData,
                        /*'data member'=>newUserData_member */]);
     
        }
        else
        {
                 return $this->response->setJSON(['success' => true, 'message' => $model->validation->getErrors()]);
                //return  json_encode($model->validation->getErrors());
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
        $model = new CategoryModel();
        $data = $model->where('idcategory', $idcategory)->first();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON(['success' => true, 'message' => 'Data Satuan berhasil diambil', 
                'data' => $data]);
        } else {
            //return $this->failNotFound('Data tidak ditemukan.');
            return $this->response->setJSON(['success' => true, 'message' => 'Data tidak ditemukan.']);
                
        }
    }


    public function categorychange(){
        $idcategory = $this->request->getVar('idcategory');
        $model = new CategoryModel();
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
            return $this->response->setJSON(['success' => true, 'message' => 'Data tidak ditemukan.']);
            //return $this->failNotFound('Data tidak ditemukan.');
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