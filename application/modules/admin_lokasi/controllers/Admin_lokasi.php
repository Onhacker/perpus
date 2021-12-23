<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_lokasi extends Admin_operator {
	function __construct(){
		parent::__construct();
		// cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
	}

	function index(){
		
		$data["controller"] = get_class($this);
		$data["record"] = $this->om->edit('sekolah', array('id_sekolah' => $this->session->userdata("op_username")))->row();
		$data["title"] = "Sekolah";
		$data["subtitle"] = "Pengaturan Lokasi Sekolah" ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	function update(){
		$data = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('lintang','Lintang','required'); 
		$this->form_validation->set_rules('bujur','Bujur','required'); 
		// $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email'); 
		// $this->form_validation->set_rules('no_telp','No Telpon','trim|numeric|required|min_length[10]|max_length[12]'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		// $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
		// $this->form_validation->set_message('numeric', '* %s Harus angka ');
		// $this->form_validation->set_message('valid_url', '* %s Tidak Valid ');
		// $this->form_validation->set_message('required', '* %s Harus diisi ');
		// $this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		// $this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 

       			$data["qry"] = "UPDATE dbo.sekolah set lintang = '".$data["lintang"]."', bujur = '".$data["bujur"]."' WHERE npsn = '".$this->session->userdata("op_username")."'";
				$this->db->where("npsn",$this->session->userdata("op_username"));
				$res  = $this->db->update("sekolah",$data);
	
		
            
			if($res) {
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil diupdate");
			} else {
				// rec(get_class($this));
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal diupdate ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
		
		
	}

	
	
}