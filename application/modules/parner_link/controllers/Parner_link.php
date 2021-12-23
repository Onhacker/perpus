<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Parner_link extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
	}

	function index(){
		// $data['title'] = "PARNER LINK ".$this->fm->web_me()->nama_website;
		// $data["link"] = $this->db->get("master_link_berita");
  //       $data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
  //       $data["keywords"] = $this->fm->web_me()->meta_keyword;
  //       $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
  //       $this->render($data);
        redirect(site_url());
	}

	function berita(){
		$data['title'] = "PARNER LINK BERITA ".$this->fm->web_me()->nama_website;
		$data["link"] = $this->db->get("master_link_berita");
        $data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
	}

	function jurnal(){
		$data['title'] = "PARNER LINK JURNAL ".$this->fm->web_me()->nama_website;
		$data["link"] = $this->db->get("master_link_jurnal");
        $data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
	}
	
}
