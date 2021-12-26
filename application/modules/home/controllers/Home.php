<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
		$this->load->helper("front");
		$this->load->model("front_model",'fm');
	}

	function index(){
		$data['title'] = "Home";
        $data["description"] = $this->fm->web_me()->meta_deskripsi;
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
        
	}

	function wax(){
		 $n = (date("Y-m-d H:i:s"));
			$this->db->where("id_identitas", "1");
         $web = $this->db->get("identitas")->row();
         // $this->db->limit(1);
         $this->db->select("*, (TIMESTAMPDIFF(DAY,NOW(),tgl_pengembalian)) as hari,
           (TIMESTAMPDIFF(HOUR,NOW(),tgl_pengembalian))%24 as jam,
           (TIMESTAMPDIFF(minute,NOW(),tgl_pengembalian))%60 as menit");
         $this->db->from("sirkulasi");
         $this->db->where("(TIMESTAMPDIFF(DAY,NOW(),tgl_pengembalian)) = 1");
         $this->db->where("nim",$nim);
         $this->db->where("status", "1");
         $this->db->where("tgl_dikembalikan", "0000-00-00 00:00:00");
         $x = $this->db->get();
         // $d = $x->row();
         // echo $this->db->last_query()."<br>";
     	foreach($x->result() as $d):
     		// echo $d->judul_buku;
         	$this->db->where("nim",$d->nim);
         	$this->db->select("no_telp")->from("users");
         	$t = $this->db->get()->row();
        	
         	$telepon = format_telpon($t->no_telp);

         	
         	$b = explode(" ", $d->tgl_pengembalian);
         	$tgl_pengembalian = flipdate($b[0])." ".$b[1];

         	$tgl1 = new DateTime($d->tgl_pengembalian);
         	$tgl2 = new DateTime(date("Y-m-d H:i:s"));
         	$jarak = $tgl2->diff($tgl1);

         	 $message = "Halo ".$d->nama_mahasiswa." Member ".$web->nama_website.". Anda memiliki pinjaman buku yang harus dikembalikan pada tanggal *".($tgl_pengembalian)."* yang berjudul *".$d->judul_buku."*";
         	// exit();
            $curl = curl_init();
            $token = "vPDwq2Xv4sCpjlklwbpVEdlOztUXFR4KBiiiSHh72Vbn3th2Y0vBnuLe33frEwwS";
            $data = [
                'phone' => "$telepon",
                'message' => "$message",
            ];

            curl_setopt($curl, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: $token",
                )
            );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_URL, "https://kacangan.wablas.com/api/send-message");
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
            echo "<pre>";
            print_r($result);
        endforeach;

        }



	function wa($telepon,$message){
		$curl = curl_init();
				$token = "vPDwq2Xv4sCpjlklwbpVEdlOztUXFR4KBiiiSHh72Vbn3th2Y0vBnuLe33frEwwS";
                $data = [
                    'phone' => "$telepon",
                    'message' => "$message",
                ];

                curl_setopt($curl, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: $token",
                    )
                );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($curl, CURLOPT_URL, "https://kacangan.wablas.com/api/send-message");
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                $result = curl_exec($curl);
                curl_close($curl);
                echo "<pre>";
				print_r($result);
	}

	function timezone(){
        $this->db->where("id_identitas", "1");
        $s = $this->db->get("identitas")->row();
        return date_default_timezone_set($s->waktu);
    }

	function reload(){
		redirect(site_url("admin_dashboard"));
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

	function reload_captcha(){
		$acak = $this->get_client_ip().date("yy-m-d H:i:s");
        $acak = md5($acak);
        $serial = substr(preg_replace("/[^0-9]/", '', $acak),0,4);
        $this->session->set_userdata("capctcha",$serial);
        return Terbilang($serial);
      
	}


	function ceklogin(){
		$data = $this->input->post();
		unset($data["password2"]);
		if ($data["captcah"] == $this->session->userdata("capctcha")) {
			$this->db->select('*')->from('users');
			$this->db->where("blokir","N");
			$this->db->where("deleted","N");
			$this->db->where("password",hash("sha512", md5($data['kode'])));
			$this->db->where("username",$data['member']);
			$this->db->or_where("email",$data['member']);
			$res = $this->db->get();
			$rows = $res->row();
			if($res->num_rows() == 1 and $data["captcah"] == $this->session->userdata("capctcha")) {
				$this->session->set_userdata("admin_login",true);
				$this->session->set_userdata("admin_username",$rows->username);
				$this->session->set_userdata("admin_level",$rows->level);
				$this->session->set_userdata("admin_attack",$rows->attack);
				$this->session->set_userdata("admin_permisson",$rows->permission_publish);
				$this->session->set_userdata("admin_session",$rows->id_session);
				if ($this->session->userdata("admin_level") == "user") {
					$this->session->set_userdata("admin_pkm",$rows->id_pkm);
				}
				// $x["ip"] = $this->get_client_ip();
				// $x["browser"] = $this->get_client_browser();
				// $x["os"] = $_SERVER['HTTP_USER_AGENT'];
				// $x["waktu"] = date("Y-m-d H:i:s");
				// $x["username"] = $this->session->userdata("admin_username");
				// $this->db->insert("user_akses", $x);
				$ret = array("success"=>true,
					"pesan"=> "Login Berhasil",
					"operation" =>"insert");
				$this->session->unset_userdata("capctcha");
			} else {
				$ret = array("success"=>false,
					"new" => $this->reload_captcha(),
					"title" => "Gagal",
					"type" => "error",
					"pesan"=> "Login Gagal. Username/Email dan password tidak diterima");
			}
		} else {
			$ret = array("success"=>false,
					"new" => $this->reload_captcha(),
					"title" => "Gagal",
					"type" => "error",
					"pesan"=> "Captcha Gagal");
		}
		
		
		echo json_encode($ret);
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

	function logout(){
		$this->session->unset_userdata("admin_login");
		$this->session->unset_userdata("admin_username");
		$this->session->unset_userdata("admin_permisson");
		$this->session->unset_userdata("admin_level");
		$this->session->unset_userdata("admin_session");
		$this->session->unset_userdata("admin_attack");
		$this->session->unset_userdata("admin_pkm");
		$this->load->view("logout");
	}
	
}
