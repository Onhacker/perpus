<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_bias extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		
	}

	function index(){
        $this->load->model("M_admin_bias", "dm");
		$data["controller"] = get_class($this);		
		$data["title"] = "BIAS";
        if ($this->session->userdata("admin_level") != "admin") {
        
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $data["fe"] = $this->db->get("master_sekolah");

            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $c = $this->db->get("master_pkm")->row();
            $vv = $this->om->bentuk_p($c->bentuk)." ".$c->nama_pkm;


            if ($data["fe"]->num_rows() == "0") {
                $data["cek"] = "PERINGATAN !!!. Anda Belum memiliki data Wilayah cakupan Imunisasi  Sekolah. Silahkan buat data sekolah dalam wilayah imunisasi <span class='text-primary'>".$vv."</span> terlebih dahulu sebelum melanjutkan pembuatan data BIAS. Buat Data Sekolah di menu Data Dasar lalu pilih Data Sekolah";
            }
        } else {
            $data["fe"] = $this->db->get("master_sekolah");
            $data["cek"] = "PERINGATAN !!!. Belum ada satupun Puskesmas Mengisi data sekolah, Silahkan sampaikan ke pihak Puskesmas sebelum melanjutkan ke Laporan BIAS";

        }
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

    

    function kelola($id){
        $data["controller"] = get_class($this);     
        $this->db->where("id_admin_bias", $id);
        $data["admin_bias"] = $this->db->get("admin_bias")->row();
        $this->db->where("admin_bias_isi.id_admin_bias",$id);
        $this->db->where("admin_bias_isi.id_pkm",$this->session->userdata("admin_pkm"));
        
        if ($this->session->userdata("admin_level")=='admin'){
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        } else {
            $this->db->where("admin_bias_isi.id_pkm", $this->session->userdata("admin_pkm"));
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        }
        $data["res"] = $this->db->get();
        // echo $this->db->last_query();
        $data["title"] = "BIAS";
        $data["subtitle"] = "Rekapitulasi Hasil Cakupan Bulan Imunisasi (BIAS) Tahun ".$data["admin_bias"]->tahun;
        $data["content"] = $this->load->view($data["controller"]."_kelola_editable_view",$data,true); 
        $this->render($data);
    }

    function statistik(){
        $this->load->model("M_admin_bias", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Trend Mingguan W2 Berdasarkan Desa";
        $data["subtitle"] = "W2";
        $data["content"] = $this->load->view($data["controller"]."_trend_view",$data,true); 
        $this->render($data);
    }

    function bulanan(){
        $this->load->model("M_admin_bias", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "W2 ";
        $data["subtitle"] = "Laporan W2 Bulanan";
        $data["content"] = $this->load->view($data["controller"]."_bulanan_view",$data,true); 
        $this->render($data);
    }

    function bulanan_dinas(){
        cek_session_admin();
        $this->load->model("M_admin_bias", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "W2 ";
        $data["subtitle"] = "Laporan W2 Bulanan dari PKM/RS";
        $data["content"] = $this->load->view($data["controller"]."_bulanan_dinas_view",$data,true); 
        $this->render($data);
    }

    function sebaran(){
        $this->load->model("M_admin_bias", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Sebaran Penyakit";
        $data["subtitle"] = "Sebaran";
        $data["content"] = $this->load->view($data["controller"]."_sebaran_view",$data,true); 
        $this->render($data);
    }

    function sebaran_pkm(){
        cek_session_admin();
        $this->load->model("M_admin_bias", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Sebaran Penyakit Berdasarkan Puskesmas";
        $data["subtitle"] = "Sebaran";
        $data["content"] = $this->load->view($data["controller"]."_sebaran_pkm_view",$data,true); 
        $this->render($data);
    }

    function laporan_dinas(){
        cek_session_admin();
        $this->load->model("M_admin_bias", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Rekapitulasi Hasil Cakupan BIAS Dinas Kesehatan";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_dinas_view",$data,true); 
        $this->render($data);
    }

    function data_pe_minggu(){
        cek_session_admin();
        $this->load->model("M_admin_bias", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Data Per Minggu";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_data_per_minggu_view",$data,true); 
        $this->render($data);
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
        $str .="<option value=x> == Semua Desa == </option> "; }
        else {
            $str .="<option value=x> == Semua Desa == </option> ";
        }
        foreach($res->result() as $row) :
            if($id_desa!='') {
                $sel = ($row->id_desa == $id_desa)?"selected":"";
            }
             $str .= "<option value=\"$row->id_desa\" $sel> $row->desa </option> \n";
        endforeach;
         $str .= "<option value='888'> LUAR WILAYAH </option> \n";
        echo $str;
    }


    function load_trend($a="",$b="",$c="",$d="",$id_pkm=""){
       
        if ($a <> "x") {
            $this->db->where("tahun", $a);
        }
        if ($d <> "x") {
            $this->db->where("id_desa", $d);
        }
        
        $this->db->where('minggu_ke BETWEEN "'.$b. '" and "'.$c.'"');
        
        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                $this->db->where("id_pkm",$id_pkm);
            } 

        } else {
            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        
        $this->db->group_by("minggu_ke");
        $this->db->select("minggu_ke,desa,sum(diare_k_lima_p+diare_k_lima_m+diare_l_lima_p+diare_l_lima_m+kholera_p+kholera_m+dbd_min_p+dbd_min_m+dbd_plus_p+dbd_plus_m+pes_p+pes_m+polio_p+polio_m+diferi_min_p+diferi_min_m+diferi_plus_p+diferi_plus_m+campak_k_lima_p+campak_k_lima_m+campak_l_lima_p+campak_l_lima_m+pneumonia_p+pneumonia_m+tetanus_p+tetanus_m+maramus_p+maramus_m+hepatitis_klinis_p+hepatitis_klinis_m+hepatitis_hbs_p+hepatitis_hbs_m+lahir_mati_m+kematian_bayi_m+kematian_neo_m+kematian_ibu_m+bblr_p+bblr_m+tb_min_p+tb_min_m+tb_plus_p+tb_plus_m+bgm_p+bgm_m+typhoid_min_p+typhoid_min_m+thypoid_plus_p+thypoid_plus_m+malaria_klinis_p+malaria_klinis_m+jumlah_persalinan_p+jumlah_kelahiran_hidup_p+kasus_gigitan_p+kasus_gigitan_m+infulensa_p+infulensa_m+marasmus_p+marasmus_m+varicella_p+varicella_m+lepospirosi_p+lepospirosi_m+dysentry_p+dysentry_m+ili_p+ili_m+suspek_ai_p+suspek_ai_m+demam_tdk_tau_p+demam_tdk_tau_m) as semua_penyakit, sum(jumlah_kunjungan_p+jumlah_kunjungan_m) as jumlah_kunjungan");+
        

        $this->db->from("w_dua_isi");
        $data["isi"] = $this->db->get();
        // echo $this->db->last_query();
        $res = $data["isi"]->row();
        $data["minggu_ke"] = "Minggu ke  ".($b)." - ".($c)." Tahun ".$a ;
        
        if ($d == "x") {
            if ($res->bentuk == "1") {
               $data["desa"] = "Semua Desa";
            } 
        } elseif ($d == "888") {
            $data["desa"] = ucwords(strtolower($res->desa));
        } else {
            $data["desa"] = "Desa ".ucwords(strtolower($res->desa));
        }

        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm == "x" and $this->session->userdata("admin_level")=='admin') {
                $data["pkm_nama"] = "Semua RS/Puskesmas";
            } else {
                $data["pkm_nama"] = $this->om->bentuk_admin($id_pkm,"p")." ".$this->om->identitas_general_l_a($id_pkm)->nama_pkm;
                echo $this->db->last_query();
            } 
        } else {
            $data["pkm_nama"] = $this->om->bentuk_admin($this->session->userdata("admin_pkm"),"p")." ".$this->om->identitas_general_l_a($this->session->userdata("admin_pkm"))->nama_pkm;
        }


        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_trend_js",$data); 
    }


    function load_sebaran($a="",$b="",$c="",$id_pkm=""){
        if ($a <> "x") {
            $this->db->where("rawat", $a);
        }
        if ($b <> "x") {
            $this->db->where("tahun", $b);
        }
        if ($c <> "x") {
            $this->db->where('bulan',$c);
        }
    
        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                $this->db->where("id_pkm",$id_pkm);
            } 

        } else {
            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        
        $this->db->group_by("id_penyakit");
        $this->db->order_by("penyakit","ASC");
         $this->db->select("penyakit, sum(l) as jum,sum(p) as jump, sum(kasus_baru) as kasus_baru ,sum(a0_7h) as a0_7h,sum(a8_28h) as a8_28h,sum(a1bl_1th) as a1bl_1th,sum(a1_4th) as a1_4th,sum(a5_9th) as a5_9th,sum(a10_14th) as a10_14th,sum(a15_19th) as a15_19th,sum(a20_44th) as a20_44th,sum(a45_54th) as a45_54th,sum(a55_59th) as a55_59th,sum(a60_69th) as a60_69th,sum(a70th) as a70th");
        $this->db->from("stp_isi");
        $data["isi"] = $this->db->get();
        // echo $this->db->last_query();
        $res = $data["isi"]->row();
        
        if ($c == "x") {
            $data["bulan_awal"] = "Bulan Januari - Desember Tahun ".$b ;
        } else {
            $data["bulan_awal"] = "Bulan ".getBulan($c)." Tahun ".$b ;
        }
        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm == "x" and $this->session->userdata("admin_level")=='admin') {
                $data["pkm_nama"] = "Semua Puskesmas";
            } else {
                $data["pkm_nama"] = "Puskesmas ".$this->om->identitas_general($id_pkm)->nama_pkm;
            } 
        } else {
            $data["pkm_nama"] = "Puskesmas ".$this->om->identitas()->nama_pkm;
        }


        if ($a == "J") {
            $data["rawat"] = "Rawat Jalan.";
        } elseif($a == "I") {
            $data["rawat"] = "Rawat Inap.";
        } else {
             $data["rawat"] = "Semua Rawat.";
        }

        // echo $this->db->last_query();

        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_sebaran_js",$data); 
    }
    
    function load_sebaran_pkm($a="",$b="",$c="",$id_penyakit=""){
        cek_session_admin();
        if ($a <> "x") {
            $this->db->where("rawat", $a);
        }
        if ($b <> "x") {
            $this->db->where("tahun", $b);
        }
        if ($c <> "x") {
            $this->db->where('bulan',$c);
        }
    
        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_penyakit <> "x" and $this->session->userdata("admin_level")=='admin') {
                $this->db->where("id_penyakit",$id_penyakit);
            } 

        } 
        $this->db->group_by("master_pkm.id_pkm");
        $this->db->order_by("master_pkm.nama_pkm","ASC");
        $this->db->select("master_pkm.id_pkm,penyakit, sum(l) as jum,sum(p) as jump, sum(kasus_baru) as kasus_baru ,sum(a0_7h) as a0_7h,sum(a8_28h) as a8_28h,sum(a1bl_1th) as a1bl_1th,sum(a1_4th) as a1_4th,sum(a5_9th) as a5_9th,sum(a10_14th) as a10_14th,sum(a15_19th) as a15_19th,sum(a20_44th) as a20_44th,sum(a45_54th) as a45_54th,sum(a55_59th) as a55_59th,sum(a60_69th) as a60_69th,sum(a70th) as a70th");
        $this->db->join("stp_isi", "master_pkm.id_pkm = stp_isi.id_pkm","left");
        $this->db->from("master_pkm");
        $data["isi"] = $this->db->get();
        $data["jml_pkm"] = $data["isi"]->num_rows();
        // echo $this->db->last_query();
        $res = $data["isi"]->row();
        
        if ($c == "x") {
            $data["bulan_awal"] = "Bulan Januari - Desember Tahun ".$b ;
        } else {
            $data["bulan_awal"] = "Bulan ".getBulan($c)." Tahun ".$b ;
        }
        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_penyakit == "x" and $this->session->userdata("admin_level")=='admin') {
                $data["penyakit"] = ", Semua Penyakit, ";
            } else {
                $data["penyakit"] = ", Penyakit ".$res->penyakit.", ";
            } 
        } else {
            $data["pkm_nama"] = "Puskesmas ".$this->om->identitas()->nama_pkm;
        }


        if ($a == "J") {
            $data["rawat"] = "Rawat Jalan.";
        } elseif($a == "I") {
            $data["rawat"] = "Rawat Inap.";
        } else {
             $data["rawat"] = "Semua Rawat.";
        }

        echo $this->db->last_query();

        $data["controller"] = get_class($this);     
        $this->load->view($data["controller"]."_sebaran_pkm_js",$data); 
    }

   
    function absen_kelas_1_l($id){
        $data = $this->input->post();
        $x["absen_kelas_1_l"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function absen_kelas_1_p($id){
        $data = $this->input->post();
        $x["absen_kelas_1_p"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function absen_kelas_2_l($id){
        $data = $this->input->post();
        $x["absen_kelas_2_l"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function absen_kelas_2_p($id){
        $data = $this->input->post();
        $x["absen_kelas_2_p"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function absen_kelas_5_l($id){
        $data = $this->input->post();
        $x["absen_kelas_5_l"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function absen_kelas_5_p($id){
        $data = $this->input->post();
        $x["absen_kelas_5_p"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_1_l_dt($id){
        $data = $this->input->post();
        $x["imun_kelas_1_l_dt"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_1_p_dt($id){
        $data = $this->input->post();
        $x["imun_kelas_1_p_dt"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_1_l_cpk($id){
        $data = $this->input->post();
        $x["imun_kelas_1_l_cpk"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_1_p_cpk($id){
        $data = $this->input->post();
        $x["imun_kelas_1_p_cpk"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_2_l($id){
        $data = $this->input->post();
        $x["imun_kelas_2_l"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_2_p($id){
        $data = $this->input->post();
        $x["imun_kelas_2_p"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_5_l($id){
        $data = $this->input->post();
        $x["imun_kelas_5_l"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function imun_kelas_5_p($id){
        $data = $this->input->post();
        $x["imun_kelas_5_p"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function vaksin_dt($id){
        $data = $this->input->post();
        $x["vaksin_dt"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function vaksin_cpk($id){
        $data = $this->input->post();
        $x["vaksin_cpk"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function vaksin_td($id){
        $data = $this->input->post();
        $x["vaksin_td"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function logistik_5ml($id){
        $data = $this->input->post();
        $x["logistik_5ml"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
    function logistik_05ml($id){
        $data = $this->input->post();
        $x["logistik_05ml"] = str_replace(",", ".", $data["value"]);
        $this->ekse($data["pk"],$id,$x);
    }
   
    function ekse($pk,$id,$x){
        $this->db->where("id_admin_bias_isi", $pk);
        $this->db->where("id_admin_bias", $id);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $res = $this->db->update("admin_bias_isi", $x);
        if ($res) {
        $ret = array("success"=>true);
        } else {
            $ret = array("success"=>false);
        }
        echo json_encode($ret);
    }

    function load_data_per_minggu($a="",$b="",$c="",$d="",$id_pkm=""){
        if ($a <> "x") {
            $this->db->where("tahun", $a);
        } else {
            $this->db->where("tahun", date("Y"));
        }
        if ($d <> "x") {
            $this->db->where("id_desa", $d);
        }

        if ($b <> "x" or $c <> "x") {
            $this->db->where('minggu_ke BETWEEN "'.$b. '" and "'.$c.'"');
        } else {
            $this->db->limit("10");
        }
        
        
        
        if ($this->session->userdata("admin_level")=='admin'){
            if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                $this->db->where("id_pkm",$id_pkm);
            } 

        } else {
            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        


        $this->db->group_by("minggu_ke");
        
        $this->db->select("w_dua_isi.id_pkm as id_pkm,w_dua_isi.minggu_ke as minggu_ke,sum(diare_k_lima_p) as diare_k_lima_p,sum(diare_k_lima_m) as diare_k_lima_m,sum(diare_l_lima_p) as diare_l_lima_p,sum(diare_l_lima_m) as diare_l_lima_m,sum(kholera_p) as kholera_p,sum(kholera_m) as kholera_m,sum(dbd_min_p) as dbd_min_p,sum(dbd_min_m) as dbd_min_m,sum(dbd_plus_p) as dbd_plus_p,sum(dbd_plus_m) as dbd_plus_m,sum(pes_p) as pes_p,sum(pes_m) as pes_m,sum(polio_p) as polio_p,sum(polio_m) as polio_m,sum(diferi_min_p) as diferi_min_p,sum(diferi_min_m) as diferi_min_m,sum(diferi_plus_p) as diferi_plus_p,sum(diferi_plus_m) as diferi_plus_m,sum(campak_k_lima_p) as campak_k_lima_p,sum(campak_k_lima_m) as campak_k_lima_m,sum(campak_l_lima_p) as campak_l_lima_p,sum(campak_l_lima_m) as campak_l_lima_m,sum(pneumonia_p) as pneumonia_p,sum(pneumonia_m) as pneumonia_m,sum(tetanus_p) as tetanus_p,sum(tetanus_m) as tetanus_m,sum(maramus_p) as maramus_p,sum(maramus_m) as maramus_m,sum(hepatitis_klinis_p) as hepatitis_klinis_p,sum(hepatitis_klinis_m) as hepatitis_klinis_m,sum(hepatitis_hbs_p) as hepatitis_hbs_p,sum(hepatitis_hbs_m) as hepatitis_hbs_m,sum(lahir_mati_m) as lahir_mati_m,sum(kematian_bayi_m) as kematian_bayi_m,sum(kematian_neo_m) as kematian_neo_m,sum(kematian_ibu_m) as kematian_ibu_m,sum(bblr_p) as bblr_p,sum(bblr_m) as bblr_m,sum(tb_min_p) as tb_min_p,sum(tb_min_m) as tb_min_m,sum(tb_plus_p) as tb_plus_p,sum(tb_plus_m) as tb_plus_m,sum(bgm_p) as bgm_p,sum(bgm_m) as bgm_m,sum(typhoid_min_p) as typhoid_min_p,sum(typhoid_min_m) as typhoid_min_m,sum(thypoid_plus_p) as thypoid_plus_p,sum(thypoid_plus_m) as thypoid_plus_m,sum(malaria_klinis_p) as malaria_klinis_p,sum(malaria_klinis_m) as malaria_klinis_m,sum(jumlah_persalinan_p) as jumlah_persalinan_p,sum(jumlah_kelahiran_hidup_p) as jumlah_kelahiran_hidup_p,sum(kasus_gigitan_p) as kasus_gigitan_p,sum(kasus_gigitan_m) as kasus_gigitan_m,sum(infulensa_p) as infulensa_p,sum(infulensa_m) as infulensa_m,sum(marasmus_p) as marasmus_p,sum(marasmus_m) as marasmus_m,sum(varicella_p) as varicella_p,sum(varicella_m) as varicella_m,sum(lepospirosi_p) as lepospirosi_p,sum(lepospirosi_m) as lepospirosi_m,sum(dysentry_p) as dysentry_p,sum(dysentry_m) as dysentry_m,sum(ili_p) as ili_p,sum(ili_m) as ili_m,sum(suspek_ai_p) as suspek_ai_p,sum(suspek_ai_m) as suspek_ai_m,sum(demam_tdk_tau_p) as demam_tdk_tau_p,sum(demam_tdk_tau_m) as demam_tdk_tau_m,sum(jumlah_kunjungan_p) as jumlah_kunjungan_p,sum(jumlah_kunjungan_m) as jumlah_kunjungan_m");
        $this->db->from("w_dua_isi");
        $data["ret"] = $this->db->get();


        // echo $this->db->last_query();
        $this->load->view("Admin_w_dua_load_data_per_minggu",$data);
    }

    function load_isi_admin_bias($id,$q=""){
       $data['controller'] = get_class($this);
       $this->db->order_by("sekolah","ASC");
       $this->db->like(array("sekolah" => $q));
       $this->db->where("admin_bias_isi.id_admin_bias",$id);
       $this->db->where("admin_bias_isi.id_pkm",$this->session->userdata("admin_pkm"));
        if ($this->session->userdata("admin_level")=='admin'){
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        } else {
            $this->db->where("admin_bias_isi.id_pkm", $this->session->userdata("admin_pkm"));
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        }
        $ret = $this->db->get();
        $data = array();
        $no = 0;
        foreach ($ret->result() as $res){
            $no++;
            $row = array();
            $row["no"] = $no;

            $row["id_admin_bias_isi"] = ($res->id_admin_bias_isi);
            $row["id_pkm"] = ($res->id_pkm);
            $row["id_admin_bias"] = ($res->id_admin_bias);
            $row["sekolah"] = ($res->sekolah);
            $row["id_sekolah"] = ($res->id_sekolah);


            $row["absen_kelas_1_l"] = ye($res->absen_kelas_1_l);
            $row["absen_kelas_1_p"] = ye($res->absen_kelas_1_p);
            $row["absen_kelas_2_l"] = ye($res->absen_kelas_2_l);
            $row["absen_kelas_2_p"] = ye($res->absen_kelas_2_p);
            $row["absen_kelas_5_l"] = ye($res->absen_kelas_5_l);
            $row["absen_kelas_5_p"] = ye($res->absen_kelas_5_p);
            $row["imun_kelas_1_l_dt"] = ye($res->imun_kelas_1_l_dt);
            $row["imun_kelas_1_p_dt"] = ye($res->imun_kelas_1_p_dt);
            $row["imun_kelas_1_l_cpk"] = ye($res->imun_kelas_1_l_cpk);
            $row["imun_kelas_1_p_cpk"] = ye($res->imun_kelas_1_p_cpk);
            $row["imun_kelas_2_l"] = ye($res->imun_kelas_2_l);
            $row["imun_kelas_2_p"] = ye($res->imun_kelas_2_p);
            $row["imun_kelas_5_l"] = ye($res->imun_kelas_5_l);
            $row["imun_kelas_5_p"] = ye($res->imun_kelas_5_p);
            $row["vaksin_dt"] = ye($res->vaksin_dt);
            $row["vaksin_cpk"] = ye($res->vaksin_cpk);
            $row["vaksin_td"] = ye($res->vaksin_td);
            $row["logistik_5ml"] = ye($res->logistik_5ml);
            $row["logistik_05ml"] = ye($res->logistik_05ml);

            $row["a"] = "volume";
            $row["b"] ="pointer";
            // $row["kun"] = ye($res->a0_7h+$res->a8_28h+$res->a1bl_1th+$res->a1_4th+$res->a5_9th+$res->a10_14th+$res->a15_19th+$res->a20_44th+$res->a45_54th+$res->a55_59th+$res->a60_69th+$res->a70th+$res->l+$res->p);

            $data[] = $row;

        }
      echo json_encode($data);
      // echo $this->db->last_query();
        
    }



	function get_data(){   
        $this->load->model("M_admin_bias", "dm");
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_admin_bias"] = $res->id_admin_bias;
            $row["tahun"] = $res->tahun;
            $row["create_date"] = tgl_indo($res->create_date);
         
            if ($this->session->userdata("admin_level") == "admin") {
                $row["kelola"] = '<div class="btn-group show">
                         <button type="button" class="btn btn-info btn-xs  ml-1 dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> Cetak <i class="mdi mdi-chevron-down"></i> </button>
                         <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 35px, 0px);">
                         <a class="dropdown-item" target="_BLANK" href="'.strtolower(get_class($this)).'/pdf_laporan/'.$res->id_admin_bias.'/'.$res->id_pkm.'" >Berdasarkan Sekolah</a>
                         <a class="dropdown-item" target="_BLANK" href="'.strtolower(get_class($this)).'/pdf_laporan_desa/'.$res->id_admin_bias.'/'.$res->id_pkm.'" >Berdasarkan Desa</a>
                         </div>
                     </div>
                  ';
            } else {
                $this->db->where("id_admin_bias", $res->id_admin_bias);
                $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
                $cek = $this->db->get("admin_bias");
                $cek2 = $cek->row();
                 if ($cek->num_rows() > 0 and $cek2->tahun < date("Y") or $cek2->bulan <> date("m")) {
                     $row["kelola"] = 
                     '<a href="'.strtolower(get_class($this)).'/kelola/'.$res->id_admin_bias.'"  class="btn btn-primary btn-xs  ml-1"> Kelola  </a>
                     &nbsp;&nbsp;&nbsp;Cetak Berdasarkan: &nbsp;&nbsp;
                     <a target="_BLANK" href="'.strtolower(get_class($this)).'/pdf_laporan/'.$res->id_admin_bias.'" class="btn btn-xs btn-danger waves-effect waves-light"> Sekolah</a>
                     <a target="_BLANK" href="'.strtolower(get_class($this)).'/pdf_laporan_desa/'.$res->id_admin_bias.'" class="btn btn-xs btn-info waves-effect waves-light"> Desa</a>
                     
                   
                     ';

                } else {
                    $row["kelola"] = 
                    '<a href="'.strtolower(get_class($this)).'/kelola/'.$res->id_admin_bias.'"  class="btn btn-primary btn-xs  ml-1"> Kelola  </a>
                    <a target="_BLANK" href="'.strtolower(get_class($this)).'/pdf_laporan/'.$res->id_admin_bias.'"  class="btn btn-info btn-xs  ml-1"> Cetak  </a>';
                }
                
            }

            

            
            $this->db->where("id_admin_bias", $res->id_admin_bias);
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $cek = $this->db->get("admin_bias");            
            $cek2 = $cek->row();
            // if ($cek->num_rows() > 0 and $cek2->tahun < date("Y") or $cek2->bulan <> date("m")) {
            //     $row['cek'] = '<i class="fa fa-ban"></i>';
            // } else {
            //     $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_admin_bias.'"><label></label></div>';
            // }
             if ($cek->num_rows() > 0 and $cek2->tahun < date("Y") or $cek2->bulan <> date("m")) {
                 $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_admin_bias.'"><label></label></div>';
            } else {
                $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_admin_bias.'"><label></label></div>';
            }

            $row["penulis"] = "<span class='text-primary'>".$this->om->bentuk_admin("$res->id_pkm",'l')." ".$this->om->identitas_general_l_a($res->id_pkm)->nama_pkm."</span>";

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

    function get_data_kelola($id){   
        $this->load->model("M_admin_kelola_w_dua", "kl");
        $list = $this->kl->get_data($id);
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_stp_isi"] = $res->id_stp_isi;
            $row["penyakit"] = $res->penyakit;
            $row["0_7h"] = uang($res->a0_7h);
            $row["8_28h"] = uang($res->a8_28h);
            $row["1bl_1th"] = uang($res->a1bl_1th);
            $row["1_4th"] = uang($res->a1_4th);
            $row["5_9th"] = uang($res->a5_9th);
            $row["10_14th"] = uang($res->a10_14th);
            $row["15_19th"] = uang($res->a15_19th);
            $row["20_44th"] = uang($res->a20_44th);
            $row["45_54th"] = uang($res->a45_54th);
            $row["55_59th"] = uang($res->a55_59th);
            $row["60_69th"] = uang($res->a60_69th);
            $row["70th"] = uang($res->a70th);
            $row["l"] = uang($res->l);
            $row["p"] = uang($res->p);
            $row["kasus_baru"] = uang($res->kasus_baru);

           
            $row["kelola"] = '<a href="'.strtolower(get_class($this)).'/kelola/'.$res->id_stp_isi.'"  class="btn btn-primary btn-sm  ml-1"> <i class="fa fa-database"></i>  </a>';
            // $row["penulis"] = "<span class='badge bg-soft-danger text-info p-1'>".$res->nama_lengkap."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_stp_isi.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kl->count_all($id),
            "recordsFiltered" => $this->kl->count_filtered($id),
            "data" => $data,
        );
        // echo $this->db->last_query();
        echo json_encode($output);
    }

    function gagal(){
         $ret = array("success" => false,
            "title" => "Gagal",
            "pesan" => "Data Sudah tidak bisa dirubah karena sekarang sudah bulan ".getBulan(date("m"))." Tahun ".date("Y"));
         echo json_encode($ret);

    }

    function edit($id){
        $this->load->model("M_admin_bias", "dm");
        $data = array();
        $res = $this->dm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        // $data["periode"] = tgl_view($data["periode_awal"])." sampai ".tgl_view($data["periode_akhir"]);
        echo json_encode($data);
    }

    function add(){
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('tahun','Tahun BIAS','required'); 

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["username"] = $this->session->userdata("admin_username");
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $data["pimpinan"] = $this->om->user()->pimpinan;
            $data["nip_pimpinan"] = $this->om->user()->nip_pimpinan;
            $data["pengelola"] = $this->om->user()->nama_lengkap;
            $data["nip_pengelola"] = $this->om->user()->nip_operator_dinas;
            $data["create_date"] = date("Y-m-d");
            $data["id_admin_bias"] = md5($this->session->userdata("admin_username").date("Ymdhis"))."_".$this->session->userdata("admin_pkm");

            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $this->db->where("tahun",$data["tahun"]);
            $cek = $this->db->get("admin_bias");
            $at = $cek->row();
            if ($cek->num_rows() > 0) {
               $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => "Data Tahun ".$data["tahun"]." Sudah ada");
                echo json_encode($ret);
                return false;
            }

            $this->db->insert('admin_bias',$data); 

            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
            $admin_bias_isi = $this->db->get("master_sekolah");
            foreach($admin_bias_isi->result() as $tr) :
                $x["sekolah"] = $tr->sekolah;
                $x["id_sekolah"] = $tr->id_sekolah;
                $x["desa"] = $tr->desa;
                $x["id_desa"] = $tr->id_desa;
                $x["id_pkm"] = $this->session->userdata("admin_pkm");
                $x["id_admin_bias"] = $data["id_admin_bias"];
                $x["tahun"] = $data["tahun"];
                if ($data["id_pkm"] = $this->session->userdata("admin_pkm")) {
                    $res = $this->db->insert("admin_bias_isi",$x); 
                    // echo $this->db->last_query();
                }
            endforeach;
      

            $ret = array("success" => true,
                "title" => "Berhasil",
                "pesan" => "Data berhasil disimpan");
            
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 
    
    function update(){
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        // $this->form_validation->set_rules('range','Periode','required'); 
        // $this->form_validation->set_rules('minggu_ke','Minggu Ke','trim|required|numeric'); 
        // $this->form_validation->set_rules('total_kunjungan','Total Kunjungan','trim|required|numeric'); 
        $this->form_validation->set_rules('minggu_ke','Minggu Ke','trim|required|numeric'); 

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            if ($data["ttd"] == "pengelola") {
                $data["nama_pengelola"] = $this->om->user()->nama_lengkap;
                $data["nip_pengelola"] = $this->om->user()->nip_operator_dinas;
            } else {
                $data["nama_pengelola"] = $data2["nama_pengelola"];
                $data["nip_pengelola"] = $data2["nip_pengelola"];
            }
            $data["tanda"] = $data["ttd"]; 
            unset($data["ttd"]);

            $data["pimpinan"] = $this->om->user()->pimpinan;
            $data["nip_pimpinan"] = $this->om->user()->nip_pimpinan;



            $this->db->where("id_kalender",$data["minggu_ke"]);
            $ab = $this->db->get("kalender")->row();
            // unset($data["minggu_ke"]);
            $data["id_minggu_ke"] = $ab->id_kalender;
            $data["minggu_ke"] = $ab->minggu_ke;
            $data["periode_awal"] = ($ab->periode_awal);
            $data["periode_akhir"] = ($ab->periode_akhir);
            $data["bulan"] = $ab->bulan;
            $data["tahun"] = $ab->tahun;
            // unset($data["minggu_ke"]);
            $this->db->where('username', $this->session->userdata("admin_username"));
            $this->db->where("id_w_dua", $data["id_w_dua"]);
            $this->db->update('w_dua',$data); 
            

            unset($data["nama_pengelola"]);
            unset($data["nip_pengelola"]);
            unset($data["nip_pimpinan"]);
            unset($data["pimpinan"]);
            unset($data["tanda"]);
            unset($data["id_minggu_ke"] );
            $this->db->where('id_pkm', $this->session->userdata("admin_pkm"));
            $this->db->where("id_w_dua", $data["id_w_dua"]);
            $this->db->update('w_dua_isi',$data); 
            // echo $this->db->last_query();
            $ret = array("success" => true,
                "title" => "Berhasil",
                "pesan" => "Data berhasil disimpan");
            
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 


    function hapus_data(){
        $list_id = $this->input->post('id');
        $this->session->set_userdata("list_id",$list_id);
        $sess = $this->session->userdata("list_id");
        foreach ($list_id as $id) {
          
                $this->db->where('username', $this->session->userdata("admin_username"));
                $this->db->where("id_admin_bias",$id);
                $we = $this->om->delete("admin_bias");

                if ($we) {
                    foreach ($sess as $ve) {
                        $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
                        $this->db->where("id_admin_bias",$ve);
                        $res =$this->db->delete("admin_bias_isi");
                        $this->session->unset_userdata("list_id");
                    }
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
           
        }
        echo json_encode($ret);
    } 


    function pdf_laporan($id,$id_pkm='') {
        $this->db->where("id_admin_bias", $id);
        $data["admin_bias"] = $this->db->get("admin_bias")->row();

        $data["title"] = "Data BIAS Tahun ".$data["admin_bias"]->tahun. " Per Sekolah";

        $this->db->order_by("sekolah","ASC");
        $this->db->where("admin_bias_isi.id_admin_bias",$id);
        // $this->db->where("admin_bias_isi.id_pkm",$this->session->userdata("admin_pkm"));
        if ($this->session->userdata("admin_level")=='admin'){
            $data["id_pkm"] = $id_pkm;
            $this->db->where("admin_bias_isi.id_pkm", $id_pkm);
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        } else {
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $this->db->where("admin_bias_isi.id_pkm", $this->session->userdata("admin_pkm"));
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        }
        $data["res"] = $this->db->get();

        $this->db->where("admin_bias_isi.id_admin_bias",$id);
        if ($this->session->userdata("admin_level")=='admin'){
            $this->db->where("admin_bias_isi.id_pkm", $id_pkm);
        } else {
            $this->db->where("admin_bias_isi.id_pkm", $this->session->userdata("admin_pkm"));
        }

        $this->db->select("
            sum(absen_kelas_1_l) as absen_kelas_1_l,
            sum(absen_kelas_1_p) as absen_kelas_1_p,
            sum(absen_kelas_2_l) as absen_kelas_2_l,
            sum(absen_kelas_2_p) as absen_kelas_2_p,
            sum(absen_kelas_5_l) as absen_kelas_5_l,
            sum(absen_kelas_5_p) as absen_kelas_5_p,
            sum(imun_kelas_1_l_dt) as imun_kelas_1_l_dt,
            sum(imun_kelas_1_p_dt) as imun_kelas_1_p_dt,
            sum(imun_kelas_1_l_cpk) as imun_kelas_1_l_cpk,
            sum(imun_kelas_1_p_cpk) as imun_kelas_1_p_cpk,
            sum(imun_kelas_2_l) as imun_kelas_2_l,
            sum(imun_kelas_2_p) as imun_kelas_2_p,
            sum(imun_kelas_5_l) as imun_kelas_5_l,
            sum(imun_kelas_5_p) as imun_kelas_5_p,
            sum(vaksin_dt) as vaksin_dt,
            sum(vaksin_cpk) as vaksin_cpk,
            sum(vaksin_td) as vaksin_td,
            sum(logistik_5ml) as logistik_5ml,
            sum(logistik_05ml) as logistik_05ml");

        $this->db->from("admin_bias_isi");
        $data["jum"] = $this->db->get()->row();

        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("L", "F4");

        $html = $this->load->view(get_class($this)."_laporan_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function pdf_laporan_desa($id,$id_pkm='') {
        $this->db->where("id_admin_bias", $id);
        $data["admin_bias"] = $this->db->get("admin_bias")->row();

        $data["title"] = "Data BIAS Tahun ".$data["admin_bias"]->tahun. " Per Desa";

        $this->db->order_by("desa","ASC");
        $this->db->where("admin_bias_isi.id_admin_bias",$id);
        // $this->db->where("admin_bias_isi.id_pkm",$this->session->userdata("admin_pkm"));
        if ($this->session->userdata("admin_level")=='admin'){
            $data["id_pkm"] = $id_pkm;
            $this->db->where("admin_bias_isi.id_pkm", $id_pkm);
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        } else {
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $this->db->where("admin_bias_isi.id_pkm", $this->session->userdata("admin_pkm"));
            $this->om->view_join_one("admin_bias_isi","admin_bias","id_admin_bias");
        }
        $this->db->group_by("admin_bias_isi.id_desa");
        $this->db->select("
            sum(absen_kelas_1_l) as absen_kelas_1_l,
            sum(absen_kelas_1_p) as absen_kelas_1_p,
            sum(absen_kelas_2_l) as absen_kelas_2_l,
            sum(absen_kelas_2_p) as absen_kelas_2_p,
            sum(absen_kelas_5_l) as absen_kelas_5_l,
            sum(absen_kelas_5_p) as absen_kelas_5_p,
            sum(imun_kelas_1_l_dt) as imun_kelas_1_l_dt,
            sum(imun_kelas_1_p_dt) as imun_kelas_1_p_dt,
            sum(imun_kelas_1_l_cpk) as imun_kelas_1_l_cpk,
            sum(imun_kelas_1_p_cpk) as imun_kelas_1_p_cpk,
            sum(imun_kelas_2_l) as imun_kelas_2_l,
            sum(imun_kelas_2_p) as imun_kelas_2_p,
            sum(imun_kelas_5_l) as imun_kelas_5_l,
            sum(imun_kelas_5_p) as imun_kelas_5_p,
            sum(vaksin_dt) as vaksin_dt,
            sum(vaksin_cpk) as vaksin_cpk,
            sum(vaksin_td) as vaksin_td,
            sum(logistik_5ml) as logistik_5ml,
            sum(logistik_05ml) as logistik_05ml");


        $data["res"] = $this->db->get();

        $this->db->where("admin_bias_isi.id_admin_bias",$id);
        if ($this->session->userdata("admin_level")=='admin'){
            $this->db->where("admin_bias_isi.id_pkm", $id_pkm);
        } else {
            $this->db->where("admin_bias_isi.id_pkm", $this->session->userdata("admin_pkm"));
        }

        $this->db->select("
            sum(absen_kelas_1_l) as absen_kelas_1_l,
            sum(absen_kelas_1_p) as absen_kelas_1_p,
            sum(absen_kelas_2_l) as absen_kelas_2_l,
            sum(absen_kelas_2_p) as absen_kelas_2_p,
            sum(absen_kelas_5_l) as absen_kelas_5_l,
            sum(absen_kelas_5_p) as absen_kelas_5_p,
            sum(imun_kelas_1_l_dt) as imun_kelas_1_l_dt,
            sum(imun_kelas_1_p_dt) as imun_kelas_1_p_dt,
            sum(imun_kelas_1_l_cpk) as imun_kelas_1_l_cpk,
            sum(imun_kelas_1_p_cpk) as imun_kelas_1_p_cpk,
            sum(imun_kelas_2_l) as imun_kelas_2_l,
            sum(imun_kelas_2_p) as imun_kelas_2_p,
            sum(imun_kelas_5_l) as imun_kelas_5_l,
            sum(imun_kelas_5_p) as imun_kelas_5_p,
            sum(vaksin_dt) as vaksin_dt,
            sum(vaksin_cpk) as vaksin_cpk,
            sum(vaksin_td) as vaksin_td,
            sum(logistik_5ml) as logistik_5ml,
            sum(logistik_05ml) as logistik_05ml");

        $this->db->from("admin_bias_isi");
        $data["jum"] = $this->db->get()->row();

        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("L", "F4");

        $html = $this->load->view(get_class($this)."_desa_laporan_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 


    
    function pdf_laporan_dinas($tahun,$ttd) {
        cek_session_admin();
        $data["admin_bias"] = $tahun;

        $data["title"] = "Rekapitulasi BIAS ".$data["admin_bias"];

        $this->db->order_by("master_pkm.id_pkm","ASC");
        $this->db->where("tahun",$tahun);
        $this->db->group_by("admin_bias_isi.id_pkm");
        $this->db->join("master_pkm", "master_pkm.id_pkm = admin_bias_isi.id_pkm");
        $this->db->select("master_pkm.nama_pkm,master_pkm.id_pkm,
            sum(absen_kelas_1_l) as absen_kelas_1_l,
            sum(absen_kelas_1_p) as absen_kelas_1_p,
            sum(absen_kelas_2_l) as absen_kelas_2_l,
            sum(absen_kelas_2_p) as absen_kelas_2_p,
            sum(absen_kelas_5_l) as absen_kelas_5_l,
            sum(absen_kelas_5_p) as absen_kelas_5_p,
            sum(imun_kelas_1_l_dt) as imun_kelas_1_l_dt,
            sum(imun_kelas_1_p_dt) as imun_kelas_1_p_dt,
            sum(imun_kelas_1_l_cpk) as imun_kelas_1_l_cpk,
            sum(imun_kelas_1_p_cpk) as imun_kelas_1_p_cpk,
            sum(imun_kelas_2_l) as imun_kelas_2_l,
            sum(imun_kelas_2_p) as imun_kelas_2_p,
            sum(imun_kelas_5_l) as imun_kelas_5_l,
            sum(imun_kelas_5_p) as imun_kelas_5_p,
            sum(vaksin_dt) as vaksin_dt,
            sum(vaksin_cpk) as vaksin_cpk,
            sum(vaksin_td) as vaksin_td,
            sum(logistik_5ml) as logistik_5ml,
            sum(logistik_05ml) as logistik_05ml");

        $this->db->from("admin_bias_isi");
        $data["res"] = $this->db->get();
        // echo $this->db->last_query();
        // exit();

        $this->db->where("tahun",$tahun);
        $this->db->select("
            sum(absen_kelas_1_l) as absen_kelas_1_l,
            sum(absen_kelas_1_p) as absen_kelas_1_p,
            sum(absen_kelas_2_l) as absen_kelas_2_l,
            sum(absen_kelas_2_p) as absen_kelas_2_p,
            sum(absen_kelas_5_l) as absen_kelas_5_l,
            sum(absen_kelas_5_p) as absen_kelas_5_p,
            sum(imun_kelas_1_l_dt) as imun_kelas_1_l_dt,
            sum(imun_kelas_1_p_dt) as imun_kelas_1_p_dt,
            sum(imun_kelas_1_l_cpk) as imun_kelas_1_l_cpk,
            sum(imun_kelas_1_p_cpk) as imun_kelas_1_p_cpk,
            sum(imun_kelas_2_l) as imun_kelas_2_l,
            sum(imun_kelas_2_p) as imun_kelas_2_p,
            sum(imun_kelas_5_l) as imun_kelas_5_l,
            sum(imun_kelas_5_p) as imun_kelas_5_p,
            sum(vaksin_dt) as vaksin_dt,
            sum(vaksin_cpk) as vaksin_cpk,
            sum(vaksin_td) as vaksin_td,
            sum(logistik_5ml) as logistik_5ml,
            sum(logistik_05ml) as logistik_05ml");

        $this->db->from("admin_bias_isi");
        $data["jum"] = $this->db->get()->row();


        $data["ttd"] = $ttd;
        if ($ttd == "kadis") {
            $data["ttd_nama"] = $this->om->web_me()->kadis;
            $data["ttd_jabatan"] = "Kepala Dinas Kesehatan ";
            $data["ttd_nip"] = $this->om->web_me()->nip_kadis;
        } elseif ($ttd== "kasi") {
            $data["ttd_nama"] = $this->om->web_me()->kepala_seksi;
            $data["ttd_jabatan"] = "Ka. Seksi surveilans dan imunisasi ";
            $data["ttd_nip"] = $this->om->web_me()->nip_kepala_seksi;
        } else {
            $data["ttd_nama"] = $this->om->web_me()->kabid;
            $data["ttd_jabatan"] = "Kepala Bidang P2P";
            $data["ttd_nip"] = $this->om->web_me()->nip_kabid;
        }


        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(5, 10, 5);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("L", "F4");

        $html = $this->load->view(get_class($this)."_laporan_dinas_pdf_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 


}
