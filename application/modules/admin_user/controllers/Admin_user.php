<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_admin();
		$this->load->model("M_admin_user", "dm");
        $this->load->model("M_admin_user_profil", "cm");
        $this->load->library("email");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Member";
        $data['fakultas']=$this->dm->get_fakultas();
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	function detail_profil($id){
		$data["controller"] = get_class($this);   
        $this->db->select("username,nama_lengkap,foto,no_telp,permission_publish,email,tanggal_reg,level,blokir")->where("id_session",$id)->from("users");
        $a = $this->db->get();
        $ret = $a->row();
        $data["record"] = $a->row();
        $data["title"] = "Manajemen User";
        $data["subtitle"] = ucfirst($ret->level) ." ".$ret->nama_lengkap ;
        $data["content"] = $this->load->view($data["controller"]."_profil_view",$data,true); 
        $this->render($data);
	}

    function get_data_modul($id){   
        $list = $this->cm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_modul"] = $res->id_modul;
            $row["nama_modul"] = $res->nama_modul;

            $this->db->where("id_modul", $res->id_modul);
            $this->db->where("id_session", $id);
            $cek = $this->db->get("users_modul");

            if ($cek->num_rows() == "1") {
                $ck = "checked";
            } else {
                $ck = "";
            }

            $row["aksi"] = '<div class="custom-control custom-switch" ><a href="javascript:void(0)" onclick="pub('.$res->id_modul.','.$id.')">
            <input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
            <label class="custom-control-label" for="cek"></label>
            </a></div>';
            
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


	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->username;
            $row["nama_lengkap"] = $res->nama_lengkap;
            
            $row["username"] = $res->username;
            $row["email"] = $res->email;
            $row["no_telp"] = $res->no_telp;
            $row["nim"] = $res->nim;
            $row["nama_prodi"] = $res->nama_prodi;
            $row["nama_jurusan"] = $res->nama_jurusan;
            $row["nama_fakultas"] = $res->nama_fakultas;
            $row["angkatan"] = $res->angkatan;
           
            if ($res->tanggal_reg == "0000-00-00") {
                $row["tanggal_reg"] = "<span class='badge badge-warning p-1'>Pending/<br>Menunggu verifikasi</span>";
            } else {
                $row["tanggal_reg"] = tgl_indo($res->tanggal_reg);
            }
    
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->username.'"><label></label></div>';

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

    
    function update(){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','trim|required|max_length[12]'); 
        $this->form_validation->set_rules('id_fakultas','Fakultas','required');
        $this->form_validation->set_rules('id_jurusan','Jurusan','required');
        $this->form_validation->set_rules('angkatan','Angkatan','trim|required|numeric'); 
        $this->form_validation->set_rules('id_prodi','Program Studi','required');
        $this->form_validation->set_rules('nama_lengkap','Nama Mahasiswa','required');  
        $this->form_validation->set_rules('nim','NIM','trim|required|numeric');  
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');  
        $this->form_validation->set_rules('no_telp','No Telpon','trim|numeric|required|min_length[10]|max_length[12]');  
        // $this->form_validation->set_rules('password_baru','Password Baru','trim|required|min_length[8]'); 
        // $this->form_validation->set_rules('password_baru_lagi','Konfirmas Password ','trim|required|min_length[8]'); 

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_message('min_length', '* %s Minimal 8  Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Karakter ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            unset($data["password2"]);
            $data["id_session"] = "8".substr(preg_replace("/[^0-9]/", '', md5(date("Ymdhis"))),0,10);
            unset($data["level"]);
            unset($data["blokir"]);
            unset($data["permission_publish"]);
            unset($data["foto"]);
            unset($data["attack"]);

            $data["nim"] = $data["nim"];
            // $this->db->where("nim !=", $data["nim"]);
            // $cek = $this->db->get("users");
            // $r = $cek->row();
            // if ($cek->num_rows() >= 1) {
            //     $ret = array("success" => false,
            //         "title" => "Gagal",
            //         "pesan" => "NIM sudah ada atas nama ". $r->nama_lengkap);
            //     echo json_encode($ret);
            //     return false;
            // }


            if ($data["password_baru"] != "" or $data["password_baru_lagi"] !="") {
                if ($data["password_baru"] <> $data["password_baru_lagi"]) {
                    $rules = "Password Baru dan Konfirmasi Password Tidak Sama<br>";
                }  else {
                    $data["username"] = $data["username"];
                    $data["password"] = $data["password_baru_lagi"];
                    unset($data["password_baru"]);
                    unset($data["password_baru_lagi"]);
                    // unset($data["username"]);
                    $data["blokir"] = "N";
                    $data["attack"] = md5(date("Ymdhis"));
                    $data["valid_reset"] = "0000-00-00";
                    // $data["tanggal_reg"] = date("Y-m-d");
                    $data["password"] = hash("sha512", md5($data["password"]));
                    $id_resett = explode("-", $id_reset);
                    $data["id_reset"] = hash("sha512", md5(date("Ymdhis")));
                              
                }
            } else {
                unset($data["password_baru"]);
                unset($data["password_baru_lagi"]);
            }

                    $this->db->where("username",$data["username"]);
                    $res  = $this->db->update("users",$data);    
                    // echo $this->db->last_query();
            if($res) {  
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan ");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan<br>".$rules);
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
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
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username','Username','trim|required|max_length[12]'); 
        $this->form_validation->set_rules('id_fakultas','Fakultas','required');
        $this->form_validation->set_rules('id_jurusan','Jurusan','required');
        $this->form_validation->set_rules('angkatan','Angkatan','trim|required|numeric'); 
        $this->form_validation->set_rules('id_prodi','Program Studi','required');
        $this->form_validation->set_rules('nama_lengkap','Nama Mahasiswa','required');  
        $this->form_validation->set_rules('nim','NIM','trim|required|numeric');  
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');  
         
        $this->form_validation->set_rules('password_baru','Password Baru','trim|required|min_length[8]'); 
        $this->form_validation->set_rules('password_baru_lagi','Konfirmas Password ','trim|required|min_length[8]'); 

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_message('min_length', '* %s Minimal 8  Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Karakter ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            unset($data["password2"]);
            $data["id_session"] = "8".substr(preg_replace("/[^0-9]/", '', md5(date("Ymdhis"))),0,10);
            unset($data["level"]);
            unset($data["blokir"]);
            unset($data["permission_publish"]);
            unset($data["foto"]);
            unset($data["attack"]);
                
            if (strlen($data["username"]) < 6) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Username harus Minimal 5 karakter");
                echo json_encode($ret);
                return false;
            }

            $this->db->where("username", $data["username"]);
            $cek_user = $this->db->get("users");
            if ($cek_user->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Username sudah ada");
                echo json_encode($ret);
                return false;
            }

            $this->db->where("nim", $data["nim"]);
            $cek_user = $this->db->get("users");
            if ($cek_user->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "NIM sudah ada");
                echo json_encode($ret);
                return false;
            }


            if ($data["password_baru"] <> $data["password_baru_lagi"]) {
                $rules = "Password Baru dan Konfirmasi Password Tidak Sama<br>";
            }  else {
                $data["username"] = $data["username"];
                $data["password"] = $data["password_baru_lagi"];
                unset($data["password_baru"]);
                unset($data["password_baru_lagi"]);
                // unset($data["username"]);
                $data["blokir"] = "N";
                $data["attack"] = md5(date("Ymdhis"));
                $data["valid_reset"] = "0000-00-00";
                $data["tanggal_reg"] = date("Y-m-d");
                $data["password"] = hash("sha512", md5($data["password"]));
                $id_resett = explode("-", $id_reset);
                $data["id_reset"] = hash("sha512", md5(date("Ymdhis")));
                $this->db->where("blokir", "P");
                $this->db->where("deleted","N");
                $this->db->where("id_reset",$id_resett[1]);
                $res  = $this->db->insert("users",$data);              
            }
            
            if($res) {  
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "id" => $data["id_session"],
                    "pesan" => "Data berhasil disimpan ");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan<br>".$rules);
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    }

    function resend(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
           
                $kode = hash("sha512", md5(date("YmdHis")));
                $data["id_reset"] = hash("sha512", $kode);
                $datetime = new DateTime('today');
                $datetime->modify('+3 day');
                $link_valid = $datetime->format('Y-m-d');
                $data["valid_reset"] = $link_valid;
                $kode_reset = site_url("kmzwa8awaa/verifikasi_email/".$kode."-".$data["id_reset"]);
                $generate_pass = md5("YmdHis");
                $data["blokir"] = "P";
                $data["password"] = hash("sha512", md5($generate_pass));
                $this->db->where("email", $data["email"]);
                $this->db->update("users", $data);
                // rec(get_class($this));

                // set penerima
                $this->db->where("email", $data["email"]);
                $this->db->select("id_session, attack, tanggal_reg, email, nama_lengkap")->from("users");
                $cek_user = $this->db->get();
                $em = $cek_user->row();

                // set pengirim
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();
                
                // isi body pesan 
                $data["title"] = "Verifikasi Email";
                $data["p1"] = $web->nama_website ." mengirim verifikasi email untuk turut mengelola website. ";
                $data["p2"] = "Email verifikasi ini berlaku hingga ". tgl_view($link_valid)." Klik Verifikasi Email ";
                $data["btn"] = "Verifikasi Email";
                $data["link_reset"] = $kode_reset;
                $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
                // end of isi body

                $email                  = $em->email;
                $subject                = "Verifikasi Email";
                $this->email->from($web->email, $web->nama_website);
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject($subject);
                $body = $this->load->view('password/reset_password_mail_template',$data,TRUE);
                $this->email->message($body);  
                $this->email->set_mailtype("html");
                $this->email->send();

                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $res = $this->email->initialize($config);
                
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    
                    "pesan" => "Email verifikasi akun telah dikirim ke email<br>". $data["email"]);
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


    function pub($id,$ses){
        $this->db->where("id_session", $ses);
        $this->db->where("id_modul", $id);
        $cek = $this->db->get("users_modul");

        $this->db->where("id_modul", $id);
        $rul = $this->db->get("modul")->row();

        if ($cek->num_rows() == 0) {
            $data["id_modul"] = $id;
            $data["id_session"] = $ses;
            $rec = $this->db->insert("users_modul", $data);
            // rec(get_class($this));
            if ($rec) {
            $ret = array("success" => true,
                "title" => "Akses Dibuka",
                "pesan" => "Akses ".$rul->nama_modul." <br>Diizinkan");
            } else {
                $ret = array("success" => false,
                    "title" => " Gagal",
                    "pesan" => " Gagal prosess");
            }
        } else {
            $data["id_modul"] = $id;
            $data["id_session"] = $ses;
            $res = $this->db->delete("users_modul", $data);
            if ($res) {
                $ret = array("success" => true,
                    "title" => "Akses Ditutup",
                    "pesan" => "Akses ".$rul->nama_modul." <br>tidak diizinkan");
            } else {
                $ret = array("success" => false,
                    "title" => " Gagal",
                    "pesan" => " Gagal prosess");
            }
        }         
       echo json_encode($ret);
       // echo $this->db->last_query();

    }

    function hapus_data(){
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->db->where("username",$id);
            $res =$this->om->delete("users");
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

    function update_setting_profil($id){
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama_website','Nama Website','required'); 
        $this->form_validation->set_rules('url','Domain','required');  
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == false ) { 

                $this->db->where("id_session",$id);
                $res  = $this->db->update("users",$data);    
                // rec(get_class($this));   
            
            
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil diupdate");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal diupdate ".$this->upload->display_errors("<br>",$rules));
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    }

    function get_jurusan(){
        $id = $this->input->post('id');
        $data = $this->dm->get_jurusan($id);
        echo json_encode($data);
    }

    function get_prodi(){
        $id = $this->input->post('id');
        $data = $this->dm->get_prodi($id);
        echo json_encode($data);
    }


    function pdf($id) {
     
        $this->db->where("username", $id);
        $this->db->select("username,nama_lengkap,nim,email,tanggal_reg, alamat,no_telp , level, nama_fakultas, nama_jurusan, nama_prodi, angkatan");
        $this->db->from("users");
        $this->db->join("master_fakultas", "master_fakultas.id_fakultas = users.id_fakultas");
        $this->db->join("master_jurusan", "master_jurusan.id_jurusan  = users.id_jurusan");
        $this->db->join("master_prodi", "master_prodi.id_prodi = users.id_prodi");
        $this->db->where("level","user");
        $this->db->where("deleted","N");

        $data["res"] = $this->db->get()->row();
       
        $data["title"] = "Kartu Peepustakaan ".$data["res"]->nama_lengkap;
      

        $datanya = "NIM : ".$data["res"]->nim; //data yang akan di 
        $this->load->helper("qr");
        $data['savename'] = FCPATH."assets/images/qr/".create_qr($datanya,$id);

        
        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetAutoPageBreak(true,5);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "A4");


        $html = $this->load->view(get_class($this)."_biodata_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 

    function biodata($id) {
     
        $this->db->where("username", $id);
        $this->db->select("username,nama_lengkap,nim,email,tanggal_reg, alamat,no_telp , level, nama_fakultas, nama_jurusan, nama_prodi, angkatan");
        $this->db->from("users");
        $this->db->join("master_fakultas", "master_fakultas.id_fakultas = users.id_fakultas");
        $this->db->join("master_jurusan", "master_jurusan.id_jurusan  = users.id_jurusan");
        $this->db->join("master_prodi", "master_prodi.id_prodi = users.id_prodi");
        $this->db->where("level","user");
        $this->db->where("deleted","N");

        $data["res"] = $this->db->get()->row();
       
        $data["title"] = "Biodata ".$data["res"]->nama_lengkap;
      

        
        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(10, 10, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetAutoPageBreak(true,5);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("P", "A4");


        $html = $this->load->view(get_class($this)."_biodata2_view",$data,true);
        $pdf->writeHTML($html, true, false, true, false, '');
        
        unlink($data['savename']);
        $pdf->Output($data['header'] .'.pdf', 'I');
    } 
	
}
