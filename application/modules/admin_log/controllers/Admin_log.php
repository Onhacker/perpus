<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_log extends Admin_Controller {
	function __construct(){
		parent::__construct();
		      cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_log", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Laporan Pengembalian Buku";
		$data["subtitle"] = "Laporan Pengembalian Buku" ;
        $data["content"] = $this->load->view($data["controller"]."_laporan_pengembalian_view",$data,true); 
		$this->render($data);
	}

    function laporan_buku_tamu(){
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Buku Tamu";
        
        $data["subtitle"] = "Laporan Buku Tamu";
        $data["content"] = $this->load->view($data["controller"]."_laporan_buku_tamu_view",$data,true); 
        $this->render($data);
    }

    function laporan_keuangan(){
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Keuangan";
        
        $data["subtitle"] = "Laporan Keuangan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_keuangan_view",$data,true); 
        $this->render($data);
    }

    function laporan_buku_tamu_pdf($awal,$akhir) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
                cek_session_akses(get_class($this),$this->session->userdata('admin_session'));

        }
        $data["title"] = "Laporan Buku Tamu ". $awal. " sd ".$akhir;

        $data["awal"] = $awal;
        $data["akhir"] = $akhir;

        $this->db->where('tanggal BETWEEN "'. flipdate($data["awal"]). ' 00:00:00" and "'. flipdate($data["akhir"]).' 23:59:59"');
        $this->db->order_by('tanggal', 'DESC');
        
        $data["res"] = $this->db->get("buku_tamu");
        // echo $this->db->last_query();
        // exit();
        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("L", "F4");


        $html = $this->load->view(get_class($this)."_laporan_buku_tamu_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function laporan_keuangan_pdf($awal,$akhir) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
                cek_session_akses(get_class($this),$this->session->userdata('admin_session'));

        }
        $data["title"] = "Laporan Keuangan ". $awal. " sd ".$akhir;

        $data["awal"] = $awal;
        $data["akhir"] = $akhir;

        $this->db->where('tanggal BETWEEN "'. flipdate($data["awal"]). ' 00:00:00" and "'. flipdate($data["akhir"]).' 23:59:59"');
        $this->db->order_by('tanggal', 'DESC');
        
        $data["res"] = $this->db->get("buku_tamu");
        // echo $this->db->last_query();
        // exit();
        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("L", "F4");


        $html = $this->load->view(get_class($this)."_laporan_buku_tamu_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function laporan_pengembalian_pdf($awal,$akhir) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
                cek_session_akses(get_class($this),$this->session->userdata('admin_session'));

        }
        $data["title"] = "Laporan Pengembalian Buku Tanggal ". $awal. " sd ".$akhir;

        $data["awal"] = $awal;
        $data["akhir"] = $akhir;

        $this->db->where('tgl_dikembalikan BETWEEN "'. flipdate($data["awal"]). ' 00:00:00" and "'. flipdate($data["akhir"]).' 23:59:59"');
        $this->db->where("status","0");
        $this->db->order_by('tgl_dikembalikan', 'DESC');
        
        $data["res"] = $this->db->get("sirkulasi");
        // echo $this->db->last_query();
        // exit();
        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("L", "F4");


        $html = $this->load->view(get_class($this)."_laporan_pengembalian_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 
}
