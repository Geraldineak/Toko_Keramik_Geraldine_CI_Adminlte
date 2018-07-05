<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use AUTH_Controller;

class Merk extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_merk');
	}

	public function index() {
		$data['userdata'] 	= $this->userdata;
		$data['dataMerk'] 	= $this->M_merk->select_all();

		$data['page'] 		= "merk";
		$data['judul'] 		= "Data Merk";
		$data['deskripsi'] 	= "Manage Data Merk";

		$data['modal_tambah_merk'] = show_my_modal('modals/modal_tambah_merk', 'tambah-merk', $data);

		$this->template->views('merk/home', $data);
	}

	public function tampil() {
		$data['dataMerk'] = $this->M_merk->select_all();
		$this->load->view('merk/list_data', $data);
	}

	public function prosesTambah() {
		$this->form_validation->set_rules('nama_merk', 'Merk', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_merk->insert($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Merk Berhasil ditambahkan', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Data Merk Gagal ditambahkan', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function update() {
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['dataMerk'] 	= $this->M_merk->select_by_id($id);

		echo show_my_modal('modals/modal_update_merk', 'update-merk', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('nama_merk', 'Merk', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_merk->update($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Merk Berhasil diupdate', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Merk Gagal diupdate', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['id'];
		$result = $this->M_merk->delete($id);
		
		if ($result > 0) {
			echo show_succ_msg('Data Merk Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Merk Gagal dihapus', '20px');
		}
	}

	public function detail() {
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['nama_merk'] = $this->M_merk->select_by_id($id);
		$data['jumlahMerk'] = $this->M_merk->total_rows();
		$data['dataMerk'] = $this->M_merk->select_by_data_stok_barang($id);

		echo show_my_modal('modals/modal_detail_merk', 'detail-merk', $data, 'lg');
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_merk->select_all();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 

		$objPHPExcel->getActiveSheet()->SetCellValue('A1', "ID"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', "Nama Merk");

		$rowCount = 2;
		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->nama_merk); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Data Merk.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/Data Merk.xlsx', NULL);
	}

	public function import() {
		$this->form_validation->set_rules('excel', 'File', 'trim|required');

		if ($_FILES['excel']['name'] == '') {
			$this->session->set_flashdata('msg', 'File harus diisi');
		} else {
			$config['upload_path'] = './assets/excel/';
			$config['allowed_types'] = 'xls|xlsx';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('excel')){
				$error = array('error' => $this->upload->display_errors());
			}
			else{
				$data = $this->upload->data();
				
				error_reporting(E_ALL);
				date_default_timezone_set('Asia/Jakarta');

				include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

				$inputFileName = './assets/excel/' .$data['file_name'];
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

				$index = 0;
				foreach ($sheetData as $key => $value) {
					if ($key != 1) {
						$check = $this->M_merk->check_nama_merk($value['B']);

						if ($check != 1) {
							$resultData[$index]['nama_merk'] = ucwords($value['B']);
						}
					}
					$index++;
				}

				unlink('./assets/excel/' .$data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_merk->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Data Merk Berhasil diimport ke database'));
						redirect('Merk');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Data Merk Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
					redirect('Merk');
				}

			}
		}
	}
}