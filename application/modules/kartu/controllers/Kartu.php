<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
	}

	function index(){
		$data['title'] = "CETAK KARTU BEBAS PUSTAKA ".$this->fm->web_me()->nama_website;
        $data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        if ($this->session->userdata("admin_login") == true and $this->session->userdata("admin_level") == "user") {
        	$this->db->where("nim",$this->session->userdata("admin_pkm"));
        	$this->db->where("status","1");

        	 $data["res"] = $this->db->get("sirkulasi")->num_rows();
        	// echo $this->db->last_query();

        	// exit();
        }
        
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
	}


	function pdf($nim) {
	    if ($this->session->userdata("admin_level") <> "user") {
	    	$this->load->view("perpus/Error_view");
	    } else {
	    	$this->db->limit(1);
	    	$this->db->where("nim",$this->session->userdata("admin_pkm"));
        	$this->db->where("status","0");
        	$x = $this->db->get("sirkulasi")->row();
       
        	$this->db->where("nim", $x->nim);
        	$this->db->select("username,nama_lengkap,nim,email, alamat,no_telp , level, nama_fakultas, nama_jurusan, nama_prodi, angkatan");
        	$this->db->from("users");
        	$this->db->join("master_fakultas", "master_fakultas.id_fakultas = users.id_fakultas");
        	$this->db->join("master_jurusan", "master_jurusan.id_jurusan  = users.id_jurusan");
        	$this->db->join("master_prodi", "master_prodi.id_prodi = users.id_prodi");
        	$this->db->where("level","user");
        	$this->db->where("deleted","N");

        	$data["res"] = $this->db->get()->row();
        	
	    	$data["title"] = "Kartu Bebas Pustaka ". $data["res"]->nama_lengkap;

	    	$data['header'] = $data["title"];
	    	$this->load->library('Pdf');
	    	$pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
	    	$pdf->SetTitle( $data['header']);

	    	$pdf->SetMargins(20, 10, 10);
	    	$pdf->SetHeaderMargin(10);
	    	$pdf->SetFooterMargin(10);
	    	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	    	$pdf->SetAutoPageBreak(true,10);
	    	$pdf->SetAuthor('Onhacker.net');

	    	$pdf->setPrintHeader(false);
	    	$pdf->setPrintFooter(false);

     // add a page
	    	$pdf->AddPage("P", "F4");


	    	$html = $this->load->view("perpus/Kartu_pdf",$data,true);
	    	$pdf->writeHTML($html, true, false, true, false, '');
	    	$pdf->lastPage();

	    	$pdf->Output($data['header'] .'.pdf', 'I');
	    }

        

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

	
	
}
