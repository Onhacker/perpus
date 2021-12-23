<?php
class Admin_Controller extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->timezone();
		$this->load->helper("cpu");
		cek_session_on_login();	
		$this->load->model("Ram_model","om");
		$this->load->helper("on");
		error_reporting(0);

	}

	

	function render($data){
		$this->om->validasiOnLogin();     // keluarkan jika perintah keluarkan dari prangkat lain
		$this->load->view("backend/admin_template",$data);
	}

	function timezone(){
		$this->db->where("id_identitas", "1");
		$s = $this->db->get("identitas")->row();
		return date_default_timezone_set($s->waktu);
	}

	function format_header($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(
					"borders" => array("top"        =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => true,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format($arr) {
		foreach($arr['arr_kolom'] as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $arr['baris'])->applyFromArray(
				array(
					"borders" => array("top"        =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => $arr['bold'],
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => isset($arr['align'])?PHPExcel_Style_Alignment::HORIZONTAL_CENTER:PHPExcel_Style_Alignment::HORIZONTAL_LEFT ,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_baris($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(
					"borders" => array("top"        =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_center($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_center_header($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => true,
						'italic'    => false,
						'size'        => 14
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_left($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_center_line($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(
					"borders" => array("top"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

}
?>