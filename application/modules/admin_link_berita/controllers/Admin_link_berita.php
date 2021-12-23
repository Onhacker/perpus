<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_link_berita extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_link_berita", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Fakultas";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}


	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_link_berita"] = $res->id_link_berita;
            $row["nama_berita"] = $res->nama_berita;
           
            $row["link"] = '<a href="'.$res->link.'" target="_blank">'.$res->link.'</a>';
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_link_berita.'"><label></label></div>';

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
        cek_session_akses("Admin_link_berita",$this->session->userdata('admin_session'));
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_berita','Nama Berita','required'); 
        $this->form_validation->set_rules('link','Link Berita','trim|required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("id_link_berita",$data["id_link_berita"]);
            $res  = $this->om->update("master_link_berita",$data); 
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
        cek_session_akses("Admin_link_berita",$this->session->userdata('admin_session'));
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_berita','Nama Berita','required'); 
        $this->form_validation->set_rules('link','Link Berita','trim|required'); 
        // $this->form_validation->set_rules('url', 'Remote Url', 'callback_valid_url');

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        // $this->form_validation->set_message('valid_url', '* %s tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            
            $res  = $this->om->insert("master_link_berita",$data); 
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
            $this->db->where("id_link_berita",$id);
            $res =$this->om->delete("master_link_berita");
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
