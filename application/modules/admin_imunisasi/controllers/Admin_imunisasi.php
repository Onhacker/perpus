<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_imunisasi extends Admin_Controller {
	function __construct(){
		parent::__construct();
		// cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_imunisasi", "dm");
        // echo FCPATH;
        // exit();
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Data Imunisasi";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)). " Anak" ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

    function kipi(){
        $data["controller"] = get_class($this);     
        $data["title"] = $this->om->engine_nama_menu(get_class($this));
        $data["subtitle"] = "Data Kejadian Ikutan Pasca Imunisasi (KIPI) Anak" ;
        $data["content"] = $this->load->view("Kipi_view",$data,true); 
        $this->render($data);
    }

    function ibu(){
        $data["controller"] = get_class($this);     
        $data["title"] = "Data Imunisasi";
        $data["subtitle"] = $this->om->engine_nama_menu(get_class($this)). " Ibu" ;
        $data["content"] = $this->load->view($data["controller"]."_ibu_view",$data,true); 
        $this->render($data);
    }

    function covid(){
        $this->load->model("M_admin_imunisasi_covid", "km");
        $data["controller"] = get_class($this);     
        $data["title"] = "Data Sasaran Imunisasi Covid-19";
        $data["subtitle"] = $this->om->engine_nama_menu(get_class($this)). " Covid-19" ;
        $data["content"] = $this->load->view($data["controller"]."_covid_view",$data,true); 
        $this->render($data);
    }

    function luar(){
        $this->load->model("M_admin_imunisasi_luar", "km");
        $data["controller"] = get_class($this);     
        $data["title"] = "Data Imunisasi Luar Wilayah";
        $data["subtitle"] = $this->om->engine_nama_menu(get_class($this)). " Luar Wilayah" ;
        $data["content"] = $this->load->view($data["controller"]."_luar_view",$data,true); 
        $this->render($data);
    }

    function riwayat(){
        
        $data["controller"] = get_class($this);     
        $data["title"] = "Imunisasi";
        $data["subtitle"] = "Data Riwayat Imunisasi Anak" ;
        $data["content"] = $this->load->view($data["controller"]."_riwayat_view",$data,true); 
        $this->render($data);
    }

    function riwayat_ibu(){
        
        $data["controller"] = get_class($this);     
        $data["title"] = "Imunisasi";
        $data["subtitle"] = "Data Riwayat Imunisasi Ibu" ;
        $data["content"] = $this->load->view($data["controller"]."_riwayat_ibu_view",$data,true); 
        $this->render($data);
    }

    function cari_anak(){
        $data = $this->input->post();
        $tahun = $this->om->web_me()->tahun_akhir;
        $tahun_1 = $tahun-1;
        $this->db->order_by("nama");
        $data['nama'] = empty($data['nama'])?"qqqqq":$data['nama'];
        $this->db->where_in("tahun",[$tahun,$tahun_1]);
        // $this->db->or_where("tahun",$tahun_1);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $this->db->like("nama",$data['nama']);
        $x['record']  = $this->db->get("im_anak");
        $x['target']  = $data['target'];
    // echo $this->db->last_query();
        $this->load->view("search_anak_table",$x);
    }

    function cari_pasca_imunisasi(){
        $data = $this->input->post();
        $tahun = $this->om->web_me()->tahun_akhir;
        $this->db->order_by("tgl_suntik","DESC");
        $data['nama'] = empty($data['nama'])?"qqqqq":$data['nama'];
        $this->db->where_in("tahun",[$tahun,$tahun_1]);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $this->db->like("nama",$data['nama']);
        // $this->db->group_by("id_anak");
        $this->db->group_by("tgl_suntik");
        $x['record']  = $this->db->get("imunisasi");
        $x['target']  = $data['target'];
    // echo $this->db->last_query();
        $this->load->view("search_kipi_table",$x);
    }

     function cari_ibu(){
        $data = $this->input->post();
        $tahun = $this->om->web_me()->tahun_akhir;
        $this->db->order_by("nama");
        $data['nama'] = empty($data['nama'])?"qqqqq":$data['nama'];
        $this->db->where_in("tahun",[$tahun,$tahun_1]);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $this->db->like("nama",$data['nama']);
        $x['record']  = $this->db->get("im_ibu");
        $x['target']  = $data['target'];
    // echo $this->db->last_query();
        $this->load->view("search_ibu_table",$x);
    }

    function get_data_parent(){
        $ret_arr = array();
        $tahun = $this->om->web_me()->tahun_akhir;
        $data = $this->input->post();
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        // $this->db->where("tahun",$tahun);
        $this->db->where("id_anak",$data['id_anak']);
        $res = $this->db->get("im_anak");
        // echo $this->db->last_query();
        if($res->num_rows() > 0 ){
            $ret_arr = $res->row_array();
        }
        else {
            $ret_arr = array();
        }
        $this->db->where("id_desa",$ret_arr["id_desa"]);
        $de = $this->db->get("master_desa")->row();
        $ret_arr["desa"] = ucwords(strtolower($de->desa));

        $this->db->where("id_agama",$ret_arr["id_agama"]);
        $ag = $this->db->get("im_agama")->row();
        $ret_arr["agama"] = ucwords(strtolower($ag->agama));

        $this->db->where("id_pekerjaan",$ret_arr["id_pekerjaan_ayah"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $ret_arr["pekerjaan_ayah"] = ucwords(strtolower($pk->pekerjaan));


        $this->db->where("id_pekerjaan",$ret_arr["id_pekerjaan_ibu"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $ret_arr["pekerjaan_ibu"] = ucwords(strtolower($pk->pekerjaan));

        $ret_arr["umur"] = umur($ret_arr["tgl_lahir"]);
        $ret_arr["tgl_lahir"] = tgl_indo($ret_arr["tgl_lahir"]);

        echo json_encode($ret_arr);
    }

    function get_data_parent_kipi(){
        $ret_arr = array();
        $tahun = $this->om->web_me()->tahun_akhir;
        $data = $this->input->post();
        $ter = explode("_", $data["id_anak"]);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $this->db->where("tahun",$tahun);
        $this->db->where("tgl_suntik",$ter[1]);
        $this->db->where("id_anak",$ter[0]);
        $res = $this->db->get("imunisasi");

        // echo $this->db->last_query();
        if($res->num_rows() > 0 ){
            $ret_arr = $res->row_array();
        }
        else {
            $ret_arr = array();
        }

        $this->db->where("id_anak",$ret_arr['id_anak']);
        $this->db->where("tahun",$tahun);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $this->db->where("tgl_suntik",$ret_arr["tgl_suntik"]);
        $this->db->select("jenis_vaksin");
        $this->db->from("imunisasi");
        $this->db->limit(1,0);
        $this->db->order_by("urutan","ASC");
        $v1 = $this->db->get()->row();
        $this->db->where("id_penyakit",$v1->jenis_vaksin);
        $v11 = $this->db->get("master_penyakit")->row();
        $ret_arr["v1"] = $v11->nama_penyakit;

        $this->db->where("id_anak",$ret_arr['id_anak']);
        $this->db->where("tahun",$tahun);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $this->db->where("tgl_suntik",$ret_arr["tgl_suntik"]);
        $this->db->select("jenis_vaksin");
        $this->db->from("imunisasi");
        $this->db->limit(1,1);
        $this->db->order_by("urutan","ASC");
        $v2 = $this->db->get()->row();
        $this->db->where("id_penyakit",$v2->jenis_vaksin);
        $v22 = $this->db->get("master_penyakit")->row();
        $ret_arr["v2"] = $v22->nama_penyakit;


        $this->db->where("id_desa",$ret_arr["id_desa"]);
        $de = $this->db->get("master_desa")->row();
        $ret_arr["desa"] = ucwords(strtolower($de->desa));

        $this->db->where("id_agama",$ret_arr["id_agama"]);
        $ag = $this->db->get("im_agama")->row();
        $ret_arr["agama"] = ucwords(strtolower($ag->agama));

        $this->db->where("id_pekerjaan",$ret_arr["id_pekerjaan_ayah"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $ret_arr["pekerjaan_ayah"] = ucwords(strtolower($pk->pekerjaan));


        $this->db->where("id_pekerjaan",$ret_arr["id_pekerjaan_ibu"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $ret_arr["pekerjaan_ibu"] = ucwords(strtolower($pk->pekerjaan));
        $ret_arr["tgl_suntikx"] = ($ret_arr["tgl_suntik"]);
        $ret_arr["umur"] = umur($ret_arr["tgl_lahir"]);
        $ret_arr["tgl_lahir"] = tgl_indo($ret_arr["tgl_lahir"]);
        $ret_arr["tgl_suntik"] = tgl_indo($ret_arr["tgl_suntik"]);


        echo json_encode($ret_arr);
    }

    function get_data_parent_ibu(){
        $ret_arr = array();
        $tahun = $this->om->web_me()->tahun_akhir;
        $data = $this->input->post();
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        $this->db->where("tahun",$tahun);
        $this->db->where("id_ibu",$data['id_ibu']);
        $res = $this->db->get("im_ibu");
        // echo $this->db->last_query();
        if($res->num_rows() > 0 ){
            $ret_arr = $res->row_array();
        }
        else {
            $ret_arr = array();
        }
        $this->db->where("id_desa",$ret_arr["id_desa"]);
        $de = $this->db->get("master_desa")->row();
        $ret_arr["desa"] = ucwords(strtolower($de->desa));

        $this->db->where("id_agama",$ret_arr["id_agama"]);
        $ag = $this->db->get("im_agama")->row();
        $ret_arr["agama"] = ucwords(strtolower($ag->agama));

        $this->db->where("id_pekerjaan",$ret_arr["id_pekerjaan_ibu"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $ret_arr["pekerjaan_ibu"] = ucwords(strtolower($pk->pekerjaan));

        $ret_arr["umur"] = umur($ret_arr["tgl_lahir"]);
        $ret_arr["tgl_lahir"] = tgl_indo($ret_arr["tgl_lahir"]);

        echo json_encode($ret_arr);
    }

	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_imunisasi;
            $row["no_im"] = "<strong>".ucwords(strtolower($res->nama))."</strong><br>".$res->id_imunisasi;
            $row["nama"] = ucwords(strtolower($res->nama));
            $row["no_kia"] = $res->no_kia;
            $row["tgl_suntik"] = hari_ini($res->tgl_suntik).", ".tgl_view($res->tgl_suntik)."<br><span class='badge bg-success text-white'>Divaksin Umur : ".$res->vaksin_umur."</span>";;
            $row["jk"] = $res->jk;
            $row["tempat_pelayanan"] = $res->tempat_pelayanan;
            $this->db->where("id_penyakit",$res->jenis_vaksin);
            $pe = $this->db->get("master_penyakit")->row();
            $row["nama_ibu"] = $pe->nama_penyakit;

            $row["ber"] = imun_berikut($res->jenis_vaksin,$res->tgl_lahir);
            // $row["do"] = drop_out($res->jenis_vaksin,$res->tgl_suntik);

            $this->db->where("id_desa", $res->id_desa);
            $desa = $this->db->get("master_desa")->row();
            $row["desa"] = ucwords(strtolower($desa->desa));

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
         	// $row["ttl"] = $res->tempat_lahir.", ".tgl_view($res->tgl_lahir);
            $row["ttl"] = ucwords(strtolower($res->tempat_lahir)).", ".tgl_view($res->tgl_lahir)."<br><span class='badge bg-blue text-white'>Umur Saat ini: ".umur($res->tgl_lahir)."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_imunisasi.'"><label></label></div>';

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

    function get_data_kipi(){   
        $this->load->model("M_kipi", "kp");
        $list = $this->kp->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->urutan;
            $row["no_im"] = "<strong>".ucwords(strtolower($res->nama))."</strong>/<br>".ucwords(strtolower($res->nama_ibu));
            $row["jk"] = $res->jk;
            $row["ttl"] = ucwords(strtolower($res->tempat_lahir)).", ".tgl_view($res->tgl_lahir)."<br><span class='badge bg-blue text-white'>Umur Saat ini: ".umur($res->tgl_lahir)."</span>";
            $row["tgl_suntik"] = hari_ini($res->tgl_suntik).", ".tgl_view($res->tgl_suntik)."<br><span class='badge bg-success text-white'>Divaksin Umur : ".$res->vaksin_umur."</span>";;
            
            $this->db->where("id_penyakit", $res->jenis_vaksin_1);
            $v1 = $this->db->get("master_penyakit")->row();
            $row["v1"] = $v1->nama_penyakit."<br>".$res->no_vaksin_1;
            
            $this->db->where("id_penyakit", $res->jenis_vaksin_2);
            $v2 = $this->db->get("master_penyakit")->row();
            $row["v2"] = $v2->nama_penyakit."<br>".$res->no_vaksin_2;

            if ($res->demam == "Y") {
                $ge1 = "Demam<br> ";
            } else {
                $ge1 = "";
            }
            if ($res->bengkak == "Y") {
                $ge2 = "Bengkak<br> ";
            } else {
                $ge2 = "";
            }
            if ($res->merah == "Y") {
                $ge3 = "Merah<br> ";
            } else {
                $ge3 = "";
            }
            if ($res->muntah == "Y") {
                $ge4 = "Muntah<br>";
            } else {
                $ge4 = "";
            }

            $row["gejala"] = "<span class='badge bg-danger text-white'>".$ge1.$ge2.$ge3.$ge4.$res->lainnya."</span>";
           // echo $this->db->last_query();

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
            
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->urutan.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kp->count_all(),
            "recordsFiltered" => $this->kp->count_filtered(),
            "data" => $data,
        );
         
        echo json_encode($output);
    }

    function get_data_luar(){   
        $this->load->model("M_admin_imunisasi_luar", "fm");
        $list = $this->fm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_imunisasi;
            $row["no_im"] = $res->id_imunisasi;
            $row["nama"] = ucwords(strtolower($res->nama));
            $row["tgl_suntik"] = hari_ini($res->tgl_suntik).", ".tgl_view($res->tgl_suntik)."<br><span class='badge bg-success text-white'>Divaksin Umur : ".$res->vaksin_umur."</span>";;
            $row["jk"] = $res->jk;
            $row["tempat_pelayanan"] = $res->tempat_pelayanan;
            $this->db->where("id_penyakit",$res->jenis_vaksin);
            $pe = $this->db->get("master_penyakit")->row();
            $row["nama_ibu"] = $pe->nama_penyakit;
            $this->db->where("id_desa", $res->id_desa);
            $desa = $this->db->get("master_desa")->row();
            $row["desa"] = ucwords(strtolower($desa->desa));

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
            $row["alamat"] = ucwords(strtolower($res->alamat));
            $row["ttl"] = tgl_view($res->tgl_lahir)."<br><span class='badge bg-blue text-white'>Umur Saat ini: ".umur($res->tgl_lahir)."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_imunisasi.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->fm->count_all(),
            "recordsFiltered" => $this->fm->count_filtered(),
            "data" => $data,
        );
         // echo $this->db->last_query();
        echo json_encode($output);
    }


    function get_data_ibu(){   
        $this->load->model("M_admin_imunisasi_ibu", "km");
        $list = $this->km->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_imunisasi_ibu;
            $row["no_im"] = $res->id_imunisasi_ibu;
            $row["nama"] = ucwords(strtolower($res->nama));
            $row["no_kia"] = $res->no_kia;
            $row["tgl_suntik"] = hari_ini($res->tgl_suntik).", ".tgl_view($res->tgl_suntik)."<br><span class='badge bg-success text-white'>Divaksin Umur : ".$res->vaksin_umur."</span>";;
            $row["jk"] = $res->jk;
            $row["tempat_pelayanan"] = $res->tempat_pelayanan;

            $row["nama_ibu"] = arr_vaksin_ibu($res->jenis_vaksin);

            $this->db->where("id_desa", $res->id_desa);
            $desa = $this->db->get("master_desa")->row();
            $row["desa"] = ucwords(strtolower($desa->desa));

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
            // $row["ttl"] = $res->tempat_lahir.", ".tgl_view($res->tgl_lahir);
            $row["ttl"] = ucwords(strtolower($res->tempat_lahir)).", ".tgl_view($res->tgl_lahir)."<br><span class='badge bg-blue text-white'>Umur Saat ini: ".umur($res->tgl_lahir)."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_imunisasi_ibu.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->km->count_all(),
            "recordsFiltered" => $this->km->count_filtered(),
            "data" => $data,
        );
         // echo $this->db->last_query();
        echo json_encode($output);
    }

    function get_data_covid(){   
        $this->load->model("M_admin_imunisasi_covid", "km");
        $list = $this->km->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_imunisasi_covid;
            $row["nik"] = $res->no_kia;
            $row["nama"] = $res->nama;
            $row["alamat"] = $res->alamat;
            $row["tgl_suntik"] = hari_ini($res->tgl_suntik).", ".tgl_view($res->tgl_suntik)."<br><span class='badge bg-success text-white'>Divaksin Umur : ".$res->vaksin_umur."</span>";;
            $row["jk"] = $res->jk;
            $row["no_hp"] = ($res->no_hp);

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
            $row["ttl"] = tgl_view($res->tgl_lahir)."<br><span class='badge bg-blue text-white'>Umur Saat ini: ".umur($res->tgl_lahir)."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_imunisasi_covid.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->km->count_all(),
            "recordsFiltered" => $this->km->count_filtered(),
            "data" => $data,
        );
         // echo $this->db->last_query();
        echo json_encode($output);
    }

    function get_data_riwayat(){   
        $this->load->model("M_admin_riwayat", "cm");
        $list = $this->cm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_anak;
            $row["nama"] = ucwords(strtolower($res->nama));
            $row["no_kia"] = $res->no_kia;
           
            $row["jk"] = $res->jk;
            $row["nama_ibu"] = ucwords(strtolower($res->nama_ibu));
            $this->db->where("id_desa", $res->id_desa);
            $desa = $this->db->get("master_desa")->row();
            $row["desa"] = ucwords(strtolower($desa->desa));

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
            $row["ttl"] = ucwords(strtolower($res->tempat_lahir)).", ".tgl_view($res->tgl_lahir);
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_anak.'"><label></label></div>';

            $row["cetak"] = '<a target= "_BLANK" href = "'.site_url("admin_imunisasi").'/pdf_riwayat/'.$res->id_anak.'" class="btn btn-primary btn-xs waves-effect waves-light"><i class="fa fa-print"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cm->count_all(),
            "recordsFiltered" => $this->cm->count_filtered(),
            "data" => $data,
        );
         // echo $this->db->last_query();
        echo json_encode($output);
    }

    function get_data_riwayat_ibu(){   
        $this->load->model("M_admin_riwayat_ibu", "dk");
        $list = $this->dk->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_ibu;
            $row["nama"] = ucwords(strtolower($res->nama));
            $row["no_kia"] = $res->no_kia;
           
            $row["jk"] = $res->jk;
            $row["nama_ibu"] = $res->nama_ibu;
            $this->db->where("id_desa", $res->id_desa);
            $desa = $this->db->get("master_desa")->row();
            $row["desa"] = ucwords(strtolower($desa->desa));

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
            $row["ttl"] = ucwords(strtolower($res->tempat_lahir)).", ".tgl_view($res->tgl_lahir);
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_ibu.'"><label></label></div>';

            $row["cetak"] = '<a target= "_BLANK" href = "'.site_url("admin_imunisasi").'/pdf_riwayat_ibu/'.$res->id_ibu.'" class="btn btn-primary btn-xs waves-effect waves-light"><i class="fa fa-print"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->dk->count_all(),
            "recordsFiltered" => $this->dk->count_filtered(),
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

        $this->db->where("id_desa",$data["id_desa"]);
        $de = $this->db->get("master_desa")->row();
        $data["desa"] = ucwords(strtolower($de->desa));

        $this->db->where("id_agama",$data["id_agama"]);
        $ag = $this->db->get("im_agama")->row();
        $data["agama"] = ucwords(strtolower($ag->agama));

        $this->db->where("id_pekerjaan",$data["id_pekerjaan_ayah"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = ucwords(strtolower($pk->pekerjaan));


        $this->db->where("id_pekerjaan",$data["id_pekerjaan_ibu"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = ucwords(strtolower($pk->pekerjaan));

        $data["umur"] = umur($data["tgl_lahir"]);
        $data["tgl_lahir"] = tgl_indo($data["tgl_lahir"]);


        $data["tgl_suntik"] = tgl_view($data["tgl_suntik"]);
        echo json_encode($data);
    }


    function edit_kipi($id){
        $this->load->model("M_kipi", "kp");
        $data = array();
        $res = $this->kp->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }

        $this->db->where("id_desa",$data["id_desa"]);
        $de = $this->db->get("master_desa")->row();
        $data["desa"] = ucwords(strtolower($de->desa));

        $this->db->where("id_agama",$data["id_agama"]);
        $ag = $this->db->get("im_agama")->row();
        $data["agama"] = ucwords(strtolower($ag->agama));

        $this->db->where("id_pekerjaan",$data["id_pekerjaan_ayah"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = ucwords(strtolower($pk->pekerjaan));


        $this->db->where("id_pekerjaan",$data["id_pekerjaan_ibu"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = ucwords(strtolower($pk->pekerjaan));

        $data["umur"] = umur($data["tgl_lahir"]);
        $data["tgl_lahir_l"] = tgl_view($data["tgl_lahir"]);
        $data["tgl_lahir"] = tgl_indo($data["tgl_lahir"]);

        $this->db->where("id_penyakit", $data["jenis_vaksin_1"]);
        $v1 = $this->db->get("master_penyakit")->row();
        $data["v1"] = $v1->nama_penyakit;
        // echo $this->db->last_query();

        $this->db->where("id_penyakit", $data["jenis_vaksin_2"]);
        $v2 = $this->db->get("master_penyakit")->row();
        $data["v2"] = $v2->nama_penyakit;

        $data["tgl_suntik_l"] = tgl_view($data["tgl_suntik"]);
        
        $data["tgl_suntikx"] = tgl_indo($data["tgl_suntik"]);
        $data["tgl_suntik"] = ($data["tgl_suntik"]);
        echo json_encode($data);
    }

    function edit_luar($id){
        $this->load->model("M_admin_imunisasi_luar", "fm");
        $data = array();
        $res = $this->fm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }

        $data["tgl_lahir"] = tgl_view($data["tgl_lahir"]);


        $data["tgl_suntik"] = tgl_view($data["tgl_suntik"]);
        echo json_encode($data);
    }

    function edit_ibu($id){
        $this->load->model("M_admin_imunisasi_ibu", "km");
        $data = array();
        $res = $this->km->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }

        $this->db->where("id_desa",$data["id_desa"]);
        $de = $this->db->get("master_desa")->row();
        $data["desa"] = ucwords(strtolower($de->desa));

        $this->db->where("id_agama",$data["id_agama"]);
        $ag = $this->db->get("im_agama")->row();
        $data["agama"] = ucwords(strtolower($ag->agama));

        $this->db->where("id_pekerjaan",$data["id_pekerjaan_ayah"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = ucwords(strtolower($pk->pekerjaan));


        $this->db->where("id_pekerjaan",$data["id_pekerjaan_ibu"]);
        $pk = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = ucwords(strtolower($pk->pekerjaan));

        $data["umur"] = umur($data["tgl_lahir"]);
        $data["tgl_lahir"] = tgl_indo($data["tgl_lahir"]);


        $data["tgl_suntik"] = tgl_view($data["tgl_suntik"]);
        echo json_encode($data);
    }

    function edit_covid($id){
        $this->load->model("M_admin_imunisasi_covid", "km");
        $data = array();
        $res = $this->km->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        $data["tgl_lahir"] = tgl_view($data["tgl_lahir"]);
        $data["tgl_suntik"] = tgl_view($data["tgl_suntik"]);
        echo json_encode($data);
    }

    function laporan_bayi(){
        // cek_session_admin();
        // $this->load->model("M_admin_tahun_vaksin", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Data Vaksin Anak";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_data_bayi_view",$data,true); 
        $this->render($data);
    }

    function laporan_kipi(){
        $this->load->model("M_kipi", "kp");
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Data KIPI";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view("Kipi_laporan",$data,true); 
        $this->render($data);
    }

    function laporan_kipi_luar(){
        $this->load->model("M_kipi", "kp");
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Data KIPI Luar Wilayah";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view("Kipi_luar_laporan",$data,true); 
        $this->render($data);
    }

    function laporan_luar(){
        $this->load->model("M_admin_imunisasi_luar", "km");
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Data Vaksin Luar Wilayah";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_data_luar_view",$data,true); 
        $this->render($data);
    }

    function laporan_ibu(){
        // cek_session_admin();
        // $this->load->model("M_admin_tahun_vaksin", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Data Vaksin Ibu";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_data_ibu_view",$data,true); 
        $this->render($data);
    }

     function laporan_covid(){
        $this->load->model("M_admin_imunisasi_covid", "km");
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Data Imunisasi Covid - 19 (Usia 18 - 59 Tahun)";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_data_covid_view",$data,true); 
        $this->render($data);
    }

    function laporan_imunisasi(){
        $data["controller"] = get_class($this);     
        if ($this->session->userdata("admin_level") == "admin") {
            $data["title"] = "Laporan Imunisasi Rutin Berdasarkan Bulan (PKM)";
        } else {
            $data["title"] = "Laporan Imunisasi Rutin Berdasarkan Bulan";
        }
        
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_imunisasi_rutin_view",$data,true); 
        $this->render($data);
    }

     function laporan_imunisasi_range(){
        $data["controller"] = get_class($this);     
        if ($this->session->userdata("admin_level") == "admin") {
            $data["title"] = "Laporan Imunisasi Rutin Berdasarkan Periode (PKM)";
        } else {
            $data["title"] = "Laporan Imunisasi Rutin Berdasarkan Periode";
        }
        
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_imunisasi_rutin_range_view",$data,true); 
        $this->render($data);
    }

    function laporan_imunisasi_covid(){
        $data["controller"] = get_class($this);     
        if ($this->session->userdata("admin_level") == "admin") {
            $data["title"] = "Laporan Imunisasi Covid-19 Berdasarkan Bulan (PKM)";
        } else {
            $data["title"] = "Laporan Imunisasi Covid-19 Berdasarkan Bulan";
        }
        
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_imunisasi_covid_rutin_view",$data,true); 
        $this->render($data);
    }

    function laporan_imunisasi_berdasarkan_penyakit(){
        // cek_session_admin();
        // $this->load->model("M_admin_tahun_vaksin", "dm");
        $data["controller"] = get_class($this);     
        if ($this->session->userdata("admin_level") == "admin") {
            $data["title"] = "Laporan Imunisasi  Berdasarkan Jenis Imunisasi (PKM)";
        } else {
            $data["title"] = "Laporan Imunisasi  Berdasarkan Jenis Imunisasi";
        }
        
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_imunisasi_berdasarkan_penyakit_view",$data,true); 
        $this->render($data);
    }

    function laporan_imunisasi_dinas(){
        cek_session_admin();
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Imunisasi Rutin Dinas";
     
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_imunisasi_rutin_dinas_view",$data,true); 
        $this->render($data);
    }

    function laporan_imunisasi_dinas_range(){
        cek_session_admin();
        $this->db->select("min(tgl_suntik) as min from imunisasi");
        $min = $this->db->get()->row();
        $data["min"] = $min->min;

        $this->db->select("max(tgl_suntik) as max from imunisasi");
        $max = $this->db->get()->row();
        $data["max"] = $max->max;
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Imunisasi Rutin Berdasarkan Periode DInas";
     
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_imunisasi_rutin_dinas_range_view",$data,true); 
        $this->render($data);
    }

     function laporan_imunisasi_berdasarkan_penyakit_dinas(){
        cek_session_admin();
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Imunisasi Berdasarkan Jenis Imunisasi (Dinas)";
     
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_imunisasi_berdasarkan_penyakit_dinas_view",$data,true); 
        $this->render($data);
    }

    function laporan_bayi_pdf($tahun,$bulan,$id_pkm,$id_desa,$jk,$jenis_vaksin) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Data Imunisasi Anak";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        $data["jenis_vaksin"] = $jenis_vaksin;
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $data["id_desa"] = $id_desa;
        $this->db->where('year(tgl_suntik)', $tahun);
        // $this->db->where("tahun",$tahun);  
        $this->db->where('month(tgl_suntik)', $bulan);
        // $this->db->where("bulan",$bulan);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('tgl_suntik', 'DESC');
        // $this->db->order_by('bulan', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }

        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }

        $data["res"] = $this->db->get("imunisasi");
        
        $this->db->where('year(tgl_suntik)', $tahun);
        // $this->db->where("tahun",$tahun);  
        $this->db->where('month(tgl_suntik)', $bulan);
        // $this->db->where("bulan",$bulan);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","L");  
        $data["jum_l"] = $this->db->get("imunisasi")->num_rows();


        $this->db->where('year(tgl_suntik)', $tahun);
        // $this->db->where("tahun",$tahun);  
        $this->db->where('month(tgl_suntik)', $bulan);
        // $this->db->where("bulan",$bulan);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","P");  
        $data["jum_p"] = $this->db->get("imunisasi")->num_rows();

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
        $pdf->setPrintFooter(true);

     // add a page
        $pdf->AddPage("L", "F4");

        $html = $this->load->view(get_class($this)."_laporan_bayi_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 
   

    

    function kipi_laporan_pdf($tahun,$bulan,$id_pkm,$id_desa,$jk) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Data KIPI ";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
       
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $data["id_desa"] = $id_desa;
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        // $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('tgl_suntik', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }

        $this->db->where("wilayah", "1");
        $data["res"] = $this->db->get("imunisasi_kipi");
        
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        
        $this->db->where("jk","L"); 
        $this->db->where("wilayah", "1"); 
        $data["jum_l"] = $this->db->get("imunisasi_kipi")->num_rows();


        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        
        $this->db->where("jk","P");  
        $this->db->where("wilayah", "1");
        $data["jum_p"] = $this->db->get("imunisasi_kipi")->num_rows();

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

        $html = $this->load->view("Kipi_laporan_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function kipi_luar_laporan_pdf($tahun,$bulan,$id_pkm,$jk) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Data KIPI ";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
       
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('tgl_suntik', 'DESC');
        // $this->db->order_by('bulan', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
       
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }

        $this->db->where("wilayah", "2");
        $data["res"] = $this->db->get("imunisasi_kipi");
        
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        
        $this->db->where("jk","L"); 
        $this->db->where("wilayah", "2"); 
        $data["jum_l"] = $this->db->get("imunisasi_kipi")->num_rows();


        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
       
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        
        $this->db->where("jk","P");  
        $this->db->where("wilayah", "2");
        $data["jum_p"] = $this->db->get("imunisasi_kipi")->num_rows();

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
        $pdf->setPrintFooter(true);

     // add a page
        $pdf->AddPage("L", "F4");

        $html = $this->load->view("Kipi_luar_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function laporan_luar_pdf($tahun,$bulan,$id_pkm,$jk,$jenis_vaksin) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Data Anak";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        $data["jenis_vaksin"] = $jenis_vaksin;
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('tgl_suntik', 'DESC');
        // $this->db->order_by('bulan', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
       
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }

        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }

        $data["res"] = $this->db->get("imunisasi_luar");
        
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("create_date","DESC");
        $this->db->order_by("create_time","DESC");
       
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","L");  
        $data["jum_l"] = $this->db->get("imunisasi_luar")->num_rows();


        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("create_date","DESC");
        $this->db->order_by("create_time","DESC");
       
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","P");  
        $data["jum_p"] = $this->db->get("imunisasi_luar")->num_rows();

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

        $html = $this->load->view(get_class($this)."_laporan_luar_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function laporan_ibu_pdf($tahun,$bulan,$id_pkm,$id_desa,$jenis_vaksin) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Data Ibu";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        $data["jenis_vaksin"] = ($jenis_vaksin);
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $data["id_desa"] = $id_desa;
        // $this->db->where("tahun",$tahun);  
        $this->db->where('year(tgl_suntik)', $tahun);
        // $this->db->where("bulan",$bulan);  
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('tgl_suntik', 'DESC');
        // $this->db->order_by('bulan', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        // if ($jk <> "x" ) {
        //     $this->db->where("jk",$jk);  
        // }

        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }

        $data["res"] = $this->db->get("imunisasi_ibu");
        
         // $this->db->where("tahun",$tahun);  
        $this->db->where('year(tgl_suntik)', $tahun);
        // $this->db->where("bulan",$bulan);  
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_ibu","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        // if ($jk <> "x" ) {
        //     $this->db->where("jk",$jk);  
        // }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","L");  
        $data["jum_l"] = $this->db->get("imunisasi_ibu")->num_rows();
        // $this->db->where("tahun",$tahun);  
        $this->db->where('year(tgl_suntik)', $tahun);
        // $this->db->where("bulan",$bulan);  
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_ibu","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        // if ($jk <> "x" ) {
        //     $this->db->where("jk",$jk);  
        // }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","P");  
        $data["jum_p"] = $this->db->get("imunisasi_ibu")->num_rows();

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
        $pdf->setPrintFooter(true);

     // add a page
        $pdf->AddPage("L", "F4");

        $html = $this->load->view(get_class($this)."_laporan_ibu_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 


    function laporan_covid_pdf($tahun,$bulan,$id_pkm) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Data Imunisasi COvid-19";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $this->db->where("tahun",$tahun);  
        $this->db->where("bulan",$bulan);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('bulan', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
        $data["res"] = $this->db->get("imunisasi_covid");
        
     //    $data['header'] = $data["title"];
     //    $this->load->library('Pdf');
     //    $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
     //    $pdf->SetTitle( $data['header']);
        
     //    $pdf->SetMargins(10, 10, 10);
     //    $pdf->SetHeaderMargin(10);
     //    $pdf->SetFooterMargin(10);
     //    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

     //    $pdf->SetAutoPageBreak(true,10);
     //    $pdf->SetAuthor('Onhacker.net');

        
     //    $pdf->setPrintHeader(false);
     //    $pdf->setPrintFooter(true);

     // // add a page
     //    $pdf->AddPage("L", "F4");

        // $html = $this->load->view(get_class($this)."_laporan_covid_pdf",$data,true);
        // $pdf->writeHTML($html, true, false, true, false, '');
        // $pdf->Output($data['header'] .'.pdf', 'I');
        $this->load->view(get_class($this)."_laporan_covid_pdf",$data);
    } 

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'IP tidak dikenali';
        return $ipaddress;
    }

    function kode_imunisasi(){
        $acak = date("dHis");
        // $acak = hash("sha512", md5($acak));
        // $serial = substr(preg_replace("/[^0-9]/", '', $acak),0,4);
        return ($acak);
      
    }

    function add(){
		$data = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama','Pilih Anak','required'); 
		$this->form_validation->set_rules('id_anak','Pilih Anak','required'); 
        $this->form_validation->set_rules('pemberi_imunisasi','Pemberi Imunisasi','required'); 
        $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
		$this->form_validation->set_rules('jenis_vaksin','Jenis Vaksin','required'); 
		$this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
        $data["bulan"] = substr($data["tgl_suntik"],3,2);
        $data["tahun"] = substr($data["tgl_suntik"],6,4);
        // 11-11-1111
        $this->db->where("id_anak", $data["id_anak"]);
        $an = $this->db->get("im_anak")->row();
            $data["id_imunisasi"] = $this->session->userdata("admin_pkm").substr($an->tahun, 2,3).$data["bulan"].$this->kode_imunisasi();
            $data["id_anak"] = $an->id_anak;
            $data["no_kia"] = $an->no_kia;
            $data["nama"] = $an->nama;
            $data["jk"] = $an->jk;
            $data["tempat_lahir"] = $an->tempat_lahir;
            $data["tgl_lahir"] = $an->tgl_lahir;
            $data["golda"] = $an->golda;
            $data["id_agama"] = $an->id_agama;
            $data["alamat"] = $an->alamat;
            $data["nama_ayah"] = $an->nama_ayah;
            $data["nik_ayah"] = $an->nik_ayah;
            $data["id_pekerjaan_ayah"] = $an->id_pekerjaan_ayah;
            $data["nama_ibu"] = $an->nama_ibu;
            $data["nik_ibu"] = $an->nik_ibu;
            $data["id_pekerjaan_ibu"] = $an->id_pekerjaan_ibu;
            $data["id_desa"] = $an->id_desa;
            $data["create_date"] = date("Y-m-d");
            $data["create_time"] = date("H:i:s");
            $data["username"] = $an->username;
            $data["id_pkm"] = $an->id_pkm;
            // $data["tahun"] = $an->tahun;

            $data["vaksin_umur"] = umur_simpan($an->tgl_lahir,tgl_simpan($data["tgl_suntik"]));
           
            
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);


			$this->db->where("no_kia", $data["no_kia"]);
            $this->db->where("jenis_vaksin", $data["jenis_vaksin"]);
            $this->db->where("bulan", $data["bulan"]);
			$this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $cek = $this->db->get("imunisasi");
            $r = $cek->row();
            $this->db->where("id_penyakit", $r->jenis_vaksin);
            $v = $this->db->get("master_penyakit")->row();
            if ($cek->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => $data["nama"]. " Sudah divaksin ".$v->nama_penyakit." pada bulan ". getBulan($r->bulan));
                echo json_encode($ret);
                return false;
            }
      
			$res  = $this->db->insert("imunisasi",$data);	
				
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil disimpan");
			} else {
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan");
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);

	}


    function add_kipi(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        // $this->form_validation->set_rules('wilayah','Nama','required'); 
        // $this->form_validation->set_rules('id_anak','Pilih Anak','required'); 
        // $this->form_validation->set_rules('pemberi_imunisasi','Pemberi Imunisasi','required'); 
        // $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
        // $this->form_validation->set_rules('jenis_vaksin_1','Jenis Vaksin 1','required'); 
        $this->form_validation->set_rules('no_vaksin_1','No Vaksin','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            
            if ($data["wilayah"] == "1") {
                if ($data["id_anak"] == "") {
                    $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Silahkan Cari Anak Pasca Imunisasi");
                    echo json_encode($ret);
                    return false;
                }
                $tahun = $this->om->web_me()->tahun_akhir;
                $ter = explode("_", $data["id_anak"]);
                $data["bulan"] = substr($ter[1],5,2);
                // 1111-11-11
                $data["tahun"] = substr($ter[1],0,4);
                $this->db->where("id_anak", $ter[0]);
                
                $an = $this->db->get("imunisasi")->row();
                $data["id_kipi"] = $this->session->userdata("admin_pkm").substr($an->tahun, 2,3).$data["bulan"].$this->kode_imunisasi();
                $this->db->where("id_anak",$an->id_anak);
                $this->db->where("tahun",$tahun);
                $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                $this->db->where("tgl_suntik",$ter[1]);
                $this->db->select("jenis_vaksin");
                $this->db->from("imunisasi");
                $this->db->limit(1,0);
                $this->db->order_by("urutan","ASC");
                $v1 = $this->db->get()->row();
                $data["jenis_vaksin_1"] = $v1->jenis_vaksin;
                // echo $this->db->last_query();
                // exit();
                $this->db->where("id_anak",$an->id_anak);
                $this->db->where("tahun",$tahun);
                $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                $this->db->where("tgl_suntik",$ter[1]);
                $this->db->select("jenis_vaksin");
                $this->db->from("imunisasi");
                $this->db->limit(1,1);
                $this->db->order_by("urutan","ASC");
                $v2 = $this->db->get()->row();
                $data["jenis_vaksin_2"] = $v2->jenis_vaksin;


                $data["id_anak"] = $an->id_anak;
                $data["no_kia"] = $an->no_kia;
                $data["nama"] = $an->nama;
                $data["jk"] = $an->jk;
                $data["tempat_lahir"] = $an->tempat_lahir;
                $data["tgl_lahir"] = $an->tgl_lahir;
                $data["golda"] = $an->golda;
                $data["id_agama"] = $an->id_agama;
                $data["alamat"] = $an->alamat;
                $data["nama_ayah"] = $an->nama_ayah;
                $data["nik_ayah"] = $an->nik_ayah;
                $data["id_pekerjaan_ayah"] = $an->id_pekerjaan_ayah;
                $data["nama_ibu"] = $an->nama_ibu;
                $data["nik_ibu"] = $an->nik_ibu;
                $data["id_pekerjaan_ibu"] = $an->id_pekerjaan_ibu;
                $data["id_desa"] = $an->id_desa;
                $data["pemberi_imunisasi"] = $an->pemberi_imunisasi;
                $data["tempat_pelayanan"] = $an->tempat_pelayanan;
                $data["create_date"] = date("Y-m-d");
                $data["create_time"] = date("H:i:s");
                $data["username"] = $an->username;
                $data["id_pkm"] = $an->id_pkm;
                // $data["tahun"] = $an->tahun;
                $data["vaksin_umur"] = umur_simpan($an->tgl_lahir,($ter[1]));
                $data["tgl_suntik"] = ($ter[1]);

                unset($data["nama_l"]);
                unset($data["jk_l"]);
                unset($data["tempat_lahir_l"]);
                unset($data["tgl_lahir_l"]);
                unset($data["nik_ibu_l"]);
                unset($data["nama_ibu_l"]);
                unset($data["alamat_l"]);
                unset($data["tgl_suntik_l"]);
                unset($data["pemberi_imunisasi_l"]);
                unset($data["tempat_pelayanan_l"]);

            } else {
                $data["id_kipi"] = $this->session->userdata("admin_pkm").substr(substr(($data["tgl_suntik_l"]), 6,4), 2,3).$data["bulan"].$this->kode_imunisasi();
                $data["id_pkm"] = $this->session->userdata("admin_pkm");
                $data["username"] = $this->session->userdata("admin_username");
                $data["tahun"] = substr(($data["tgl_suntik_l"]), 6,4);
                $data["bulan"] = substr(($data["tgl_suntik_l"]), 3,2);
                $data["vaksin_umur"] = umur_simpan($data["tgl_lahir_l"],($data["tgl_suntik_l"]));
                $data["create_date"] = date("Y-m-d");
                $data["create_time"] = date("H:i:s");
                $data["nama"] = ($data["nama_l"]);
                $data["jk"] = ($data["jk_l"]);
                $data["tempat_lahir"] = ($data["tempat_lahir_l"]);
                $data["tgl_lahir"] = tgl_simpan($data["tgl_lahir_l"]);
                $data["nik_ibu"] = ($data["nik_ibu_l"]);
                $data["nama_ibu"] = ($data["nama_ibu_l"]);
                $data["alamat"] = ($data["alamat_l"]);
                $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik_l"]);
                $data["pemberi_imunisasi"] = ($data["pemberi_imunisasi_l"]);
                $data["tempat_pelayanan"] = ($data["tempat_pelayanan_l"]);

                unset($data["nama_l"]);
                unset($data["jk_l"]);
                unset($data["tempat_lahir_l"]);
                unset($data["tgl_lahir_l"]);
                unset($data["nik_ibu_l"]);
                unset($data["nama_ibu_l"]);
                unset($data["alamat_l"]);
                unset($data["tgl_suntik_l"]);
                unset($data["pemberi_imunisasi_l"]);
                unset($data["tempat_pelayanan_l"]);
            }

            
      
            $res  = $this->db->insert("imunisasi_kipi",$data);   
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);

    }

    function update_kipi(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        // $this->form_validation->set_rules('wilayah','Nama','required'); 
        // $this->form_validation->set_rules('id_anak','Pilih Anak','required'); 
        // $this->form_validation->set_rules('pemberi_imunisasi','Pemberi Imunisasi','required'); 
        // $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
        // $this->form_validation->set_rules('jenis_vaksin_1','Jenis Vaksin 1','required'); 
        $this->form_validation->set_rules('no_vaksin_1','No Vaksin','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            
            if ($data["wilayah"] == "1") {
                if ($data["tgl_suntik"] == "") {
                    $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Silahkan Cari Anak Pasca Imunisasi");
                    echo json_encode($ret);
                    return false;
                }


                $tahun = $this->om->web_me()->tahun_akhir;
                $ter = explode("_", $data["id_anak"]);
                
                $this->db->where("urutan", $data["urutan"]);
                $an = $this->db->get("imunisasi_kipi")->row();
                $data["bulan"] = $an->bulan;
                // $data["id_kipi"] = $this->session->userdata("admin_pkm").substr($an->tahun, 2,3).$data["bulan"].$this->kode_imunisasi();
                $this->db->where("id_anak",$an->id_anak);
                $this->db->where("tahun",$tahun);
                $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                $this->db->where("tgl_suntik",$data["tgl_suntik"]);
                $this->db->select("jenis_vaksin");
                $this->db->from("imunisasi");
                $this->db->limit(1,0);
                $this->db->order_by("urutan","ASC");
                $v1 = $this->db->get()->row();
                $data["jenis_vaksin_1"] = $v1->jenis_vaksin;
                // echo $this->db->last_query();
                // exit();
                $this->db->where("id_anak",$an->id_anak);
                $this->db->where("tahun",$tahun);
                $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                $this->db->where("tgl_suntik",$data["tgl_suntik"]);
                $this->db->select("jenis_vaksin");
                $this->db->from("imunisasi");
                $this->db->limit(1,1);
                $this->db->order_by("urutan","ASC");
                $v2 = $this->db->get()->row();
                $data["jenis_vaksin_2"] = $v2->jenis_vaksin;


                $data["id_anak"] = $an->id_anak;
                $data["no_kia"] = $an->no_kia;
                $data["nama"] = $an->nama;
                $data["jk"] = $an->jk;
                $data["tempat_lahir"] = $an->tempat_lahir;
                $data["tgl_lahir"] = $an->tgl_lahir;
                $data["golda"] = $an->golda;
                $data["id_agama"] = $an->id_agama;
                $data["alamat"] = $an->alamat;
                $data["nama_ayah"] = $an->nama_ayah;
                $data["nik_ayah"] = $an->nik_ayah;
                $data["id_pekerjaan_ayah"] = $an->id_pekerjaan_ayah;
                $data["nama_ibu"] = $an->nama_ibu;
                $data["nik_ibu"] = $an->nik_ibu;
                $data["id_pekerjaan_ibu"] = $an->id_pekerjaan_ibu;
                $data["id_desa"] = $an->id_desa;
                $data["pemberi_imunisasi"] = $an->pemberi_imunisasi;
                $data["tempat_pelayanan"] = $an->tempat_pelayanan;
                // $data["create_date"] = date("Y-m-d");
                // $data["create_time"] = date("H:i:s");
                $data["username"] = $an->username;
                $data["id_pkm"] = $an->id_pkm;
                $data["tahun"] = $an->tahun;
                $data["vaksin_umur"] = umur_simpan($an->tgl_lahir,($data["tgl_suntik"]));
                $data["tgl_suntik"] = $data["tgl_suntik"];

                unset($data["nama_l"]);
                unset($data["jk_l"]);
                unset($data["tempat_lahir_l"]);
                unset($data["tgl_lahir_l"]);
                unset($data["nik_ibu_l"]);
                unset($data["nama_ibu_l"]);
                unset($data["alamat_l"]);
                unset($data["tgl_suntik_l"]);
                unset($data["pemberi_imunisasi_l"]);
                unset($data["tempat_pelayanan_l"]);

            } else {
                // $data["id_kipi"] = $this->session->userdata("admin_pkm").substr(substr(($data["tgl_suntik_l"]), 6,4), 2,3).$data["bulan"].$this->kode_imunisasi();
                if ($data["tgl_suntik_l"] == "") {
                    $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Tanggal Suntik");
                    echo json_encode($ret);
                    return false;
                }
                if ($data["tgl_lahir_l"] == "") {
                    $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Tanggal Lahir");
                    echo json_encode($ret);
                    return false;
                }
                $data["id_pkm"] = $this->session->userdata("admin_pkm");
                $data["username"] = $this->session->userdata("admin_username");
                $data["tahun"] = substr(($data["tgl_suntik_l"]), 6,4);
                $data["bulan"] = substr(($data["tgl_suntik_l"]), 3,2);
                $data["vaksin_umur"] = umur_simpan($data["tgl_lahir_l"],($data["tgl_suntik_l"]));
                // $data["create_date"] = date("Y-m-d");
                // $data["create_time"] = date("H:i:s");
                $data["nama"] = ($data["nama_l"]);
                $data["jk"] = ($data["jk_l"]);
                $data["tempat_lahir"] = ($data["tempat_lahir_l"]);
                $data["tgl_lahir"] = tgl_simpan($data["tgl_lahir_l"]);
                $data["nik_ibu"] = ($data["nik_ibu_l"]);
                $data["nama_ibu"] = ($data["nama_ibu_l"]);
                $data["alamat"] = ($data["alamat_l"]);
                $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik_l"]);
                $data["pemberi_imunisasi"] = ($data["pemberi_imunisasi_l"]);
                $data["tempat_pelayanan"] = ($data["tempat_pelayanan_l"]);

                unset($data["nama_l"]);
                unset($data["jk_l"]);
                unset($data["tempat_lahir_l"]);
                unset($data["tgl_lahir_l"]);
                unset($data["nik_ibu_l"]);
                unset($data["nama_ibu_l"]);
                unset($data["alamat_l"]);
                unset($data["tgl_suntik_l"]);
                unset($data["pemberi_imunisasi_l"]);
                unset($data["tempat_pelayanan_l"]);
            }

            $this->db->where("urutan",$data["urutan"]);
            $res  = $this->db->update("imunisasi_kipi",$data);   
            // echo $this->db->last_query();
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);

    }

    function add_luar(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Nama Anak','required'); 
        $this->form_validation->set_rules('pemberi_imunisasi','Pemberi Imunisasi','required'); 
        $this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required'); 
        $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
        $this->form_validation->set_rules('alamat','Alamat','required'); 
        $this->form_validation->set_rules('nama_ibu','Nama Ibu/Ayah','required'); 
        $this->form_validation->set_rules('jenis_vaksin','Jenis Vaksin','required'); 
        $this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["bulan"] = substr($data["tgl_suntik"],3,2);
            $data["tahun"] = substr($data["tgl_suntik"],6,4);
            $data["id_imunisasi"] = $this->session->userdata("admin_pkm").substr($an->tahun, 2,3).$data["bulan"].$this->kode_imunisasi();
            $data["create_date"] = date("Y-m-d");
            $data["create_time"] = date("H:i:s");
            $data["username"] = $this->session->userdata("admin_username");
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $data["vaksin_umur"] = umur_simpan($data["tgl_lahir"],tgl_simpan($data["tgl_suntik"]));
           
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);
            $data["tgl_lahir"] = tgl_simpan($data["tgl_lahir"]);
      
            $res  = $this->db->insert("imunisasi_luar",$data);   
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);

    }


   function add_ibu(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Pilih Ibu','required'); 
        $this->form_validation->set_rules('id_ibu','Pilih Ibu','required'); 
        $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
        $this->form_validation->set_rules('jenis_vaksin','Jenis Vaksin','required'); 
        $this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
        $data["bulan"] = substr($data["tgl_suntik"],3,2);
        $data["tahun"] = substr($data["tgl_suntik"],6,4);
        // 11-11-1111
        $this->db->where("id_ibu", $data["id_ibu"]);
        $an = $this->db->get("im_ibu")->row();
            $data["id_imunisasi_ibu"] = $this->session->userdata("admin_pkm").substr($an->tahun, 2,3).$data["bulan"].$this->kode_imunisasi();
            $data["id_ibu"] = $an->id_ibu;
            $data["no_kia"] = $an->no_kia;
            $data["nama"] = $an->nama;
            $data["jk"] = $an->jk;
            $data["tempat_lahir"] = $an->tempat_lahir;
            $data["tgl_lahir"] = $an->tgl_lahir;
            $data["golda"] = $an->golda;
            $data["id_agama"] = $an->id_agama;
            $data["alamat"] = $an->alamat;
          
            $data["id_pekerjaan_ibu"] = $an->id_pekerjaan_ibu;
            $data["id_desa"] = $an->id_desa;
            $data["create_date"] = date("Y-m-d");
            $data["create_time"] = date("H:i:s");
            $data["username"] = $an->username;
            $data["id_pkm"] = $an->id_pkm;
            // $data["tahun"] = $an->tahun;

            $data["vaksin_umur"] = umur_simpan($an->tgl_lahir,tgl_simpan($data["tgl_suntik"]));
           
            
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);


            $this->db->where("no_kia", $data["no_kia"]);
            $this->db->where("jenis_vaksin", $data["jenis_vaksin"]);
            $this->db->where("bulan", $data["bulan"]);
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $cek = $this->db->get("imunisasi_ibu");
            $r = $cek->row();
            // $this->db->where("id_penyakit", $r->jenis_vaksin);
            // $v = $this->db->get("master_penyakit")->row();
            if ($cek->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => $data["nama"]. " Sudah divaksin ".arr_vaksin_ibu($data["jenis_vaksin"])." pada bulan ". getBulan($r->bulan));
                echo json_encode($ret);
                return false;
            }
      
            $res  = $this->db->insert("imunisasi_ibu",$data);   
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);

    }

    function umur_covid($tgl_lahir){
        $birthDt = new DateTime($tgl_lahir);
        $today = new DateTime('today');
        $y = $today->diff($birthDt)->y;
        return $y;
        
    }

    function add_covid(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_kia','NIK','required'); 
        $this->form_validation->set_rules('nama','Nama','required'); 
        $this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required'); 
        $this->form_validation->set_rules('alamat','Alamat','required'); 
        $this->form_validation->set_rules('id_pekerjaan','Pekerjaan','required'); 
        $this->form_validation->set_rules('id_detail_pekerjaan','Detail Pekerjaan','required'); 
        $this->form_validation->set_rules('no_hp','No. HP','required'); 
        $this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["bulan"] = substr($data["tgl_suntik"],3,2);
            $data["tahun"] = substr($data["tgl_suntik"],6,4);
            $data["id_imunisasi_covid"] = $this->session->userdata("admin_pkm").$data["bulan"].$this->kode_imunisasi();
            $data["no_kia"] = str_replace(" ", "", $data["no_kia"]);
            $data["create_date"] = date("Y-m-d");
            $data["create_time"] = date("H:i:s");
            $data["username"] = $this->session->userdata("admin_username");
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $data["vaksin_umur"] = umur_simpan($data["tgl_lahir"],tgl_simpan($data["tgl_suntik"]));
            
            if ($data["komorbid"] == "2") {
                $data["hipertensi"] = "0";
                $data["diabetes"] = "0";
                $data["jantung"] = "0";
                $data["ginjal"] = "0";
                $data["paru"] = "0";
                $data["lainnya"] = "0";
            }

            if ($data["hipertensi"] == "" and $data["diabetes"] == "" and $data["jantung"] == "" and $data["ginjal"] == "" and $data["paru"] == "" and $data["lainnya"] == "" and $data["komorbid"] == "1") {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Centang Jenis Komorbid Jika ada atau pilih tidak ada pada Komorbid");
                echo json_encode($ret);
                return false;
            }


            $umur = $this->umur_covid($data["tgl_lahir"]);
            if ($umur < 18) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Umur ".$data["nama"]." Sekarang adalah ".$data["vaksin_umur"].". Umur Imunisasi Covid-19 tidak boleh kurang dari 18 Tahun");
                echo json_encode($ret);
                return false;
            }

            $data["tgl_lahir"] = tgl_simpan($data["tgl_lahir"]);
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);
            $res  = $this->db->insert("imunisasi_covid",$data);   
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);

    }

    function update_covid(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_kia','NIK','required'); 
        $this->form_validation->set_rules('nama','Nama','required'); 
        $this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required'); 
        $this->form_validation->set_rules('alamat','Alamat','required'); 
        $this->form_validation->set_rules('id_pekerjaan','Pekerjaan','required'); 
        $this->form_validation->set_rules('no_hp','No. HP','required'); 
        $this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            
            $data["bulan"] = substr($data["tgl_suntik"],3,2);
            $data["tahun"] = substr($data["tgl_suntik"],6,4);
            $data["no_kia"] = str_replace(" ", "", $data["no_kia"]);
            // $data["create_date"] = date("Y-m-d");
            // $data["create_time"] = date("H:i:s");
            $data["username"] = $this->session->userdata("admin_username");
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $data["vaksin_umur"] = umur_simpan($data["tgl_lahir"],tgl_simpan($data["tgl_suntik"]));
            
            if ($data["komorbid"] == "2") {
                $data["hipertensi"] = "0";
                $data["diabetes"] = "0";
                $data["jantung"] = "0";
                $data["ginjal"] = "0";
                $data["paru"] = "0";
                $data["lainnya"] = "0";
            } 

            if ($data["hipertensi"] == ""){
                $data["hipertensi"] = "0";
            }
            if ($data["diabetes"] == ""){
                $data["diabetes"] = "0";
            }
            if ($data["jantung"] == ""){
                $data["jantung"] = "0";
            }
            if ($data["ginjal"] == ""){
                $data["ginjal"] = "0";
            }
            if ($data["paru"] == ""){
                $data["paru"] = "0";
            }
            if ($data["lainnya"] == ""){
                $data["lainnya"] = "0";
            }
            if ($data["hipertensi"] == "0" and $data["diabetes"] == "0" and $data["jantung"] == "0" and $data["ginjal"] == "0" and $data["paru"] == "0" and $data["lainnya"] == "0" and $data["komorbid"] == "1") {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Centang Jenis Komorbid Jika ada atau pilih tidak ada pada Komorbid");
                echo json_encode($ret);
                return false;
            }

            $umur = $this->umur_covid($data["tgl_lahir"]);
            if ($umur < 18) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Umur ".$data["nama"]." Sekarang adalah ".$data["vaksin_umur"].". Umur Imunisasi Covid-19 tidak boleh kurang dari 18 Tahun");
                echo json_encode($ret);
                return false;
            }

            $data["tgl_lahir"] = tgl_simpan($data["tgl_lahir"]);
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);
            $this->db->where("username", $this->session->userdata("admin_username"));
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $this->db->where("id_imunisasi_covid", $data["id_imunisasi_covid"]);
            $res  = $this->db->update("imunisasi_covid",$data);   
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    }

	function update(){
		$data = $this->input->post();
		$this->load->library('form_validation');
	    $this->form_validation->set_rules('nama','Pilih Anak','required'); 
        $this->form_validation->set_rules('id_anak','Pilih Anak','required'); 
        $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
        $this->form_validation->set_rules('jenis_vaksin','Jenis Vaksin','required'); 
        $this->form_validation->set_rules('pemberi_imunisasi','Pemberi Imunisasi','required'); 
        $this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			
            $data["bulan"] = substr($data["tgl_suntik"],3,2);
            $data["tahun"] = substr($data["tgl_suntik"],6,4);
            $this->db->where("id_anak", $data["id_anak"]);
            $an = $this->db->get("im_anak")->row();
            $data["id_anak"] = $an->id_anak;
            $data["no_kia"] = $an->no_kia;
            $data["nama"] = $an->nama;
            $data["jk"] = $an->jk;
            $data["tempat_lahir"] = $an->tempat_lahir;
            $data["tgl_lahir"] = $an->tgl_lahir;
            $data["golda"] = $an->golda;
            $data["id_agama"] = $an->id_agama;
            $data["alamat"] = $an->alamat;
            $data["nama_ayah"] = $an->nama_ayah;
            $data["nik_ayah"] = $an->nik_ayah;
            $data["id_pekerjaan_ayah"] = $an->id_pekerjaan_ayah;
            $data["nama_ibu"] = $an->nama_ibu;
            $data["nik_ibu"] = $an->nik_ibu;
            $data["id_pekerjaan_ibu"] = $an->id_pekerjaan_ibu;
            $data["id_desa"] = $an->id_desa;
            // $data["create_date"] = date("Y-m-d");
            // $data["create_time"] = date("H:i:s");
            $data["username"] = $an->username;
            $data["id_pkm"] = $an->id_pkm;
            // $data["tahun"] = $an->tahun;
            $data["vaksin_umur"] = umur_simpan($an->tgl_lahir,tgl_simpan($data["tgl_suntik"]));
            
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);

            $this->db->where("id_anak !=", $data["id_anak"]);
            $this->db->where("no_kia", $data["no_kia"]);
            $this->db->where("jenis_vaksin", $data["jenis_vaksin"]);
            $this->db->where("bulan", $data["bulan"]);
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $cek = $this->db->get("imunisasi");
            $r = $cek->row();
            $this->db->where("id_penyakit", $r->jenis_vaksin);
            $v = $this->db->get("master_penyakit")->row();
            if ($cek->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => $data["nama"]. " Sudah divaksin ".$v->nama_penyakit." pada bulan ". getBulan($r->bulan));
                echo json_encode($ret);
                return false;
            }


            $this->db->where("username", $this->session->userdata("admin_username"));
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
			$this->db->where("id_imunisasi",$data["id_imunisasi"]);
			$res  = $this->om->update("imunisasi",$data);
            
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


    

    function update_ibu(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Pilih Ibu','required'); 
        $this->form_validation->set_rules('id_ibu','Pilih Ibu','required'); 
        $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
        $this->form_validation->set_rules('jenis_vaksin','Jenis Vaksin','required'); 
        $this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            
            $data["bulan"] = substr($data["tgl_suntik"],3,2);
            $data["tahun"] = substr($data["tgl_suntik"],6,4);
            $this->db->where("id_ibu", $data["id_ibu"]);
            $an = $this->db->get("im_ibu")->row();
            $data["id_ibu"] = $an->id_ibu;
            $data["no_kia"] = $an->no_kia;
            $data["nama"] = $an->nama;
            $data["jk"] = $an->jk;
            $data["tempat_lahir"] = $an->tempat_lahir;
            $data["tgl_lahir"] = $an->tgl_lahir;
            $data["golda"] = $an->golda;
            $data["id_agama"] = $an->id_agama;
            $data["alamat"] = $an->alamat;
          
            $data["id_pekerjaan_ibu"] = $an->id_pekerjaan_ibu;
            $data["id_desa"] = $an->id_desa;
            // $data["create_date"] = date("Y-m-d");
            // $data["create_time"] = date("H:i:s");
            $data["username"] = $an->username;
            $data["id_pkm"] = $an->id_pkm;
            // $data["tahun"] = $an->tahun;
            $data["vaksin_umur"] = umur_simpan($an->tgl_lahir,tgl_simpan($data["tgl_suntik"]));
            
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);

            $this->db->where("id_ibu !=", $data["id_ibu"]);
            $this->db->where("no_kia", $data["no_kia"]);
            $this->db->where("jenis_vaksin", $data["jenis_vaksin"]);
            $this->db->where("bulan", $data["bulan"]);
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $cek = $this->db->get("imunisasi_ibu");
            $r = $cek->row();
            if ($cek->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => $data["nama"]. " Sudah divaksin ".arr_vaksin_ibu($data["jenis_vaksin"])." pada bulan ". getBulan($r->bulan));
                echo json_encode($ret);
                return false;
            }


            $this->db->where("username", $this->session->userdata("admin_username"));
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $this->db->where("id_imunisasi_ibu",$data["id_imunisasi_ibu"]);
            $res  = $this->om->update("imunisasi_ibu",$data);
            
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

    function update_luar(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Nama Anak','required'); 
        $this->form_validation->set_rules('pemberi_imunisasi','Pemberi Imunisasi','required'); 
        $this->form_validation->set_rules('tgl_lahir','Tanggal Lahir','required'); 
        $this->form_validation->set_rules('tgl_suntik','Tanggal Suntik','required'); 
        $this->form_validation->set_rules('alamat','Alamat','required'); 
        $this->form_validation->set_rules('nama_ibu','Nama Ibu/Ayah','required'); 
        $this->form_validation->set_rules('jenis_vaksin','Jenis Vaksin','required'); 
        $this->form_validation->set_rules('tempat_pelayanan','Tempat Pelayanan','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["bulan"] = substr($data["tgl_suntik"],3,2);
            $data["tahun"] = substr($data["tgl_suntik"],6,4);
            // $data["id_imunisasi"] = $this->session->userdata("admin_pkm").substr($an->tahun, 2,3).$data["bulan"].$this->kode_imunisasi();
            // $data["create_date"] = date("Y-m-d");
            // $data["create_time"] = date("H:i:s");
            $data["username"] = $this->session->userdata("admin_username");
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            $data["vaksin_umur"] = umur_simpan($data["tgl_lahir"],tgl_simpan($data["tgl_suntik"]));
           
            $data["tgl_suntik"] = tgl_simpan($data["tgl_suntik"]);
            $data["tgl_lahir"] = tgl_simpan($data["tgl_lahir"]);
            
            $this->db->where("username", $this->session->userdata("admin_username"));
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $this->db->where("id_imunisasi",$data["id_imunisasi"]);
            $res  = $this->db->update("imunisasi_luar",$data);   
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
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

	function hapus_data(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("id_imunisasi",$id);
                $res =$this->om->delete("imunisasi");
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

        echo json_encode($ret);
    } 

    function hapus_data_kipi(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("urutan",$id);
                $res =$this->om->delete("imunisasi_kipi");
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

        echo json_encode($ret);
    } 

    function hapus_data_ibu(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("id_imunisasi_ibu",$id);
                $res =$this->om->delete("imunisasi_ibu");
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

        echo json_encode($ret);
    } 

    function hapus_data_covid(){
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->db->where("id_imunisasi_covid",$id);
            $res =$this->om->delete("imunisasi_covid");
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

        echo json_encode($ret);
    } 

    function hapus_data_luar(){
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->db->where("id_imunisasi",$id);
            $res =$this->om->delete("imunisasi_luar");
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

        echo json_encode($ret);
    } 

     function pdf($id) {
     	if ($this->session->userdata("admin_level") != "admin") {
     		$this->db->where("imunisasi.username", $this->session->userdata("admin_username"));
     		$this->db->where("imunisasi.id_pkm", $this->session->userdata("admin_pkm"));
     	}
        $this->db->where("id_imunisasi", $id);
        $this->db->join("im_agama", "im_agama.id_agama = imunisasi.id_agama");
        $this->db->join("master_desa", "master_desa.id_desa = imunisasi.id_desa");

        $data["res"] = $this->db->get("imunisasi")->row();
        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ayah);
        $p = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = $p->pekerjaan;

        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ibu);
        $pa = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = $pa->pekerjaan;

        $this->db->where("id_penyakit", $data["res"]->jenis_vaksin);
        $red = $this->db->get("master_penyakit")->row();
        $data["jenis_vaksinx"] = $red->nama_penyakit;

        $this->db->where("id_desa",$data["res"]->id_desa);
        $de = $this->db->get("master_desa")->row();

        $this->db->where("id_kecamatan", $de->id_kecamatan);
        $data["kec"] = $this->db->get("master_kecamatan")->row();
    
        $data["title"] = "Data Vaksin ".$data["res"]->nama;
 	      

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        // $data['data'] = site_url("admin_imunisasi/pdf/".$id); //data yang akan di jadikan QR CODE
        // $data['data'] = $id."-".$data["res"]->jenis_vaksin; //data yang akan di jadikan QR CODE
        $data['data'] = site_url("publik/imunisasi/"). $id; 
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE
        


        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "F4");

        $html = $this->load->view("admin_imunisasi_biodata_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 


    function pdf_kipi($id) {
        if ($this->session->userdata("admin_level") != "admin") {
            $this->db->where("imunisasi_kipi.username", $this->session->userdata("admin_username"));
            $this->db->where("imunisasi_kipi.id_pkm", $this->session->userdata("admin_pkm"));
        }
        $this->db->where("urutan", $id);
        // $this->db->join("im_agama", "im_agama.id_agama = imunisasi_kipi.id_agama");
        // $this->db->join("master_desa", "master_desa.id_desa = imunisasi_kipi.id_desa");

        $data["res"] = $this->db->get("imunisasi_kipi")->row();
        // echo $this->db->last_query();

        $this->db->where("id_desa", $data["res"]->id_desa);
        $data["nama_desa"] = $this->db->get("master_desa")->row();

        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ayah);
        $p = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = $p->pekerjaan;

        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ibu);
        $pa = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = $pa->pekerjaan;

        $this->db->where("id_penyakit", $data["res"]->jenis_vaksin_1);
        $red = $this->db->get("master_penyakit")->row();
        $data["jenis_vaksin_1"] = $red->nama_penyakit;

        $this->db->where("id_penyakit", $data["res"]->jenis_vaksin_2);
        $red = $this->db->get("master_penyakit")->row();
        $data["jenis_vaksin_2"] = $red->nama_penyakit;

        $this->db->where("id_desa",$data["res"]->id_desa);
        $de = $this->db->get("master_desa")->row();

        $this->db->where("id_kecamatan", $de->id_kecamatan);
        $data["kec"] = $this->db->get("master_kecamatan")->row();
    
        $data["title"] = "Data KIPI ".$data["res"]->nama;
          

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        // $data['data'] = site_url("admin_imunisasi/pdf/".$id); //data yang akan di jadikan QR CODE
        // $data['data'] = $id."-".$data["jenis_vaksin_1"]."-".$data["res"]->nama; //data yang akan di jadikan QR CODE
        $data['data'] = site_url("publik/imunisasi_kipi/"). $id; 
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE
        


        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "F4");

        $html = $this->load->view("Kipi_biodata_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 


    function pdf_luar($id) {
        if ($this->session->userdata("admin_level") != "admin") {
            $this->db->where("imunisasi_luar.username", $this->session->userdata("admin_username"));
            $this->db->where("imunisasi_luar.id_pkm", $this->session->userdata("admin_pkm"));
        }
        $this->db->where("id_imunisasi", $id);
        $data["res"] = $this->db->get("imunisasi_luar")->row();
        $this->db->where("id_penyakit", $data["res"]->jenis_vaksin);
        $red = $this->db->get("master_penyakit")->row();
        $data["jenis_vaksinx"] = $red->nama_penyakit;
        $data["title"] = "Data Vaksin ".$data["res"]->nama;
          

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        // $data['data'] = site_url("admin_imunisasi/pdf/".$id); //data yang akan di jadikan QR CODE
        // $data['data'] = "L-".$id."-".$data["res"]->jenis_vaksin; //data yang akan di jadikan QR CODE
        $data['data'] = site_url("publik/imunisasi_luar/"). $id; 
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE
        

        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "F4");

        $html = $this->load->view("Admin_imunisasi_biodata_luar_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 

    function pdf_ibu($id) {
        if ($this->session->userdata("admin_level") != "admin") {
            $this->db->where("imunisasi_ibu.username", $this->session->userdata("admin_username"));
            $this->db->where("imunisasi_ibu.id_pkm", $this->session->userdata("admin_pkm"));
        }
        $this->db->where("id_imunisasi_ibu", $id);
        $this->db->join("im_agama", "im_agama.id_agama = imunisasi_ibu.id_agama");
        $this->db->join("master_desa", "master_desa.id_desa = imunisasi_ibu.id_desa");

        $data["res"] = $this->db->get("imunisasi_ibu")->row();
        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ayah);
        $p = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = $p->pekerjaan;

        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ibu);
        $pa = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = $pa->pekerjaan;

        $this->db->where("id_penyakit", $data["res"]->jenis_vaksin);
        $red = $this->db->get("master_penyakit")->row();
        $data["jenis_vaksinx"] = arr_vaksin_ibu_p($data["res"]->jenis_vaksin);

        $this->db->where("id_desa",$data["res"]->id_desa);
        $de = $this->db->get("master_desa")->row();

        $this->db->where("id_kecamatan", $de->id_kecamatan);
        $data["kec"] = $this->db->get("master_kecamatan")->row();
    
        $data["title"] = "Data Vaksin ".$data["res"]->nama;
          

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        // $data['data'] = $id."-".$data["res"]->jenis_vaksin; //data yang akan di jadikan QR CODE
        $data['data'] = site_url("publik/imunisasi_ibu/"). $id; 
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE
        


        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "F4");

        $html = $this->load->view(get_class($this)."_ibu_biodata_view",$data,true);
        // exit();
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
        
    } 

    function pdf_covid($id) {
        if ($this->session->userdata("admin_level") != "admin") {
            $this->db->where("imunisasi_covid.username", $this->session->userdata("admin_username"));
            $this->db->where("imunisasi_covid.id_pkm", $this->session->userdata("admin_pkm"));
        }
        $this->db->where("id_imunisasi_covid", $id);

        $data["res"] = $this->db->get("imunisasi_covid")->row();

        $this->db->where("id_pekerjaan", $data["res"]->id_detail_pekerjaan);
        $pa = $this->db->get("im_pekerjaan")->row();
        $data["id_detail_pekerjaan"] = $pa->pekerjaan;
    
        $data["title"] = "Data Imunisasi Covid-19 ".$data["res"]->nama;
          

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        $data['data'] = $id."-".$data["res"]->no_kia; //data yang akan di jadikan QR CODE
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE
        


        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "F4");

        $html = $this->load->view(get_class($this)."_covid_biodata_view",$data,true);
        // exit();
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
        
    } 


    function pdf_riwayat($id) {
        if ($this->session->userdata("admin_level") != "admin") {
            $this->db->where("im_anak.username", $this->session->userdata("admin_username"));
            $this->db->where("im_anak.id_pkm", $this->session->userdata("admin_pkm"));
        }
        $this->db->where("id_anak", $id);
        $this->db->join("im_agama", "im_agama.id_agama = im_anak.id_agama");
        $this->db->join("master_desa", "master_desa.id_desa = im_anak.id_desa");

        $data["res"] = $this->db->get("im_anak")->row();

        // $this->db->order_by("tahun","DESC");
        // $this->db->order_by("bulan","DESC");
        $this->db->order_by("tgl_suntik","DESC");
        $this->db->where("id_anak",$id);
        $data["record"] = $this->db->get("imunisasi");


        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ayah);
        $p = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = $p->pekerjaan;

        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ibu);
        $pa = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = $pa->pekerjaan;

        $this->db->where("id_penyakit", $data["res"]->jenis_vaksin);
        $red = $this->db->get("master_penyakit")->row();
        $data["jenis_vaksinx"] = $red->nama_penyakit;

        $this->db->where("id_desa",$data["res"]->id_desa);
        $de = $this->db->get("master_desa")->row();

        $this->db->where("id_kecamatan", $de->id_kecamatan);
        $data["kec"] = $this->db->get("master_kecamatan")->row();
    
        $data["title"] = "Riwayat Vaksin ".$data["res"]->nama;
          

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        // $data['data'] = $data["res"]->nama."_".tgl_view($data["res"]->tgl_lahir)."_".$id; //data yang akan di jadikan QR CODE
        $data['data'] = site_url("publik/riwayat_anak/"). $id; 
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE

        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "F4");

        $html = $this->load->view(get_class($this)."_pdf_riwayat_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 


    function pdf_riwayat_ibu($id) {
        if ($this->session->userdata("admin_level") != "admin") {
            $this->db->where("im_ibu.username", $this->session->userdata("admin_username"));
            $this->db->where("im_ibu.id_pkm", $this->session->userdata("admin_pkm"));
        }
        $this->db->where("id_ibu", $id);
        $this->db->join("im_agama", "im_agama.id_agama = im_ibu.id_agama");
        $this->db->join("master_desa", "master_desa.id_desa = im_ibu.id_desa");

        $data["res"] = $this->db->get("im_ibu")->row();

        $this->db->order_by("tahun","DESC");
        $this->db->order_by("bulan","DESC");
        $this->db->order_by("tgl_suntik","DESC");
        $this->db->where("id_ibu",$id);
        $data["record"] = $this->db->get("imunisasi_ibu");


        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ayah);
        $p = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = $p->pekerjaan;

        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ibu);
        $pa = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = $pa->pekerjaan;

        $this->db->where("id_penyakit", $data["res"]->jenis_vaksin);
        $red = $this->db->get("master_penyakit")->row();
        $data["jenis_vaksinx"] = $red->nama_penyakit;

        $this->db->where("id_desa",$data["res"]->id_desa);
        $de = $this->db->get("master_desa")->row();

        $this->db->where("id_kecamatan", $de->id_kecamatan);
        $data["kec"] = $this->db->get("master_kecamatan")->row();
    
        $data["title"] = "Riwayat Vaksin ".$data["res"]->nama;
          

        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
 
        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim
 
        // $data['data'] = $data["res"]->nama."_".tgl_view($data["res"]->tgl_lahir)."_".$id; //data yang akan di jadikan QR CODE
        $data['data'] = site_url("publik/riwayat_ibu/"). $id; 
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE

        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 15);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "F4");

        $html = $this->load->view(get_class($this)."_pdf_riwayat_ibu_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 



    function laporan_imunisasi_rutin_pdf($tahun,$bulan,$id_pkm) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Laporan Imunisasi Rutin";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
       
        $data["id_pkm"] = $id_pkm;

        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('desa', 'ASC');
      
        $data["res"] = $this->db->get("im_tahun_vaksin_isi");


        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_l) as jum_bayi_l');
        $jum_bayi_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_l"] = $jum_bayi_l->jum_bayi_l;

        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_p) as jum_bayi_p');
        $jum_bayi_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_p"] = $jum_bayi_p->jum_bayi_p;


        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_l) as jum_bayi_si_l');
        $jum_bayi_si_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_l"] = $jum_bayi_si_l->jum_bayi_si_l;

        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_p) as jum_bayi_si_p');
        $jum_bayi_si_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_p"] = $jum_bayi_si_p->jum_bayi_si_p;

        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_tahun_lalu_l) as jum_bayi_si_tahun_lalu_l');
        $jum_bayi_si_tahun_lalu_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_l"] = $jum_bayi_si_tahun_lalu_l->jum_bayi_si_tahun_lalu_l;

        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_tahun_lalu_p) as jum_bayi_si_tahun_lalu_p');
        $jum_bayi_si_tahun_lalu_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_p"] = $jum_bayi_si_tahun_lalu_p->jum_bayi_si_tahun_lalu_p;

        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(wus_hamil) as jum_wus_hamil');
        $jum_wus_hamil = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_hamil"] = $jum_wus_hamil->jum_wus_hamil;

        $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(wus_jumlah) as jum_wus_jumlah');
        $jum_wus_jumlah = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_jumlah"] = $jum_wus_jumlah->jum_wus_jumlah;



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


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        $pdf->AddPage("L", "F4");


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin2_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();


        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function laporan_imunisasi_rutin_range_pdf($awal,$akhir,$id_pkm) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Laporan Imunisasi Rutin". $awal. " sd ".$akhir;


        $data["awal"] = $awal;
        $data["akhir"] = $akhir;

       
        $data["id_pkm"] = $id_pkm;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        // $this->db->where("tahun",$tahun);  
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('desa', 'ASC');
      
        $data["res"] = $this->db->get("im_tahun_vaksin_isi");
        // echo $this->db->last_query();
        // exit();

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_l) as jum_bayi_l');
        $jum_bayi_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_l"] = $jum_bayi_l->jum_bayi_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_p) as jum_bayi_p');
        $jum_bayi_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_p"] = $jum_bayi_p->jum_bayi_p;


        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_l) as jum_bayi_si_l');
        $jum_bayi_si_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_l"] = $jum_bayi_si_l->jum_bayi_si_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_p) as jum_bayi_si_p');
        $jum_bayi_si_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_p"] = $jum_bayi_si_p->jum_bayi_si_p;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_tahun_lalu_l) as jum_bayi_si_tahun_lalu_l');
        $jum_bayi_si_tahun_lalu_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_l"] = $jum_bayi_si_tahun_lalu_l->jum_bayi_si_tahun_lalu_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(bayi_si_tahun_lalu_p) as jum_bayi_si_tahun_lalu_p');
        $jum_bayi_si_tahun_lalu_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_p"] = $jum_bayi_si_tahun_lalu_p->jum_bayi_si_tahun_lalu_p;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(wus_hamil) as jum_wus_hamil');
        $jum_wus_hamil = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_hamil"] = $jum_wus_hamil->jum_wus_hamil;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->select('sum(wus_jumlah) as jum_wus_jumlah');
        $jum_wus_jumlah = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_jumlah"] = $jum_wus_jumlah->jum_wus_jumlah;



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


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin_range_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        $pdf->AddPage("L", "F4");


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin2_range_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();


        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 


    function laporan_imunisasi_rutin_covid_pdf($tahun,$bulan,$ttd) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Laporan Imunisasi Rutin Dinas";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
       

        $this->db->order_by("master_pkm.id_pkm","ASC");
        $this->db->where("tahun",$tahun);
        $this->db->group_by("imunisasi_covid.id_pkm");
        $this->db->join("master_pkm", "master_pkm.id_pkm = imunisasi_covid.id_pkm");
        $this->db->select("master_pkm.nama_pkm,master_pkm.id_pkm");

        $this->db->from("imunisasi_covid");
        $data["res"] = $this->db->get();

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
        
        $pdf->SetMargins(20, 10, 5);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);

     // add a page
        $pdf->AddPage("P", "F4");


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_covid_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 

    function laporan_imunisasi_berdasarkan_penyakit_pdf($tahun,$bulan,$id_pkm) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Laporan Imunisasi Berdasarkan Penyakit";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
       
        $data["id_pkm"] = $id_pkm;
        
        $this->db->where("urutan between '1' and '13'");
        $this->db->order_by('urutan', 'ASC');
        $data["res"] = $this->db->get("master_penyakit");

        $this->db->where("urutan between '14' and '16'");
        $this->db->order_by('urutan', 'ASC');
        $data["res2"] = $this->db->get("master_penyakit");

        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('L', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(10, 5, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("P", "F4");


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_berdasarkan_penyakit_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 


    function laporan_imunisasi_berdasarkan_penyakit_dinas_pdf($tahun,$bulan,$ttd) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Laporan Imunisasi Berdasarkan Penyakit";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
       
        // $data["id_pkm"] = $id_pkm;
        
        $this->db->where("urutan between '1' and '13'");
        $this->db->order_by('urutan', 'ASC');
        $data["res"] = $this->db->get("master_penyakit");

        $this->db->where("urutan between '14' and '16'");
        $this->db->order_by('urutan', 'ASC');
        $data["res2"] = $this->db->get("master_penyakit");

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
        
        $pdf->SetMargins(10, 5, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

     // add a page
        $pdf->AddPage("P", "F4");


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_berdasarkan_penyakit_dinas_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 


    function laporan_imunisasi_rutin_dinas_pdf($tahun,$bulan,$ttd) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Laporan Imunisasi Rutin Dinas";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
       

        $this->db->order_by("master_pkm.id_pkm","ASC");
        $this->db->where("tahun",$tahun);
        $this->db->group_by("im_tahun_vaksin_isi.id_pkm");
        $this->db->join("master_pkm", "master_pkm.id_pkm = im_tahun_vaksin_isi.id_pkm");
        $this->db->select("master_pkm.nama_pkm,master_pkm.id_pkm,sum(penduduk_l) as penduduk_l,sum(penduduk_p) as penduduk_p,sum(bayi_l) as bayi_l,sum(bayi_p) as bayi_p,sum(bayi_si_l) as bayi_si_l,sum(bayi_si_p) as bayi_si_p,sum(bayi_si_tahun_lalu_l) as bayi_si_tahun_lalu_l,sum(bayi_si_tahun_lalu_p) as bayi_si_tahun_lalu_p,sum(wus_jumlah) as wus_jumlah,sum(wus_hamil) as wus_hamil");

        $this->db->from("im_tahun_vaksin_isi");
        $data["res"] = $this->db->get();

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

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_l) as jum_bayi_l');
        $jum_bayi_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_l"] = $jum_bayi_l->jum_bayi_l;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_p) as jum_bayi_p');
        $jum_bayi_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_p"] = $jum_bayi_p->jum_bayi_p;


        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_l) as jum_bayi_si_l');
        $jum_bayi_si_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_l"] = $jum_bayi_si_l->jum_bayi_si_l;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_p) as jum_bayi_si_p');
        $jum_bayi_si_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_p"] = $jum_bayi_si_p->jum_bayi_si_p;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_tahun_lalu_l) as jum_bayi_si_tahun_lalu_l');
        $jum_bayi_si_tahun_lalu_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_l"] = $jum_bayi_si_tahun_lalu_l->jum_bayi_si_tahun_lalu_l;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_tahun_lalu_p) as jum_bayi_si_tahun_lalu_p');
        $jum_bayi_si_tahun_lalu_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_p"] = $jum_bayi_si_tahun_lalu_p->jum_bayi_si_tahun_lalu_p;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(wus_hamil) as jum_wus_hamil');
        $jum_wus_hamil = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_hamil"] = $jum_wus_hamil->jum_wus_hamil;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(wus_jumlah) as jum_wus_jumlah');
        $jum_wus_jumlah = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_jumlah"] = $jum_wus_jumlah->jum_wus_jumlah;



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


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin_dinas_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        $pdf->AddPage("L", "F4");


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin2_dinas_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();


        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    }

   
    function laporan_imunisasi_rutin_dinas_range_pdf($awal,$akhir,$ttd) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Laporan Imunisasi Rutin Dinas ". $awal. " sd ".$akhir;
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        
        $data["awal"] = $awal;
        $data["akhir"] = $akhir;

        $this->db->order_by("master_pkm.id_pkm","ASC");
        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->group_by("im_tahun_vaksin_isi.id_pkm");
        $this->db->join("master_pkm", "master_pkm.id_pkm = im_tahun_vaksin_isi.id_pkm");
        $this->db->select("master_pkm.nama_pkm,master_pkm.id_pkm,sum(penduduk_l) as penduduk_l,sum(penduduk_p) as penduduk_p,sum(bayi_l) as bayi_l,sum(bayi_p) as bayi_p,sum(bayi_si_l) as bayi_si_l,sum(bayi_si_p) as bayi_si_p,sum(bayi_si_tahun_lalu_l) as bayi_si_tahun_lalu_l,sum(bayi_si_tahun_lalu_p) as bayi_si_tahun_lalu_p,sum(wus_jumlah) as wus_jumlah,sum(wus_hamil) as wus_hamil");

        $this->db->from("im_tahun_vaksin_isi");
        $data["res"] = $this->db->get();

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

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_l) as jum_bayi_l');
        $jum_bayi_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_l"] = $jum_bayi_l->jum_bayi_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_p) as jum_bayi_p');
        $jum_bayi_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_p"] = $jum_bayi_p->jum_bayi_p;


        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_l) as jum_bayi_si_l');
        $jum_bayi_si_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_l"] = $jum_bayi_si_l->jum_bayi_si_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_p) as jum_bayi_si_p');
        $jum_bayi_si_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_p"] = $jum_bayi_si_p->jum_bayi_si_p;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_tahun_lalu_l) as jum_bayi_si_tahun_lalu_l');
        $jum_bayi_si_tahun_lalu_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_l"] = $jum_bayi_si_tahun_lalu_l->jum_bayi_si_tahun_lalu_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_tahun_lalu_p) as jum_bayi_si_tahun_lalu_p');
        $jum_bayi_si_tahun_lalu_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_p"] = $jum_bayi_si_tahun_lalu_p->jum_bayi_si_tahun_lalu_p;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(wus_hamil) as jum_wus_hamil');
        $jum_wus_hamil = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_hamil"] = $jum_wus_hamil->jum_wus_hamil;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(wus_jumlah) as jum_wus_jumlah');
        $jum_wus_jumlah = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_jumlah"] = $jum_wus_jumlah->jum_wus_jumlah;



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


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin_dinas_range_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();

        $pdf->AddPage("L", "F4");


        $html = $this->load->view(get_class($this)."_laporan_imunisasi_rutin2_dinas_range_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();


        $pdf->Output($data['header'] .'.pdf', 'I');

        // $html = $this->load->view(get_class($this)."_laporan_view",$data);

    
    } 



    

	
}

