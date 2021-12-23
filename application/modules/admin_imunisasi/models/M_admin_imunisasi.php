<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_imunisasi extends CI_Model {
	var $table = 'imunisasi';
	var $column_order = array('','','nama','jk','jenis_vaksin','tgl_lahir','tgl_suntik','','id_pkm');
	var $column_search = array('nama'); 
	// var $order = array('tahun'=> 'DESC','bulan'=> 'DESC','create_date'=> 'DESC','create_time'=> 'DESC');
	var $order = array('urutan'=> 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){

		if($this->input->post('tahun')) {
			// $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $this->input->post('tahun')))
			$this->db->where('year(tgl_suntik)', $this->input->post('tahun'));
		}

		if($this->input->post('bulan')) {
			$this->db->where('month(tgl_suntik)', $this->input->post('bulan'));
		}

		if($this->input->post('id_pkm')) {
            $this->db->where('id_pkm', $this->input->post('id_pkm'));
        }

        if($this->input->post('jenis_vaksin')) {
            $this->db->where('jenis_vaksin', $this->input->post('jenis_vaksin'));
        }

        if($this->input->post('id_desa')) {
            $this->db->where('id_desa', $this->input->post('id_desa'));
        }

        if($this->input->post('jk')) {
            $this->db->where('jk', $this->input->post('jk'));
        }

        if($this->input->post('no_kia')) {
            $this->db->where('no_kia', $this->input->post('no_kia'));
        }
        if($this->input->post('nama')) {
            $this->db->like('nama', $this->input->post('nama'));
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
			// $order = $this->order;
			$this->db->order_by('urutan', 'DESC');
			// $this->db->order_by('bulan', 'DESC');
			// $this->db->order_by('create_date', 'DESC');
			// $this->db->order_by('create_time', 'DESC');
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
			$this->db->where('id_imunisasi',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('id_imunisasi',$id);
			$query = $this->db->get();
		}   
		return $query;
	}

	function arr_agama(){
        $this->db->order_by("id_agama", "ASC");
		$res = $this->db->get("im_agama");
		$arr[""]  = "== Pilih Agama ==";
		foreach($res->result() as $row) :
			$arr[$row->id_agama]  = $row->agama;
		endforeach;
		return $arr;
	}

	function arr_pekerjaan(){
        $this->db->order_by("id_pekerjaan", "ASC");
		$res = $this->db->get("im_pekerjaan");
		$arr[""]  = "== Pilih Pekerjaan ==";
		foreach($res->result() as $row) :
			$arr[$row->id_pekerjaan]  = strtoupper($row->pekerjaan);
		endforeach;
		return $arr;
	}

	function arr_tahun(){
        $this->db->group_by("tahun");
		$res = $this->db->get("imunisasi");
		$arr[""]  = "== Semua Tahun == ";
		foreach($res->result() as $row) :
			$arr[$row->tahun]  = $row->tahun;
		endforeach;
		return $arr;
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

	function arr_vaksin(){
        $this->db->order_by("urutan", "ASC");
		$res = $this->db->get("master_penyakit");
		$arr[""]  = "== Pilih Vaksin == ";
		foreach($res->result() as $row) :
			$arr[$row->id_penyakit]  = $row->nama_penyakit;
		endforeach;
		return $arr;
	}

	function arr_vaksin_form(){
        $this->db->order_by("urutan", "ASC");
		$res = $this->db->get("master_penyakit");
		$arr[""]  = "== Semua Vaksin == ";
		foreach($res->result() as $row) :
			$arr[$row->id_penyakit]  = $row->nama_penyakit;
		endforeach;
		return $arr;
	}

	function arr_vaksin_formx(){
        $this->db->order_by("urutan", "ASC");
		$res = $this->db->get("master_penyakit");
		$arr["x"]  = "== Semua Vaksin == ";
		foreach($res->result() as $row) :
			$arr[$row->id_penyakit]  = $row->nama_penyakit;
		endforeach;
		return $arr;
	}

	function arr_desa($id=""){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->where("id_pkm",$id);
		} else {
			$this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
		}
		
        $this->db->order_by("desa", "ASC");
		$res = $this->db->get("master_desa");
		$arr[""]  = "== Semua Desa == ";
		foreach($res->result() as $row) :
			$arr[$row->id_desa]  = $row->desa;
		endforeach;
		return $arr;
	}

	function arr_desa2($id=""){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->where("id_pkm",$id);
		} else {
			$this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
		}
		
        $this->db->order_by("desa", "ASC");
		$res = $this->db->get("master_desa");
		$arr["x"]  = "== Semua Desa == ";
		foreach($res->result() as $row) :
			$arr[$row->id_desa]  = $row->desa;
		endforeach;
		return $arr;
	}

	function arr_bulan(){
        $this->db->order_by("bulan", "DESC");
        $this->db->group_by("bulan");
		$res = $this->db->get("imunisasi");
		$arr[""]  = "== Semua Bulan == ";
		foreach($res->result() as $row) :
			$arr[$row->bulan]  = getBulan($row->bulan);
		endforeach;
		return $arr;
	}

	function arr_bulan_ibu(){
        $this->db->order_by("bulan", "DESC");
        $this->db->group_by("bulan");
		$res = $this->db->get("imunisasi_ibu");
		$arr[""]  = "== Semua Bulan == ";
		foreach($res->result() as $row) :
			$arr[$row->bulan]  = getBulan($row->bulan);
		endforeach;
		return $arr;
	}

	function arr_bulan_full(){
		$arr[""]  = "== Pilih Bulan == ";
		for ($i=1; $i <= 12 ; $i++) { 
			$arr[$i]  = getBulan($i);
		}
		return $arr;
	}

}
