<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pengurus extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_pengurus", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = $this->om->web_me()->type;
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_pengurus;
            $row["nama"] = "<a href=".url("$res->nama_seo", "Admin_pengurus")." target='_BLANK'>".$res->nama."<br><span class='badge badge-danger'>Detail</span></a></a>";
            $row["jabatan"] = $res->jabatan;
            $row["jk"] = $res->jk;
            $row["alamat"] = $res->alamat;
            $row["telepon"] = $res->telepon;
            if ($res->tempat_lahir != "") {
                $row["ttl"] = $res->tempat_lahir.", ".tgl_view($res->tanggal_lahir);
            } else {
                $row["ttl"] = tgl_view($res->tanggal_lahir);
            }
            
            if (empty($res->gambar)) {
                $row["gambar"] = '<img src="'.base_url('upload/gambar/no-image.jpg').'" alt="contact-img" title="contact-img" class="rounded-circle avatar-md" width="50">';
            } else {
                $row["gambar"] = '<img src="'.base_url("upload/gambar/").$res->gambar.'" alt="contact-img" title="contact-img" class="rounded-circle avatar-md" width="50">';
            }
           
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_pengurus.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
        	"draw" => $_POST['draw'],
        	"recordsTotal" => $this->dm->count_all(),
        	"recordsFiltered" => $this->dm->count_filtered(),
        	"data" => $data,
        );
        // echo $this->db->last_query();
        echo json_encode($output);
    }

    function edit($id){
        $data = array();
        $query = $this->om->view_join_where("pengurus","desa_jabatan","id_jabatan","id_pengurus = '".$id."'","id_pengurus","DESC");
        $this->dm->valid_join($query,"pengurus");
        $res =  $this->db->get();
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        $data["tanggal_lahir"] = tgl_view($data["tanggal_lahir"]);
        echo json_encode($data);
    }

    function hapus_gambar($id){
    	$this->db->where("id_pengurus", $id);
    	$gbr = $this->db->get("pengurus")->row();
    	$path = 'upload/gambar/';
    	$filename =  $path.$gbr->gambar;
     	if ($this->session->userdata("admin_level") == "admin") {
    		unlink($filename);
    	} elseif ($this->session->userdata("admin_username") == $gbr->username) {
    		unlink($filename);
    	}
     	$data["gambar"] = "";
     	$this->db->where("id_pengurus",$id);
     	$res = $this->om->update("pengurus",$data);
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

    function link_pengurus($link){
        $c = array (' ');
        $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
        $link = str_replace($d, '', $link); 
        $this->db->where("nama", $link);
        $cek = $this->db->get("pengurus");
        if ($cek->num_rows() >= 1) {
           $link = strtolower(str_replace($c, '-', $link))."-".($cek->num_rows() + 1);
        } else {
           $link = strtolower(str_replace($c, '-', $link));
           
       }
       return $link;
    }

    function add(){
		$data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Nama','required'); 
        $this->form_validation->set_rules('id_jabatan','Jabatan','required'); 
        $this->form_validation->set_rules('telepon','No Telpon','trim|numeric|min_length[10]|max_length[12]'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["username"] = $this->session->userdata("admin_username");
			$data["nama_seo"] = $this->link_pengurus($data["nama"]);
			$data["dibaca"] = "0";
			$data["tanggal_lahir"] = tgl_simpan($data["tanggal_lahir"]);
            $data["telepon"] = preg_replace('/\s+/', '',$data["telepon"]);
			$new_name = "pengurus-".md5(date("Ymdhis"));
			$config['upload_path'] = 'upload/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
            $config['max_size'] = '1000'; // kb
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

           
            if (empty($_FILES['gambar']["name"])){
				$res  = $this->db->insert("pengurus",$data);
                // rec(get_class($this));		
			} 

			if (! $this->upload->do_upload('gambar')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$fdata =  $this->upload->data();
				$data['gambar'] = $fdata['file_name'];	
				$res  = $this->db->insert("pengurus",$data);
                // rec(get_class($this));		
			}
            
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil disimpan");
			} else {
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		// echo $this->db->last_query();
		echo json_encode($ret);
	}



	function update(){
		$data = $this->db->escape_str($this->input->post());
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama','Nama','required'); 
		$this->form_validation->set_rules('id_jabatan','Jabatan','required'); 
        $this->form_validation->set_rules('telepon','No Telpon','trim|numeric|min_length[10]|max_length[12]'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
        $this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["nama_seo"] = $this->link_pengurus($data["nama"]);
			$data["tanggal_lahir"] = tgl_simpan($data["tanggal_lahir"]);
            $data["telepon"] = preg_replace('/\s+/', '',$data["telepon"]);
			$new_name = "pengurus-".md5(date("Ymdhis"));
			$config['upload_path'] = 'upload/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
            $config['max_size'] = '1000'; // kb
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if (empty($_FILES['gambar']["name"])){
				$this->db->where("id_pengurus",$data["id_pengurus"]);
				$res  = $this->om->update("pengurus",$data);
                // rec(get_class($this));	
			} 

			if (! $this->upload->do_upload('gambar')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$this->db->where("id_pengurus", $data["id_pengurus"]);
                $gbr = $this->db->get("pengurus")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
				$fdata =  $this->upload->data();
				$data['gambar'] = $fdata['file_name'];	
				$this->db->where("id_pengurus",$data["id_pengurus"]);
				$res  = $this->om->update("pengurus",$data);
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

	function hapus_data(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("id_pengurus", $id);
                $gbr = $this->db->get("pengurus")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
                $this->db->where("id_pengurus",$id);
                $res =$this->om->delete("pengurus");
                // rec(get_class($this));
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
