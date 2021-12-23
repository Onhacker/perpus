<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_prodi extends CI_Model {
	var $table = 'master_prodi';
	var $table2 = 'master_fakultas';
	var $column_order = array('','','master_prodi.nama_prodi','master_jurusan.nama_jurusan','master_fakultas.nama_fakultas');
	var $order = array('master_prodi.id_prodi' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	private function get_data_query(){
		$this->db->select("master_prodi.id_prodi,master_prodi.nama_prodi,master_prodi.id_jurusan,master_prodi.id_fakultas,master_fakultas.nama_fakultas,master_jurusan.nama_jurusan");
		$this->db->from("master_prodi");
		$this->db->join("master_fakultas","master_fakultas.id_fakultas = master_prodi.id_fakultas");
		$this->db->join("master_jurusan","master_jurusan.id_jurusan  = master_prodi.id_jurusan");
		$i = 0;
		if ($this->session->userdata("admin_level") == "admin") {
			$column_search = array('master_fakultas.nama_fakultas','master_prodi.nama_prodi','master_jurusan.nama_jurusan'); 
		} else {
			$column_search = array('master_fakultas.nama_fakultas','master_prodi.nama_prodi','master_jurusan.nama_jurusan'); 
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
			// $this->db->order_by(key($order), $order[key($order)]);
			$this->db->order_by('id_prodi', 'DESC');
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
		$this->db->select("master_prodi.id_prodi,master_prodi.nama_prodi,master_prodi.id_jurusan,master_prodi.id_fakultas,master_fakultas.nama_fakultas,master_jurusan.nama_jurusan");
		$this->db->from("master_prodi");
		$this->db->join("master_fakultas","master_fakultas.id_fakultas = master_prodi.id_fakultas");
		$this->db->join("master_jurusan","master_jurusan.id_jurusan  = master_prodi.id_jurusan");
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
			$this->db->where('id_prodi',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('id_prodi',$id);
			$query = $this->db->get();
		}   
		return $query;
	}

	function arr_fakultas(){
		$this->db->order_by("nama_fakultas", "ASC");
		$res = $this->db->get("master_fakultas");
		$arr[""]  = "== Pilih ".$this->om->engine_nama_menu("Admin_fakultas")." ==";
		foreach($res->result() as $row) :
			$arr[$row->id_fakultas]  = $row->nama_fakultas;
		endforeach;
		return $arr;
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

	


}
