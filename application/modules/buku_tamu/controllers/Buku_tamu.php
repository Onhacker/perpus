<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buku_tamu extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
	}

	function index(){
		$data['title'] = "BUKU TAMU ".$this->fm->web_me()->nama_website;
		$data["link"] = $this->db->get("master_link_berita");
		$this->db->select('nama_lengkap,email,alamat')
		->from("users")
		->where("username", $this->session->userdata("admin_username"));
		$x = $this->db->get()->row();
		$data["nama"] = $x->nama_lengkap;
		$data["email"] = $x->email;
		$data["alamat"] = $x->alamat;
		$data["kode"] = $this->reload_captcha();
		$data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
		$data["keywords"] = $this->fm->web_me()->meta_keyword;
		$data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
		$this->render($data);
	}

	function reload_captcha(){
		$acak = $this->get_client_ip().date("yy-m-d H:i:s");
		$acak = md5($acak);
		$serial = substr(preg_replace("/[^0-9]/", '', $acak),0,4);
		$this->session->set_userdata("capctcha",$serial);
		return Terbilang($serial);

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

	function get_client_ip_2() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'IP tidak dikenali';
		return $ipaddress;
	}


	function get_client_browser() {
		$browser = '';
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
			$browser = 'Netscape';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			$browser = 'Firefox';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
			$browser = 'Chrome';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
			$browser = 'Opera';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
			$browser = 'Internet Explorer';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari'))
			$browser = 'Safari';
		else
			$browser = 'Other';
		return $browser;
	}

	function write(){
		unlink($this->session->userdata("file"));
		$this->session->unset_userdata("file");
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		$acak = $this->get_client_ip().$d->format("Y-m-d H:i:s.u");
		$acak = substr(md5($acak), 0,15);
		$new_image = $acak.".png";
		$config['image_library']='gd2';
		$config['source_image'] = 'assets/images/qr/cap.png';
		$config['wm_text'] = $this->reload_captcha();
		$config['wm_type'] = 'text';
		$config['wm_font_path'] = 'system/fonts/texb.ttf';
		$config['wm_font_size'] = '14';
		$config['wm_font_color'] = 'F3FF00';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'center';
		$config['quality'] = '100%';
		$config['new_image']= 'assets/images/qr/'.$new_image;
		$this->load->library('image_lib',$config);
		$this->image_lib->watermark();
		$path = 'assets/images/qr/';
		$filename =  $path.$new_image;
		$this->session->set_userdata("file",$filename);
		return $new_image;            
	}
	function send(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama','Nama','required'); 
		$this->form_validation->set_rules('alamat','Alamat','required'); 
		$this->form_validation->set_rules('pesan','Pesan','required'); 
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
		$this->form_validation->set_message('numeric', '* %s Harus angka ');
		$this->form_validation->set_message('valid_url', '* %s Tidak Valid ');
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			if ($data["captcah"] == $this->session->userdata("capctcha")) {
				unset($data["captcah"]);
				$data["tanggal"] = date("Y-m-d H:i:s");
				$res  = $this->db->insert("buku_tamu",$data);
				if($res) {
					$ret = array("success" => true,
						"title" => "Berhasil",
						"new" => $this->reload_captcha(),
						"pesan" => "Pesan berhasil dikirim");
				} else {
					$ret = array("success" => false,
						"title" => "Gagal",
						"pesan" => "Pesan Gagal dikirim ".$this->upload->display_errors("<br>",$rules));
				}

			} else {
				$ret = array("success"=>false,
				"new" => $this->reload_captcha(),
				"title" => "Gagal",
				"type" => "error",
				"pesan"=> "Captcha Gagal");
			}
		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);


	}

}
