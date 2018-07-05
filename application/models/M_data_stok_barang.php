<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class  M_data_stok_barang extends CI_Model {
    public function select_all_data_stok_barang(){
        $sql = "SELECT * FROM data_stok_barang";

        $data = $this->db->query($sql);

        return $data->result();
    }

    public function select_all() {
        $sql = "SELECT data_stok_barang.id AS id, data_stok_barang.nama_barang AS nama_barang, merk.nama_merk AS merk, ukuran.ukuran AS ukuran FROM data_stok_barang, merk, ukuran WHERE data_stok_barang.id_ukuran = ukuran.id AND data_stok_barang.id_merk = merk.id";

        $data = $this->db->query($sql);

        return $data->result();
    }

    public function select_by_id($id) {
        $sql = "SELECT data_stok_barang.id AS id_data_stok_barang, data_stok_barang.nama_barang AS nama_barang, data_stok_barang.id_merk, data_stok_barang.id_ukuran, merk.nama_merk AS merk, ukuran.ukuran AS ukuran FROM data_stok_barang, merk, ukuran WHERE data_stok_barang.id_merk = merk.id AND data_stok_barang.id_ukuran = ukuran.id = '{$id}'";

        $data = $this->db->query($sql);

        return $data->row();
    }

    public function select_by_merk($id) {
        $sql = "SELECT COUNT(*) AS jml FROM data_stok_barang WHERE id_merk = {$id}";

        $data = $this->db->query($sql);

        return $data->row();
    }

    public function select_by_ukuran($id) {
        $sql = "SELECT COUNT(*) AS jml FROM data_stok_barang WHERE id_ukuran = {$id}";

        $data = $this->db->query($sql);

        return $data->row();

    }

    public function update($data) {
        $sql = "UPDATE data_stok_barang SET nama_barang='" .$data['nama_barang'] ."', id_merk=" .$data['nama_merk'] .", id_ukuran=" .$data['ukuran'] ." WHERE id='" .$data['id'] ."'";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function delete($id) {
		$sql = "DELETE FROM data_stok_barang WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
    }
    
    public function insert($data) {
        $id = md5(DATE('ymdhms').rand());
        $sql = "INSERT INTO data_stok_barang VALUES('{$id}', '" .$data['nama_barang'] ."', " .$data['nama_merk'] .", " .$data['ukuran'] .",1)";

        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    public function insert_batch($data) {
		$this->db->insert_batch('data_stok_barang', $data);
		
		return $this->db->affected_rows();
    }
    
    public function check_nama_barang($nama_barang) {
		$this->db->where('nama', $nama_barang);
		$data = $this->db->get('data_stok_barang');

		return $data->num_rows();
    }
    
    public function total_rows() {
		$data = $this->db->get('data_Stok_barang');

		return $data->num_rows();
	}



}