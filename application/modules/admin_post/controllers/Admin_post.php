<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_post extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_post", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Posting";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	function load_tag($id){
		$data["controller"] = get_class($this);
		$data["tag"] = $this->om->view_ordering('tag','id_tag','DESC');
		$data["rec"] = $this->om->edit('berita', array('id_berita' => $id))->row();
		$this->load->view("load_tag",$data); 
	}

	function load_tag_add(){
		$data["controller"] = get_class($this);
		$data["tag"] = $this->om->view_ordering('tag','id_tag','DESC');
		$data["rec"] = "";
		$this->load->view("load_tag",$data); 
	}

	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_berita;
            $row["judul"] = $res->judul;
            $row["kategori"] = $res->nama_kategori;
            $cp = "'#".$res->id_berita."'";
            if ($res->status == "Y") {
            	$stat = "<span class='badge bg-soft-success text-success'>Published</span>";
            	$ck = "checked";
            } else {
            	$stat = "<span class='badge bg-soft-danger text-danger'>Unpublished</span>";
            	$ck = "";
            }
            if ($this->session->userdata("admin_level") == "admin" or $this->session->userdata("admin_permisson") == "Y") {
            	$row["judul_seo"] = '<span style="display:none;" id="'.$res->id_berita.'">'.url($res->judul_seo,"Admin_post", "copy").'</span> 
		            				<span class="float-right">
		            					<div class="custom-control custom-switch" >
		            						<a href="javascript:void(0)" onclick="pub('.$res->id_berita.')">
			            						<input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
			            						<label class="custom-control-label" for="cek"></label>
		            						</a>  / &nbsp;
		            						<a href="'.url($res->judul_seo,"Admin_post").'" target="_BLANK"><i class="fe-link" data-toggle="tooltip" title="Kunjungi Link" ></i></a>  / &nbsp;
		            						<a href="javascript:void(0)" onclick="copy_link('.$cp.')"><i class="fe-copy" data-toggle="tooltip" title="Copy" ></i></a>
		            					</div>
		            				</span>
		            			</span>';
            } else {
            	$row["judul_seo"] = '<span style="display:none;" id="'.$res->id_berita.'">'.url($res->judul_seo,"Admin_post","copy").'</span> 
		            				<span class="float-right">
		            					<div class="custom-control custom-switch" >
		            						<a href="javascript:void(0)">
			            						<input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
			            						<label class="custom-control-label" for="cek"></label>
		            						</a>  / &nbsp;
		            						<a href="'.url($res->judul_seo,"Admin_post").'" target="_BLANK"><i class="fe-link" data-toggle="tooltip" title="Kunjungi Link" ></i></a>  / &nbsp;
		            						<a href="javascript:void(0)" onclick="copy_link('.$cp.')"><i class="fe-copy" data-toggle="tooltip" title="Copy" ></i></a>
		            					</div>
		            				</span>
		            			</span>';
            }
            
            $row["penulis"] = "<span class='badge bg-soft-danger text-info p-1'>".$res->nama_lengkap."</span>";
            $row["tanggal"] = hari_ini($res->tanggal).", ".tgl_indo($res->tanggal)." Pukul ".$res->jam;
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_berita.'"><label></label></div>';

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
        $query = $this->om->view_join_where("berita","kategori","id_kategori","id_berita = '".$id."'","id_berita","DESC");
        $this->dm->valid_join($query,"berita");
        $res =  $this->db->get();
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        $data["tanggal"] = tgl_view($data["tanggal"]);
        echo json_encode($data);
    }

    function hapus_gambar($id){
    	$this->db->where("id_berita", $id);
    	$gbr = $this->db->get("berita")->row();
    	$path = 'upload/gambar/';
    	$filename =  $path.$gbr->gambar;
     	if ($this->session->userdata("admin_level") == "admin") {
    		unlink($filename);
    	} elseif ($this->session->userdata("admin_username") == $gbr->username) {
    		unlink($filename);
    	}
     	$data["gambar"] = "";
     	$this->db->where("id_berita",$id);
     	$res = $this->om->update("berita",$data);
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
    	$this->db->where("id_berita", $id);
    	$cek = $this->db->get("berita")->row();
    	if ($cek->status == "Y") {
    		$data["status"] = "N";
    		$this->db->where("id_berita", $id);
    		$this->om->update("berita",$data);
    	} else {
    		$data["status"] = "Y";
    		$this->db->where("id_berita", $id);
    		$this->om->update("berita",$data);
    	}
        // rec(get_class($this));
    	if ($res) {
    		$ret = array("success" => false,
        		"title" => "Unpublished",
        		"pesan" => $cek->judul." <br>tidak diterbitkan");
    	} elseif ($rew) {
    		$ret = array("success" => true,
        		"title" => "Published",
        		"pesan" => $cek->judul." <br>diterbitkan");
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
		$this->form_validation->set_rules('judul','Judul','required'); 
		$this->form_validation->set_rules('id_kategori','Kategori','required'); 
        $this->form_validation->set_rules('tanggal','Tanggal','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["username"] = $this->session->userdata("admin_username");
			$data["isi_berita"] = $data2["isi_berita"];
			$data["judul_seo"] = link_post($data["judul"]);
			$data["keterangan_gambar"] = $data2["keterangan_gambar"];
			$data["dibaca"] = "0";
			$data["tanggal"] = tgl_simpan($data["tanggal"]);

			$new_name = nama_file(linker($data["judul"]),get_class($this));
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
            
            if ($data["tag"]!=''){
                $tag_seo = $data["tag"];
                $tag = implode(',',$tag_seo);
            } else {
                $tag = '';
            }
            $data["tag"] = $tag;
			$data["status"] = $status;

            if (empty($_FILES['gambar']["name"])){
				$res  = $this->db->insert("berita",$data);
                // rec(get_class($this));		
			} 

			if (! $this->upload->do_upload('gambar')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				
				$fdata =  $this->upload->data();
				$data['gambar'] = $fdata['file_name'];	
				$res  = $this->db->insert("berita",$data);
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
		// echo $this->db->last_query();
		echo json_encode($ret);
	}


   function add_tag(){
   		cek_session_akses("Admin_tag",$this->session->userdata('admin_session'));
   		$data = $this->db->escape_str($this->input->post());
   		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id','Nama Tag','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["nama_tag"] = $data["id"];
			$data["tag_seo"] = linker($data2["id"],"0");
			$data["count"] = "0";
			$data["username"] = $this->session->userdata("admin_username");
			$this->db->where("nama_tag",$data2["id"]);
			$res = $this->db->get("tag");
			if ($res->num_rows() > 0) {
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Nama Tag Sudah Ada");
			} else {
				unset($data["id"]);
				$this->db->insert('tag',$data);	
                // rec(get_class($this));
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
			}
		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
        echo json_encode($ret);
    } 

    function hapus_tag($id){
    	cek_session_akses("Admin_tag",$this->session->userdata('admin_session'));
    	$this->db->where("id_tag", $id);
        $res =$this->om->delete("tag");
        // rec(get_class($this));
        if($res) {    
        	$ret = array("success" => true);
        } else {
        	$ret = array("success" => false,
        		"title" => "Gagal",
        		"pesan" => "Gambar Gagal dihapus");
        }

       echo json_encode($ret);

    }

	function update($sta){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('judul','Judul','required'); 
		$this->form_validation->set_rules('id_kategori','Kategori','required'); 
        $this->form_validation->set_rules('tanggal','Tanggal','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["isi_berita"] = $data2["isi_berita"];
			// $data["judul_seo"] = link_post($data["judul"]);
			$data["keterangan_gambar"] = $data2["keterangan_gambar"];
			$data["tanggal"] = tgl_simpan($data["tanggal"]);

			$new_name = nama_file(linker($data["judul"]),get_class($this));
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
            if ($data["tag"]!=''){
                $tag_seo = $data["tag"];
                $tag = implode(',',$tag_seo);
            } else {
                $tag = '';
            }
            $data["tag"] = $tag;
			$data["status"] = $status;

            if (empty($_FILES['gambar']["name"])){
				$this->db->where("id_berita",$data["id_berita"]);
				$res  = $this->om->update("berita",$data);
                // rec(get_class($this));	
			} 

			if (! $this->upload->do_upload('gambar')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$this->db->where("id_berita", $data["id_berita"]);
                $gbr = $this->db->get("berita")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
				$fdata =  $this->upload->data();
				$data['gambar'] = $fdata['file_name'];	
				$this->db->where("id_berita",$data["id_berita"]);
				$res  = $this->om->update("berita",$data);
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
                $this->db->where("id_berita", $id);
                $gbr = $this->db->get("berita")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
                $this->db->where("id_berita",$id);
                $res =$this->om->delete("berita");
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