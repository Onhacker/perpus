<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_history extends Admin_Controller {
	function __construct(){
		parent::__construct();
		// cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_history", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = $this->session->userdata("admin_username");
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id;
            $row["ip"] = $res->ip;
            $row["browser"] = $res->browser;            
            $row["os"] = $res->os;
            $ex = explode(" ", $res->waktu);
            $row["waktu"] = tgl_indo($ex[0]).", ".$ex[1];
         
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
        	"draw" => $_POST['draw'],
        	"recordsTotal" => $this->dm->count_all(),
        	"recordsFiltered" => $this->dm->count_filtered(),
        	"data" => $data,
        );
        
        echo json_encode($output);
    }

    function edit($id){
        $data = array();
        $res = $this->dm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        echo json_encode($data);
    }

    function hapus_gambar($id){
    	$this->db->where("id_halaman", $id);
    	$gbr = $this->db->get("halamanstatis")->row();
    	$path = 'upload/gambar/';
    	$filename =  $path.$gbr->gambar;
    	if ($this->session->userdata("admin_level") == "admin") {
    		unlink($filename);
    	} elseif ($this->session->userdata("admin_username") == $gbr->username) {
    		unlink($filename);
    	}
     	$data["gambar"] = "";
     	$this->db->where("id_halaman",$id);
     	$res = $this->om->update("halamanstatis",$data);
     	// rec(get_class($this));
        if($res) {    
        	// echo $this->db->last_query();
        	$ret = array("success" => true,
        		"title" => "Berhasil",
        		"pesan" => "Gambar berhasil dihapus");
        } else {
        	$ret = array("success" => false,
        		"title" => "Berhasil",
        		"pesan" => "Gambar Berhasil dihapus");
        }

       echo json_encode($ret);

    }


    function add(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('judul','Judul Halaman','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			unset($data2["id_halaman"]);
			$data["isi_halaman"] = $data2["isi_halaman"];
			$data["judul_seo"] = linker($data["judul"],"0");
			$data["tgl_posting"] = date("Y-m-d");
			$data["username"] = $this->session->userdata("admin_username");
			$data["jam"] = date("H:i:s");

            if (empty($_FILES['gambar']["name"])){
				$res  = $this->db->insert("halamanstatis",$data);
				// rec(get_class($this));  	
			}
			$new_name = nama_file(linker($data["judul"],"0"),get_class($this)); 
			$config['upload_path'] = 'upload/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $new_name;

            $this->load->library('upload', $config);
			if (! $this->upload->do_upload('gambar')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";
			} else {
				$fdata =   $this->upload->data();
				$data['gambar'] = $fdata['file_name'];	
				$res  = $this->db->insert("halamanstatis",$data);	
				// rec(get_class($this));  	
			}
            
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil diupdate");
			} else {
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal diupdate ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);

	}

   

	function update(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('judul','Judul Halaman','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["isi_halaman"] = $data2["isi_halaman"];
			$data["judul_seo"] = linker($data["judul"],"0");
            if (empty($_FILES['gambar']["name"])){
				$this->db->where("id_halaman",$data["id_halaman"]);
				$res  = $this->om->update("halamanstatis",$data);
				// rec(get_class($this));  ; 		
			} 
			$new_name = nama_file(linker($data["judul"],"0"),get_class($this)); 
			$config['upload_path'] = 'upload/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
			if (! $this->upload->do_upload('gambar')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$this->db->where("id_halaman",$data["id_halaman"]);
                $gbr = $this->db->get("halamanstatis")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
				$fdata =   $this->upload->data();
				$data['gambar'] = $fdata['file_name'];	
				$this->db->where("id_halaman",$data["id_halaman"]);
				$res  = $this->om->update("halamanstatis",$data);
				// rec(get_class($this));  ; 			
			}
            
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil diupdate");
			} else {
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal diupdate ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
	}

	function hapus_datax(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("id",$id);
                $res =$this->om->delete("user_akses");
                // rec(get_class($this));  ; 	
            }
	        if($res) {    
	        	$ret = array("success" => true,
	        		"title" => "Berhasil",
	        		"pesan" => "Data berhasil dihapus");
	        } else {
	        	$ret = array("success" => false,
	        		"title" => "Gagal",
	        		"pesan" => "Data Gagal dihapus");
	        }

        echo json_encode($ret);
    } 


	
}
