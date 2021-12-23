<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pengumuman extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_pengumuman", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Posting";
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
            $row["id"] = $res->id_sekilas;
            // if (strlen($res->info) > 100) {
                // $row["info"] = substr($res->info, 0,100)." ...";
            // } else {
                $row["info"] = $res->info;
            // }
            
            $row["tgl"] = tgl_indo($res->tgl_posting);
            $cp = "'#".$res->id_sekilas."'";
            if ($res->aktif == "Y") {
            	$stat = "<span class='badge bg-soft-success text-success'>Published</span>";
            	$ck = "checked";
            } else {
            	$stat = "<span class='badge bg-soft-danger text-danger'>Unpublished</span>";
            	$ck = "";
            }

            $row["aktif"] = '<span class="float-right">
		            					<div class="custom-control custom-switch" >
		            						<a href="javascript:void(0)" onclick="pub('.$res->id_sekilas.')">
			            						<input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
			            						<label class="custom-control-label" for="cek"></label>
		            						</a>  
		            					</div>
		            		</span>';
		   
            
            
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_sekilas.'"><label></label></div>';

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
        $res = $this->dm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        echo json_encode($data);
    }


    function hapus_gambar($id){
    	$this->db->where("id_sekilas", $id);
    	$gbr = $this->db->get("sekilasinfo")->row();
    	$path = 'upload/gambar/';
    	$filename =  $path.$gbr->gambar;
        unlink($filename);
     	$data["gambar"] = "";
     	$this->db->where("id_sekilas",$id);
     	$res = $this->db->update("sekilasinfo",$data);
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

    function pub($id){
    	cek_permission();
    	$this->db->where("id_sekilas", $id);
    	$cek = $this->db->get("sekilasinfo")->row();
    	if ($cek->aktif == "Y") {
    		$data["aktif"] = "N";
    		$this->db->where("id_sekilas", $id);
    		$this->db->update("sekilasinfo",$data);
            // rec(get_class($this));  
    	} else {
    		$data["aktif"] = "Y";
    		$this->db->where("id_sekilas", $id);
    		$this->db->update("sekilasinfo",$data);
            // rec(get_class($this));  
    	}
    	if ($res) {
    		$ret = array("success" => false,
        		"title" => "Unpublished",
        		"pesan" => " <br>tidak diterbitkan");
    	} elseif ($rew) {
    		$ret = array("success" => true,
        		"title" => "Published",
        		"pesan" => " <br>diterbitkan");
    	} else {
        	$ret = array("success" => false,
        		"title" => " Gagal",
        		"pesan" => " Gagal prosess");
        }
       echo json_encode($ret);

    }

    function add($sta){
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('info','Info','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["tgl_posting"] = date("Y-m-d");
            $data["info"] = $data2["info"];
            $new_name = "sekilas-".md5(date("Ymdhis"));
            $config['upload_path'] = 'upload/gambar/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if ($this->session->userdata("admin_permisson") == 'N' or $sta == "N"){  
                $kalimat = "<br>Disimpan sebagai draft dan belum diterbitkan";
                $status = 'N'; 
            } else { 
                $kalimat = "<br>dan Diterbitkan";
                $status = 'Y'; 
            }
            
            $data["aktif"] = $status;

            if (empty($_FILES['gambar']["name"])){
                $res  = $this->db->insert("sekilasinfo",$data);  
                // rec(get_class($this)); 
            } 

            if (! $this->upload->do_upload('gambar')) {
                $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

            } else {
                $this->db->where("id_sekilas", $data["id_sekilas"]);
                $gbr = $this->db->get("sekilasinfo")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar;
                unlink($filename);
                $fdata =  $this->upload->data();
                $data['gambar'] = $fdata['file_name'];    
                $res  = $this->db->insert("sekilasinfo",$data);  
                // rec(get_class($this));     
            }
            
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan".$kalimat);
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
        echo json_encode($ret);
    }

	function update($sta){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('info','Info','required');  
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
            $data["info"] = $data2["info"];
			$new_name = "sekilas-".md5(date("Ymdhis"));
			$config['upload_path'] = 'upload/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);

            if ($this->session->userdata("admin_permisson") == 'N' or $sta == "N"){  
            	$kalimat = "<br>Disimpan sebagai draft dan belum diterbitkan";
            	$status = 'N'; 
            } else { 
            	$kalimat = "<br>dan Diterbitkan";
            	$status = 'Y'; 
            }
            
			$data["aktif"] = $status;

            if (empty($_FILES['gambar']["name"])){
				$this->db->where("id_sekilas",$data["id_sekilas"]);
				$res  = $this->db->update("sekilasinfo",$data);
                // rec(get_class($this));  	
			} 

			if (! $this->upload->do_upload('gambar')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$this->db->where("id_sekilas", $data["id_sekilas"]);
                $gbr = $this->db->get("sekilasinfo")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar;
                unlink($filename);
				$fdata =  $this->upload->data();
				$data['gambar'] = $fdata['file_name'];	
				$this->db->where("id_sekilas",$data["id_sekilas"]);
				$res  = $this->db->update("sekilasinfo",$data);
                // rec(get_class($this));  		
			}
            
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil diupdate".$kalimat);
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
            $this->db->where("id_sekilas", $id);
            $gbr = $this->db->get("sekilasinfo")->row();
            $path = 'upload/gambar/';
            $filename =  $path.$gbr->gambar;
            unlink($filename);
            $this->db->where("id_sekilas",$id);
            $res =$this->db->delete("sekilasinfo");
            // rec(get_class($this));  

            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil dihapus");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal dihapus");
            }
        }
        echo json_encode($ret);
    } 


	
}
