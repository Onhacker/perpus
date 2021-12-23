<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pesan extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_pesan", "dm");
        $this->load->library("email");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Pesan Masuk";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

    function load_jumlah(){
        $jp = $this->om->view_where('hubungi', array('dibaca'=>'N'))->num_rows(); 
        $btg = $this->om->view_where('hubungi', array('bintang'=>'Y'))->num_rows(); 
        $sent = $this->om->view_where('hubungi', array('terbalas'=>'1'))->num_rows(); 
        $trash = $this->om->view_where('hubungi', array('deleted'=>'1'))->num_rows(); 

        $ret = array("success" => true,
                "jp" => $jp,
                "btg" => $btg,
                "sent" => $sent,
                "trash" => $trash);

        echo json_encode($ret);
    }

    function strong($str){
        return "<strong>".$str."</strong>";
    }

	function get_data($b){   
        $list = $this->dm->get_data($b);
        $data = array();
        $no = $_POST['start'];
        $tes = "'#p1'";
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id"] = $res->id_hubungi;
            $tgl_terbalas = explode(" ", $res->tgl_terbalas);
            $blsan = str_replace("<p>", "", $res->balasan);
            $blsan_lagi = str_replace("</p>", "", $blsan);
            
            $titik = strlen($blsan_lagi);
            if ($titik > 70) {
                $tt = " ...";
            } else {
                $tt = "";
            }

            $titik2 = strlen(cetak($res->pesan));
            if ($titik2 > 70) {
                $tt2 = " ...";
            } else {
                $tt2 = "";
            }


            if ($b == "1") {
                if ($res->dibaca == "N") {
                    if ($res->bintang == "N") {
                        $row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'start(".$res->id_hubungi.")' ><span class='star-toggle far fa-star'></span></a>";
                    } else {
                        $row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'unstart(".$res->id_hubungi.")' ><span class='star-toggle far fa-star text-warning'></span></a>";
                    }
                    
                    $row["nama"] = "<strong><a href='javascript:void(0)' style='color:#72747b;'  onclick= 'edit(".$res->id_hubungi.")' > <strong>Dikirim ke</strong> ".$res->nama."</a></strong>"; 
                    $row["pesan"] = "<strong><a href='javascript:void(0)' style='color:#72747b;'  onclick= 'edit(".$res->id_hubungi.")' >".substr($blsan_lagi, 0,70).$tt."</a></strong>";
                    $row["subjek"] = $res->subjek;
                    $row["waktu"] = "<strong><a href='javascript:void(0)' style='color:#72747b;'  onclick= 'edit(".$res->id_hubungi.")' ><span class='badge bg-soft-danger text-danger'>".cek_terakhir($tgl_terbalas[0].' '.$tgl_terbalas[1])." yang lalu </span></a></strong>";
                } else {
                    if ($res->bintang == "N") {
                        $row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'start(".$res->id_hubungi.")' ><span class='star-toggle far fa-star'></span></a>";
                    } else {
                        $row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'unstart(".$res->id_hubungi.")' ><span class='star-toggle far fa-star text-warning'></span></a>";
                    }
                    $row["nama"] = "<a href='javascript:void(0)' style='color:#72747b;' class = 'text-purple m-b-0' onclick= 'edit(".$res->id_hubungi.")' > <strong>Dikirim ke</strong> ".$res->nama."</a>"; 
                    $row["pesan"] = "<a href='javascript:void(0)' style='color:#72747b;' class = 'text-purple m-b-0' onclick= 'edit(".$res->id_hubungi.")' >".substr($blsan_lagi, 0,70).$tt."</a>";
                    $row["subjek"] = $res->subjek;
                    $row["waktu"] = "<a href='javascript:void(0)' style='color:#72747b;' class = 'text-purple m-b-0' onclick= 'edit(".$res->id_hubungi.")' ><span class='badge bg-soft-primary text-primary'>".cek_terakhir($tgl_terbalas[0].' '.$tgl_terbalas[1])." yang lalu </span></a>";
                }
            } else {
                if ($res->dibaca == "N") {
                	if ($res->bintang == "N") {
                		$row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'start(".$res->id_hubungi.")' ><span class='star-toggle far fa-star'></span></a>";
                	} else {
                		$row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'unstart(".$res->id_hubungi.")' ><span class='star-toggle far fa-star text-warning'></span></a>";
                	}
                	
                	$row["nama"] = "<strong><a href='javascript:void(0)' style='color:#72747b;'  onclick= 'edit(".$res->id_hubungi.")' >".$res->nama."</a></strong>"; 
                	$row["pesan"] = "<strong><a href='javascript:void(0)' style='color:#72747b;'  onclick= 'edit(".$res->id_hubungi.")' >".substr(cetak($res->pesan), 0,70).$tt2."</a></strong>";
                	$row["subjek"] = $res->subjek;
                	$row["waktu"] = "<strong><a href='javascript:void(0)' style='color:#72747b;'  onclick= 'edit(".$res->id_hubungi.")' ><span class='badge bg-soft-danger text-danger'>".cek_terakhir($res->tanggal.' '.$res->jam)." yang lalu </span></a></strong>";
                } else {
                	if ($res->bintang == "N") {
                        $row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'start(".$res->id_hubungi.")' ><span class='star-toggle far fa-star'></span></a>";
                    } else {
                        $row["bintang"] = "<a href='javascript:void(0)' style='color:#72747b;'  onclick= 'unstart(".$res->id_hubungi.")' ><span class='star-toggle far fa-star text-warning'></span></a>";
                    }
                	$row["nama"] = "<a href='javascript:void(0)' style='color:#72747b;' class = 'text-purple m-b-0' onclick= 'edit(".$res->id_hubungi.")' >".$res->nama."</a>"; 
                	$row["pesan"] = "<a href='javascript:void(0)' style='color:#72747b;' class = 'text-purple m-b-0' onclick= 'edit(".$res->id_hubungi.")' >".substr(cetak($res->pesan), 0,70).$tt2."</a>";
                	$row["subjek"] = $res->subjek;
                	$row["waktu"] = "<a href='javascript:void(0)' style='color:#72747b;' class = 'text-purple m-b-0' onclick= 'edit(".$res->id_hubungi.")' ><span class='badge bg-soft-info text-info'>".cek_terakhir($res->tanggal.' '.$res->jam)." yang lalu </span></a>";
                }
            }
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_hubungi.'"><label></label></div>';

            $data[] = $row;
        }

        $output = array(
        	"draw" => $_POST['draw'],
        	"recordsTotal" => $this->dm->count_all($b),
        	"recordsFiltered" => $this->dm->count_filtered($b),
        	"data" => $data,
        );
        // // rec(get_class($this));
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
        $data["waktu"] = tgl_indo($data["tanggal"]);
        $data["pesan"] = cetak($data["pesan"]);
        $tgl_bls = explode(" ", $data["tgl_terbalas"]);
        $data["tgl_bls"] = tgl_indo($tgl_bls[0])." ".$tgl_bls[1] ;
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
        $this->load->library('form_validation');
        $this->form_validation->set_rules('balasan','Isi Pesan','required'); 
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('valid_email', '* %s Tidak Valid ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["terbalas"] = "1";
            $data["nama"] = $data["email"];
            $data["tgl_terbalas"] = date("Y-m-d H:i:s");
            $data["dibaca"] = "Y";
            $data["status"] = "1";
            $data["pesan"] = $data["balasan"];
            $data["tanggal"] = date("Y-m-d");
            $data["jam"] = date("H:i:s");
                $this->db->insert("hubungi",$data);
                rec();  
                 // set pengirim
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();

                $message = $data["balasan"];
                // isi body pesan
                // end of isi body
                $email                  = $data["email"];
                $subject                = $data["subjek"];
                $this->email->from($web->email, $web->nama_website);
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject($subject);
                $this->email->message($message);  
                $this->email->set_mailtype("html");
                $this->email->send();

                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $res = $this->email->initialize($config);
            
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Pesan berhasil dikirim ke ". $data["email"]);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Pesan Gagal diupdate ");
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
		$this->load->library('form_validation');
		$this->form_validation->set_rules('balas','Balasan','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$data["balasan"] = $data["balas"];
            $data["terbalas"] = "1";
            $data["tgl_terbalas"] = date("Y-m-d H:i:s");
			unset($data["balas"]);
				$this->db->where("id_hubungi",$data["id_hubungi"]);
				$this->db->update("hubungi",$data);
				rec(); 	
                 // set pengirim

                $this->db->where("id_hubungi",$data["id_hubungi"]);
                $hub = $this->db->get("hubungi")->row();
               
                $this->db->where("id_identitas", "1");
                $web = $this->db->get("identitas")->row();

                $message= cetak($hub->pesan)." <br><hr><br> ".$data["balasan"];
                // isi body pesan
                // end of isi body
                $email                  = $hub->email;
                $subject                = $hub->subjek;
                $this->email->from($web->email, $web->nama_website);
                $this->email->to($email);
                $this->email->cc('');
                $this->email->bcc('');
                $this->email->subject($subject);
                $this->email->message($message);  
                $this->email->set_mailtype("html");
                $this->email->send();

                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['charset'] = 'utf-8';
                $config['wordwrap'] = TRUE;
                $config['mailtype'] = 'html';
                $res = $this->email->initialize($config);
            
			if($res) {    
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Pesan berhasil dikirim ke ". $hub->email);
			} else {
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Pesan Gagal diupdate ");
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
                $this->db->where("id_hubungi",$id);
                $res =$this->db->delete("hubungi");
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

    function trash(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $data["deleted"] = "1";
                $this->db->where("id_hubungi",$id);
                $res =$this->db->update("hubungi",$data);
                // rec(get_class($this));  
            }
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Pesan di pindahkan ke sampah");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Silahkan pilih pesan");
            }

        echo json_encode($ret);
    } 


    function start($id){
        $data["bintang"] = "Y";
        $this->db->where("id_hubungi",$id);
        $res =$this->db->update("hubungi",$data);
        // rec(get_class($this));  

        if($res) {    
            $ret = array("success" => true,
                "title" => "Berhasil",
                "pesan" => "Pesan berbintang");
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => "Silahkan pilih pesan");
        }

        echo json_encode($ret);
    } 

    function unstart($id){
        $data["bintang"] = "N";
        $this->db->where("id_hubungi",$id);
        $res =$this->db->update("hubungi",$data);
        // rec(get_class($this));  

        if($res) {    
            $ret = array("success" => true,
                "title" => "Berhasil",
                "pesan" => "Pesan tidak berbintang");
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => "Silahkan pilih pesan");
        }

        echo json_encode($ret);
    } 


	
}
