<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_data_stok_barang');
		$this->load->model('M_merk');
		$this->load->model('M_ukuran');

	}

	public function index()
	{
		$data['jml_data_stok_barang']	= $this->M_data_stok_barang->total_rows();
		$data['jml_merk']				= $this->M_merk->total_rows();
		$data['jml_ukuran']				= $this->M_ukuran->total_rows();
		$data['userdata']				= $this->userdata;

		//membuat nilai matriks hexa untuk warna acak
		$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');

		//charts untuk merk
		$merk						= $this->M_merk->select_all();
		$index = 0;
		foreach ($merk as $value) {
			$color = '#' .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)];

			$data_stok_barang_by_merk = $this->M_data_stok_barang->select_by_merk($value->id);

			$data_merk[$index]['value'] = $data_stok_barang_by_merk->jml;
			$data_merk[$index]['color'] = $color;
			$data_merk[$index]['highlight'] = $color;
			$data_merk[$index]['label'] = $value->nama_merk;

			$index++;
		}
		//charts untuk ukuran
		$ukuran	= $this->M_ukuran->select_all();
		$index = 0;
		foreach ($ukuran as $value) {
			$color = '#' .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)] .$rand[rand(0,15)];

			$data_stok_barang_by_ukuran = $this->M_data_stok_barang->select_by_ukuran($value->id);

			$data_ukuran[$index]['value'] = $data_stok_barang_by_ukuran->jml;
			$data_ukuran[$index]['color'] = $color;
			$data_ukuran[$index]['highlight'] = $color;
			$data_ukuran[$index]['label'] = $value->ukuran;

			$index++;
		}

		$data['data_merk'] = json_encode($data_merk);
		$data['data_ukuran'] = json_encode($data_ukuran);

		$data['page']		= "home";
		$data['judul']		= "Beranda";
		$data['deskripsi']	= "CRUD Stok Data Keramik";

		$this->template->views('home', $data);
	}
}
