<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_prodi extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_prodi", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Jurusan";
        $data['fakultas']=$this->dm->get_fakultas();
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}


	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_prodi;
            $row["nama_prodi"] = $res->nama_prodi;
            $row["nama_fakultas"] = $res->nama_fakultas;
            $row["nama_jurusan"] = $res->nama_jurusan;
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_prodi.'"><label></label></div>';

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
        // echo $this->db->last_query();
    }

    function add(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_fakultas','Fakultas','required'); 
        $this->form_validation->set_rules('id_jurusan','Jurusan','required'); 
        $this->form_validation->set_rules('nama_prodi','Program Studi','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 

            $res  = $this->om->insert("master_prodi",$data); 
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
    } 
    
    function update(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_fakultas','Fakultas','required'); 
        $this->form_validation->set_rules('id_jurusan','Jurusan','required'); 
        $this->form_validation->set_rules('nama_prodi','Program Studi','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("id_prodi",$data["id_prodi"]);
            $res  = $this->om->update("master_prodi",$data); 
                // rec(get_class($this));
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

    
    function hapus_data(){
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->db->where("id_prodi",$id);
            $res =$this->om->delete("master_prodi");
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

   
    function get_jurusan(){
        $id=$this->input->post('id');
        $data=$this->dm->get_jurusan($id);
        echo json_encode($data);
    }

    

    }
