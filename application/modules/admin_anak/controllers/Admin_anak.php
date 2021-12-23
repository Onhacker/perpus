<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_anak extends Admin_Controller {
	function __construct(){
		parent::__construct();
		// cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_anak", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Registrasi";
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
            $row["id"] = $res->id_anak;
            $row["nama"] = ucwords(strtolower($res->nama));
            $row["no_kia"] = $res->no_kia;
            $row["tgl_reg"] = tgl_view($res->create_date);
            $row["jk"] = $res->jk;
            $row["nama_ibu"] = ucwords(strtolower($res->nama_ibu));
            $this->db->where("id_desa", $res->id_desa);
            $desa = $this->db->get("master_desa")->row();
            $row["desa"] = ucwords(strtolower($desa->desa));

            $this->db->where("id_pkm", $res->id_pkm);
            $pkm = $this->db->get("master_pkm")->row();
            $row["pkm"] = "<span class ='text-primary'>".$pkm->nama_pkm."</span>";
         	$row["ttl"] = ucwords(strtolower($res->tempat_lahir)).", ".tgl_view($res->tgl_lahir)."<br><span class='badge bg-success text-white'>Umur : ".umur($res->tgl_lahir)."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_anak.'"><label></label></div>';

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
        $data["tgl_lahir"] = tgl_view($data["tgl_lahir"]);
        echo json_encode($data);
    }

    function laporan_bayi(){
        // cek_session_admin();
        // $this->load->model("M_admin_tahun_vaksin", "dm");
        $data["controller"] = get_class($this);     
        $data["title"] = "Laporan Data Anak";
        $data["subtitle"] = "Laporan";
        $data["content"] = $this->load->view($data["controller"]."_laporan_data_bayi_view",$data,true); 
        $this->render($data);
    }

    function laporan_bayi_pdf($tahun,$id_pkm,$id_desa,$jk) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
           cek_session_admin();
        }
        $data["title"] = "Data Anak";
        $data["tahun"] = $tahun;
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $data["id_desa"] = $id_desa;
        $this->db->where('year(create_date)', $tahun);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }

        $data["res"] = $this->db->get("im_anak");
        

        $this->db->where('year(create_date)', $tahun);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        $this->db->where("jk","L");  
        $data["jum_l"] = $this->db->get("im_anak")->num_rows();



        $this->db->where('year(create_date)', $tahun);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        $this->db->where("jk","P");  
        $data["jum_p"] = $this->db->get("im_anak")->num_rows();

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

        $html = $this->load->view(get_class($this)."_laporan_bayi_pdf",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output($data['header'] .'.pdf', 'I');
        // $html = $this->load->view(get_class($this)."_laporan_view",$data);
    } 


    function add(){
		$data = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('no_kia','No. Registrasi KIA','required'); 
		$this->form_validation->set_rules('nama','Nama Anak','required'); 
		$this->form_validation->set_rules('jk','Jenis Kelamin Anak','required'); 
		$this->form_validation->set_rules('tempat_lahir','Tempat Lahir Anak','required'); 
		$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir Anak','required'); 
		$this->form_validation->set_rules('id_agama','Agama','required'); 
		$this->form_validation->set_rules('id_desa','Desa','required'); 
		$this->form_validation->set_rules('alamat','Alamat Lengkap','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 

			$data["tgl_lahir"] = tgl_simpan($data["tgl_lahir"]);
			$data["create_date"] = date("Y-m-d");
			$data["tahun"] = $this->om->web_me()->tahun_akhir;
			$data["username"] = $this->session->userdata("admin_username");
			$data["create_time"] = date("H:i:s");
			$data["id_pkm"] = $this->session->userdata("admin_pkm");
            $data["no_kia"] = str_replace(" ", "", $data["no_kia"]);
            $data["nik_ayah"] = str_replace(" ", "", $data["nik_ayah"]);
            $data["nik_ibu"] = str_replace(" ", "", $data["nik_ibu"]);


			$this->db->where("no_kia", $data["no_kia"]);
			$this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $cek = $this->db->get("im_anak");
            $r = $cek->row();
            if ($cek->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "No. Registrasi KIA sudah ada atas nama ". $r->nama);
                echo json_encode($ret);
                return false;
            }
      
			$res  = $this->db->insert("im_anak",$data);	
				
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
		$this->form_validation->set_rules('no_kia','No. Registrasi KIA','required'); 
		$this->form_validation->set_rules('nama','Nama Anak','required'); 
		$this->form_validation->set_rules('jk','Jenis Kelamin Anak','required'); 
		$this->form_validation->set_rules('tempat_lahir','Tempat Lahir Anak','required'); 
		$this->form_validation->set_rules('tgl_lahir','Tanggal Lahir Anak','required'); 
		$this->form_validation->set_rules('id_agama','Agama','required'); 
		$this->form_validation->set_rules('id_desa','Desa','required'); 
		$this->form_validation->set_rules('alamat','Alamat Lengkap','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			
            $data["tgl_lahir"] = tgl_simpan($data["tgl_lahir"]);
            $data["no_kia"] = str_replace(" ", "", $data["no_kia"]);
            $data["nik_ayah"] = str_replace(" ", "", $data["nik_ayah"]);
            $data["nik_ibu"] = str_replace(" ", "", $data["nik_ibu"]);

            $this->db->where("id_anak !=", $data["id_anak"]);
            $this->db->where("no_kia", $data["no_kia"]);
			$this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
            $cek = $this->db->get("im_anak");
            $r = $cek->row();
            if ($cek->num_rows() >= 1) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "No. Registrasi KIA sudah ada atas nama ". $r->nama);
                echo json_encode($ret);
                return false;
            }
            $this->db->where("username", $this->session->userdata("admin_username"));
            $this->db->where("id_pkm", $this->session->userdata("admin_pkm"));
			$this->db->where("id_anak",$data["id_anak"]);
			$res  = $this->om->update("im_anak",$data);
            
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
                $this->db->where("id_anak",$id);
                $res =$this->om->delete("im_anak");
                // rec(get_class($this));  ; 	
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
     		$this->db->where("im_anak.username", $this->session->userdata("admin_username"));
     		$this->db->where("im_anak.id_pkm", $this->session->userdata("admin_pkm"));
     	}
        $this->db->where("id_anak", $id);
        $this->db->join("im_agama", "im_agama.id_agama = im_anak.id_agama");
        $this->db->join("master_desa", "master_desa.id_desa = im_anak.id_desa");

        $data["res"] = $this->db->get("im_anak")->row();
        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ayah);
        $p = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ayah"] = $p->pekerjaan;

        $this->db->where("id_pekerjaan", $data["res"]->id_pekerjaan_ibu);
        $pa = $this->db->get("im_pekerjaan")->row();
        $data["pekerjaan_ibu"] = $pa->pekerjaan;

        $this->db->where("id_desa",$data["res"]->id_desa);
        $de = $this->db->get("master_desa")->row();

        $this->db->where("id_kecamatan", $de->id_kecamatan);
        $data["kec"] = $this->db->get("master_kecamatan")->row();
    
        $data["title"] = "Kartu Imunisasi ".$data["res"]->nama;
 	    
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
        $data['data'] = site_url("publik/kartu_imun_anak/"). $id; 
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

        $html = $this->load->view("Admin_anak_biodata_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 


	
}
