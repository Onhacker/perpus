<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_history extends CI_Model {
	var $table = 'user_akses';
	var $column_order = array('','','ip','browser','os','waktu');
	var $column_search = array('ip', 'browser','os','waktu'); 
	var $order = array('id' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
			$this->db->where(array("username" => $this->session->userdata("admin_username")));
			$this->db->from($this->table);
		
        
		$i = 0;

		foreach ($this->column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->like($item, $_POST['search']['value']);
				}
				else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i);

			}
			$i++;
		}

		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

	}

	function get_data(){
		$this->get_data_query();
		if ($_POST["length"] == "-1") {
			$query = $this->db->get();
		} else {
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
		}	
		return $query->result();
	}

	function count_filtered(){
		$this->get_data_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all(){
		$this->db->where(array("username" => $this->session->userdata("admin_username")));
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
			$this->db->where('id_halaman',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('id_halaman',$id);
			$query = $this->db->get();
		}   
		return $query;
	}

}
