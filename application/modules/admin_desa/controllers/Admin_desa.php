<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_desa extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_desa", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = $this->om->web_me()->type;
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
            $row["id"] = $res->id_desa;
            $row["desa"] = $res->desa;
            $row["kecamatan"] = $res->kecamatan;
            $row["nama_pkm"] = $res->nama_pkm;
            $row["penulis"] = "<span class='badge bg-soft-danger text-info p-1'>".$res->nama_lengkap."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_desa.'"><label></label></div>';

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

    function add(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('desa','Nama Puskesmas','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["username"] = $this->session->userdata("admin_username");
            $this->db->where("desa",$data["desa"]);
            $res = $this->db->get("master_pkm");
            // rec(get_class($this));
            if ($res->num_rows() >  0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Jabatan Sudah Ada");
            } else {
                $this->db->insert('master_pkm',$data); 
                // rec(get_class($this));
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
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
        $this->form_validation->set_rules('id_pkm',$this->om->engine_nama_menu("Admin_pkm"),'required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
                $this->db->where("id_desa",$data["id_desa"]);
                $res  = $this->om->update("master_desa",$data); 
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
                $this->db->where("id_desa",$id);
                $res =$this->om->delete("master_pkm");
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
