<?php

namespace App\Controllers;

use App\Models\ModelProduk;

class Stok extends BaseController
{

    public function __construct()
    {
        $this->produkModel = new ModelProduk();
    }
    public function index()
    {
        $data = [
            'title' => 'Stok Produk ATK',
            'produk' => $this->produkModel->getStok()
        ];
        return view('master/produk/index', $data);
    }
}
