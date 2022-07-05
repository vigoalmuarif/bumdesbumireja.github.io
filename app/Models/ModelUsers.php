<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelUsers extends Model
{

	public function users()
	{
		$db = $this->db->table('users');
		$db->select('*, users.id as userID, auth_groups.name as role');
		$db->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
		$db->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
		$db->join('pegawai', 'pegawai.id = users.petugas_id');
		return $db->get()->getResultArray();
	}

	public function simpan($data, $group)
	{
		$this->db->transStart();

		$db = $this->db->table('users');
		$db->insert($data);

		$user_id = $this->insertID();

		$db = $this->db->table('auth_groups_users');
		$db->insert([
			'user_id' => $user_id,
			'group_id' => $group
		]);

		$this->db->transComplete();
	}
	public function updated($data, $group, $user)
	{
		$this->db->transStart();

		$db = $this->db->table('users');
		$db->where('id', $user);
		$db->update($data);

		$db = $this->db->table('auth_groups_users');
		$db->where('user_id', $user);
		$db->update([
			'group_id' => $group
		]);

		$this->db->transComplete();
	}
}
