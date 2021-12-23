<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kmzwa8awaa extends MX_Controller {
	function __construct(){
		parent::__construct();
        $this->timezone();
        $this->load->helper("front");
        $this->load->model("Front_model", "fm");
        $this->load->library("email");
        error_reporting(0);
    }

    function timezone(){
        $this->db->where("id_identitas", "1");
        $s = $this->db->get("identitas")->row();
        return date_default_timezone_set($s->waktu);
    }

	function index(){
	$this->load->helper("front");
        $data['record'] = $this->fm->view_ordering_limit('berita','id_berita','DESC',0,10);
        $this->load->view(onhacker(get_class($this)),$data); 
	}

    // function feed(){
    //     $this->load->view(onhacker_view("rss")); 
    // }

    function verifikasi_email_users_web($id_reset = ""){
        $id_reset = explode("-", $id_reset);
        $id_reset = $id_reset[1];

        $this->db->where("id_reset", $id_reset);
        $this->db->select("id_session, attack, valid_reset,email")->from("users_web");
        $res = $this->db->get();
        $rec = $res->row();
        $today = date("Y-m-d");
        $until = $rec->valid_reset;

        $data["rec"] = $this->fm->web_me();

        if ($until < $today) {
                $z["id_reset"] = md5(date("YmdHis"));
                $this->db->where("id_reset", $id_reset);
                $this->db->update("users_web", $z);
                $this->load->view("password/link_expired", $data);
        } elseif ($res->num_rows() == 1) {
            $data["success"] = "Email ".$rec->email." berhasil diverifikasi. Silahkan Lengkapi form dibawah untuk melengkapi data login";
            $this->load->view("password/form_verifikasi_email_user_web", $data);
        }  else {
            $this->load->view("password/link_expired", $data);
        }
       
    }


    function new_user_web($id_reset){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password_baru','Password Baru','trim|required|min_length[8]'); 
        $this->form_validation->set_rules('password_baru_lagi','Konfirmasi Password ','trim|required|min_length[8]'); 

        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_message('min_length', '* %s Minimal 8  Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Karakter ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            unset($data["password2"]);
            unset($data["id_session"]);
            unset($data["level"]);
            unset($data["blokir"]);
            unset($data["permission_publish"]);
            unset($data["foto"]);
            unset($data["attack"]);
        

            if ($data["password_baru"] <> $data["password_baru_lagi"]) {
                $rules = "Password Baru dan Konfirmasi Password Tidak Sama<br>";
            }  else {

                $data["password"] = $data["password_baru_lagi"];
                unset($data["password_baru"]);
                unset($data["password_baru_lagi"]);
                unset($data["member"]);
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
                $res  = $this->db->update("users_web",$data);    
          
            }
            
            if($res) {  
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan. Silahkan login menggunakan email dan password anda ");
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

    function reset_password_user_web(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("blokir", "N");
            $this->db->where("email", $data["email"]);
            $this->db->select("id_session, attack, tanggal_reg, email, nama_lengkap")->from("users_web");
            $cek_user = $this->db->get();
            $em = $cek_user->row();

            if ($cek_user->num_rows() == 0) {
                $rules = "Email ini tidak terdaftar. Masukkan email yang sudah terdaftar";
            } else {
                // buat kode reset dlu bro
                $kode = hash("sha512", md5(date("YmdHis")));
                $x["id_reset"] = hash("sha512", $kode);
                $datetime = new DateTime('today');
                $datetime->modify('+3 day');
                $link_valid = $datetime->format('Y-m-d');
                $x["valid_reset"] = $link_valid;
                $kode_reset = site_url("kmzwa8awaa/reset_password_web/".$kode."-".$x["id_reset"]);
                // insert tgl expired dan id_reset ke database untuk validasi
                $this->db->where("email", $data["email"]);
                $this->db->update("users_web", $x);

                // set pengirim
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();
                
                // isi body pesan 
                $data["title"] = "Reset Password";
                $data["p1"] = "Hai ".$em->nama_lengkap.". Jika permintaan ini adalah anda, Silahkan reset password anda";
                $data["p2"] = "Email reset password ini berlaku hingga ". tgl_view($link_valid)." Klik Reset Password ";
                $data["btn"] = "Reset Password";
                $data["link_reset"] = $kode_reset;
                $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
                // end of isi body

                $email                  = $em->email;
                $subject                = "Reset Password ".$web->nama_website;
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

                $rules = "Link Reset Password telah dikirim ke Email ". $data["email"]." Silahkan cek inbox atau spam";
            }
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "type" => "success",
                    "pesan" => $rules);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "type" => "error",
                    "pesan" => "Reset Password Gagal ".$rules);
            }

        } else {
            $ret = array("success"=>false,
                    "title" => "Gagal",
                    "type" => "error",
                   "pesan" => validation_errors());

        }
        echo json_encode($ret);
    }


    function reset_password_web($id_reset = ""){
        $id_reset = explode("-", $id_reset);
        $id_reset = $id_reset[1];

        $this->db->where("id_reset", $id_reset);
        $this->db->select("id_session, attack, valid_reset")->from("users_web");
        $res = $this->db->get();
        $rec = $res->row();
        $today = date("Y-m-d");
        $until = $rec->valid_reset;

        $data["rec"] = $this->fm->web_me();

        if ($until < $today) {
                $z["id_reset"] = md5(date("YmdHis"));
                $this->db->where("id_reset", $id_reset);
                $this->db->update("users_web", $z);
                // // rec(get_class($this));
                $this->load->view("password/link_expired", $data);
        } elseif ($res->num_rows() == 1) {
            $this->load->view("password/form_reset_user_web", $data);
        }  else {
            $this->load->view("password/link_expired", $data);
        }
       
    }

    function verifikasi_email($id_reset = ""){
        $id_reset = explode("-", $id_reset);
        $id_reset = $id_reset[1];

        $this->db->where("id_reset", $id_reset);
        $this->db->select("id_session, attack, valid_reset,email")->from("users");
        $res = $this->db->get();
        $rec = $res->row();
        $today = date("Y-m-d");
        $until = $rec->valid_reset;

        $data["rec"] = $this->fm->web_me();

        if ($until < $today) {
                $z["id_reset"] = md5(date("YmdHis"));
                $this->db->where("id_reset", $id_reset);
                $this->db->update("users", $z);
                // // rec(get_class($this));
                $this->load->view("password/link_expired", $data);
        } elseif ($res->num_rows() == 1) {
            $data["success"] = "Email ".$rec->email." berhasil diverifikasi. Silahkan Lengkapi form dibawah untuk melengkapi data login";
            $this->load->view("password/form_verifikas_email", $data);
        }  else {
            $this->load->view("password/link_expired", $data);
        }
       
    }

    function reset_password($id_reset = ""){
        $id_reset = explode("-", $id_reset);
        $id_reset = $id_reset[1];

        $this->db->where("id_reset", $id_reset);
        $this->db->select("id_session, attack, valid_reset")->from("users");
        $res = $this->db->get();
        $rec = $res->row();
        $today = date("Y-m-d");
        $until = $rec->valid_reset;

        $data["rec"] = $this->fm->web_me();

        if ($until < $today) {
                $z["id_reset"] = md5(date("YmdHis"));
                $this->db->where("id_reset", $id_reset);
                $this->db->update("users", $z);
                // // rec(get_class($this));
                $this->load->view("password/link_expired", $data);
        } elseif ($res->num_rows() == 1) {
            $this->load->view("password/form_reset", $data);
        }  else {
            $this->load->view("password/link_expired", $data);
        }
       
    }


    function reset_password_user(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("blokir", "N");
            $this->db->where("email", $data["email"]);
            $this->db->select("id_session, attack, tanggal_reg, email, nama_lengkap")->from("users");
            $cek_user = $this->db->get();
            $em = $cek_user->row();

            if ($cek_user->num_rows() == 0) {
                $rules = "Email ini tidak terdaftar. Masukkan email yang sudah terdaftar";
            } else {
                // buat kode reset dlu bro
                $kode = hash("sha512", md5(date("YmdHis")));
                $x["id_reset"] = hash("sha512", $kode);
                $datetime = new DateTime('today');
                $datetime->modify('+3 day');
                $link_valid = $datetime->format('Y-m-d');
                $x["valid_reset"] = $link_valid;
                $kode_reset = site_url("kmzwa8awaa/reset_password/".$kode."-".$x["id_reset"]);
                // insert tgl expired dan id_reset ke database untuk validasi
                $this->db->where("email", $data["email"]);
                $this->db->update("users", $x);
                // // rec(get_class($this));

                // set pengirim
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();
                
                // isi body pesan 
                $data["title"] = "Reset Password";
                $data["p1"] = "Hai ".$em->nama_lengkap.". Jika permintaan ini adalah anda, Silahkan reset password anda";
                $data["p2"] = "Email reset password ini berlaku hingga ". tgl_view($link_valid)." Klik Reset Password ";
                $data["btn"] = "Reset Password";
                $data["link_reset"] = $kode_reset;
                $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
                // end of isi body

                $email                  = $em->email;
                $subject                = "Reset Password ".$web->nama_website;
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

                $rules = "Link Reset Password telah dikirim ke Email ". $data["email"]." Silahkan cek inbox atau spam";
            }
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "type" => "success",
                    "pesan" => $rules);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "type" => "error",
                    "pesan" => "Reset Password Gagal ".$rules);
            }

        } else {
            $ret = array("success"=>false,
                    "title" => "Gagal",
                    "type" => "error",
                   "pesan" => validation_errors());

        }
        echo json_encode($ret);
    }


    function new_pass_user_web($id_reset){
        $data = $this->input->post();
        $pass = $data["password_baru_lagi"];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password_baru','Password Baru','trim|required|min_length[8]'); 
        $this->form_validation->set_rules('password_baru_lagi','Konfirmas Password ','trim|required|min_length[8]'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('min_length', '* %s Minimal 8 karakter ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            unset($data["password"]);
            unset($data["id_session"]);
            unset($data["level"]);
            unset($data["blokir"]);
            unset($data["permission_publish"]);
            unset($data["nama_lengkap"]);
            unset($data["foto"]);
            unset($data["attack"]);
           
            if ($data["password_baru"] <> $data["password_baru_lagi"]) {
                $rules = "Password Baru dan Konfirmasi Password Tidak Sama<br>";
            }  else {
                unset($data["password_baru"]);
                unset($data["password_baru_lagi"]);
               
                $data["attack"] = md5(date("Ymdhis"));
                $data["valid_reset"] = "0000-00-00";

                $data["password"] = hash("sha512", md5($pass));
                $id_resett = explode("-", $id_reset);
                $data["id_reset"] = hash("sha512", md5(date("Ymdhis")));
                $this->db->where("blokir", "N");
                $this->db->where("deleted","N");
                $this->db->where("id_reset",$id_resett[1]);
                $res  = $this->db->update("users_web",$data); 
                // // rec(get_class($this));                 
            }
            
            if($res) {  
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Password berhasil diupdate ");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Password Gagal diupdate<br>");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    }

    function new_pass($id_reset){
        $data = $this->input->post();
        $pass = $data["password_baru_lagi"];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password_baru','Password Baru','trim|required|min_length[8]'); 
        $this->form_validation->set_rules('password_baru_lagi','Konfirmas Password ','trim|required|min_length[8]'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('min_length', '* %s Minimal 8 karakter ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            unset($data["password"]);
            unset($data["id_session"]);
            unset($data["level"]);
            unset($data["blokir"]);
            unset($data["permission_publish"]);
            unset($data["nama_lengkap"]);
            unset($data["foto"]);
            unset($data["attack"]);
           
            if ($data["password_baru"] <> $data["password_baru_lagi"]) {
                $rules = "Password Baru dan Konfirmasi Password Tidak Sama<br>";
            }  else {
                unset($data["password_baru"]);
                unset($data["password_baru_lagi"]);
               
                $data["attack"] = md5(date("Ymdhis"));
                $data["valid_reset"] = "0000-00-00";

                $data["password"] = hash("sha512", md5($pass));
                $id_resett = explode("-", $id_reset);
                $data["id_reset"] = hash("sha512", md5(date("Ymdhis")));
                $this->db->where("blokir", "N");
                $this->db->where("deleted","N");
                $this->db->where("id_reset",$id_resett[1]);
                $res  = $this->db->update("users",$data); 
                // // rec(get_class($this));                 
            }
            
            if($res) {  
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Password berhasil diupdate ");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Password Gagal diupdate<br>");
            }

        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    }


    function new_user($id_reset){
        $data = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('member','Username','trim|required|max_length[12]'); 
        $this->form_validation->set_rules('nama_lengkap','Nama Lengkap','required'); 
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
            unset($data["id_session"]);
            unset($data["level"]);
            unset($data["blokir"]);
            unset($data["permission_publish"]);
            unset($data["foto"]);
            unset($data["attack"]);
                
            if (strlen($data["member"]) < 6) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Username harus Minimal 5 karakter");
                echo json_encode($ret);
                return false;
            }

            $this->db->where("username", $data["member"]);
            $cek_user = $this->db->get("users");
            if ($cek_user->num_rows() > 0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Username sudah ada");
                echo json_encode($ret);
                return false;
            }

            if ($data["password_baru"] <> $data["password_baru_lagi"]) {
                $rules = "Password Baru dan Konfirmasi Password Tidak Sama<br>";
            }  else {
                $data["username"] = $data["member"];
                $data["password"] = $data["password_baru_lagi"];
                unset($data["password_baru"]);
                unset($data["password_baru_lagi"]);
                unset($data["member"]);
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
                $res  = $this->db->update("users",$data);    
                // // rec(get_class($this));              
            }
            
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


   
}
