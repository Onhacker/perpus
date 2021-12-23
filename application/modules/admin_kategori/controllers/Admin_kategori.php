<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kategori extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_kategori", "dm");
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
            $row["id"] = $res->id_kategori;
            $row["kategori"] = $res->nama_kategori;
            $cp = "'#".$res->id_kategori."'";
            if ($res->aktif == "Y") {
            	$stat = "<span class='badge bg-soft-success text-success'>Published</span>";
            	$ck = "checked";
            } else {
            	$stat = "<span class='badge bg-soft-danger text-danger'>Unpublished</span>";
            	$ck = "";
            }
            $this->db->where("id_kategori", $res->id_kategori);
            $row["jum"] = $this->db->get("berita")->num_rows();

            if ($this->session->userdata("admin_level") == "admin" or $this->session->userdata("admin_permisson") == "Y") {
            	$row["judul_seo"] = '<span style="display:none;" id="'.$res->id_kategori.'">'.url($res->kategori_seo, "Admin_kategori", "copy").'</span> 
		            				<span class="float-right">
		            					<div class="custom-control custom-switch" >
		            						<a href="javascript:void(0)" onclick="pub('.$res->id_kategori.')">
			            						<input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
			            						<label class="custom-control-label" for="cek"></label>
		            						</a>  / &nbsp;
		            						<a href="'.url($res->kategori_seo, "Admin_kategori").'" target="_BLANK"><i class="fe-link" data-toggle="tooltip" title="Kunjungi Link" ></i></a>  / &nbsp;
		            						<a href="javascript:void(0)" onclick="copy_link('.$cp.')"><i class="fe-copy" data-toggle="tooltip" title="Copy" ></i></a>
		            					</div>
		            				</span>
		            			</span>';
            } else {
            	$row["judul_seo"] = '<span style="display:none;" id="'.$res->id_kategori.'">'.url($res->kategori_seo, "Admin_kategori", "copy").'</span> 
		            				<span class="float-right">
		            					<div class="custom-control custom-switch" >
		            						<a href="javascript:void(0)">
			            						<input type="checkbox" '.$ck.' style="cursor: pointer !important;" class="custom-control-input"">
			            						<label class="custom-control-label" for="cek"></label>
		            						</a>  / &nbsp;
		            						<a href="'.url($res->kategori_seo, "Admin_kategori").'" target="_BLANK"><i class="fe-link" data-toggle="tooltip" title="Kunjungi Link" ></i></a>  / &nbsp;
		            						<a href="javascript:void(0)" onclick="copy_link('.$cp.')"><i class="fe-copy" data-toggle="tooltip" title="Copy" ></i></a>
		            					</div>
		            				</span>
		            			</span>';
            }
            
            $row["penulis"] = "<span class='badge bg-soft-danger text-info p-1'>".$res->nama_lengkap."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_kategori.'"><label></label></div>';

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
    	$this->db->where("id_kategori", $id);
    	$gbr = $this->db->get("kategori")->row();
    	$path = 'upload/gambar/';
    	$filename =  $path.$gbr->gambar_utama;
     	if ($this->session->userdata("admin_level") == "admin") {
    		unlink($filename);
    	} elseif ($this->session->userdata("admin_username") == $gbr->username) {
    		unlink($filename);
    	}
     	$data["gambar_utama"] = "";
     	$this->db->where("id_kategori",$id);
     	$res = $this->om->update("kategori",$data);
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
    	$this->db->where("id_kategori", $id);
    	$cek = $this->db->get("kategori")->row();
    	if ($cek->aktif == "Y") {
    		$data["aktif"] = "N";
    		$this->db->where("id_kategori", $id);
    		$this->om->update("kategori",$data);
            // rec(get_class($this));  
    	} else {
    		$data["aktif"] = "Y";
    		$this->db->where("id_kategori", $id);
    		$this->om->update("kategori",$data);
            // rec(get_class($this));  
    	}
    	if ($res) {
    		$ret = array("success" => false,
        		"title" => "Unpublished",
        		"pesan" => $cek->nama_kategori." <br>tidak diterbitkan");
    	} elseif ($rew) {
    		$ret = array("success" => true,
        		"title" => "Published",
        		"pesan" => $cek->nama_kategori." <br>diterbitkan");
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
        $this->form_validation->set_rules('nama_kategori',$this->om->engine_nama_menu("Admin_kategori"),'required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 

            $data["kategori_seo"] = linker($data2["nama_kategori"],"0");
            $data["username"] = $this->session->userdata("admin_username");
            $new_name = nama_file(linker($data["judul"]),get_class($this));
            $config['upload_path'] = 'upload/gambar/';
            $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
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

            if (empty($_FILES['gambar_utama']["name"])){
                $res  = $this->db->insert("kategori",$data);  
                // rec(get_class($this)); 
            } 

            if (! $this->upload->do_upload('gambar_utama')) {
                $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

            } else {
                $this->db->where("id_kategori", $data["id_kategori"]);
                $gbr = $this->db->get("kategori")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar_utama;
                if ($this->session->userdata("admin_level") == "admin") {
                    unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                    unlink($filename);
                }
                $fdata =  $this->upload->data();
                $data['gambar_utama'] = $fdata['file_name'];    
                $res  = $this->db->insert("kategori",$data);  
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
		$this->form_validation->set_rules('nama_kategori',$this->om->engine_nama_menu("Admin_kategori"),'required');  
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 

			$data["kategori_seo"] = linker($data2["nama_kategori"],"0");

			$new_name = nama_file(linker($data["judul"]),get_class($this));
			$config['upload_path'] = 'upload/gambar/';
			$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG';
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

            if (empty($_FILES['gambar_utama']["name"])){
				$this->db->where("id_kategori",$data["id_kategori"]);
				$res  = $this->om->update("kategori",$data);
                // rec(get_class($this));  	
			} 

			if (! $this->upload->do_upload('gambar_utama')) {
				$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

			} else {
				$this->db->where("id_kategori", $data["id_kategori"]);
                $gbr = $this->db->get("kategori")->row();
                $path = 'upload/gambar/';
                $filename =  $path.$gbr->gambar_utama;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
				$fdata =  $this->upload->data();
				$data['gambar_utama'] = $fdata['file_name'];	
				$this->db->where("id_kategori",$data["id_kategori"]);
				$res  = $this->om->update("kategori",$data);
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
                $this->db->where("id_kategori", $id);
                $cek_berita = $this->db->get("berita");
                if ($cek_berita->num_rows() > 0) {
                    $pesan = "<br>Terdapat ".$cek_berita->num_rows()." artikel dalam kategori";
                } else {
                    $this->db->where("id_kategori", $id);
                    $gbr = $this->db->get("kategori")->row();
                    $path = 'upload/gambar/';
                    $filename =  $path.$gbr->gambar_utama;
                    if ($this->session->userdata("admin_level") == "admin") {
                        unlink($filename);
                    } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                        unlink($filename);
                    }
                    $this->db->where("id_kategori",$id);
                    $res =$this->om->delete("kategori");
                    // rec(get_class($this));  
                }

                if($res) {    
                    $ret = array("success" => true,
                        "title" => "Berhasil",
                        "pesan" => "Data berhasil dihapus");
                } else {
                    $ret = array("success" => false,
                        "title" => "Gagal",
                        "pesan" => "Data Gagal dihapus".$pesan);
                }
            }
        echo json_encode($ret);
    } 


	
}
