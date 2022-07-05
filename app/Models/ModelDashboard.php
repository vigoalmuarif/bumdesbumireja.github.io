<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDashboard extends Model
{

    public function admin()
    {
        $db = $this->db->table('pegawai');
        $db->select('count(id) as total');
        $db->where('status', 1);
        $pegawai_aktif = $db->countAllResults('id');
        // $pegawai_aktif = $db->get()->getResultArray();

        $db = $this->db->table('retribusi_group_user');
        $db->where('status', 1);
        $petugas_retribusi = $db->countAllResults('id');

        $db = $this->db->table('users');
        $db->where('active', 1);
        $user = $db->countAllResults('id');

        $db = $this->db->table('auth_logins');
        $db->select('ip_address, auth_logins.email as emailLogin, username, date, success');
        $db->join('users', 'users.id = auth_logins.user_id', 'left');
        $db->where('month(date)', date('m'));
        $db->orderBy('date', 'desc');
        $logins = $db->get()->getResultArray();

        $data = [
            'pegawai' => $pegawai_aktif,
            'petugas' => $petugas_retribusi,
            'user' => $user,
            'logins' => $logins
        ];
        return $data;
    }
    public function bendahara()
    {
        //Total Pendapatan
        $db = $this->db->table('penjualan');
        $db->select('SUM(total) as total');
        $penjualan = $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('SUM(harga) as total');
        $sewa = $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->select('SUM(tarif) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $tagihan_bulanan1 = $db->get()->getRowArray();

        $db = $this->db->table('pembayaran_retribusi');
        $db->select('SUM(bayar) as total');
        $retribusi = $db->get()->getRowArray();

        // $db = $this->db->table('tagihan_bulanan');
        // $db->select('SUM(total_bayar) as total');
        // $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id');
        // $db->where('tarif > total_bayar');
        // $tagihan_bulanan2 = $db->get()->getRowArray();


        $db = $this->db->table('arus_uang');
        $db->select('SUM(jumlah) as total');
        $db->where('jenis', 'in');
        $pemasukan_lainnya = $db->get()->getRowArray();

        $total_pendapatan = $penjualan['total'] + $sewa['total']  + $tagihan_bulanan1['total']  + $retribusi['total']  + $pemasukan_lainnya['total'];

        //pemasukan by manual
        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "in"');
        $db->where('unit = "Umum"');
        $pemasukan_umum = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "in"');
        $db->where('unit = "ATK"');
        $pemasukan_atk = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "in"');
        $db->where('unit = "Pasar"');
        $pemasukan_pasar = $db->get()->getRowArray();

        //pengeluaran
        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "out"');
        $pengeluaran = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "out"');
        $db->where('unit = "Umum"');
        $pengeluaran_umum = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "out"');
        $db->where('unit = "ATK"');
        $pengeluaran_atk = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "out"');
        $db->where('unit = "Pasar"');
        $pengeluaran_pasar = $db->get()->getRowArray();


        //Pendapatan Bulanan
        $db = $this->db->table('penjualan');
        $db->selectSum('total');
        $db->where('month(created_at)', date('m'));
        $b_penjualan = $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->selectSum('tarif');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->where('month(created_at)', date('m'));
        $b_bulanan = $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->selectSum('harga');
        $db->where('month(created_at)', date('m'));
        $b_sewa = $db->get()->getRowArray();

        $db = $this->db->table('pembayaran_retribusi');
        $db->selectSum('bayar');
        $db->where('month(created_at)', date('m'));
        $b_retribusi = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('month(created_at)', date('m'));
        $db->where('jenis = "in"');
        $b_pemasukan = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('month(created_at)', date('m'));
        $db->where('jenis = "out"');
        $b_pengeluaran = $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('sum(total - diskon) as total');
        $db->where('month(created_at)', date('m'));
        $db->where('(total-diskon) <= bayar');
        $b_pembelian_tunai = $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->selectSum('bayar');
        $db->where('month(created_at)', date('m'));
        $db->where('(total-diskon) > bayar');
        $b_pembelian_kredit = $db->get()->getRowArray();

        $db = $this->db->table('arus_uang');
        $db->selectSum('jumlah');
        $db->where('jenis = "out"');
        $pengeluaran = $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('sum(total - diskon) as total');
        $db->where('bayar >= total-diskon');
        $pembelian_lunas = $db->get()->getRowArray();

        $db = $this->db->table('pembelian');
        $db->select('sum(bayar) as total');
        $db->where('bayar < total-diskon');
        $pembelian_belum_lunas = $db->get()->getRowArray();


        //piutang
        $db = $this->db->table('penjualan');
        $db->select('sum(total - bayar) as total');
        $db->where('bayar < total');
        $piutang_penjualan = $db->get()->getRowArray();


        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(tarif - total_bayar) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id', 'left');
        $db->where('total_bayar < tarif');
        $piutang_pajak = $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('sum(harga - total_bayar) as total');
        $db->where('total_bayar < harga');
        $piutang_sewa = $db->get()->getRowArray();

        $db = $this->db->table('pembayaran_retribusi');
        $db->select('count(*) as total');
        $db->where('bayar = 0');
        $db->where('status = 1');
        $piutang_retribusi = $db->get()->getRowArray();


        // total hutang
        $db = $this->db->table('pembelian');
        $db->select('sum((total - diskon) - bayar) as total');
        $db->where('bayar < total-diskon');
        $hutang = $db->get()->getRowArray();


        $total_pengeluaran = $pengeluaran['jumlah'] + $pembelian_lunas['total'] + $pembelian_belum_lunas['total'];
        $piutang = $piutang_penjualan['total'] + $piutang_pajak['total'] + $piutang_sewa['total'];

        ///--------------------------------------------//
        $pendapatan_bulanan = $b_penjualan['total'] + $b_bulanan['tarif'] + $b_sewa['harga'] + $b_retribusi['bayar'] + $b_pemasukan['jumlah'];

        $pendapatan_atk = $penjualan['total'] + $pemasukan_atk['jumlah'];
        $pendapatan_pasar = $sewa['total'] + $pemasukan_pasar['jumlah']  + $tagihan_bulanan1['total']  + $retribusi['total'];
        $pendapatan_umum = $pemasukan_umum['jumlah'];

        $pengeluaran_atk = $pengeluaran_atk['jumlah'] + $pembelian_lunas['total'] + $pembelian_belum_lunas['total'];
        $pengeluaran_pasar = $pengeluaran_pasar['jumlah'];
        $pengeluaran_umum = $pengeluaran_umum['jumlah'];

        $pengeluaran_bulanan = $b_pengeluaran['jumlah'] + $b_pembelian_kredit['bayar'] + $b_pembelian_tunai['total'];
        $hutang = $hutang['total'];
        $saldo = $total_pendapatan - ($piutang + $total_pengeluaran);
        $data = [
            'saldo' => $saldo,
            'total' => $total_pendapatan,
            'pengeluaran' => $total_pengeluaran,
            'pendapatan_bulanan' => $pendapatan_bulanan,
            'pendapatan_atk' => $pendapatan_atk,
            'pendapatan_pasar' => $pendapatan_pasar,
            'pendapatan_umum' => $pendapatan_umum,
            'pengeluaran_atk' => $pengeluaran_atk,
            'pengeluaran_pasar' => $pengeluaran_pasar,
            'pengeluaran_umum' => $pengeluaran_umum,
            'piutang' => $piutang,
            'hutang' => $hutang,
            'retribusi' => $piutang_retribusi,
            'pengeluaran_bulanan' => $pengeluaran_bulanan
        ];

        return $data;
    }

    public function pendapatansewa()
    {
        $db = $this->db->table('sewa');
        $db->select('sum(harga) as total');
        $sewa = $db->get()->getRowArray();

        $db = $this->db->table('sewa');
        $db->select('sum(harga - total_bayar) as total');
        $db->where('total_bayar < harga');
        $sewa_belum_lunas = $db->get()->getRowArray();


        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(tarif) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id');
        $bulanan = $db->get()->getRowArray();

        $db = $this->db->table('tagihan_bulanan');
        $db->select('sum(tarif - total_bayar) as total');
        $db->join('periode_bulanan', 'periode_bulanan.id = tagihan_bulanan.periode_id');
        $db->where('tarif > total_bayar');
        $bulanan_belum_lunas = $db->get()->getRowArray();

        $db = $this->db->table('property');
        $db->where('status = 1');
        $property_ready = $db->countAllResults();

        $db = $this->db->table('property');
        $db->where('status = 0');
        $property_sewa = $db->countAllResults();

        $db = $this->db->table('pedagang');
        $db->where('status = 1');
        $pedagang_aktif = $db->countAllResults();

        $db = $this->db->table('pedagang');
        $db->where('status = 0');
        $pedagang_nonaktif = $db->countAllResults();

        $data = [
            'total_sewa' => $sewa,
            'total_bulanan' => $bulanan,
            'sewa_belum_lunas' => $sewa_belum_lunas,
            'bulanan_belum_lunas' => $bulanan_belum_lunas,
            'property_ready' => $property_ready,
            'property_sewa' => $property_sewa,
            'pedagang_aktif' => $pedagang_aktif,
            'pedagang_nonaktif' => $pedagang_nonaktif,
        ];

        return $data;
    }

    public function retribusi()
    {
        $db = $this->db->table('pembayaran_retribusi');
        $db->select('sum(bayar) as total');
        $db->where('status = 1');
        $pendapatan_retribusi = $db->get()->getRowArray();

        $db = $this->db->table('pembayaran_retribusi');
        $db->select('sum(bayar) as total');
        $db->where('status = 1');
        $db->where('Year(created_at)', date('Y'));
        $pendapatan_tahun = $db->get()->getRowArray();

        $db = $this->db->table('pembayaran_retribusi');
        $db->select('sum(bayar) as total');
        $db->where('status = 1');
        $db->where('month(created_at)', date('m'));
        $pendapatan_bulan = $db->get()->getRowArray();

        $db = $this->db->table('retribusi');
        $db->select('count(id) as total');
        $db->where('status = 1');
        $retribusi = $db->get()->getRowArray();

        $db = $this->db->table('retribusi');
        $db->select('count(id) as total');
        $jml_retribusi = $db->get()->getRowArray();


        $db = $this->db->table('retribusi_group_user');
        $db->where('status', 1);
        $total_petugas = $db->countAllResults();

        $db = $this->db->table('retribusi');
        $db->where('status', 1);
        $total_retribusi = $db->countAllResults();

        $db = $this->db->table('periode_retribusi');
        $total_periode = $db->countAllResults();



        $data = [
            'pendapatan_retribusi' => $pendapatan_retribusi,
            'pendapatan_tahun' => $pendapatan_tahun,
            'pendapatan_bulan' => $pendapatan_bulan,
            'retribusi' => $retribusi,
            'jml_retribusi' => $jml_retribusi,
            'petugas' => $total_petugas,
            'total_retribusi' => $total_retribusi,
            'periode' => $total_periode
        ];

        return $data;
    }
}
