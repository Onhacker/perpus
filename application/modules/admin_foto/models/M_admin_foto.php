<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_foto extends CI_Model {
	var $table2 = "users";
	var $table = 'album';
	var $field2 = "username";
	var $column_order = array('','','','jdl_album','','tgl_posting','aktif','nama_lengkap');
	var $order = array('album.id_album' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
		$query = $this->om->view_join_one($this->table,$this->table2,$this->field2);
		$this->valid_join($query,$this->table);
		$i = 0;
		if ($this->session->userdata("admin_level") == "admin") {
			$column_search = array('jdl_album','nama_lengkap'); 
		} else {
			$column_search = array('jdl_album'); 
		}
		foreach ($column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->like($item, $_POST['search']['value']);
				}
				else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($column_search) - 1 == $i);

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
		$query = $this->om->view_join_one($this->table,$this->table2,$this->field2);
		$this->valid_join($query,$this->table);
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
			$this->db->where('id_album',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('id_album',$id);
			$query = $this->db->get();
		}   
		return $query;
	}


	function valid_join($query,$table){
        if ($this->session->userdata("admin_level")=='admin'){
            return $query;
        } else {
            $this->db->where($table.".username", $this->session->userdata("admin_username"));
            return $query;
        }
    }

}
