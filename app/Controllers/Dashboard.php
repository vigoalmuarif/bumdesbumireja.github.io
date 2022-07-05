<?php

namespace App\Controllers;

use App\Models\ModelProperty;
use App\Models\ModelSewa;
use App\Models\ModelRetribusi;
use App\Models\ModelDashboard;
use App\Models\ModelPenjualan;

class Dashboard extends BaseController
{
    public function index()
    {

        $m_sewa = new ModelSewa();
        $m_sewa->cek_sewa();
        $m_sewa->cek_expire_pedagang();

        $m_dashboard = new ModelDashboard();
        $data = $m_dashboard->bendahara();

        $admin = $m_dashboard->admin();

        $data = [
            'title' => 'Home',
            'total' => $data['total'],
            'saldo' => $data['saldo'],
            'pengeluaran' => $data['pengeluaran'],
            'pendapatan_bulanan' => $data['pendapatan_bulanan'],
            'pendapatan_atk' => $data['pendapatan_atk'],
            'pendapatan_pasar' => $data['pendapatan_pasar'],
            'pendapatan_umum' => $data['pendapatan_umum'],
            'pengeluaran_atk' => $data['pengeluaran_atk'],
            'pengeluaran_pasar' => $data['pengeluaran_pasar'],
            'pengeluaran_umum' => $data['pengeluaran_umum'],
            'piutang' => $data['piutang'],
            'hutang' => $data['hutang'],
            'retribusi' => $data['retribusi'],
            'pengeluaran_bulanan' => $data['pengeluaran_bulanan'],
            'pegawai' => $admin['pegawai'],
            'petugas' => $admin['petugas'],
            'user' => $admin['user'],
            'logins' => $admin['logins']

        ];
        // dd($data['tahun']->getResultArray());
        return view('home/index', $data);
    }
    public function pengelolaan_atk()
    {
        //penjualan bulan ini
        $db = $this->db->table('penjualan');
        $db->selectSum('total');
        $db->where('MONTH(created_at)', date('m'));
        // $db->where('pembayaran = "Tunai"');
        $penjualan_bulanan = $db->get()->getRowArray();


        $db = $this->db->table('penjualan');
        $db->selectSum('bayar');
        $db->selectSum('total');
        $db->where('bayar < total');
        $db->where('pembayaran', 'Kredit');
        $piutang = $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('sum(bayar) as bayar, sum(total-diskon) as total');
        $db->where('bayar < total-diskon');
        $db->where('pembayaran', 'Kredit');
        $hutang = $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('sum(bayar), sum(total-diskon) as total');
        // $db->selectSum('kembali');
        $db->where('MONTH(created_at)', date('m'));
        $pembelian_bulanan = $db->get()->getRowArray();

        $db = $this->db->table('users');
        $db->where('id', user_id());
        $user = $db->get()->getRowArray();

        $m_penjualan = new ModelPenjualan();
        $penjualan = $m_penjualan->penjualan_today();

        $total_piutang = $piutang['total'] - $piutang['bayar'];
        $total_hutang = $hutang['total'] - $hutang['bayar'];

        $diagram = $m_penjualan->diagramPenjualan();
        // dd($diagram);
        $data = [
            'title' => 'Home',
            'penjualan_bulanan' => $penjualan_bulanan,
            'pembelian_bulanan' => $pembelian_bulanan,
            'piutang' => $total_piutang,
            'hutang' => $total_hutang,
            'user' => $user,
            'penjualan' => $penjualan,
            'diagram' => $diagram

        ];
        return view('home/index_atk', $data);
    }

    public function persewaan()
    {
        $m_sewa = new ModelSewa();
        $m_sewa->cek_sewa();
        $m_sewa->cek_expire_pedagang();

        $sewa = $m_sewa->sewa_belum_lunas();
        $tagihan_bulanan = $m_sewa->tagihan_bulanan_belum_lunas();

        $m_sewa = new ModelDashboard();
        $data = $m_sewa->pendapatansewa();
        $data = [
            'title' => 'Persewaan',
            'total_pendapatan_sewa' => $data['total_sewa'],
            'pajak' => $data['total_bulanan'],
            'sewa_belum_lunas' => $data['sewa_belum_lunas'],
            'bulanan_belum_lunas' => $data['bulanan_belum_lunas'],
            'property_ready' => $data['property_ready'],
            'property_sewa' => $data['property_sewa'],
            'pedagang_aktif' => $data['pedagang_aktif'],
            'pedagang_nonaktif' => $data['pedagang_nonaktif'],
            'sewa' => $sewa,
            'tagihan' => $tagihan_bulanan

        ];
        return view('home/index_sewa', $data);
    }

    public function retribusi()
    {
        $m_pendapatan = new ModelDashboard();
        $m_retribusi = new ModelRetribusi();
        $retribusi = $m_retribusi->setor_retribusi();

        $data = $m_pendapatan->retribusi();
        $data = [
            'title' => 'Retribusi',
            'pendapatan_retribusi' => $data['pendapatan_retribusi'],
            'pendapatan_tahun' => $data['pendapatan_tahun'],
            'pendapatan_bulan' => $data['pendapatan_bulan'],
            'retribusi' => $retribusi,
            'retribusi_aktif' => $data['retribusi'],
            'jml_retribusi' => $data['jml_retribusi'],
            'petugas' => $data['petugas'],
            'total_retribusi' => $data['total_retribusi'],
            'periode' => $data['periode']

        ];
        return view('home/index_retribusi', $data);
    }

    public function ketua()
    {
        $data = [
            'title' => 'Dashboard'
        ];

        return view('templates/index_ketua', $data);
    }
}
