<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_stok_barang extends AUTH_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('M_data_stok_barang');
        $this->load->model('M_merk');
		$this->load->model('M_ukuran');
    }

    public function index(){
        $data['userdata'] = $this->userdata;
        $data['dataDataStokBarang'] = $this->M_data_stok_barang->select_all();
        $data['dataMerk'] = $this->M_merk->select_all();
        $data['dataUkuran'] = $this->M_ukuran->select_all();

        $data['page']		= "stok barang";
		$data['judul']		= "Data Stok Barang";
        $data['deskripsi']	= "CRUD Stok Keramik";
        
        $data['modal_tambah_data_stok_barang'] = show_my_modal('modals/modal_tambah_data_stok_barang', 'tambah-stok', $data);

        $this->template->views('data_stok_barang/home', $data);
    }

    public function tampil(){
        $data['dataDataStokBarang'] = $this->M_data_stok_barang->select_all();
        $this->load->view('data_stok_barang/list_data', $data);
    }

    public function prosesTambah(){
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('nama_merk', 'Merk', 'trim|required');
        $this->form_validation->set_rules('ukuran', 'Ukuran', 'trim|required');

        $data = $this->input->post();
        if($this->form_validation->run() == TRUE) {
            $result = $this->M_data_stok_barang->insert($data);

            if($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Stok Barang Berhasil ditambahkan');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Stok Barang Gagal ditambahkan');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function update() {
        $id = trim($_POST['id']);

        $data['dataDataStokBarang'] = $this->M_data_stok_barang->select_by_id($id);
        $data['dataMerk'] = $this->M_merk->select_all();
        $data['dataUkuran'] = $this->M_ukuran->select_all();
        $data['userdata'] = $this->userdata;

        echo show_my_modal('modals/modal_update_data_stok_barang', 'update-stok', $data);
    }

    public function prosesUpdate() {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required');
        $this->form_validation->set_rules('nama_merk', 'Merk', 'trim|required');
        $this->form_validation->set_rules('ukuran', 'Ukuran', 'trim|required');

        $data = $this->input->post();
        if($this->form_validation->run() == TRUE) {
            $result = $this->M_data_stok_barang->update($data);

            if($result > 0) {
                $out['status'] = '';
                $out['msg'] = show_succ_msg('Data Stok Barang Berhasil diupdate');
            } else {
                $out['status'] = '';
                $out['msg'] = show_err_msg('Data Stok Barang Gagal diupddate');
            }
        } else {
            $out['status'] = 'form';
            $out['msg'] = show_err_msg(validation_errors());
        }

        echo json_encode($out);
    }

    public function delete(){
        $id = $_POST['id'];
        $result = $this->M_data_stok_barang->delete($id);

        if($result > 0){
            echo show_succ_msg('Data Stok Barang Berhasil dihapus', '20px');
        } else {
            echo show_err_msg('Data Stok Barang Gagal dihapus', '20px');
        }
    }

    //fungsi untuk melakukan export data ke local directory berformat excel
    public function export() {
        error_reporting(E_ALL);

        include_once './assets/phpexcel/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

        $data = $this->M_data_stok_barang->select_all_data_stok_barang();

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $rowCount = 1;

        $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, "ID");
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, "Nama Barang");
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, "ID Merk");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, "ID Ukuran");
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, "Status");
        $rowCount++;

        foreach($data as $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $value->id);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount, $value->nama_barang);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount, $value->id_merk);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount, $value->id_ukuran);
          
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount, $value->status);
            $rowCount++;
        }

        //membuat objek untuk inisialisasi excel format yang digunakan
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('./assets/excel/Data Stok Barang.xlsx');

        $this->load->helper('download');
        force_download('./assets/excel/Data Stok Barang.xlsx', NULL);
    }

    //fungsi untuk melakukan import data excel ke database
    public function import() {
        $this->form_validation->set_rules('excel', 'File', 'trim|required');

        if($_FILES['excel']['name'] == ''){
            $this->session->set_flashdata('msg', 'File harus diisi');
        } else {
            $config['upload_path'] = './assets/excel/';
            $config['allowed_types'] = 'xls|xlsx';

            $this->load->library('upload', $config);

            //kondisi upload bukan tipe excel
            if(! $this->upload->do_upload('excel')){
                $error = array('error' => $this->upload->display_errors());
            } else{
                $data = $this->upload->data();

                error_reporting(E_ALL);
                date_default_timezone_set('Asia/Jakarta');

                include './assets/phpexcel/Classes/PHPExcel/IOFactory.php';

                $inputFileName ='./assets/excel/' .$data['file_name'];
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

                $index = 0;
                foreach($sheetData as $key => $value) {
                    if($key != 1){
                        $id = md5(DATE('ymdhms').rand());
                        $check = $this->M_data_stok_barang->check_nama_barang($value['B']);

                        if($check != 1) {
                            $resultData[$index]['id'] = $id;
                            $resultData[$index]['nama_barang'] = ucwords($value['B']);
                            $resultData[$index]['id_merk'] = $value['C'];
                            $resultData[$index]['id_ukuran'] = $value['D'];
                            $resultData[$index]['status'] = $value['F'];
                        }
                    }
                    $index++;
                }

                unlink('./assets/excel/' .$data['file_name']);

                if(count($resultData) != 0) {
                    $result = $this->M_data_stok_barang->insert_batch($resultData);
                    if($result > 0){
                        $this->session->set_flashdata('msg', show_succ_msg('Data Stok Barang Berhasil diimport ke database'));
                        redirect('Data_stok_barang');
                    }
                }
                else {
                    $this->session->set_flashdata('msg', show_msg('Data Stok Barang Gagal diimport ke database (Data sudah terupdate)', 'warning', 'fa-warning'));
                    redirect('Data_stok_barang');
                }
            }
        }
    }
}