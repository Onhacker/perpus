<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_pengurus extends CI_Model {
	var $table2 = 'desa_jabatan';
	var $field = "id_jabatan";
	var $table = 'pengurus';
	var $column_order = array('','','gambar','nama','jabatan','jk','tempat_lahir', 'alamat', 'telepon');
	var $order = array('id_pengurus' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
		$query = $this->om->view_join_one($this->table,$this->table2,$this->field);
		$this->valid_join($query,$this->table);
		$i = 0;
			$column_search = array('nama','jabatan','alamat', 'tempat_lahir', 'telepon'); 
		
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
		$query = $this->om->view_join_one($this->table,$this->table2,$this->field);
		$this->valid_join($query,$this->table);
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		$this->db->from($this->table);
		$this->db->where('id_berita',$id);
		$query = $this->db->get();
		return $query;
	}

	function arr_jabatan(){
		$this->db->order_by("id_jabatan", "DESC");
		$res = $this->db->get("desa_jabatan");
		$arr[""]  = "== Pilih jabatan ==";
		foreach($res->result() as $row) :
			$arr[$row->id_jabatan]  = $row->jabatan;
		endforeach;
		return $arr;
	}

	function arr_pendidikan(){
		$this->db->order_by("id_pendidikan", "DESC");
		$res = $this->db->get("pendidikan");
		$arr[""]  = "== Jangan Tampilkan Pendidikan ==";
		foreach($res->result() as $row) :
			$arr[$row->id_pendidikan]  = $row->pendidikan;
		endforeach;
		return $arr;
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
