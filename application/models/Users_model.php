<?php
class Users_model extends CI_Model
{
    public function login($username = null, $password = null)
    {
        $this->db->select('*');
        $this->db->from('users');
        if ($username != null) {
            $this->db->where('username', $username);
        }
        if ($password != null) {
            $this->db->where('password', md5($password));
        }
        return $this->db->get();
    }
    public function joinProfile($id_users = null, $id_users_not = null, $cek = null, $forgot = null, $username = null)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->join('profile', 'users.id_users = profile.users_id');
        if ($id_users != null) {
            $this->db->where('users.id_users', $id_users);
        }
        if ($id_users_not !=  null) {
            $this->db->where('users.id_users <> ', $id_users_not);
        }
        if ($cek != null) {
            $this->db->where('users.level', $cek);
        }
        if ($forgot != null) {
            $this->db->where('users.forgot', $forgot);
        }
        if ($username != null) {
            $this->db->where('users.username', $username);
        }
        return $this->db->get();
    }
    public function getCookie($cookie = null)
    {
        $this->db->select('*');
        $this->db->from('users');
        if ($cookie != null) {
            $this->db->where('cookie', $cookie);
        }
        return $this->db->get();
    }

    public function update_users($data, $id_users)
    {
        $this->db->where('id_users', $id_users);
        $this->db->update('users', $data);
        return $this->db->affected_rows();
    }
    public function update_profile($data, $id_users)
    {
        $this->db->where('users_id', $id_users);
        $this->db->update('profile', $data);
        return $this->db->affected_rows();
    }
    public function insert_users($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }
    public function insert_profile($data)
    {
        $this->db->insert('profile', $data);
        return $this->db->insert_id();
    }
    public function delete($id_users)
    {
        $this->db->delete('users', ['id_users' => $id_users]);
        return $this->db->affected_rows();
    }
}
