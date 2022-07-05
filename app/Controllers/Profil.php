<?php

namespace App\Controllers;

use App\Models\ModelProperty;
use App\Models\ModelSewa;

class Profil extends BaseController
{
    public function index()
    {
        $db = $this->db->table('profil');
        $db->where('id', 1);
        $profil = $db->get()->getRowArray();
        $data = [
            'title' => 'Pengaturan Profil',
            'profil' => $profil

        ];
        return view('profil/index', $data);
    }

    public function edit()
    {
        if ($this->request->isAJAX()) {
            $db = $this->db->table('pegawai');
            $db->select('pegawai.nama as pegawai, pegawai_jabatan.nama as jabatan');
            $db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id');
            $pegawai = $db->get()->getResultArray();

            $db = $this->db->table('profil');
            $db->where('id', 1);
            $profil = $db->get()->getRowArray();

            $data = [
                'pegawai' => $pegawai,
                'profil' => $profil
            ];

            $view = [
                'view' => view('profil/edit', $data)
            ];
            echo json_encode($view);
        }
    }
    public function update()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'nama' => $this->request->getVar('nama'),
                'ketua' => $this->request->getVar('pj'),
                'no_hp' => $this->request->getVar('telp'),
                'email' => $this->request->getVar('email'),
                'alamat' => $this->request->getVar('alamat'),

            ];

            $db = $this->db->table('profil');
            $db->where('id', 1);
            $profil = $db->update($data);



            $msg = [
                'sukses' => 'sukses'
            ];
            session()->setFlashdata('sukses', 'Data berhasil diubah');
            echo json_encode($msg);
        }
    }

    public function printer()
    {
        $db = $this->db->table('printer');
        $cek = $db->countAll();

        if ($cek > 0) {
            # code...
            $db = $this->db->table('printer');
            $db->orderBy('id', 'asc');
            $db->limit(1);
            $printer = $db->get()->getRowArray();

            $db = $this->db->table('printer');
            $db->where('id', $printer['id']);
            $printer = $db->get()->getRowArray();
        }

        $data = [
            'title' => 'Pengaturan Printer',
            'printer' => $printer,
            'cek' => $cek

        ];
        return view('profil/printer', $data);
    }

    public function create_printer()
    {
        if ($this->request->isAJAX()) {
            $view = [
                'view' => view('profil/create_printer')
            ];

            echo json_encode($view);
        }
    }

    public function edit_printer()
    {
        if ($this->request->isAJAX()) {

            $db = $this->db->table('printer');
            $db->where('id', $this->request->getVar('id'));
            $printer = $db->get()->getRowArray();
            $data = [
                'printer' => $printer
            ];

            $view = [
                'view' => view('profil/edit_printer', $data)
            ];

            echo json_encode($view);
        }
    }

    public function save_printer()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'printer' => $this->request->getVar('printer'),
                'nama_toko' => $this->request->getVar('nama'),
                'alamat' => $this->request->getVar('alamat'),
                'footer_1' => $this->request->getVar('footer_1'),
                'footer_2' => $this->request->getVar('footer_2'),
            ];

            if ($this->request->getVar('aksi') == 1) {
                $db = $this->db->table('printer');
                $db->insert($data);
            } else {
                $db = $this->db->table('printer');
                $db->update($data);
            }

            session()->setFlashdata('sukses', 'Data berhasil diubah');
            $data = [
                'sukses' => 'sukses'
            ];
            echo json_encode($data);
        }
    }
}
