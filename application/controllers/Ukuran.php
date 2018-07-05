<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ukuran extends AUTH_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('M_ukuran');
	}

	public function index() {
		$data['userdata'] 	= $this->userdata;
		$data['dataUkuran'] 	= $this->M_ukuran->select_all();

		$data['page'] 		= "Ukuran";
		$data['judul'] 		= "Data Ukuran";
		$data['deskripsi'] 	= "Manage Data Ukuran";

		$data['modal_tambah_ukuran'] = show_my_modal('modals/modal_tambah_ukuran', 'tambah-ukuran', $data);

		$this->template->views('ukuran/home', $data);
	}

	public function tampil() {
		$data['dataUkuran'] = $this->M_ukuran->select_all();
		$this->load->view('ukuran/list_data', $data);
	}

	public function prosesTambah() {
		$this->form_validation->set_rules('ukuran', 'Ukuran', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_ukuran->insert($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Ukuran Berhasil ditambahkan', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_err_msg('Data Ukuran Gagal ditambahkan', '20px');
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
		$data['dataUkuran'] 	= $this->M_ukuran->select_by_id($id);

		echo show_my_modal('modals/modal_update_ukuran', 'update-ukuran', $data);
	}

	public function prosesUpdate() {
		$this->form_validation->set_rules('ukuran', 'Ukuran', 'trim|required');

		$data 	= $this->input->post();
		if ($this->form_validation->run() == TRUE) {
			$result = $this->M_ukuran->update($data);

			if ($result > 0) {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Ukuran Berhasil diupdate', '20px');
			} else {
				$out['status'] = '';
				$out['msg'] = show_succ_msg('Data Ukuran Gagal diupdate', '20px');
			}
		} else {
			$out['status'] = 'form';
			$out['msg'] = show_err_msg(validation_errors());
		}

		echo json_encode($out);
	}

	public function delete() {
		$id = $_POST['id'];
		$result = $this->M_ukuran->delete($id);
		
		if ($result > 0) {
			echo show_succ_msg('Data Ukuran Berhasil dihapus', '20px');
		} else {
			echo show_err_msg('Data Ukuran Gagal dihapus', '20px');
		}
	}

	public function detail() {
		$data['userdata'] 	= $this->userdata;

		$id 				= trim($_POST['id']);
		$data['ukuran'] = $this->M_ukuran->select_by_id($id);
		$data['jumlahUkuran'] = $this->M_ukuran->total_rows();
		$data['dataUkuran'] = $this->M_ukuran->select_by_data_stok_barang($id);

		echo show_my_modal('modals/modal_detail_ukuran', 'detail-ukuran', $data, 'lg');
	}

	public function export() {
		error_reporting(E_ALL);
    
		include_once './assets/phpexcel/Classes/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		$data = $this->M_ukuran->select_all();

		$objPHPExcel = new PHPExcel(); 
		$objPHPExcel->setActiveSheetIndex(0); 

		$objPHPExcel->getActiveSheet()->SetCellValue('A', "ID"); 
		$objPHPExcel->getActiveSheet()->SetCellValue('B', "Nama Ukuran");

		$rowCount = 2;
		foreach($data as $value){
		    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value->id); 
		    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value->ukuran); 
		    $rowCount++; 
		} 

		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
		$objWriter->save('./assets/excel/Data Ukuran.xlsx'); 

		$this->load->helper('download');
		force_download('./assets/excel/Data Ukuran.xlsx', NULL);
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
						$check = $this->M_ukuran->check_ukuran($value['B']);

						if ($check != 1) {
							$resultData[$index]['ukuran'] = ucwords($value['B']);
						}
					}
					$index++;
				}

				unlink('./assets/excel/' .$data['file_name']);

				if (count($resultData) != 0) {
					$result = $this->M_ukuran->insert_batch($resultData);
					if ($result > 0) {
						$this->session->set_flashdata('msg', show_succ_msg('Data Ukuran Berhasil diimport ke database'));
						redirect('Ukuran');
					}
				} else {
					$this->session->set_flashdata('msg', show_msg('Data Ukuran Gagal diimport ke database (Data Sudah terupdate)', 'warning', 'fa-warning'));
					redirect('Ukuran');
				}

			}
		}
	}
}