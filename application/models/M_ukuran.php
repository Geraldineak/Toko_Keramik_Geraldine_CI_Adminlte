<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ukuran extends CI_Model {
	public function select_all() {
		$this->db->select('*');
		$this->db->from('ukuran');

		$data = $this->db->get();

		return $data->result();
	}

	public function select_by_id($id) {
		$sql = "SELECT * FROM ukuran WHERE id = '{$id}'";

		$data = $this->db->query($sql);

		return $data->row();
	}

	public function select_by_data_stok_barang($id) {
		$sql = " SELECT data_stok_barang.id AS id, data_stok_barang.nama_barang AS data_stok_barang, merk.nama_merk AS merk, ukuran.ukuran AS ukuran FROM data_stok_barang, merk, ukuran WHERE data_stok_barang.id_ukuran = ukuran.id AND data_stok_barang.id_merk = merk.id AND data_stok_barang.id_ukuran={$id}";

		$data = $this->db->query($sql);

		return $data->result();
	}

	public function insert($data) {
		$sql = "INSERT INTO ukuran VALUES('','" .$data['ukuran'] ."')";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function insert_batch($data) {
		$this->db->insert_batch('ukuran', $data);
		
		return $this->db->affected_rows();
	}

	public function update($data) {
		$sql = "UPDATE ukuran SET ukuran='" .$data['ukuran'] ."' WHERE id='" .$data['id'] ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function delete($id) {
		$sql = "DELETE FROM ukuran WHERE id='" .$id ."'";

		$this->db->query($sql);

		return $this->db->affected_rows();
	}

	public function check_ukuran($ukuran) {
		$this->db->where('ukuran', $ukuran);
		$data = $this->db->get('ukuran');

		return $data->num_rows();
	}

	public function total_rows() {
		$data = $this->db->get('ukuran');

		return $data->num_rows();
	}
}