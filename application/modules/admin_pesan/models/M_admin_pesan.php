<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_pesan extends CI_Model {
	var $table = 'hubungi';
	var $column_order = array('','bintang','nama','','tanggal');
	var $column_search = array('nama','email','subjek','tanggal'); 
	var $order = array('id_hubungi' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query($b = ""){
		if ($b == "Y") {
			$this->db->where("deleted", "0");
			$this->db->where("bintang", "Y");
			$this->db->from($this->table);
		} elseif ($b == "X") {
			$this->db->where("deleted", "1");
			$this->db->from($this->table);
		} elseif ($b == "1") {
			$this->db->where("deleted", "0");
			$this->db->where("terbalas", "1");
			$this->db->from($this->table);
		} else {
			$this->db->where("deleted", "0");
			$this->db->where("status", "0");
			$this->db->from($this->table);
		}
        
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

	function get_data($b){
		$this->get_data_query($b);
		if ($_POST["length"] == "-1") {
			$query = $this->db->get();
		} else {
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
		}	
		return $query->result();
	}

	function count_filtered($b){
		$this->get_data_query($b);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all($b){
		if ($b == "Y") {
			$this->db->where("deleted", "0");
			$this->db->where("bintang", "Y");
			$this->db->from($this->table);
		} elseif ($b == "X") {
			$this->db->where("deleted", "1");
			$this->db->from($this->table);
		} else {
			$this->db->where("deleted", "0");
			$this->db->from($this->table);
		}
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		$x["dibaca"] = "Y";
		$this->db->where("id_hubungi", $id);
		$this->db->update("hubungi", $x);

		$this->db->from($this->table);
		$this->db->where('id_hubungi',$id);
		$query = $this->db->get();

		return $query;
	}

}
