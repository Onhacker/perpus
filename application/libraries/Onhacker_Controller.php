<?php
class Onhacker_Controller extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->timezone();
		$this->load->model("Front_model","fm");
		$this->load->helper("front");
		error_reporting(0);

		
	}

	function render($data){
		$this->db->where("aktif", "Y");
		$res = $this->db->get("templates")->row();
		$this->load->view($res->folder."/publik_view",$data);
	}
	
	function timezone(){
		$this->db->where("id_identitas", "1");
		$s = $this->db->get("identitas")->row();
		return date_default_timezone_set($s->waktu);
	}

	function kunjungan(){
        $ip      = $_SERVER['REMOTE_ADDR'];
        $tanggal = date("Y-m-d");
        $waktu   = time(); 
        $cekk = $this->db->query("SELECT * FROM statistik WHERE ip='$ip' AND tanggal='$tanggal'");
        $rowh = $cekk->row_array();
        if($cekk->num_rows() == 0){
            $datadb = array('ip'=>$ip, 'tanggal'=>$tanggal, 'hits'=>'1', 'online'=>$waktu);
            $this->db->insert('statistik',$datadb);
        }else{
            $hitss = $rowh['hits'] + 1;
            $datadb = array('ip'=>$ip, 'tanggal'=>$tanggal, 'hits'=>$hitss, 'online'=>$waktu);
            $array = array('ip' => $ip, 'tanggal' => $tanggal);
            $this->db->where($array);
            $this->db->update('statistik',$datadb);
        }
    }

	
}
?>