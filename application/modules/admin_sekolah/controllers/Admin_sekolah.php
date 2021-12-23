<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_sekolah extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_sekolah", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
        $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
        $c = $this->db->get("master_pkm")->row();
		$data["title"] = $this->om->bentuk_p($c->bentuk)." ".$c->nama_pkm;
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
            $row["id_sekolah"] = $res->id_sekolah;
            $row["sekolah"] = $res->sekolah;
            $row["desa"] = $res->desa;
            $row["kecamatan"] = $res->kecamatan;
            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_sekolah.'"><label></label></div>';

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
        $this->form_validation->set_rules('sekolah','Nama Sekolah','required'); 
        $this->form_validation->set_rules('id_desa','Desa','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["username"] = $this->session->userdata("admin_username");
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            
            $this->db->where("id_desa",$data["id_desa"]);
            $d = $this->db->get("master_desa")->row();
            $data["desa"] = $d->desa;
            $data["id_kecamatan"] = $d->id_kecamatan;

            $this->db->where("id_kecamatan",$data["id_kecamatan"]);
            $k = $this->db->get("master_kecamatan")->row();
            $data["kecamatan"] = $k->kecamatan;

            $this->db->where("sekolah",$data["sekolah"]);
            $res = $this->db->get("master_sekolah");

            if ($res->num_rows() >  0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Sekolah Sudah Ada");
            } else {
                $this->db->insert('master_sekolah',$data); 
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
        $this->form_validation->set_rules('sekolah','Nama Sekolah','required'); 
        $this->form_validation->set_rules('id_desa','Desa','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("id_desa",$data["id_desa"]);
            $d = $this->db->get("master_desa")->row();
            $data["desa"] = $d->desa;
            $data["id_kecamatan"] = $d->id_kecamatan;

            $this->db->where("id_kecamatan",$data["id_kecamatan"]);
            $k = $this->db->get("master_kecamatan")->row();
            $data["kecamatan"] = $k->kecamatan;

            $this->db->where("id_sekolah !=", $data["id_sekolah"]);
            $this->db->where("sekolah",$data["sekolah"]);
            $cek = $this->db->get("master_sekolah");
            $r = $cek->row();
            if ($cek->num_rows() >= 1) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => $r->sekolah." Sudah ada");
                echo json_encode($ret);
                return false;
            }
            $this->db->where("id_sekolah",$data["id_sekolah"]);
            $res  = $this->om->update("master_sekolah",$data); 
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
                $this->db->where("id_sekolah",$id);
                $res =$this->db->delete("master_sekolah");
                if($res) {    
                    $ret = array("success" => true,
                        "title" => "Berhasil",
                        "pesan" => "Data berhasil dihapus");
                } else {
                    $ret = array("success" => false,
                        "title" => "Gagal",
                        "pesan" => "Data Gagal dihapus");
                }
            }
        echo json_encode($ret);
    } 


    function get_desa($id_pkm) {
        $form = $this->uri->segment(4);
        $sel="";
        $id_desa = $this->uri->segment(4);
        $this->db->where("id_pkm",$id_pkm);
        $this->db->order_by("desa");
        $res = $this->db->get("master_desa  ");
        //echo $this->db->last_query();
        $str = "";

        if($form<>0) {
        $str .="<option value=''> == Semua Desa == </option> "; }
        else {
            $str .="<option value=''> == Semua Desa == </option> ";
        }
        foreach($res->result() as $row) :
            if($id_desa!='') {
                $sel = ($row->id_desa == $id_desa)?"selected":"";
            }
             $str .= "<option value=\"$row->id_desa\" $sel> $row->desa </option> \n";
        endforeach;
        echo $str;
    }

	
}
