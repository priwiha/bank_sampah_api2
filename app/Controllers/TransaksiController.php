<?php

namespace App\Controllers;

use App\Models\TransaksiTimbangModel;
use App\Models\TransaksiRedeemModel;
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
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $model = new TransaksiTimbangModel();
        $data = $model->orderBy('idgrb', 'DESC')->findAll();
        //echo json_encode($data);
        //return $this->respond($data);
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data timbang berhasil diambil',
            'data' => $data
        ]);
    }

    public function getuom()
    {
        $iduom = trim($this->request->getVar('iduom'));
        //echo $iduom;
        $model = new SatuanModel();
        $data = $model->where('iduom', $iduom)->first();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data Satuan berhasil diambil',
                'data' => $data
            ]);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    public function getcategoryprice()
    {

        $db = \Config\Database::connect();
        $builder = $db->table('mtprice');
        $builder->select('mtprice.price,mtcategory.idcategory,mtcategory.namecategory,mtuom.iduom,mtuom.uomname');
        $builder->join('mtcategory', 'mtcategory.idcategory = mtprice.idcategory');
        $builder->join('mtuom', 'mtuom.iduom = mtcategory.iduom');
        $builder->where('mtprice.status', 'Y');
        $builder->where('DATE_FORMAT(mtprice.begdate, "%Y-%m-%d") >=', date("Y-m-d"));//
        $query = $builder->get();
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data Category berhasil diambil',
            'data' => $query->getResult()
        ]);



    }

    // createtimbang
    public function create_timbang()
    {

        //create timbang
        $idcategory = trim($this->request->getVar('idcategory'));
        $iduom = trim($this->request->getVar('iduom'));
        $qty = trim($this->request->getVar('qty'));
        $price = trim($this->request->getVar('price'));
        $userid = trim($this->request->getVar('userid'));
        $membercode = trim($this->request->getVar('membercode'));
        $pricetot = $qty * $price;


        //cek member by code
        $model_m = new MemberModel();
        $data_m = $model_m->where('membercode', $membercode)->first();

        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Member tidak ditemukan', $membercode]);
        } else {

            //cek data timbang atas kategori & member di hari yang sama
            $model = new TransaksiTimbangModel();
            $data_cek = $model
                ->where('membercode', $membercode)
                ->where('date', date("Y-m-d"))
                ->where('idcategory', $idcategory)
                ->first();
            if ($data_cek) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Transaksi timbang sudah ada atas kategori ' . $idcategory .
                        ' & code member ' . $membercode
                ]);
            } else {

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

                $totalamt_akhir = $pricetot + $totalamt;

                ////update saldo member
                $data_update = [
                    'totalamt' => $totalamt_akhir,
                    'chuserid' => $userid,
                    'chdate' => date("Y-m-d h:i:sa"),

                ];

                $model_m->update($userid_m, $data_update);


                $memberUpdated = $model_m->where('membercode', $userid_m)->first();

                //insert timbang
                $model = new TransaksiTimbangModel();
                $data = array(
                    'membercode' => $membercode,
                    'date' => date("Y-m-d"),
                    'userid' => $userid_m,
                    'idcategory' => $idcategory,
                    'idprod' => null,
                    'qty' => $qty,
                    'iduom' => $iduom,
                    'price' => $price,
                    'pricetot' => $pricetot,
                    'inuserid' => $userid,
                    'chuserid' => null,
                    'indate' => date("Y-m-d h:i:sa"),
                    'chdate' => null,

                );

                $insertedId = $model->insert($data);

                if ($insertedId) {

                    $newTimbangData = $model->find($insertedId);
                    // Berikan respons JSON sukses dengan data yang baru diinsert
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Data timbang berhasil disimpan',
                        'data' => $newTimbangData,
                    ]);

                } else {
                    return json_encode($model->validation->getErrors());
                }
            }
        }

        
    }

    //delete timbang
    public function delete_timbang()
    {
        $idgrb = trim($this->request->getVar('idgrb'));
        $userid = trim($this->request->getVar('userid'));



        $model = new TransaksiTimbangModel();

        $data_m = $model->where('idgrb', $idgrb)->first();

        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan', $idgrb]);
        } {
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
                'totalamt' => $totalamt - $pricetot,
                'chuserid' => $userid,
                'chdate' => date("Y-m-d h:i:sa"),

            ];

            $model_m->update($userid_m, $data_update);

            // Contoh penghapusan data berdasarkan kondisi
            $model->where('idgrb', $idgrb)
                ->delete();

            $memberUpdated = $model_m->where('userid', $userid_m)->first();

            if ($memberUpdated) {

                //$newTimbangData = $model->find($insertedId);
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data data timbang berhasil dihapus',
                    'data' => $memberUpdated,
                ]);

            } else {
                return json_encode($model->validation->getErrors());
            }
        }


    }



    //create redeem
    public function create_redeem_adm(){
        $membercode     = trim($this->request->getVar('membercode'));
        //$userid         = trim($this->request->getVar('userid'));
        $redeemamt      = trim($this->request->getVar('redeemamt'));
        $redeemdate     = date('Y-m-d');
        $approveddate   = date("Y-m-d h:i:sa");
        $userapproved   = trim($this->request->getVar('inuserid'));
        $inuserid       = trim($this->request->getVar('inuserid'));
        $chuserid       = null;
        $indate         = date("Y-m-d h:i:sa");
        $chdate         = null;
        

        //cek member by code
        $model_m = new MemberModel();
        $data_m = $model_m->where('membercode', $membercode)->first();

        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Member tidak ditemukan', $membercode]);
        } else 
        {
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

            $totalamt_akhir =  $totalamt-$redeemamt;

            ////update saldo member
            $data_update = [
                'totalamt' => $totalamt_akhir,
                'chuserid' => $inuserid,
                'chdate'   => date("Y-m-d h:i:sa"),

            ];

            $model_m->update($userid_m, $data_update);
            $memberUpdated = $model_m->where('membercode', $userid_m)->first();


            //insert redeem
            $model = new TransaksiRedeemModel();
            $data = array(
                'membercode'   => $membercode,
                'userid'       => $userid_m,
                'redeemamt'    => $redeemamt,
                'redeemdate'   => $redeemdate,
                'approveddate' => $approveddate,
                'userapproved' => $userapproved,
                'inuserid'     => $inuserid,
                'chuserid'     => $chuserid,
                'indate'       => $indate,
                'chdate'       => $chdate,

            );

            $insertedId = $model->insert($data);

            if ($insertedId) {

                $newRedeemData = $model->find($insertedId);
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data redeem berhasil disimpan',
                    'data' => $newRedeemData,
                ]);

            } else {
                return json_encode($model->validation->getErrors());
            }
        }

    }


    //create redeem
    public function create_redeem_mem(){
        $membercode     = trim($this->request->getVar('membercode'));
        //$userid         = trim($this->request->getVar('userid'));
        $redeemamt      = trim($this->request->getVar('redeemamt'));
        $redeemdate     = date('Y-m-d');
        $approveddate   = null;
        $userapproved   = '-';
        $inuserid       = trim($this->request->getVar('inuserid'));
        $chuserid       = null;
        $indate         = date("Y-m-d h:i:sa");
        $chdate         = null;
        

        //cek member by code
        $model_m = new MemberModel();
        $data_m = $model_m->where('membercode', $membercode)->first();

        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Member tidak ditemukan', $membercode]);
        } else 
        {
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

            //$totalamt_akhir =  $totalamt-$redeemamt;

            ////update saldo member
            //$data_update = [
            //    'totalamt' => $totalamt_akhir,
            //    'chuserid' => $inuserid,
            //    'chdate'   => date("Y-m-d h:i:sa"),

            //];

            //$model_m->update($userid_m, $data_update);
            //$memberUpdated = $model_m->where('membercode', $userid_m)->first();


            //insert redeem
            $model = new TransaksiRedeemModel();
            $data = array(
                'membercode'   => $membercode,
                'userid'       => $userid_m,
                'redeemamt'    => $redeemamt,
                'redeemdate'   => $redeemdate,
                'approveddate' => $approveddate,
                'userapproved' => $userapproved,
                'inuserid'     => $inuserid,
                'chuserid'     => $chuserid,
                'indate'       => $indate,
                'chdate'       => $chdate,

            );

            $insertedId = $model->insert($data);

            if ($insertedId) {

                $newRedeemData = $model->find($insertedId);
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data redeem berhasil disimpan',
                    'data' => $newRedeemData,
                ]);

            } else {
                return json_encode($model->validation->getErrors());
            }
        }

    }



    public function delete_redeem(){
        $idredeem = trim($this->request->getVar('idredeem'));
        $userid = trim($this->request->getVar('userid'));

        $model = new TransaksiRedeemModel();

        $data_m = $model->where('idredeem', $idredeem)->first();

        if (!$data_m) {
            return $this->response->setJSON(['success' => false, 'message' => 'Transaksi tidak ditemukan', $idredeem]);
        } {
            $results = $model->select('redeemamt, userid')
                ->where('idredeem', $idredeem)
                ->get()
                ->getResult();

            $redeemamt = 0;
            $userid_m = "-";

            if (!empty($results)) {
                //echo "ada";
                // Pilih hasil pertama (baris pertama)
                $result = $results[0];

                $redeemamt = $result->redeemamt;
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
                'totalamt' => $totalamt + $redeemamt,
                'chuserid' => $userid,
                'chdate' => date("Y-m-d h:i:sa"),

            ];

            $model_m->update($userid_m, $data_update);

            // Contoh penghapusan data berdasarkan kondisi
            $model->where('idredeem', $idredeem)
                ->delete();

            $memberUpdated = $model_m->where('userid', $userid_m)->first();

            if ($memberUpdated) {

                //$newTimbangData = $model->find($insertedId);
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data redeem berhasil dihapus',
                    'data' => $memberUpdated,
                ]);

            } else {
                return json_encode($model->validation->getErrors());
            }
        }
    }

    

    public function get_timbang_bymcode()
    {   
        $membercode = trim($this->request->getVar('membercode'));
        
        $db = \Config\Database::connect();
        $builder = $db->table('trgrbres');
        $builder->select('trgrbres.idgrb,trgrbres.date ,trgrbres.membercode,trgrbres.userid,
                        trgrbres.idcategory,mtcategory.namecategory,
                        trgrbres.idprod,trgrbres.qty,trgrbres.iduom,mtuom.uomname,trgrbres.price,trgrbres.pricetot');
        $builder->join('mtcategory', 'mtcategory.idcategory = trgrbres.idcategory');
        $builder->join('mtuom', 'mtuom.iduom = trgrbres.iduom');
        $builder->where('trgrbres.membercode',$membercode);
        $builder->orderBy('trgrbres.idgrb', 'DESC');
        $data = $builder->get();

        //$membercode = trim($this->request->getVar('membercode'));
        //$model = new TransaksiTimbangModel();
        //$data = $model->where('membercode', $membercode)->orderBy('membercode', 'DESC')->findAll();
        
        //if ($data) {
        if ($data->getResult()) {
            //return $this->respond($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data Timbang berhasil diambil',
                'data' => $data->getResult(),
                'membercode' => $membercode
            ]);
        } else {
            //return $this->failNotFound('Data tidak ditemukan.');
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data tidak ditemukan.',
                'membercode' => $membercode
            ]);
        }
    }


    public function get_redeem_bymcode()
    {
        $membercode = trim($this->request->getVar('membercode'));
        $model = new TransaksiRedeemModel();
        $data = $model->where('membercode', $membercode)->orderBy('idredeem', 'DESC')->findAll();
        if ($data) {
            //return $this->respond($data);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data Redeem berhasil diambil',
                'data' => $data
            ]);
        } else {
            //return $this->failNotFound('Data tidak ditemukan.');
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function get_timbang_bymcode_filldate()
    {   
        $membercode = trim($this->request->getVar('membercode'));
        $date       = trim($this->request->getVar('date'));
        
        $db = \Config\Database::connect();

        $builder = $db->table('trgrbres');
        $builder->select('trgrbres.idgrb,trgrbres.date,trgrbres.membercode,trgrbres.userid,
                        trgrbres.idcategory,mtcategory.namecategory,
                        trgrbres.idprod,trgrbres.qty,trgrbres.iduom,mtuom.uomname,trgrbres.price,trgrbres.pricetot');
        $builder->join('mtcategory', 'mtcategory.idcategory = trgrbres.idcategory');
        $builder->join('mtuom', 'mtuom.iduom = trgrbres.iduom');
        $builder->where('trgrbres.membercode',$membercode);
        $builder->where("DATE_FORMAT(trgrbres.date, '%d/%m/%Y')", $date);
        $builder->orderBy('trgrbres.date', 'DESC');
        $data = $builder->get();

        if ($data->getResult()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data Timbang berhasil diambil',
                'data' => $data->getResult(),
                'fillter' => $membercode.'-'.$date
            ]);
        } else {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data tidak ditemukan.',
                'fillter' => $membercode.'-'.$date,
                'getdata' => '0'
            ]);
        }
    }

    public function get_redeem_bymcode_filldate()
    {
        $membercode = trim($this->request->getVar('membercode'));
        $date       = trim($this->request->getVar('date'));

        $db = \Config\Database::connect();

        $builder = $db->table('trredeem');
        $builder->select('trredeem.idredeem,trredeem.membercode,trredeem.userid,
                        trredeem.redeemamt,trredeem.redeemdate,trredeem.approveddate,
                        trredeem.userapproved,trredeem.inuserid,trredeem.chuserid,
                        trredeem.indate,trredeem.chdate');
        $builder->where('trredeem.membercode',$membercode);
        $builder->where("DATE_FORMAT(trredeem.redeemdate, '%d/%m/%Y')", $date);
        $builder->orderBy('trredeem.redeemdate', 'DESC');
        $data = $builder->get();

        if ($data->getResult()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data Redeem berhasil diambil',
                'data' => $data->getResult(),
                'fillter' => $membercode.'-'.$date
            ]);
        } else {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Data tidak ditemukan',
                'fillter' => $membercode.'-'.$date,
                'getdata' => '0'
            ]);
        }
    }
    


}