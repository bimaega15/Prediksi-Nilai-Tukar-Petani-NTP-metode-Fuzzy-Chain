<?php
class DataPenerapan_model extends CI_Model
{
    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('data_penerapan');
        if ($id != null) {
            $this->db->where('id_data_penerapan', $id);
        }
        return $this->db->get();
    }
    public function update($data, $id_data_penerapan)
    {
        $this->db->where('id_data_penerapan', $id_data_penerapan);
        $this->db->update('data_penerapan', $data);
        return $this->db->affected_rows();
    }
    public function insert($data)
    {
        $this->db->insert('data_penerapan', $data);
        return $this->db->affected_rows();
    }
    public function delete($id_data_penerapan)
    {
        $this->db->delete('data_penerapan', ['id_data_penerapan' => $id_data_penerapan]);
        return $this->db->affected_rows();
    }
    public function grafikPenerapan()
    {
        $this->db->select('*, sum(ntp) as jumlah_ntp');
        $this->db->from('data_penerapan');
        $this->db->group_by('tanggal');
        return $this->db->get();
    }

    public function minData()
    {
        $this->db->select('min(ntp) as min');
        $this->db->from('data_penerapan');
        return $this->db->get();
    }
    public function maxData()
    {
        $this->db->select('max(ntp) as max');
        $this->db->from('data_penerapan');
        return $this->db->get();
    }
    public function jumlahData()
    {
        $this->db->select('count(*) as jumlah_data');
        $this->db->from('data_penerapan');
        return $this->db->get();
    }
}
