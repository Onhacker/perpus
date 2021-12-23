<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_user extends CI_Model {
	var $table = 'users';
	var $column_order = array('','','nim','nama_lengkap','no_telp','email','nama_fakultas','nama_jurusan','nama_prodi','angkatan');
	var $column_search = array('nim','nama_lengkap','no_telp','email','nama_fakultas','nama_jurusan','nama_prodi','angkatan'); 
	var $order = array('id_user' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
		$this->db->select("username,nama_lengkap,nim,email, alamat,no_telp , level, nama_fakultas, nama_jurusan, nama_prodi, angkatan");
		$this->db->from("users");
		$this->db->join("master_fakultas", "master_fakultas.id_fakultas = users.id_fakultas");
		$this->db->join("master_jurusan", "master_jurusan.id_jurusan  = users.id_jurusan");
		$this->db->join("master_prodi", "master_prodi.id_prodi = users.id_prodi");
		$this->db->where("level","user");
		$this->db->where("deleted","N");
		$i = 0;

		foreach ($this->column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->where("level", "user");
					$this->db->like($item, $_POST['search']['value']);
				}
				else {
					$this->db->where("level", "user");
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
		$this->db->where("level", "user");
		$this->get_data_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all(){
		$this->db->select("username,nama_lengkap,nim,email, alamat,no_telp , level, nama_fakultas, nama_jurusan, nama_prodi, angkatan");
		$this->db->from("users");
		$this->db->join("master_fakultas", "master_fakultas.id_fakultas = users.id_fakultas");
		$this->db->join("master_jurusan", "master_jurusan.id_jurusan  = users.id_jurusan");
		$this->db->join("master_prodi", "master_prodi.id_prodi = users.id_prodi");
		$this->db->where("level","user");
		$this->db->where("deleted","N");
		// $this->db->get();
		return $this->db->count_all_results();
	}

	function get_by_id($id){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
			$this->db->where('username',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('username',$id);
			$query = $this->db->get();
		}   
		return $query;
	}

	function get_fakultas(){
		$hasil = $this->db->get("master_fakultas");
        return $hasil;
    }
 
    function get_jurusan($id){
    	$this->db->where("id_fakultas", $id);
    	$hasil = $this->db->get("master_jurusan");
        return $hasil->result();
    }

    function get_prodi($id){
    	$this->db->where("id_jurusan", $id);
    	$hasil = $this->db->get("master_prodi");
        return $hasil->result();
    }
	
	

}
