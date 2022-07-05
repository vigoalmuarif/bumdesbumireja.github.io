<?php

namespace App\Controllers;

use App\Models\ModelProperty;

class Property extends BaseController
{
    public function __construct()
    {
        $this->propertyModel = new ModelProperty();
    }
    public function type($id = null)
    {
        $uri = Service('uri');
        $id = $uri->getsegment(3);

        $property = $this->propertyModel->getAll($id);
        $validation =  \Config\Services::validation();

        $data = [
            'title' => 'Property',
            'property' => $property,
            'validation' => $validation
        ];
        return view('master/properti/index', $data);
    }

    public function kios()
    {

        $property = $this->propertyModel->getKios();
        $validation =  \Config\Services::validation();

        $data = [
            'title' => 'Property Kios',
            'property' => $property,
            'validation' => $validation
        ];
        return view('master/properti/kios', $data);
    }

    public function lapak()
    {

        $property = $this->propertyModel->getlapak();
        $validation =  \Config\Services::validation();

        $data = [
            'title' => 'Property Lapak',
            'property' => $property,
            'validation' => $validation
        ];
        return view('master/properti/lapak', $data);
    }


    public function create()
    {

        $validation =  \Config\Services::validation();

        $data = [
            'title' => 'Form Tambah Property',
            'validation' => $validation
        ];
        return view('master/properti/create', $data);
    }

    public function save()
    {
        if (!$this->validate(
            [
                'jenis_property' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis property harus diisi!'
                    ]
                ],
                'kode_property' => [
                    'rules' => 'required|is_unique[property.kode_property]',
                    'errors' => [
                        'required' => 'Kode property harus diisi!',
                        'is_unique' => 'Kode property sudah digunakan sebelumnya.'
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi!',
                    ]
                ],
                'luas_tanah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Luas tanah harus diisi!'
                    ]
                ],
                'luas_bangunan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Luas bangunan harus diisi!'
                    ]
                ],
                'jangka' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempo harus diisi!'
                    ]
                ],
                'harga' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga harus diisi!'
                    ]
                ],
                'fasilitas' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Fasilitas property harus diisi!'
                    ]
                ],
                'gambar' => [
                    'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,5120]',
                    'errors' => [
                        'is_image' => 'Yang anda masukan bukan gambar',
                        'mime_in' => 'Yang anda masukan bukan gambar',
                        'max_size' => 'Ukuran gambar terlalu besar'
                    ]
                ],
            ]
        )) {
            $validation =  \Config\Services::validation();
            $data = [
                'title' => 'Form Tambah Property',
                'validation' => $validation
            ];
            return view('master/properti/create', $data);
        }
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('img/upload/', $namaGambar);

        $data = [
            'jenis_property' => $this->request->getVar('jenis_property'),
            'alamat' => $this->request->getVar('alamat'),
            'kode_property' => $this->request->getVar('kode_property'),
            'luas_tanah' => $this->request->getVar('luas_tanah'),
            'luas_bangunan' => $this->request->getVar('luas_bangunan'),
            'jangka' => $this->request->getVar('jangka'),
            'harga' => str_replace(',', '', $this->request->getVar('harga')),
            'fasilitas' => $this->request->getVar('fasilitas'),
            'keterangan' => $this->request->getVar('keterangan'),
            'gambar' => $namaGambar,
            'status' => 1
        ];

        $this->propertyModel->insert($data);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan!');
        return redirect()->to('/property/type/semua');
    }


    public function detail($id)
    {
        $property_id = $this->propertyModel->getAll($id);
        $data = [
            'title' => 'Detail Property',
            'property_id' => $property_id

        ];
        return view('master/properti/detail', $data);
    }
    public function edit($id)
    {
        $validation =  \Config\Services::validation();
        $property_id = $this->propertyModel->getAll($id);
        $data = [
            'title' => 'Detail Property',
            'property_id' => $property_id,
            'validation' => $validation
        ];
        return view('master/properti/edit', $data);
    }

    public function update($id)
    {
        $kode = $this->propertyModel->getAll($id);
        $kode_lama = $kode['kode_property'];
        $kode_baru = $this->request->getVar('kode_property');

        if ($kode_lama == $kode_baru) {
            $rules = 'required';
        } else {
            $rules = 'required|is_unique[property.kode_property]';
        }


        if (!$this->validate(
            [
                'jenis_property' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenis property harus diisi!'
                    ]
                ],
                'kode_property' => [
                    'rules' => $rules,
                    'errors' => [
                        'required' => 'Kode property harus diisi!',
                        'is_unique' => 'Kode property sudah digunakan sebelumnya.'
                    ]
                ],
                'alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat harus diisi!',
                    ]
                ],
                'luas_tanah' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Luas tanah harus diisi!'
                    ]
                ],
                'luas_bangunan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Luas bangunan harus diisi!'
                    ]
                ],
                'jangka' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tempo harus diisi!'
                    ]
                ],
                'harga' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga harus diisi!'
                    ]
                ],
                'fasilitas' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Fasilitas property harus diisi!'
                    ]
                ],
                'gambar' => [
                    'rules' => 'is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|max_size[gambar,5120]',
                    'errors' => [
                        'is_image' => 'Yang anda masukan bukan gambar',
                        'mime_in' => 'Yang anda masukan bukan gambar',
                        'max_size' => 'Ukuran gambar terlalu besar'
                    ]
                ],


            ]
        )) {

            $validation =  \Config\Services::validation();
            $data = [
                'title' => 'Form Ubah Property',
                'validation' => $validation,
                'property_id' => $this->propertyModel->getAll($id)
            ];

            return view('master/properti/edit', $data);
        }

        $gambar_old = $this->request->getVar('gambar_old');
        $fileGambar = $this->request->getFile('gambar');
        // dd($fileGambar);
        if ($fileGambar->getError() == 4) {
            $namaGambar = $gambar_old;
        } else {
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img/upload', $namaGambar);
        }

        if ($gambar_old !== 'store.png') {
            unlink('img/upload/' . $gambar_old);
        }
        $data = [
            'jenis_property' => $this->request->getVar('jenis_property'),
            'alamat' => $this->request->getVar('alamat'),
            'kode_property' => $this->request->getVar('kode_property'),
            'luas_tanah' => $this->request->getVar('luas_tanah'),
            'luas_bangunan' => $this->request->getVar('luas_bangunan'),
            'jangka' => $this->request->getVar('jangka'),
            'harga' => str_replace(',', '', $this->request->getVar('harga')),
            'fasilitas' => $this->request->getVar('fasilitas'),
            'keterangan' => $this->request->getVar('keterangan'),
            'gambar' => $namaGambar
        ];

        $this->propertyModel->update($id, $data);


        session()->setFlashdata('pesan', 'Data berhasil diubah!');
        return redirect()->to('/property/type/semua');
    }

    public function delete($id)
    {
        $db = $this->db->table('property');
        $db->where('property_id', $id);
        $gambar = $db->get()->getRowArray();

        if ($gambar['gambar'] != 'store.png') {
            unlink('img/upload/' . $gambar['gambar']);
        }
        $this->propertyModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        return redirect()->to('/property/type/semua');
    }
}
