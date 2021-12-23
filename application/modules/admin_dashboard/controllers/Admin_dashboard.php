<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_dashboard extends Admin_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("M_admin_dashboard","ma");

	}
	function index(){
		
		$data["controller"] = get_class($this);
		$data["title"] = "Dashboard";
		$data["subtitle"] = "Welcome";
		if ($this->session->userdata("admin_level") == "admin") {
			$x = $this->db->get("buku_tamu")->num_rows();
            $data["jumlah_pengunjung"] = $x;
            $this->db->select("sum(jumlah_unit) as jumlah_buku")->from("master_buku");
            $r = $this->db->get()->row();

            $j = $this->db->get("master_buku")->num_rows();
            $data["jenis_buku"] = $j;

            $this->db->where("status","1");
            $j = $this->db->get("sirkulasi")->num_rows();
            $data["dipinjam"] = $j;

            $this->db->where('tgl_dikembalikan BETWEEN "'. date("Y-m-d"). ' 00:00:00" and "'. date("Y-m-d").' 23:59:59"');
            $this->db->where("status","0");
            $j = $this->db->get("sirkulasi")->num_rows();
            $data["dikembalikan"] = $j;

            $data["jumlah_buku"] = $r->jumlah_buku;
			$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
			$this->render($data);
		} 
	}

    function pws(){
        $data["controller"] = get_class($this);     
        $data["title"] = "PWS";
        $data["subtitle"] = "Pemantauan Wilayah Setempat Berdasarkan Desa";
        $data["content"] = $this->load->view($data["controller"]."_pws_view",$data,true); 
        $this->render($data);
    }

    function pws_dinas(){
        cek_session_admin();
        $data["controller"] = get_class($this);     
        $data["title"] = "PWS";
        $data["subtitle"] = "Pemantauan Wilayah Setempat Berdasarkan Puskesmas";
        $data["content"] = $this->load->view($data["controller"]."_pws_dinas_view",$data,true); 
        $this->render($data);
    }

    function hak_akses(){
        $data["controller"] = get_class($this);     
        $data["title"] = "Hak Akses";
        $data["subtitle"] = "Hak Akses System";
        $data["record"] = $this->om->profil("users")->row();
        $this->db->select('*');
        $this->db->from("modul");
        $this->db->join('users_modul', 'modul.id_modul = users_modul.id_modul');
        $this->db->where("users_modul.id_session", $this->session->userdata("admin_session"));
        $this->db->order_by("nama_modul", "ASC");
        $data["mod"] = $this->db->get();
        $data["content"] = $this->load->view($data["controller"]."_hak_akses_view",$data,true); 
        $this->render($data);
    }

    function stat_vaksin(){
        $data["controller"] = get_class($this);     
        $data["title"] = "Statistik Berdasarkan Jenis Vaksin";
        $data["subtitle"] = "Statistik";
        $data["content"] = $this->load->view($data["controller"]."_stat_vaksin_view",$data,true); 
        $this->render($data);
    }

    function trend_vaksin(){
        $data["controller"] = get_class($this);     
        $data["title"] = "Trend Berdasarkan Bulan";
        $data["subtitle"] = "Statistik";
        $data["content"] = $this->load->view($data["controller"]."_trend_vaksin_view",$data,true); 
        $this->render($data);
    }

    function stat_vaksin_desa(){
        $data["controller"] = get_class($this);     
        $data["title"] = "Statistik Berdasarkan Desa";
        $data["subtitle"] = "Statistik";
        $data["content"] = $this->load->view($data["controller"]."_stat_vaksin_desa_view",$data,true); 
        $this->render($data);
    }

    function stat_vaksin_pkm(){
        cek_session_admin();
        $data["controller"] = get_class($this);     
        $data["title"] = "Statistik Berdasarkan PKM";
        $data["subtitle"] = "Statistik";
        $data["content"] = $this->load->view($data["controller"]."_stat_vaksin_pkm_view",$data,true); 
        $this->render($data);
    }

    function get_desa2($id_pkm) {
        $form = $this->uri->segment(4);
        $sel="";
        $id_desa = $this->uri->segment(4);
        $this->db->where("id_pkm",$id_pkm);
        $this->db->order_by("desa");
        $res = $this->db->get("master_desa  ");
        //echo $this->db->last_query();
        $str = "x";

        if($form<>0) {
        $str .="<option value='x'> == Semua Desa == </option> "; }
        else {
            $str .="<option value='x'> == Semua Desa == </option> ";
        }
        foreach($res->result() as $row) :
            if($id_desa!='') {
                $sel = ($row->id_desa == $id_desa)?"selected":"";
            }
             $str .= "<option value=\"$row->id_desa\" $sel> $row->desa </option> \n";
        endforeach;
        echo $str;
    }

    function load_stat_vaksin($id_desa="",$tahun="",$bulan="",$id_pkm=""){
        $this->db->order_by("urutan","ASC");
        $data["vaksin"] = $this->db->get("master_penyakit");
        $data["id_desa"] = $id_desa;
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        $data["id_pkm"] = $id_pkm;
        
        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_load_stat_vaksin_js",$data); 
    }

    function load_trend_vaksin($id_desa="",$tahun="",$jenis_vaksin="",$id_pkm=""){
        if ($this->session->userdata("admin_level") == "admin") {
            $data["id_pkm"] = $id_pkm;
            // $this->db->where("id_pkm",$id_pkm);
        } else {
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            // $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        // $this->db->order_by("bulan","ASC");
        // $this->db->group_by("bulan");

        // $arr[""]  = "== Pilih Bulan == ";
        // for ($i=1; $i <= 12 ; $i++) { 
        //     $data["trend_bulan"]  = getBulan($i);
        // }
        // return $arr;

        // $data["trend_bulan"] = $this->db->get("imunisasi");
        $data["id_desa"] = $id_desa;
        $data["tahun"] = $tahun;
        $data["id_pkm"] = $id_pkm;
        $data["jenis_vaksin"] = $jenis_vaksin;
        
        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_load_trend_vaksin_js",$data); 
    }

    function load_stat_vaksin_desa($jenis_vaksin="",$tahun="",$bulan="",$id_pkm=""){
        if ($this->session->userdata("admin_level") == "admin") {
            $data["id_pkm"] = $id_pkm;
            $this->db->where("id_pkm",$id_pkm);
        } else {
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        $this->db->order_by("id_desa","ASC");
        $data["desa"] = $this->db->get("master_desa");
        $data["jenis_vaksin"] = $jenis_vaksin;
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        
        
        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_load_stat_vaksin_desa_js",$data); 
    }



    function load_stat_vaksin_pkm($jenis_vaksin="",$tahun="",$bulan=""){
       
        $this->db->order_by("id_pkm","ASC");
        $data["pkm"] = $this->db->get("master_pkm");
        $data["jenis_vaksin"] = $jenis_vaksin;
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        
        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_load_stat_vaksin_pkm_js",$data); 
    }

    function load_pws($jenis_vaksin_form="",$tahun="",$bulan="",$id_pkm=""){
        // $this->db->order_by("desa","ASC");
        $data["jenis_vaksin"] = $jenis_vaksin_form;
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        
        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                $data["id_pkm"] = $id_pkm;
            } 

        } else {
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
        }

        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                $this->db->where("id_pkm",$id_pkm);
            } 

        } else {
            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        $data["desa"] = $this->db->get("master_desa");

        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                $this->db->where("id_pkm",$id_pkm);
            } 

        } else {
            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        $data["desa2"] = $this->db->get("v_pws2");

        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_load_pws_js",$data); 
    }

    function load_pws_dinas($jenis_vaksin_form="",$tahun="",$bulan=""){
        // $this->db->order_by("desa","ASC");
        $data["jenis_vaksin"] = $jenis_vaksin_form;
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        
        $data["desa"] = $this->db->get("master_pkm");
        // $this->db->order_by("jum_vaksin_bayi","DESC");
        $data["desa2"] = $this->db->get("v_pws_dinas2");

        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_load_pws_dinas_js",$data); 
    }

	


	
}
