<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelUsers;
use Myth\Auth\Entities\User;

class Users extends BaseController
{

	public function __construct()
	{
		$this->m_users = new ModelUsers();
	}

	public function index()
	{

		$data = [
			'title' => 'Users',
			'users' => $this->m_users->users()
		];


		return view('users/index', $data);
	}

	public function create()
	{
		if ($this->request->isAJAX()) {

			$db = $this->db->table('auth_groups');
			$role = $db->get()->getResultArray();

			$data = [
				'role' => $role
			];

			$view = [
				'view' => view('users/create', $data)
			];

			echo json_encode($view);
		}
	}

	public function cek_nik()
	{
		if ($this->request->isAJAX()) {
			$nik = $this->request->getVar('nik');

			$cek = $this->db->table('pegawai')->where('nik', $nik)->countAllResults();

			$cek2 = $this->db->table('users');
			$cek2->join('pegawai', 'pegawai.id = users.petugas_id', 'left');
			$cek2->where('pegawai.nik', $nik);
			$petugas = $cek2->countAllResults();

			if ($cek == 0) {
				$data = [
					'pegawai' => 0
				];
			} elseif ($petugas > 0) {
				$data = [
					'pegawai' => 1
				];
			} else {
				$db = $this->db->table('pegawai');
				$db->select('pegawai.id as pegawaiID, nik, pegawai.nama as pegawai, pegawai_jabatan.nama as jabatan');
				$db->join('pegawai_jabatan', 'pegawai_jabatan.id = pegawai.jabatan_id');
				$db->where('pegawai.nik', $nik);
				$pegawai = $db->get()->getRowArray();

				$data = [
					'pegawai' => $pegawai['pegawai'],
					'jabatan' => $pegawai['jabatan'],
					'pegawaiID' => $pegawai['pegawaiID']
				];
			}

			echo json_encode($data);
		}
	}

