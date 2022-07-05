<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ModelSewa;
use App\Models\ModelLaporan;
use Dompdf\Options;


class Export extends BaseController
{

    public function index()
    {
        return view('pdf');
    }


    function print($faktur = null)
    {
        $db = $this->db->table('sewa');
        $db->select('*, sewa.id as sewaID');
        $db->join('faktur', 'faktur.id = sewa.no_transaksi');
        $db->where('faktur', $faktur);
        $faktur = $db->get()->getRowArray();

        $db = $this->db->table('profil');
        $db->where('id', 1);
        $profil = $db->get()->getRowArray();

        $db = $this->db->table('pegawai');
        $db->select('nama');
        $db->join('users', 'users.petugas_id = pegawai.id');
        $db->where('users.id', user_id());
        $petugas = $db->get()->getRowArray();

        $m_sewa = new ModelSewa();
        $data = [
            'title' => 'view sewa',
            'profil' => $profil,
            'sewa' => $m_sewa->detailSewaById($faktur['sewaID']),
            'history_bayar' => $m_sewa->riwayat_bayar_by_id($faktur['sewaID'])->getResultArray(),
            'faktur' => $faktur['faktur'],
            'petugas' => $petugas
        ];
        return view('export/print_sewa', $data);
    }
    // function printSewa($faktur)
    // {
    //     $faktur = $this->request->getVar('faktur');
    //     if ($this->request->getVar('aksi') == 1) {
    //         $db = db_connect();
    //         $query = $db->query("SELECT * FROM sewa ORDER BY id DESC LIMIT 1");
    //         $id = $query->getRowArray();
    //         $id = $id['id'];
    //     } else {
    //         $id = $this->request->getVar('id');
    //     }

    //     $db = $this->db->table('profil');
    //     $db->where('id', 1);
    //     $profil = $db->get()->getRowArray();

    //     $m_sewa = new ModelSewa();
    //     $data = [
    //         'title' => 'view sewa',
    //         'profil' => $profil,
    //         'sewa' => $m_sewa->detailSewaById($id),
    //         'history_bayar' => $m_sewa->riwayat_bayar_by_id($id)->getResultArray()
    //     ];
    //     $options = new \Dompdf\Options();
    //     // $options->set('defaultFont', 'Courier');
    //     $options->set('isRemoteEnabled', TRUE);
    //     $options->set('debugKeepTemp', TRUE);
    //     $options->set('isHtml5ParserEnabled', true);
    //     $options->set('chroot', '');
    //     $dompdf = new \Dompdf\Dompdf($options);
    //     $filename = 'sewa' . ' ' . date('d-m-Y-H:i:s');
    //     $dompdf = new \Dompdf\Dompdf();
    //     $dompdf->loadHtml(view('export/print_sewa'));
    //     $dompdf->setPaper('A4', 'potrait');
    //     $dompdf->render();
    //     $pdf = $dompdf->stream($filename . ".pdf",  array("Attachment" => 0));

    //     $data = ['data' => $pdf];
    //     echo json_encode($data);
    // }

