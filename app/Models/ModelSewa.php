<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Stmt\Return_;

class ModelSewa extends Model
{
    protected $table      = 'sewa';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = false;

    protected $allowedFields = ['pedagang_id', 'no_transaksi', 'property_id', 'tanggal_sewa', 'tanggal_batas', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function save_sewa($sewa, $faktur)
    {
        $this->db->transStart();

        $db = $this->db->table('faktur');
        $db->insert($faktur);
        $faktur_id = $this->insertID();

        $db = $this->db->table('sewa');
        $db->insert([
            'pedagang_id' => $sewa['pedagang_id'],
            'no_transaksi' => $faktur_id,
            'property_id' => $sewa['property_id'],
            'harga' => $sewa['harga'],
            'tanggal_sewa' => $sewa['tanggal_sewa'],
            'total_bayar' => $sewa['bayar'],
            'tanggal_batas' => $sewa['tanggal_batas'],
            'jenis_pembayaran' => $sewa['jenis_pembayaran'],
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $sewa_id = $this->insertID();

        $bayar = $sewa['bayar'];
        $harga = $sewa['harga'];
        if ($bayar > $harga) {
            $kembalian = $bayar - $harga;
        } else {
            $kembalian = 0;
        }


        $db = $this->db->table('transaksi_sewa');
        $db->insert([
            'sewa_id' => $sewa_id,
            'bayar' => $sewa['bayar'],
            'kembalian' => $kembalian,
            'metode_bayar' => $sewa['metode_bayar'],
            'bukti' => $sewa['bukti'],
            'keterangan' => $sewa['keterangan'],
            'created_at' => $sewa['created_at'],
            'user_id' => $sewa['user_id'],

        ]);

        $db = $this->db->table('property');
        $db->set(['status' => 0]);
        $db->where('property_id', $sewa['property_id']);
        $db->update();

        $db = $this->db->table('pedagang');
        $db->where('id', $sewa['pedagang_id']);
        $expire = $db->get()->getRowArray();

        if ($expire['expired'] == NULL) {
            $db = $this->db->table('pedagang');
            $db->where('id', $sewa['pedagang_id']);
            $db->set(['status' => 1, 'expired' => $sewa['tanggal_batas']]);
            $db->update();
        } elseif (strtotime($expire['expired']) < strtotime($sewa['tanggal_batas'])) {
            $db = $this->db->table('pedagang');
            $db->where('id', $sewa['pedagang_id']);
            $db->set(['status' => 1, 'expired' => $sewa['tanggal_batas']]);
            $db->update();
        }

        $this->db->transComplete();
    }


    public function save_pelunasan($pembayaran, $total_bayar)
    {

        $db = $this->db->table('sewa');
        $db->set($total_bayar);
        $db->where('id', $pembayaran['sewa_id']);
        $db->update();


        $db = $this->db->table('transaksi_sewa');
        $db->insert($pembayaran);


        $this->db->transComplete();
    }

    public function getSewa()
    {
        $db = $this->db->table('sewa');
        $db->select('faktur,sewa.id as sewaId, kode_property, no_transaksi, tanggal_sewa, tanggal_batas, SUM(transaksi_sewa.bayar) as terbayar, sewa.harga as harga_sewa, pedagang.nama as pedagang');
        $db->join('transaksi_sewa', 'sewa.id = transaksi_sewa.sewa_id', 'left');
        $db->join('property', 'property.property_id = sewa.property_id');
        $db->join('faktur', 'faktur.id = sewa.no_transaksi');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $db->groupBy('sewa.id');
        $db->orderBy('sewa.id', 'desc');
        return $db->get()->getResultArray();
    }
    public function sewa_aktif()
    {
        $db = $this->db->table('sewa');
        $db->select('faktur, sewa.id as sewaId, kode_property, no_transaksi, tanggal_sewa, tanggal_batas, SUM(transaksi_sewa.bayar) as terbayar, sewa.harga as harga_sewa, pedagang.nama as pedagang');
        $db->join('transaksi_sewa', 'sewa.id = transaksi_sewa.sewa_id', 'left');
        $db->join('property', 'property.property_id = sewa.property_id');
        $db->join('faktur', 'faktur.id = sewa.no_transaksi');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $db->where('sewa.tanggal_batas >', date('Y-m-d'));
        $db->groupBy('sewa.id');
        return $db->get()->getResultArray();
    }

    public function sewa_belum_lunas()
    {
        $db = $this->db->table('sewa');
        $db->select('faktur, sewa.id as sewaId, kode_property, no_transaksi, tanggal_sewa, tanggal_batas, SUM(transaksi_sewa.bayar) as terbayar, sewa.harga as harga_sewa, pedagang.nama as pedagang');
        $db->join('transaksi_sewa', 'sewa.id = transaksi_sewa.sewa_id', 'left');
        $db->join('property', 'property.property_id = sewa.property_id');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $db->join('faktur', 'faktur.id = sewa.no_transaksi');
        // $db->whereNotIn('sewa.status', ['Selesai']);
        $db->where('sewa.harga > total_bayar');
        $db->groupBy('sewa.id');
        return $db->get()->getResultArray();
    }
    public function sewa_selesai()
    {
        $db = $this->db->table('sewa');
        $db->select('faktur, sewa.id as sewaId, kode_property, no_transaksi, tanggal_sewa, tanggal_batas, SUM(transaksi_sewa.bayar) as terbayar, sewa.harga as harga_sewa, pedagang.nama as pedagang');
        $db->join('transaksi_sewa', 'sewa.id = transaksi_sewa.sewa_id', 'left');
        $db->join('property', 'property.property_id = sewa.property_id');
        $db->join('faktur', 'faktur.id = sewa.no_transaksi');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $db->where('sewa.tanggal_batas <', date('Y-m-d'));
        // $db->where('sewa.harga <= sewa.total_bayar');
        $db->groupBy('sewa.id');
        return $db->get()->getResultArray();
    }

    public function detailSewaById($id)
    {
        $db = $this->db->table('sewa');
        $db->select('sewa.id as id_sewa, kode_property, sewa.harga as harga_sewa, pedagang.nama as pedagang, faktur, jenis_property, jenis_usaha, tanggal_sewa, tanggal_batas, nik, sum(bayar) as total_bayar, sum(kembalian) as kembali');
        $db->join('transaksi_sewa', 'sewa.id = transaksi_sewa.sewa_id');
        $db->join('faktur', 'sewa.no_transaksi = faktur.id');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $db->join('property', 'property.property_id = sewa.property_id');
        $db->where('sewa.id', $id);
        return $db->get()->getRowArray();
    }

    public function delete_sewa($id)
    {
        $this->db->transStart();
        $db = $this->db->table('sewa');
        $db->where('id', $id);
        $sewa = $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->where('pedagang_id', $sewa['pedagang_id']);
        $count = $db->countAllResults();

        $db = $this->db->table('property');
        $db->where('property_id', $sewa['property_id']);
        $db->update([
            'status' => 1
        ]);

        $db = $this->db->table('sewa');
        $db->where('id', $id);
        $db->delete();

        if ($count == 1) {
            $db = $this->db->table('pedagang');
            $db->where('id', $sewa['pedagang_id']);
            $db->update([
                'status' => 0,
                'expired' => null
            ]);
        }


        $this->db->transComplete();
    }

    public function riwayat_bayar_by_id($id)
    {
        $db = $this->db->table('transaksi_sewa');
        $db->select('transaksi_sewa.created_at as tanggal_bayar, metode_bayar, users.username, transaksi_sewa.keterangan, sewa.harga as harga_sewa, bayar, no_transaksi, faktur, transaksi_sewa.id as transaksiId, sewa.id as sewaId, bukti');
        $db->join('sewa', 'transaksi_sewa.sewa_id = sewa.id', 'right');
        $db->join('users', 'users.id = transaksi_sewa.user_id');
        $db->join('faktur', 'sewa.no_transaksi = faktur.id');
        $db->where('sewa.id', $id);
        $db->orderBy('transaksi_sewa.id', 'desc');
        return $db->get();
    }
    public function edit_bayar_by_id($id)
    {
        $db = $this->db->table('transaksi_sewa');
        $db->select('transaksi_sewa.created_at as tanggal_bayar,bayar, metode_bayar, transaksi_sewa.keterangan, transaksi_sewa.id as transaksiId, sewa_id, bukti');
        $db->where('transaksi_sewa.id', $id);
        return $db->get();
    }

    public function update_pembayaran_sewa($data, $transaksiid, $sewaid, $update_bayar)
    {
        $this->db->transStart();


        $db = $this->db->table('transaksi_sewa');
        $db->set($data);
        $db->where('id', $transaksiid);
        $db->update();


        $totalBayar = [
            'total_bayar' => $update_bayar
        ];

        $db = $this->db->table('sewa');
        $db->set($totalBayar);
        $db->where('id', $sewaid);
        $db->update();


        $this->db->transComplete();
    }

    public function cek_sewa()
    {

        $db = $this->db->table('sewa');
        $db->where('tanggal_batas <', date('Y-m-d'));
        $rent = $db->get();

        $count = $rent->getNumRows();

        if ($count > 0) {

            $property = [];

            $sewa = $rent->getResultArray();
            foreach ($sewa as $row) {
                $property[] = [
                    'property_id' => $row['property_id'],
                    'status' => 1
                ];
            }

            $this->db->transStart();

            $db = $this->db->table('property');
            $db->updateBatch($property, 'property_id');

            $this->db->transComplete();
        }
    }

    public function cek_expire_pedagang()
    {
        $db = $this->db->table('pedagang');
        $db->where('expired <', date('Y-m-d'));
        $rent = $db->get();

        $count = $rent->getNumRows();

        if ($count > 0) {

            $pedagang = [];
            $customer = $rent->getResultArray();
            foreach ($customer as $row) {
                $pedagang[] = [
                    'id' => $row['id'],
                    'status' => 0
                ];
            }

            $this->db->transStart();

            $db = $this->db->table('pedagang');
            $db->updateBatch($pedagang, 'id');

            $this->db->transComplete();
        }
    }

    public function buatFaktur()
    {


        $sql = "SELECT MAX(MID(faktur, 9, 4)) AS faktur
        FROM faktur
        
        WHERE MID(faktur, 3, 6) = DATE_FORMAT(CURDATE(), '%d%m%y') AND jenis = 'Sewa'";
        $query = $this->db->query($sql);

        //cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->getNumRows() > 0) {
            //cek kode jika telah tersedia    
            $data = $query->getRow();
            $kode = intval($data->faktur) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $tgl = date('dmy');
        $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil = "SW" . $tgl . $batas;  //format kode
        return $kodetampil;
    }

    public function referensi()
    {


        $sql = "SELECT MAX(MID(referensi, 10, 4)) AS no_refrensi
        FROM transaksi
    
        WHERE MID(referensi, 4, 6) = DATE_FORMAT(CURDATE(), '%d%m%y')";
        $query = $this->db->query($sql);

        //cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->getNumRows() > 0) {
            //cek kode jika telah tersedia    
            $data = $query->getRow();
            $kode = intval($data->no_refrensi) + 1;
        } else {
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $tgl = date('dmy');
        $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil = "Ref" . $tgl . $batas;  //format kode
        return $kodetampil;
    }



    public function periode_bulanan()
    {

        $db = $this->db->table('periode_bulanan');
        $db->select('*');
        $db->orderBy('periode', 'desc');
        return $db->get()->getResultArray();
    }

    public function cek_tanggal_sewa($date, $jenis)
    {
        $db = \config\Database::connect();
        $query = $db->table('sewa');
        $query->select('*');
        $query->join('property', 'sewa.property_id = property.property_id');
        $query->where('tanggal_sewa <', date('Y-m-d', strtotime('+1 month', strtotime($date))));
        $query->where('sewa.tanggal_batas >', date('Y-m-d'));
        $query->wherein('property.jenis_property', $jenis);
        return $query->countAllResults();
    }
    public function create_tagihan_bulanan($data, $date, $jenis)
    {
        $this->db->transStart();
        $db = $this->db->table('sewa');
        $db->select('sewa.id as sewaId');
        $db->join('property', 'sewa.property_id = property.property_id');
        $db->where('date(tanggal_sewa) <=', date('Y-m-d', strtotime('+1 month', strtotime($date))));
        $db->where('date(sewa.tanggal_batas) >', date('Y-m-d'));
        $db->wherein('property.jenis_property', $jenis);
        $sewa = $db->get()->getResultArray();

        $db = $this->db->table('periode_bulanan');
        $db->insert($data);
        $id = $this->insertID();

        $i = [];
        foreach ($sewa as $row) {
            $i[] = [
                'periode_id' => $id,
                'sewa_id' => $row['sewaId'],
            ];
        }
        $db = $this->db->table('tagihan_bulanan');
        $db->insertBatch($i);

        $this->db->transComplete();
    }

    public function update_periode_bulanan($id, $data)
    {
        $db = $this->db->table('periode_bulanan');
        $db->where('id', $id);
        $db->set($data);
        $db->update();
    }
    public function detail_periode($id)
    {
        $db = $this->db->table('tagihan_bulanan');
        $db->select('*, tagihan_bulanan.id as tagihanId, transaksi_bulanan.id as transaksiId, tagihan_bulanan.tarif as totalTarif, pedagang.nama as pedagang   ');
        $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
        $db->join('periode_bulanan', 'tagihan_bulanan.periode_id = periode_bulanan.id');
        $db->join('pedagang', 'pedagang.id = tagihan_bulanan.pedagang_id');
        $db->where('periode_id', $id);
        $db->orderBy('periode', 'desc');
        return $db->get();
    }

    public function tagihan_bulanan_belum_lunas($id = null)
    {
        if ($id == null) {
            $db = $this->db->table('tagihan_bulanan');
            $db->select('COALESCE(sum(tagihan_bulanan.total_bayar), 0) as bayar, count(tagihan_bulanan.sewa_id) as bulan, sum(periode_bulanan.tarif) as totalTarif, pedagang.nama as pedagang,  tagihan_bulanan.id as tagihanId, pedagang_id, tarif');
            $db->join('periode_bulanan', 'tagihan_bulanan.periode_id = periode_bulanan.id', 'right');
            $db->join('sewa', 'tagihan_bulanan.sewa_id = sewa.id', 'left');
            $db->join('pedagang', 'pedagang.id = sewa.pedagang_id', 'left');
            $db->where('tarif > tagihan_bulanan.total_bayar');
            $db->groupBy('pedagang.id');
            $db->Having('totalTarif > bayar');
            $db->orderBy('periode', 'desc');
            return  $db->get()->getResultArray();
        }
    }
    public function tagihan_bulanan_by_pedagang($id)
    {
        $db = $this->db->table('tagihan_bulanan');
        $db->select('periode_bulanan.jenis as jenisTagihan, periode_bulanan.tarif , tagihan_bulanan.id as tagihanId, periode, jenis, kode_property, COALESCE(sum(bayar), 0) as bayar');
        $db->join('periode_bulanan', 'tagihan_bulanan.periode_id = periode_bulanan.id', 'left');
        $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
        $db->join('sewa', 'sewa.id = tagihan_bulanan.sewa_id', 'left');
        $db->join('property', 'property.property_id = sewa.property_id', 'left');
        $db->where('sewa.pedagang_id', $id);
        $db->groupBy('tagihan_bulanan.id');
        $db->orderBy('periode', 'desc');
        return $db->get()->getResultArray();
    }
    public function tagihan_bulanan_by_id($id)
    {
        $db = $this->db->table('tagihan_bulanan');
        $db->select('*, sum(bayar) as total_bayar, periode_bulanan.tarif as tarifTotal, tagihan_bulanan.id as tagihanId, periode_bulanan.jenis as jenis_tagihan, periode_bulanan.tarif as tarifPeriode');
        $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id', 'left');
        $db->join('periode_bulanan', 'tagihan_bulanan.periode_id = periode_bulanan.id');
        // $db->join('pedagang', 'pedagang.id = tagihan_bulanan.pedagang_id');
        $db->where('tagihan_bulanan.id', $id);
        return $db->get()->getRowArray();
    }
    public function riwayat_tagihan_bulanan($id = null)
    {
        if ($id == null) {

            $db = $this->db->table('tagihan_bulanan');
            $db->select('*, periode_bulanan.tarif as tarifTotal, tagihan_bulanan.id as tagihanId, periode_bulanan.jenis as jenis_tagihan, periode_bulanan.tarif as tarifPeriode, transaksi_bulanan.created_at as tanggal_bayar');
            $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id');
            $db->join('periode_bulanan', 'tagihan_bulanan.periode_id = periode_bulanan.id');
            // $db->join('pedagang', 'pedagang.id = tagihan_bulanan.pedagang_id');
            return $db->get()->getResultArray();
        } else {
            $db = $this->db->table('tagihan_bulanan');
            $db->select('*,transaksi_bulanan.id as transaksiId, periode_bulanan.tarif as tarifTotal, tagihan_bulanan.id as tagihanId, periode_bulanan.jenis as jenis_tagihan, periode_bulanan.tarif as tarifPeriode, transaksi_bulanan.created_at as tanggal_bayar');
            $db->join('transaksi_bulanan', 'transaksi_bulanan.tagihan_id = tagihan_bulanan.id');
            $db->join('periode_bulanan', 'tagihan_bulanan.periode_id = periode_bulanan.id');
            $db->join('users', 'users.id = transaksi_bulanan.user_id', 'left');
            // $db->join('pedagang', 'pedagang.id = tagihan_bulanan.pedagang_id');
            $db->where('tagihan_bulanan.id', $id);
            return $db->get()->getResultArray();
        }
    }

    public function simpan_pembayaran_tagihan($data, $data2)
    {
        $this->db->transStart();

        $db = $this->db->table('tagihan_bulanan');
        $db->set($data2);
        $db->where('id', $data['tagihan_id']);
        $db->update();

        $db = $this->db->table('transaksi_bulanan');
        $db->insert($data);

        $this->db->transComplete();
    }

    public function edit_nominal_tagihan_bulanan($id)
    {
        $db = $this->db->table('tagihan_bulanan');
        $db->select('*,transaksi_bulanan.bayar, transaksi_bulanan.id as transaksiId, tagihan_bulanan.id as tagihanId, pedagang.nama as pedagang, transaksi_bulanan.created_at as waktuBayar, transaksi_bulanan.keterangan as desc');
        $db->join('transaksi_bulanan', 'tagihan_bulanan.id = transaksi_bulanan.tagihan_id');
        $db->join('sewa', 'tagihan_bulanan.sewa_id = sewa.id');
        $db->join('users', 'transaksi_bulanan.user_id = users.id');
        $db->join('periode_bulanan', 'tagihan_bulanan.periode_id = periode_bulanan.id');
        $db->join('pedagang', 'pedagang.id = sewa.pedagang_id');
        $db->where('transaksi_bulanan.id', $id);
        return  $db->get()->getRowArray();
    }

    public function update_nominal_tagihan($data)
    {
        $this->db->transStart();

        $db = $this->db->table('transaksi_bulanan');
        $db->set($data);
        $db->where('id', $data['id']);
        $db->update();

        $this->db->transComplete();
    }
    public function delete_riwayat_bayar_by_id($data)
    {
        $this->db->transStart();

        $db = $this->db->table('transaksi_bulanan');
        $db->where('id', $data['id']);
        $db->delete();

        $db = $this->db->table('transaksi_bulanan');
        $db->select('sum(bayar) as total_bayar');
        $db->where('tagihan_id', $data['tagihanId']);
        $total_bayar = $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->where('id', $data['tagihanId']);
        $db->update([
            'total_bayar' => $total_bayar['total_bayar']
        ]);

        $this->db->transComplete();
    }

    public function delete_pedagang_by_periode($id)
    {
        $db = $this->db->table('tagihan_bulanan');
        $db->where('id', $id);
        $db->delete();
    }
}
