<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_bias extends CI_Model {
	var $table2 = "users";
	var $table = 'admin_bias';
	var $field2 = "username";
	var $column_order = array('','','tahun','create_date','id_pkm');
	var $order = array('tahun' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	private function get_data_query(){
		if($this->input->post('tahun')) {
            $this->db->where('tahun', $this->input->post('tahun'));
        }
       
        if ($this->session->userdata("admin_username") == "admin") {
        	if($this->input->post('id_pkm')) {
            	$this->db->where('admin_bias.id_pkm', $this->input->post('id_pkm'));
        	}
        }
        // jika isian gunakan like, jika selected gunakan where 
      	if ($this->session->userdata("admin_level") != "admin") {
      		$this->db->where("admin_bias.id_pkm", $this->session->userdata("admin_pkm"));
      	}
		$query = $this->om->view_join_one($this->table,$this->table2,$this->field2);
		$this->valid_join($query,$this->table);
		$i = 0;

		if ($this->session->userdata("admin_level") == "admin") {
			$column_search = array('tahun','nama_lengkap'); 
		} else {
			$column_search = array('tahun'); 
		}

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
			$this->db->order_by('tahun', 'DESC');
			$this->db->order_by('create_date', 'DESC');
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
		
		$query = $this->om->view_join_one($this->table,$this->table2,$this->field2,$this->order);
		$this->valid_join($query,$this->table);
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
			$this->db->where('id_admin_bias',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('id_admin_bias',$id);
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

    function arr_tahun(){
        $this->db->order_by("tahun", "DESC");
        $this->db->group_by("tahun");
		$res = $this->db->get("admin_bias");
		$arr[""]  = "== Semua Tahun == ";
		foreach($res->result() as $row) :
			$arr[$row->tahun]  = $row->tahun;
		endforeach;
		return $arr;
	}

	function arr_tahun_manual(){
        $arr[""]  = "== Semua Tahun == ";
        for($i=date('Y'); $i>=date('Y')-1; $i-=1){
            $arr[$i]  = $i;
        }
        return $arr;

    }


 //    function arr_pkm(){
 //    	$this->db->order_by("bentuk","ASC");
 //        $this->db->order_by("nama_pkm", "ASC");
	// 	$res = $this->db->get("master_pkm");
	// 	$arr[""]  = "== Semua PKM/RS == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->id_pkm]  = $this->om->bentuk($row->bentuk)." ".$row->nama_pkm;
	// 	endforeach;
	// 	return $arr;
	// }

	// function arr_pkm_trend(){
	// 	$this->db->order_by("bentuk","ASC");
 //        $this->db->order_by("nama_pkm", "ASC");
	// 	$res = $this->db->get("master_pkm");
	// 	$arr["x"]  = "== Semua PKM/RS == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->id_pkm]  = $this->om->bentuk($row->bentuk)." ".$row->nama_pkm;
	// 	endforeach;
	// 	return $arr;
	// }

	// function arr_pkm_trendx(){
	// 	$this->db->group_by("id_pkm","ASC");
 //        $this->db->order_by("nama_pkm", "ASC")->join("master_pkm","master_pkm.id_pkm = admin_bias.id_pkm");
 //        $this->db->select("admin_bias.id_pkm,master_pkm.nama_pkm")->from("admin_bias");
	// 	$res = $this->db->get();
	// 	$arr["x"]  = "== Pilih PKM/RS == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->id_pkm]  = $this->om->bentuk($row->bentuk)." ".$row->nama_pkm;
	// 	endforeach;
	// 	return $arr;
	// }


	// function arr_desa($id=""){
	// 	if ($this->session->userdata("admin_level") == "admin") {
	// 		$this->db->where("id_pkm",$id);
	// 	} else {
	// 		$this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
	// 	}
		
 //        $this->db->order_by("id_desa", "ASC");
	// 	$res = $this->db->get("master_desa");
	// 	$arr["x"]  = "== Semua Desa == ";

	// 	foreach($res->result() as $row) :
	// 		$arr[$row->id_desa]  = $row->desa;
	// 	endforeach;
	// 	$arr["888"]  = "LUAR WILAYAH ";
	// 	return $arr;
	// }

	// function arr_bulan(){
 //        $this->db->order_by("bulan", "DESC");
 //        $this->db->group_by("bulan");
	// 	$res = $this->db->get("admin_bias");
	// 	$arr[""]  = "== Semua Bulan == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->bulan]  = getBulan($row->bulan);
	// 	endforeach;
	// 	return $arr;
	// }

	// function arr_minggu_ke(){
	// 	if ($this->session->userdata("admin_level")!="admin") {
	// 		$this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
	// 	}
		
 //        $this->db->order_by("minggu_ke", "DESC");
 //        $this->db->group_by("minggu_ke");
	// 	$res = $this->db->get("admin_bias");
	// 	$arr["x"]  = "== Semua Minggu == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->minggu_ke]  = ($row->minggu_ke);
	// 	endforeach;
	// 	return $arr;
	// }

	// function arr_minggu_kedd(){
	// 	if ($this->session->userdata("admin_level")!="admin") {
	// 		$this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
	// 	}
		
 //        $this->db->order_by("minggu_ke", "DESC");
 //        $this->db->group_by("minggu_ke");
	// 	$res = $this->db->get("admin_bias");
	// 	$arr[""]  = "== Semua Minggu == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->minggu_ke]  = ($row->minggu_ke);
	// 	endforeach;
	// 	return $arr;
	// }


	// function arr_bulan_sebaran(){
 //        $this->db->order_by("bulan", "DESC");
 //        $this->db->group_by("bulan");
	// 	$res = $this->db->get("admin_bias");
	// 	$arr["x"]  = "== Semua Bulan == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->bulan]  = getBulan($row->bulan);
	// 	endforeach;
	// 	return $arr;
	// }

	// function arr_kalender(){
	// 	$tahap = $this->om->web_me()->tahun_awal.$this->om->web_me()->tahun_akhir;
 //        $this->db->order_by("minggu_ke", "DESC");
 //        $this->db->where("tahap_survey",$tahap);
 //        $this->db->group_by("minggu_ke");
	// 	$res = $this->db->get("kalender");
	// 	$arr[""]  = "== Pilih Minggu ke/Periode == ";
	// 	foreach($res->result() as $row) :
	// 		$arr[$row->id_kalender]  ="Periode (".tgl_view($row->periode_awal)." s/d ".tgl_view($row->periode_akhir). ") - Minggu ke ".$row->minggu_ke;
	// 	endforeach;
	// 	return $arr;
	// }




}
