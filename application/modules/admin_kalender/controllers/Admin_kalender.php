<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kalender extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_kalender", "dm");
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
            $row["id"] = $res->id_kalender;
            $row["minggu_ke"] = $res->minggu_ke;
            $row["tahun"] = $res->tahun;
            $row["bulan"] = getBulan($res->bulan);
            $row["periode_awal"] = tgl_view($res->periode_awal);
            $row["tahap_survey"] = substr($res->tahap_survey, 0,4)." - ".substr($res->tahap_survey, 4,8);
            // $row["tahap_survey"] = ;
            $row["periode_akhir"] = tgl_view($res->periode_akhir);
            $row["penulis"] = "<span class='badge bg-soft-danger text-info p-1'>".$res->nama_lengkap."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_kalender.'"><label></label></div>';

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
        $data["periode"] = tgl_view($data["periode_awal"])." sampai ".tgl_view($data["periode_akhir"]);
        echo json_encode($data);
    }

    function add(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('range','Periode','required'); 
        $this->form_validation->set_rules('minggu_ke','Minggu Ke','trim|required|numeric'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["username"] = $this->session->userdata("admin_username");
            $range = str_replace(" ", "", $data["range"]);
            $range2 = explode("sampai", $range);
            $data["periode_awal"] = tgl_simpan($range2[0]);
            $data["periode_akhir"] = tgl_simpan($range2[1]);
            $bln = explode("-", tgl_simpan($range2[0]));
            $data["bulan"] = $bln[1];
            $data["tahun"] = $bln[0];


           $data["tahap_survey"] = $this->om->web_me()->tahun_awal.$this->om->web_me()->tahun_akhir;

            $this->db->where("tahun",$data["tahun"]);
            $this->db->where("minggu_ke",$data["minggu_ke"]);
            $res = $this->db->get("kalender");
            if ($res->num_rows() >  0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Minggu ke sudah ada di tahun ".$data["tahun"]. " sudah ada");
            } else {
                unset($data["range"]);
                $this->db->insert('kalender',$data); 
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
        $this->form_validation->set_rules('range','Periode','required'); 
        $this->form_validation->set_rules('minggu_ke','Minggu Ke','trim|required|numeric'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 

            $range = str_replace(" ", "", $data["range"]);
            $range2 = explode("sampai", $range);
            $data["periode_awal"] = tgl_simpan($range2[0]);
            $data["periode_akhir"] = tgl_simpan($range2[1]);
            $bln = explode("-", tgl_simpan($range2[0]));
            $data["bulan"] = $bln[1];
            $data["tahun"] = $bln[0];


            $data["tahap_survey"] = $this->om->web_me()->tahun_awal.$this->om->web_me()->tahun_akhir;
            unset($data["range"]);
                $this->db->where("id_kalender",$data["id_kalender"]);
                $res  = $this->om->update("kalender",$data); 
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
                $this->db->where("id_kalender",$id);
                $res =$this->om->delete("kalender");
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
