<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_profil extends Admin_Controller {
	function __construct(){
		parent::__construct();
		// cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
	}

	function index(){
		
		$data["controller"] = get_class($this);
		$data["record"] = $this->om->profil()->row();
		$data["title"] = "Pengaturan Profil";
		$data["subtitle"] = $data["record"]->nama_lengkap;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	function load_profil(){
		$data = array();
		$res  = $this->om->profil();
		if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
		$data["tanggal_reg"] = tgl_indo($data["tanggal_reg"]);
		echo json_encode($data);
	}

	function update(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama_lengkap','Nama Mahasiswa','required');  
		if ($this->session->userdata("admin_level") != "admin") {
			 $this->form_validation->set_rules('nim','NIM','trim|required|numeric');  
		}
       
        $this->form_validation->set_rules('email','Email','trim|required|valid_email'); 
        $this->form_validation->set_rules('alamat','Alamat','trim|required'); 
		$this->form_validation->set_rules('no_telp','No Telpon','trim|numeric|required|min_length[10]|max_length[12]'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('numeric', '* %s Harus angka ');
		$this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
		$this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 

			$this->db->where("username !=",$this->session->userdata("admin_username"));
			$this->db->where("blokir", "N");
            $this->db->where("email", $data["email"]);
            $this->db->select("id_session, username,attack, tanggal_reg, email, nama_lengkap")->from("users");
            $cek_user = $this->db->get();
            // echo $this->db->last_query();
            $em = $cek_user->row();
            if ($cek_user->num_rows() >= 1) {
                $ret = array("success" => false,
						"title" => "Gagal",
						"pesan" => "Email ".$data["email"]." sudah digunakan");
					echo json_encode($ret);
					return false;

            } 
			unset($data["password"]);
			unset($data["id_session"]);
			$data["username"] = $this->session->userdata("admin_username");
			$this->db->where("username",$data["username"]);
			$user = $this->om->profil()->row();
			
			$data["level"] = $this->session->userdata("admin_level");
			$data["blokir"] = $user->blokir;
			$data["permission_publish"] = $user->permission_publish;

			$new_name = buat_name($data["nama_lengkap"],"0")."_".substr(md5(date("Ymdhis")), 0,8);
			$config['upload_path'] = 'upload/users/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|PNG|JPEG|GIF';
            $config['max_size'] = '1000'; // kb
            $config['overwrite'] = TRUE;
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (empty($_FILES['foto']["name"])){
				$this->db->where("username",$data["username"]);
				$res  = $this->om->update("users",$data);
				// // rec(get_class($this));	
			} 

			if (! $this->upload->do_upload('foto')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size'])." Kb)";

			} else {
				// if ($this->session->userdata("admin_level") == "admin") {
				// 	$ret = array("success" => false,
				// 		"title" => "Gagal",
				// 		"pesan" => "Akun Dinas Kesehatan ".$this->om->web_me()->kabupaten." Tidak diperkenankan untuk merubah gambar. Silahkan reload halaman ini jika ingin mengupdate form lainnya tanpa memasukkan gambar");
				// 	echo json_encode($ret);
				// 	return false;
				// }
				$gbr = $this->om->profil()->row();
				$path = 'upload/users/';
				$filename =  $path.$gbr->foto;
				unlink($filename);
				// echo $this->db->last_query();
				$fdata =  $this->upload->data();
				$data['foto'] = $fdata['file_name'];	
				$this->db->where("username",$data["username"]);
				$res  = $this->db->update("users",$data);
				// // rec(get_class($this));		


			}
		
            
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

	function update_pass(){
		$data = $this->input->post();
		$pass = $data["password_baru_lagi"];
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password_baru','Password Baru','trim|required|min_length[8]'); 
        $this->form_validation->set_rules('password_baru_lagi','Konfirmas Password ','trim|required|min_length[8]'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_rules('password_lama','Password Lama','required'); 
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
			$data["username"] = $this->session->userdata("admin_username");
			$this->db->where("username",$data["username"]);
			$user = $this->db->get("users")->row();
			if ($data["password_baru"] <> $data["password_baru_lagi"]) {
				$rules = "Password Baru dan Password Baru Lagi Tidak Sama<br>";
			} elseif (hash("sha512", md5($data["password_lama"])) <> $user->password) {
				$rules = "Password Lama Salah<br>";
			} else {
				unset($data["password_lama"]);
				unset($data["password_baru"]);
				unset($data["password_baru_lagi"]);
				if ($data["out"] == "out") {
					$data["attack"] = md5(date("Ymdhis"));
				} else {
					unset($data["attack"]);
				}
				unset($data["out"]);
				$data["password"] = hash("sha512", md5($pass));
				$this->db->where("username",$data["username"]);
				$res  = $this->db->update("users",$data);
				// rec(get_class($this));

				$this->db->where("username",$data["username"]);
				$new_sess = $this->db->get("users")->row();
				$this->session->set_userdata("admin_attack",$new_sess->attack);		
			}
			
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil diupdate ");
			} else {
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal diupdate<br>".$rules);
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
	}

	
	
}
