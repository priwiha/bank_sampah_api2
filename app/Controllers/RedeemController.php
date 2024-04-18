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

class RedeemController extends ResourceController
{
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


    public function get_wait_redeem_bymcode()
    {
        $membercode = trim($this->request->getVar('membercode'));
        $model = new TransaksiRedeemModel();
        $data = $model
                ->where('membercode', $membercode)
                ->where('approved', "0")
                ->orderBy('idredeem', 'DESC')->findAll();
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
    

    public function get_wait_redeem_bymcode_filldate()
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
        $builder->where('approved', "0");
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

    /////////////REDEEM
    //create redeem
    public function create_redeem_adm(){
        $membercode     = trim($this->request->getVar('membercode'));
        //$userid         = trim($this->request->getVar('userid'));
        $redeemamt      = trim($this->request->getVar('redeemamt'));
        $redeemdate     = date('Y-m-d');
        $approved       = "1";
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
                'approved'     => $approved,
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


    //create redeem member
    public function create_redeem_mem(){
        $membercode     = trim($this->request->getVar('membercode'));
        //$userid         = trim($this->request->getVar('userid'));
        $redeemamt      = trim($this->request->getVar('redeemamt'));
        $redeemdate     = date('Y-m-d');
        $approved       = "0";
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
                'approved'     => $approved,
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

//approve_reedem_mem
public function approve_reedem_mem(){
    $idredeem       = trim($this->request->getVar('idredeem'));
    $membercode     = trim($this->request->getVar('membercode'));
    //$userid         = trim($this->request->getVar('userid'));
    //$redeemamt      = trim($this->request->getVar('redeemamt'));
    //$redeemdate     = date('Y-m-d');
    $approved       = "1";
    $approveddate   = date("Y-m-d h:i:sa");
    $userapproved   = trim($this->request->getVar('chuserid'));
    $chuserid       = trim($this->request->getVar('chuserid'));
    $chdate         = date("Y-m-d h:i:sa");
    

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

     
        //cek reedem by code
        $model = new TransaksiRedeemModel();
        $data_r = $model
                ->where('idredeem', $idredeem)
                ->where('approved', "0")
                ->first();

        if (!$data_r) {
            return $this->response->setJSON(['success' => false, 
                                            'message' => 'Transaksi redeem tidak ditemukan', 
                                            $idredeem]);
        } else 
        {

            ///ambil nominal transaksi
            $redeemamt=0;
            $result1 = $model->select('redeemamt')
                    ->where('idredeem', $idredeem)
                    ->where('approved', "0")
                    ->get()
                    ->getRow();

            if ($result1) {
                $redeemamt = $result1->redeemamt;
                // Gunakan nilai $value1 dan $value2 sesuai kebutuhan Anda
            } else {
                // Tidak ada hasil yang ditemukan
            }

            //akumulasi saldo akhir member
            $totalamt_akhir =  $totalamt-$redeemamt;


            //update transaksi redeem
            $data_redeem = [
                'approved' => $approved,
                'approveddate' => $approveddate,
                'userapproved' => $userapproved,
                'chuserid' => $chuserid,
                'chdate'   => $chdate,
            ];

            $model->update($idredeem, $data_redeem);



            ////update saldo member
            $data_update = [
            'totalamt' => $totalamt_akhir,
            'chuserid' => $chuserid,
            'chdate'   => $chdate,

            ];

            $model_m->update($userid_m, $data_update);
        
            $redeemUpdated = $model->where('idredeem', $idredeem)->first();

            if ($redeemUpdated) {

                $newRedeemData = $model_m->find($redeemUpdated);
                // Berikan respons JSON sukses dengan data yang baru diinsert
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data redeem berhasil disimpan',
                    'data' => $newRedeemData,
                ]);

            } else {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Data redeem gagal diubah',
                    //'data' => $newRedeemData,
                ]);
                //return json_encode($model_m->validation->getErrors());
            }
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
}