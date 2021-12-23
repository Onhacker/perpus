<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
	}

	function index(){
		$data['title'] = "PROFIL ".$this->fm->web_me()->nama_website;
		$data["profil"] = $this->fm->web_me()->profil;
		$data["visi"] = $this->fm->web_me()->visi;
		$data["misi"] = $this->fm->web_me()->misi;
		$data["str"] = $this->fm->web_me()->str;
        $data["description"] = cetak_meta($this->fm->web_me()->profil,0,1000);
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
        
	}
	
}
