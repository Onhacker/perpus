<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_buku extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_buku", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Katalog";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

    function bikin_barcode($kode){
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
    }

	function get_data(){  
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["kode_buku"] = $res->kode_buku;
            $row["judul_buku"] = $res->judul_buku;
            $row["nama_pengarang"] = $res->nama_pengarang;
            $row["nama_penerbit"] = $res->nama_penerbit;
            $row["tahun_terbit"] = $res->tahun_terbit;
            if (strlen($res->deskripsi) >= 130) {
                $des = substr($res->deskripsi, 0,130);
                $row["deskripsi"] = "<p align = 'justify'>".$des.". <a href='#' onclick='sel(".$res->id_buku.") '>Selengkapnya ->></a> </p>";
            } else {
                // $des = substr($res->deskripsi, 0,150);
                $row["deskripsi"] = "<p align = 'justify'>".$res->deskripsi."</p>";
            }
            
            $row["jumlah_unit"] = $res->jumlah_unit;
            $row["id_buku"] = $res->id_buku;
            $kode = $res->kode_buku;
            $row["kode"] = "<img src=".site_url('/admin_buku/bikin_barcode/'.$kode).">";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_buku.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
        	"draw" => $_POST['draw'],
        	"recordsTotal" => $this->dm->count_all(),
        	"recordsFiltered" => $this->dm->count_filtered(),
        	"data" => $data,
        );
        // echo $this->db->last_query();
        echo json_encode($output);
    }

    function edit($id){
        $data = array();
        $res = $this->dm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        echo json_encode($data);
    }

    
    
    function update(){
        cek_session_akses("Admin_buku",$this->session->userdata('admin_session'));
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul_buku','Judul Buku','required'); 
        $this->form_validation->set_rules('kode_buku','Kode Buku','required'); 
        $this->form_validation->set_rules('nama_pengarang','Pengarang','required'); 
        $this->form_validation->set_rules('nama_penerbit','Penerbit','required'); 
        $this->form_validation->set_rules('tahun_terbit','Tahun Terbit','required'); 
        $this->form_validation->set_rules('jumlah_unit','Jumlah Unit','required'); 
        $this->form_validation->set_rules('deskripsi','Deskripsi','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("id_buku",$data["id_buku"]);
            $res  = $this->om->update("master_buku",$data); 
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil diupdate");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal diupdate ");
            }
            
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 

    function add(){
        cek_session_akses("Admin_buku",$this->session->userdata('admin_session'));
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('judul_buku','Judul Buku','required'); 
        $this->form_validation->set_rules('kode_buku','Kode Buku','required'); 
        $this->form_validation->set_rules('nama_pengarang','Pengarang','required'); 
        $this->form_validation->set_rules('nama_penerbit','Penerbit','required'); 
        $this->form_validation->set_rules('tahun_terbit','Tahun Terbit','required'); 
        $this->form_validation->set_rules('jumlah_unit','Jumlah Unit','required'); 
        $this->form_validation->set_rules('deskripsi','Deskripsi','required'); 

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            
            $res  = $this->om->insert("master_buku",$data); 
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan ");
            }
            
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => validation_errors());
        }
        echo json_encode($ret);
        // echo $this->db->last_query();
    } 

    
    function hapus_data(){
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->db->where("id_buku",$id);
            $res =$this->om->delete("master_buku");
                // rec(get_class($this));
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil dihapus");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal dihapus".$pesan);
            }
        }
        echo json_encode($ret);
    } 


    
}
