<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kartu extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
	}

	function index(){
		$data['title'] = "CETAK KARTU BEBAS PUSTAKA ".$this->fm->web_me()->nama_website;
        $data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        if ($this->session->userdata("admin_login") == true and $this->session->userdata("admin_level") == "user") {
        	$this->db->where("nim",$this->session->userdata("admin_pkm"));
        	$this->db->where("status","0");
        	$data["res"] = $this->db->get("sirkulasi");
        }
        
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
	}

	
	
}