    public function printpembayaranbulanan()
    {
        $db = $this->db->table('profil');
        $db->where('id', 1);
        $profil = $db->get()->getRowArray();

        $m_sewa = new ModelSewa();
        $history = $m_sewa->riwayat_tagihan_bulanan($this->request->getVar('id'));

        $db = $this->db->table('pegawai');
        $db->select('nama');
        $db->join('users', 'users.petugas_id = pegawai.id');
        $db->where('users.id', user_id());
        $petugas = $db->get()->getRowArray();



        $data = [
            'periode' => $this->request->getVar('periode'),
            'property' => $this->request->getVar('property'),
            'pedagang' => $this->request->getVar('pedagang'),
            'nik' => $this->request->getVar('nik'),
            'tarif' => str_replace(['Rp.', '.'], '', $this->request->getVar('tarif')),
            'bayar' => str_replace(['Rp.', '.'], '', $this->request->getVar('bayar')),
            'profil' => $profil,
            'history' => $history,
            'petugas' => $petugas
        ];
        $filename = 'pembayaran-bulanan' . '-' . date('d-m-Y-H:i:s');
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('export/print_tagihan_bulanan', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename . ".pdf",  array("Attachment" => 0));
    }
    public function cetakPembayaranBulanan($id)
    {
        $db = $this->db->table('profil');
        $db->where('id', 1);
        $profil = $db->get()->getRowArray();

        $m_sewa = new ModelSewa();
        $history = $m_sewa->riwayat_tagihan_bulanan($id);

        $db = $this->db->table('pegawai');
        $db->select('nama');
        $db->join('users', 'users.petugas_id = pegawai.id');
        $db->where('users.id', user_id());
        $petugas = $db->get()->getRowArray();

        $data = [
            'periode' => $this->request->getVar('periode'),
            'property' => $this->request->getVar('property'),
            'pedagang' => $this->request->getVar('pedagang'),
            'nik' => $this->request->getVar('nik'),
            'tarif' => str_replace(['Rp.', '.'], '', $this->request->getVar('tarif')),
            'bayar' => str_replace(['Rp.', '.'], '', $this->request->getVar('bayar')),
            'profil' => $profil,
            'history' => $history,
            'petugas' => $petugas
        ];
        return view('export/print_tagihan_bulanan', $data);
    }
    public function saldo()
    {
        $tanggal = date('Y-m-d', strtotime($this->request->getVar('tanggal')));
        $m_laporan = new ModelLaporan();
        $cek = $m_laporan->saldo($tanggal);
        $data = [
            'title' => 'Laporan Saldo',
            'tanggal' => $tanggal,
            'penjualan' => $cek['penjualan']['total'],
            'transaksi_penjualan' => $cek['transaksi_penjualan']['total'],
            'sewa' => $cek['sewa']['total'],
            'transaksi_sewa' => $cek['transaksi_sewa']['total'],
            'pajak_bulanan' => $cek['pajak_bulanan']['total'],
            'transaksi_pajak_bulanan' => $cek['transaksi_pajak_bulanan']['total'],
            'retribusi' => $cek['retribusi']['total'],
            'pembelian' => $cek['pembelian']['total'],
            'transaksi_pembelian' => $cek['transaksi_pembelian']['total'],
            'pengeluaran_umum' => $cek['pengeluaran_umum']['total'],
            'pengeluaran_atk' => $cek['pengeluaran_atk']['total'],
            'pengeluaran_pasar' => $cek['pengeluaran_pasar']['total'],
            'pemasukan_lainnya' => $cek['pemasukan_lainnya']['total'],

        ];
        $filename = 'Laporan-Saldo' . ' per ' . date_indo($tanggal);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('export/saldo', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename . ".pdf",  array("Attachment" => 1));
    }
    public function keuangan()
    {
        $start = date('Y-m-d', strtotime($this->request->getVar('start')));
        $end = date('Y-m-d', strtotime($this->request->getVar('end')));
        $m_laporan = new ModelLaporan();
        $cek = $m_laporan->keuangan($start, $end);
        $data = [
            'title' => 'Laporan Keuangan',
            'start' => $start,
            'end' => $end,
            'penjualan' => $cek['penjualan']['total'],
            'transaksi_penjualan' => $cek['transaksi_penjualan']['total'],
            'sewa' => $cek['sewa']['total'],
            'transaksi_sewa' => $cek['transaksi_sewa']['total'],
            'pajak_bulanan' => $cek['pajak_bulanan']['total'],
            'transaksi_pajak_bulanan' => $cek['transaksi_pajak_bulanan']['total'],
            'retribusi' => $cek['retribusi']['total'],
            'pembelian' => $cek['pembelian']['total'],
            'transaksi_pembelian' => $cek['transaksi_pembelian']['total'],
            'pengeluaran_umum' => $cek['pengeluaran_umum']['total'],
            'pengeluaran_atk' => $cek['pengeluaran_atk']['total'],
            'pengeluaran_pasar' => $cek['pengeluaran_pasar']['total'],
            'pemasukan_lainnya' => $cek['pemasukan_lainnya']['total'],

        ];
        $filename = 'Laporan-Keuangan' . ' dari ' . date_indo($start). ' sampai '.date_indo($end);
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('export/keuangan', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename . ".pdf",  array("Attachment" => 1));
    }

    public function laba()
    {
        $data = [
            'start' => $this->request->getVar('mulai'),
            'end' => $this->request->getVar('sampai'),
        ];

        $m_laporan = new ModelLaporan();
        $laba = $m_laporan->laba($data);
        $data = [
            'start' => $this->request->getVar('mulai'),
            'end' => $this->request->getVar('sampai'),
            'penjualan_lunas' => $laba['menerima'],
            'penjualan_belum_lunas' => $laba['piutang'],
            'hpp' => $laba['hpp'],
            'pengeluaran_atk' => $laba['pengeluaran_atk'],
            'pendapatan_atk' => $laba['pendapatan_atk'],
            'uang_sewa_diterima' => $laba['sewa_diterima'],
            'piutang_sewa' => $laba['piutang_sewa'],
            'pajak_bulanan_terbayar' => $laba['pajak_bulanan_terbayar'],
            'pajak_bulanan' => $laba['pajak_bulanan'],
            'retribusi' => $laba['retribusi'],
            'pendapatan_pasar' => $laba['pendapatan_pasar'],
            'pengeluaran_pasar' => $laba['pengeluaran_pasar'],
        ];

        $filename = 'Laporan-Laba' . '-' . date('d/m/Y', strtotime($data['start'])) . ' sampai ' . date('d/m/Y', strtotime($data['end']));
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('export/laba', $data));
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream($filename . ".pdf",  array("Attachment" => 1));
    }
}
