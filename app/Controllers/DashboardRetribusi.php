<?php

namespace App\Controllers;

use App\Models\ModelProperty;
use App\Models\ModelSewa;

class DashboardRetribusi extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',

        ];
        return view('home/index_retribusi', $data);
    }
}
