<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_foto extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_foto", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Posting";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

	
    function load_drop($id){
        $data["controller"] = get_class($this);
        $this->db->where("id_album", $id);
        $res = $this->db->get("album")->row();
        $data["id_album"] = $res->id_album;
        $data["jdl_album"] = $res->jdl_album;
        $data["title"] = "Gallery";
        $data["subtitle"] = "Album ".$res->jdl_album;
        $data["content"] = $this->load->view("load_drop",$data,true); 
        $this->render($data);
    }

    function load_gambar($id,$jml){
        $this->db->where("id_album", $id);
        $res = $this->db->get("album")->row();
        $data["subtitle"] = "Album ".$res->jdl_album;
        $data["controller"] = get_class($this);
        if ($jml == "all") {
            $this->db->order_by("id_gallery","DESC");
            $this->db->where("id_album", $id);
        } else {
            $this->db->limit($jml);
            $this->db->order_by("id_gallery","DESC");
            $this->db->where("id_album", $id);
        }
        if ($this->session->userdata("admin_level") == "admin") {
            $data["gal"] = $this->db->get("gallery");
            $jum = $this->db->query("select count(*) as jum_ga from gallery where id_album = '".$id."'")->row();
            if ($jum->jum_ga == "0") {
                $data["jum_ga"] = "Belum ada gambar di album " .$res->jdl_album.". Silahkan Upload Gambar";
            } else {
                $data["jum_ga"] = "Menampilkan ".$jml." dari ".$jum->jum_ga." Gambar ";
            }
        } else {
            $this->db->where("username",$this->session->userdata("admin_username"));
            $data["gal"] = $this->db->get("gallery");
            $jum = $this->db->query("select count(*) as jum_ga from gallery where id_album = '".$id."' and username = '".$this->session->userdata("admin_username")."' ")->row();
            if ($jum->jum_ga == "0") {
                $data["jum_ga"] = "Belum ada gambar di album " .$res->jdl_album.". Silahkan Upload Gambar";
            } else {
                $data["jum_ga"] = "Menampilkan ".$jml." dari ".$jum->jum_ga." Gambar ";
            }
        }
        
        
        $this->load->view("load_gambar",$data); 
    }


    function proses_upload(){
        $tokex = explode("onhacker", $this->input->post('token_foto'));
        $this->db->where("id_album", $tokex[1]);
        $res = $this->db->get("album")->row();
        $new_name = $res->jdl_album."_".substr(md5($tokex[0]), 0,10);
        $config['upload_path'] = 'upload/gambar/';
        $config['allowed_types'] = 'jpeg|gif|jpg|png|JPG|JPEG';
        $config['max_size'] = '3000'; // kb
        $config['file_name'] = $new_name;
        $this->load->library('upload',$config);

        if($this->upload->do_upload('userfile')){
            $token = $this->input->post('token_foto');
            $nama = $this->upload->data('file_name');
            $this->db->insert('gallery',array('gbr_gallery' => $nama,'keterangan' => $tokex[0], 'id_album' => $tokex[1], 'username' => $this->session->userdata("admin_username")));
            // rec(get_class($this));
        }


    }

    function remove_mul(){
        $tokex = explode("onhacker", $this->input->post('token'));
        $foto=$this->db->get_where('gallery',array('keterangan' => $tokex[0]));
        if($foto->num_rows() > 0){
            $hasil = $foto->row();
            $path = 'upload/gambar/';
            $filename =  $path.$hasil->gbr_gallery;

            if ($this->session->userdata("admin_level") == "admin") {
                unlink($filename);
                $this->db->delete('gallery',array('keterangan'=>$tokex[0]));
            } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                unlink($filename);
                $this->db->where("username",$this->session->userdata("admin_username"));
                $this->db->delete('gallery',array('keterangan'=>$tokex[0]));
            }
            // rec(get_class($this));
        }


        echo "{}";
    }


	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_album;
            $row["judul"] = $res->jdl_album;
            // $row["kategori"] = $res->nama_kategori;
            $cp = "'#".$res->id_album."'";
            if ($res->aktif == "Y") {
            	$stat = "<span class='badge bg-soft-success text-success'>Published</span>";
            	$ck = "checked";
            } else {
            	$stat = "<span class='badge bg-soft-danger text-danger'>Unpublished</span>";
            	$ck = "";
            }
            if (empty($res->gbr_album)) {
                $row["gbr_album"] = "<i class = 'far fa-file-image'> </i>";
            } else {
                $row["gbr_album"] = '<img src="'.base_url("upload/gambar/").$res->gbr_album.'" alt="contact-img" title="contact-img" class="img-fluid rounded" width="100">';
            }
            $this->db->where("id_album", $res->id_album);
            $row["jum"] = $this->db->get("gallery")->num_rows(). '<span class="float-right"><a href="javascript:void(0)" onclick="load_dropx('.$res->id_album.')"><span class="badge badge-primary">Manage Album</span></a></span>';
            
            if ($this->session->userdata("admin_level") == "admin" or $this->session->userdata("admin_permisson") == "Y") {
            	$row["judul_seo"] = '<span style="display:none;" id="'.$res->id_album.'">'.url($res->album_seo,"Admin_foto","copy").'</span> 
		            				  <span class="float-right">
		            					<div class="custom-control custom-switch" >
		            						<a href="javascript:void(0)" onclick="pub('.$res->id_album.')">
			            						<input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
			            						<label class="custom-control-label" for="cek"></label>
		            						</a>  / &nbsp;
		            						<a href="'.url($res->album_seo,"Admin_foto").'" target="_BLANK"><i class="fe-link" data-toggle="tooltip" title="Kunjungi Link" ></i></a>  / &nbsp;
		            						<a href="javascript:void(0)" onclick="copy_link('.$cp.')"><i class="fe-copy" data-toggle="tooltip" title="Copy" ></i></a>
		            					</div>
		            				</span>
		            			</span>';
            } else {
            	$row["judul_seo"] = '<span style="display:none;" id="'.$res->id_album.'">'.url($res->album_seo,"Admin_foto","copy").'</span> 
		            				<span class="float-right">
		            					<div class="custom-control custom-switch" >
		            						<a href="javascript:void(0)">
			            						<input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
			            						<label class="custom-control-label" for="cek"></label>
		            						</a>  / &nbsp;
		            						<a href="'.url($res->album_seo,"Admin_foto").'" target="_BLANK"><i class="fe-link" data-toggle="tooltip" title="Kunjungi Link" ></i></a>  / &nbsp;
		            						<a href="javascript:void(0)" onclick="copy_link('.$cp.')"><i class="fe-copy" data-toggle="tooltip" title="Copy" ></i></a>
		            					</div>
		            				</span>
		            			</span>';
            }
            
            $row["penulis"] = "<span class='badge bg-soft-danger text-info p-1'>".$res->nama_lengkap."</span>";
            $row["tanggal"] = hari_ini($res->tgl_posting).", ".tgl_indo($res->tgl_posting)." ".$res->jam;
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_album.'"><label></label></div>';

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
        $data["tgl_posting"] = tgl_view($data["tgl_posting"]);
        echo json_encode($data);
    }

    function hapus_gambar($id){
    	$this->db->where("id_album", $id);
    	$gbr = $this->db->get("album")->row();
    	$path = 'upload/gambar/';
    	$filename =  $path.$gbr->gbr_album;
     	if ($this->session->userdata("admin_level") == "admin") {
    		unlink($filename);
    	} elseif ($this->session->userdata("admin_username") == $gbr->username) {
    		unlink($filename);
    	}
     	$data["gbr_album"] = "";
     	$this->db->where("id_album",$id);
     	$res = $this->om->update("album",$data);
        // rec(get_class($this));
        if($res) {    
        	echo $this->db->last_query();
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
    	$this->db->where("id_album", $id);
    	$cek = $this->db->get("album")->row();
    	if ($cek->aktif == "Y") {
    		$data["aktif"] = "N";
    		$this->db->where("id_album", $id);
    		$this->om->update("album",$data);
    	} else {
    		$data["aktif"] = "Y";
    		$this->db->where("id_album", $id);
    		$this->om->update("album",$data);
    	}
        // rec(get_class($this));
    	if ($res) {
    		$ret = array("success" => false,
        		"title" => "Unpublished",
        		"pesan" => $cek->jdl_album." <br>tidak diterbitkan");
    	} elseif ($rew) {
    		$ret = array("success" => true,
        		"title" => "Published",
        		"pesan" => $cek->jdl_album." <br>diterbitkan");
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
        $this->form_validation->set_rules('jdl_album','Judul Album','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 

            $data["keterangan"] = $data2["keterangan"];
            $data["album_seo"] = linker($data["jdl_album"],"0");
            $data["keterangan"] = $data2["keterangan"];
            $data["tgl_posting"] = tgl_simpan($data["tgl_posting"]);
            $data["hits_album"] = "0";
            $data["username"] = $this->session->userdata("admin_username");

            $new_name = nama_file(linker($data["jdl_album"]),get_class($this));
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

            if (empty($_FILES['gbr_album']["name"])){
                $res  = $this->db->insert("album",$data);
                // rec(get_class($this));   
            } 

            if (! $this->upload->do_upload('gbr_album')) {
                $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

            } else {
                $this->db->where("id_album", $data["id_album"]);
                $gbr = $this->db->get("album")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gbr_album;
                if ($this->session->userdata("admin_level") == "admin") {
                    unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                    unlink($filename);
                }
                $fdata =  $this->upload->data();
                $data['gbr_album'] = $fdata['file_name'];   
                $res  = $this->db->insert("album",$data);
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


  

	function update($sta){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('jdl_album','Judul Album','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 

			$data["keterangan"] = $data2["keterangan"];
			$data["album_seo"] = linker($data["jdl_album"],"0");
			$data["keterangan"] = $data2["keterangan"];
			$data["tgl_posting"] = tgl_simpan($data["tgl_posting"]);
            // $data["hits_album"] = "0";

			$new_name = nama_file(linker($data["jdl_album"]),get_class($this));
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

            if (empty($_FILES['gbr_album']["name"])){
				$this->db->where("id_album",$data["id_album"]);
				$res  = $this->om->update("album",$data);
                // rec(get_class($this));	
			} 

			if (! $this->upload->do_upload('gbr_album')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$this->db->where("id_album", $data["id_album"]);
                $gbr = $this->db->get("album")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gbr_album;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
				$fdata =  $this->upload->data();
				$data['gbr_album'] = $fdata['file_name'];	
				$this->db->where("id_album",$data["id_album"]);
				$res  = $this->om->update("album",$data);
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
                $this->db->where("id_album", $id);
                $cek_gallery = $this->db->get("gallery");
                foreach ($cek_gallery->result() as $row) :
                    $path1 = 'upload/gambar/';
                    $filename1 =  $path1.$row->gbr_gallery;
                    if ($this->session->userdata("admin_level") == "admin") {
                        unlink($filename1);
                    } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                        unlink($filename1);
                    }
                endforeach;
                
                    $this->db->where("id_album", $id);
                    $gbr = $this->db->get("album")->row();
                    $path = 'upload/gambar/';
                    $filename =  $path.$gbr->gbr_album;
                    if ($this->session->userdata("admin_level") == "admin") {
                        unlink($filename);
                    } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                        unlink($filename);
                    }
                    $this->db->where("id_album",$id);
                    $res =$this->om->delete("album");
                    // rec(get_class($this));

                    $this->db->where("id_album",$id);
                    $res =$this->om->delete("gallery");
                    // rec(get_class($this));

                if($res) {    
                    $ret = array("success" => true,
                        "title" => "Berhasil",
                        "pesan" => "Data berhasil dihapus");
                } else {
                    $ret = array("success" => false,
                        "title" => "Gagal",
                        // "pesan" => "Data Gagal dihapus".$pesan);
                        "pesan" => "Data Gagal dihapus");
                }
            }
        echo json_encode($ret);
    } 

    function hapus_gambar_thumb(){
        $id = $this->input->post("id");
        $this->db->where("id_gallery", $id);
        $gbr = $this->db->get("gallery")->row();
        $path = 'upload/gambar/';
        $filename =  $path.$gbr->gbr_gallery;
        if ($this->session->userdata("admin_level") == "admin") {
            unlink($filename);
        } elseif ($this->session->userdata("admin_username") == $gbr->username) {
            unlink($filename);
        }
        $this->db->where("id_gallery",$id);
        $res = $this->om->delete("gallery");
        // rec(get_class($this));
        if($res) {    
            $ret = array("success" => true,
                "title" => "Berhasil",
                "pesan" => "Gambar berhasil dihapus");
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => "Gambar Gagal dihapus");
        }

       echo json_encode($ret);

    }
	
}
