<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_sekolah extends CI_Model {
	var $table = 'master_sekolah';
	var $column_order = array('','','sekolah','desa','kecamatan');
	var $column_search = array('sekolah'); 
	var $order = array('sekolah' => 'ASC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
		if($this->input->post('id_pkm')) {
            $this->db->where('id_pkm', $this->input->post('id_pkm'));
        }

        if($this->input->post('id_desa')) {
            $this->db->where('id_desa', $this->input->post('id_desa'));
        }

        if($this->input->post('sekolah')) {
            $this->db->like('sekolah', $this->input->post('sekolah'));
        }
    
        if ($this->session->userdata("admin_username") == "admin") {
        	if($this->input->post('id_pkm')) {
            	$this->db->where('id_pkm', $this->input->post('id_pkm'));
        	}
        }

		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
		}
        
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by('sekolah', 'ASC');
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
		if ($this->session->userdata("admin_username") == "admin") {
			$this->db->from($this->table);
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
		}
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
			$this->db->where('id_sekolah',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('id_sekolah',$id);
			$query = $this->db->get();
		}   
		return $query;
	}

	function arr_pkm(){
        $this->db->order_by("bentuk", "ASC");
        $this->db->order_by("nama_pkm", "ASC");
		$res = $this->db->get("master_pkm");
		$arr[""]  = "== Semua PKM == ";
		foreach($res->result() as $row) :
			$arr[$row->id_pkm]  = $this->om->bentuk($row->bentuk)." ".$row->nama_pkm;
		endforeach;
		return $arr;
	}
    function arr_desa(){
        $this->db->order_by("desa", "ASC");
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
		$res = $this->db->get("master_desa");
		$arr[""]  = "== Pilih ".$this->om->engine_nama_menu("Admin_desa")." ==";
		foreach($res->result() as $row) :
			$arr[$row->id_desa]  = $row->desa;
		endforeach;
		return $arr;
	}

}