	public function save()
	{
		if ($this->request->isAJAX()) {
			$validation = \config\Services::validation();

			$validate = $this->validate([
				'role' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Role harus diisi',
					]
				],
				'username' => [
					'rules' => 'required|is_unique[users.username]',
					'errors' => [
						'required' => 'Username harus diisi',
						'is_unique' => 'Username telah terdaftar'
					]
				],
				'email' => [
					'rules' => 'required|valid_email|is_unique[users.email]',
					'errors' => [
						'required' => 'Email harus diisi',
						'valid_email' => 'Email tidak valid',
						'is_unique' => 'Email telah terdaftar'
					]
				],
				'password' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Password harus diisi',
					]
				],
				'confirm_password' => [
					'rules' => 'required|matches[password]',
					'errors' => [
						'required' => 'Password harus diisi',
						'matches' => 'Password tidak sesuai'
					]
				]
			]);

			if (!$validate) {
				$data = [
					'error' => [
						'role' => $validation->getError('role'),
						'username' => $validation->getError('username'),
						'email' => $validation->getError('email'),
						'password' => $validation->getError('password'),
						'confirm_password' => $validation->getError('confirm_password'),
					]
				];
			} else {

				$data = [
					'petugas_id' => $this->request->getVar('pegawaiID'),
					'username' => $this->request->getVar('username'),
					'email' => $this->request->getVar('email'),
					'password_hash' => password_hash(base64_encode(hash('sha384', $this->request->getVar('password'), true)), PASSWORD_DEFAULT),
					'active' => 1,
					'created_at' => date('Y-m-d H:i:s')
				];


				$group = $this->request->getVar('role');

				$this->m_users->simpan($data, $group);

				$data = [
					'sukses' => 'sukses'
				];
				session()->setFlashdata('sukses', 'User berhasil ditambahkan!');
			}

			echo json_encode($data);
		}
	}

	public function edit()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('id');

			$db = $this->db->table('users');
			$db->select('*, users.id as userID, pegawai_jabatan.nama as jabatan, pegawai.nama as pegawai');
			$db->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
			$db->join('pegawai', 'pegawai.id = users.petugas_id');
			$db->join('pegawai_jabatan', 'pegawai.jabatan_id = pegawai_jabatan.id');
			$db->where('users.id', $id);
			$user = $db->get()->getRowArray();

			$db = $this->db->table('auth_groups');
			$role = $db->get()->getResultArray();

			$data = [
				'user' => $user,
				'role' => $role
			];

			$view = [
				'view' => view('users/edit', $data)
			];

			echo json_encode($view);
		}
	}

	public function update()
	{
		if ($this->request->isAJAX()) {
			$validation = \config\Services::validation();

			$username_old = $this->request->getVar('username_old');
			$username_new = $this->request->getVar('username');

			if ($username_old != $username_new) {
				$rules_username = 'required|is_unique[users.username]';
			} else {
				$rules_username = 'required';
			}

			$email_old = $this->request->getVar('email_old');
			$email_new = $this->request->getVar('email');

			if ($email_old != $email_new) {
				$rules_email = 'required|is_unique[users.email]|valid_email';
			} else {
				$rules_email = 'required';
			}

			$validate = $this->validate([
				'role' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Role harus diisi',
					]
				],
				'username' => [
					'rules' => $rules_username,
					'errors' => [
						'required' => 'Username harus diisi',
						'is_unique' => 'Username telah terdaftar'
					]
				],
				'email' => [
					'rules' => $rules_email,
					'errors' => [
						'required' => 'Email harus diisi',
						'valid_email' => 'Email tidak valid',
						'is_unique' => 'Email telah terdaftar'
					]
				]

			]);

			if (!$validate) {
				$data = [
					'error' => [
						'role' => $validation->getError('role'),
						'username' => $validation->getError('username'),
						'email' => $validation->getError('email'),
					]
				];
			} else {


				$data = [
					'username' => $this->request->getVar('username'),
					'email' => $this->request->getVar('email'),
					'active' => $this->request->getVar('status'),
					'updated_at' => date('Y-m-d H:i:s')
				];


				$group = $this->request->getVar('role');
				$user = $this->request->getVar('user');

				$this->m_users->updated($data, $group, $user);

				$data = [
					'sukses' => 'sukses'
				];
				session()->setFlashdata('sukses', 'User berhasil diubah!');
			}

			echo json_encode($data);
		}
	}

	public function resetPassword()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('id');

			$db = $this->db->table('users');
			$db->select('*, users.id as userID, pegawai_jabatan.nama as jabatan, pegawai.nama as pegawai');
			$db->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
			$db->join('pegawai', 'pegawai.id = users.petugas_id');
			$db->join('pegawai_jabatan', 'pegawai.jabatan_id = pegawai_jabatan.id');
			$db->where('users.id', $id);
			$user = $db->get()->getRowArray();

			$db = $this->db->table('auth_groups');
			$role = $db->get()->getResultArray();

			$data = [
				'user' => $user,
				'role' => $role
			];

			$view = [
				'view' => view('users/reset_password', $data)
			];

			echo json_encode($view);
		}
	}
	public function updatePassword()
	{
		if ($this->request->isAJAX()) {
			$validation = \config\Services::validation();

			$validate = $this->validate([
				'password' => [
					'rules' => 'required',
					'errors' => [
						'required' => 'Password harus diisi',
					]
				],
				'confirm_password' => [
					'rules' => 'required|matches[password]',
					'errors' => [
						'required' => 'Password harus diisi',
						'matches' => 'Password tidak sesuai'
					]
				]
			]);

			if (!$validate) {
				$data = [
					'error' => [
						'password' => $validation->getError('password'),
						'confirm_password' => $validation->getError('confirm_password'),
					]
				];
			} else {

				$data = [
					'password_hash' => password_hash(base64_encode(hash('sha384', $this->request->getVar('password'), true)), PASSWORD_DEFAULT),
					'updated_at' => date('Y-m-d H:i:s')
				];


				$db = $this->db->table('users');
				$db->where('id', $this->request->getVar('user'));
				$db->update($data);

				$data = [
					'sukses' => 'sukses'
				];
				session()->setFlashdata('sukses', 'password berhasil diubah!');
			}

			echo json_encode($data);
		}
	}

	public function delete()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('id');

			$db = $this->db->table('users');
			$db->where('id', $id);
			$db->delete();
			$data = [
				'sukses' => 'sukses'
			];
			session()->setFlashdata('sukses', 'User berhasil dihapus!');
			echo json_encode($data);
		}
	}
}
