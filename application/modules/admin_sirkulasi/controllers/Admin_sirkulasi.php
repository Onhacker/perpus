<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_sirkulasi extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_sirkulasi", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Peminjaman";
		$data["subtitle"] = $this->om->engine_nama_menu(get_class($this)) ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}

    function bikin_barcode($kode){
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
    }
    function notif(){
        $this->load->library("email");
        $this->db->where("status", "1");
        $x = $this->db->get("sirkulasi")->row();

        $b = explode(" ", $x->tgl_pengembalian);
        $tgl_pengembalian = flipdate($b[0])." ".$b[1];

        $tgl1 = new DateTime($x->tgl_pengembalian);
        $tgl2 = new DateTime(date("Y-m-d H:i:s"));
        $jarak = $tgl2->diff($tgl1);

        if ($jarak->days == 1) {
                // set pengirim
            $this->db->where("id_identitas", "1");
            $web = $this->db->get("identitas")->row();

                // isi body pesan 
            $data["title"] = "Reset Password";
            $data["p1"] = "Hai ".$x->nama_mahasiswa.". Anda masih ada buku yang belum Dikembalikan";
            $data["p2"] = "Judul Buku ".$x->judul_buku." dengan batas tanggal pengembalian ". tgl_view($tgl_pengembalian) ;
            $data["btn"] = "Kunjungi web";
            $data["link_reset"] = " ";
            $data["web"] = "<a href=".$web->url.">".$web->nama_website."</a>";
                // end of isi body

            $email                  = $x->email;
            $subject                = "Pengembalian Buku ".$x->judul_buku;
            $this->email->from($web->email, $web->nama_website);
            $this->email->to($email);
            $this->email->cc('');
            $this->email->bcc('');
            $this->email->subject($subject);
            $body = $this->load->view('password/reset_password_mail_template',$data,TRUE);
            $this->email->message($body);  
            $this->email->set_mailtype("html");
            $this->email->send();

            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = TRUE;
            $config['mailtype'] = 'html';
            $res = $this->email->initialize($config);

           echo  $rules = "Link Reset Password telah dikirim ke Email ". $x->email." Silahkan cek inbox atau spam";

        }

        // echo json_encode($ret);
    }
	function get_data(){  
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["nim"] = $res->nim;
            $row["id_sirkulasi"] = $res->id_sirkulasi;
            $row["nama_mahasiswa"] = $res->nama_mahasiswa;
            $row["judul_buku"] = $res->judul_buku;
            $row["kode_buku"] = "<img src=".site_url('/admin_buku/bikin_barcode/'.$res->kode_buku).">";
            


            $a1 = explode(" ", $res->tgl_peminjaman);
            $row["tgl_peminjaman"] = flipdate($a1[0])." ".$a1[1];
            $b = explode(" ", $res->tgl_pengembalian);
            $row["tgl_pengembalian"] = flipdate($b[0])." ".$b[1];

            $b = explode(" ", $res->tgl_dikembalikan);
            $row["tgl_dikembalikan"] = flipdate($b[0])."<br>".$b[1];

            $tgl1 = new DateTime($res->tgl_pengembalian);
            $tgl2 = new DateTime(date("Y-m-d H:i:s"));
            $jarak = $tgl2->diff($tgl1);

            // echo $jarak->d;
            if ($res->status == 0) {      
                $jarak = '<code class="badge badge-success">Peminjaman Selesai</code>' ;
            } else {
                if ($tgl2 > $tgl1) {
                    $jarak = '<code class="badge badge-danger">Lewat '.$jarak->days." hari ".$jarak->h."jam<br> ".$jarak->i." menit ".$jarak->s.' detik </code>' ;
                } else {
                    $jarak = '<code class="badge badge-blue">Sisa '.$jarak->days." hari ".$jarak->h."jam<br> ".$jarak->i." menit ".$jarak->s.' detik </code>' ;
                }
            }
            


            $row["range"] = '<code class="badge badge-primary">'.$row["tgl_peminjaman"].'<br>sampai<br>'.$row["tgl_pengembalian"].'</code><br>'.$jarak;

            if ($res->status == 1) {
                $row["status"] = '<span class="badge badge-danger">Dipinjam</span>';
            } else {
                $row["status"] = '<code class="badge badge-success">Dikembalikan<br>'.$row["tgl_dikembalikan"].'</code>';

            }
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_sirkulasi.'"><label></label></div>';

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
        $a1 = explode(" ", $data["tgl_peminjaman"]);
        $data["tgl_peminjaman"] = flipdate($a1[0])." ".$a1[1];
        $b = explode(" ", $data["tgl_pengembalian"]);
        $data["tgl_pengembalian"] = flipdate($b[0])." ".$b[1];

        // $data["tgl_peminjaman"] = flipdate($data["tgl_peminjaman"]);
        // $data["tgl_pengembalian"] = flipdate($data["tgl_pengembalian"]);

        echo json_encode($data);
    }

    
    
    function update(){
        cek_session_akses("Admin_sirkulasi",$this->session->userdata('admin_session'));
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_buku','Buku','required'); 
        $this->form_validation->set_rules('nim','Mahasiswa','required'); 
        $this->form_validation->set_rules('waktu_awal','Tanggal Peminjaman','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 

            $this->db->where("id_buku",$data["id_buku"]);
            $b = $this->db->get("master_buku")->row();
            $data["id_buku"] = $b->id_buku;
            $data["kode_buku"] = $b->kode_buku;
            $data["judul_buku"] = $b->judul_buku;

            $this->db->where("nim",$data["nim"]);
            $m = $this->db->get("users")->row();
            $data["nim"] = $m->nim;
            $data["nama_mahasiswa"] = $m->nama_lengkap;
            $data["email"] = $m->email;

            $a = explode(" sampai ", $data["waktu_awal"]);
            $a1 = explode(" ", $a[0]);
            $data["tgl_peminjaman"] = save_date_time($a1[0])." ".$a1[1];
            $b = explode(" ", $a[1]);
            $data["tgl_pengembalian"] = save_date_time($b[0])." ".$b[1];

            unset($data["waktu_awal"]);

            $this->db->where("id_sirkulasi",$data["id_sirkulasi"]);
            $res  = $this->om->update("sirkulasi",$data); 
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil diupdate");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal diupdate ");
            }
            
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 

    function add(){
        cek_session_akses("Admin_sirkulasi",$this->session->userdata('admin_session'));
        $data = $this->db->escape_str($this->input->post());
        $data2 = $this->input->post();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id_buku','Buku','required'); 
        $this->form_validation->set_rules('nim','Mahasiswa','required'); 
        $this->form_validation->set_rules('waktu_awal','Tanggal Peminjaman','required'); 
       
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_message('numeric', '* %s Harus angka ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("id_buku",$data["id_buku"]);
            $b = $this->db->get("master_buku")->row();
            $data["id_buku"] = $b->id_buku;
            $data["kode_buku"] = $b->kode_buku;
            $data["judul_buku"] = $b->judul_buku;

            $this->db->where("nim",$data["nim"]);
            $m = $this->db->get("users")->row();
            $data["nim"] = $m->nim;
            $data["nama_mahasiswa"] = $m->nama_lengkap;
            $data["email"] = $m->email;

            $a = explode(" sampai ", $data["waktu_awal"]);
            $a1 = explode(" ", $a[0]);
            $data["tgl_peminjaman"] = save_date_time($a1[0])." ".$a1[1];
            $b = explode(" ", $a[1]);
            $data["tgl_pengembalian"] = save_date_time($b[0])." ".$b[1];

            unset($data["waktu_awal"]);
            $data["status"] = 1;
            $res  = $this->om->insert("sirkulasi",$data); 
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal disimpan ");
            }
            
        } else {
            $ret = array("success" => false,
                "title" => "Gagal",
                "pesan" => validation_errors());
        }
        echo json_encode($ret);
        // echo $this->db->last_query();
    } 

    
    function hapus_data(){
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->db->where("id_sirkulasi",$id);
            $res =$this->om->delete("sirkulasi");
                // rec(get_class($this));
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

    function kembalikan(){
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->db->where("id_sirkulasi", $id);
            $res = $this->db->get("sirkulasi")->row();

               $a1 = explode(" ", $res->tgl_peminjaman);
               $row["tgl_peminjaman"] = flipdate($a1[0])." ".$a1[1];
               $b = explode(" ", $res->tgl_pengembalian);
               $row["tgl_pengembalian"] = flipdate($b[0])." ".$b[1];

               $b = explode(" ", $res->tgl_dikembalikan);
               $row["tgl_dikembalikan"] = flipdate($b[0])."<br>".$b[1];

               $tgl1 = new DateTime($res->tgl_pengembalian);
               $tgl2 = new DateTime(date("Y-m-d H:i:s"));
               $jarak = $tgl2->diff($tgl1);
               if ($res->status == 1) { 
                    if ($tgl2 > $tgl1) {
                        $data["denda"] = 1;
                        $data["uang"] = $jarak->days * $this->om->web_me()->denda;
                        $data["lewat"] = $jarak->days;
                    } else {
                    $data["denda"] = 0;
                    $data["uang"] = 0;
                        $data["lewat"] = 0;
                    }
                }

            $data["tgl_dikembalikan"] = date("Y-m-d H:i:s");
            $data["status"] =  0;
            $this->db->where("id_sirkulasi",$id);
            $res =$this->db->update("sirkulasi",$data);
                // rec(get_class($this));
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


    function cari_buku(){
        $data = $this->input->post();
        $data['kode_buku'] = empty($data['kode_buku'])?"qqqqq":$data['kode_buku'];
        $data['judul_buku'] = empty($data['judul_buku'])?"qqqqq":$data['judul_buku'];
        $this->db->order_by("judul_buku");
        
        $this->db->like("judul_buku",$data['judul_buku']);
        $this->db->or_like("kode_buku",$data['judul_buku']);
        $this->db->or_like("nama_pengarang",$data['judul_buku']);
        $this->db->or_like("nama_penerbit",$data['judul_buku']);
        $x['record']  = $this->db->get("master_buku");
        $x['target']  = $data['target'];
        if ($data["judul_buku"] == "qqqqq") {
             $x['keyword'] = "";
        } else {
             $x['keyword'] = $data['judul_buku'];
        }
       
    // echo $this->db->last_query();
        $this->load->view("search_buku_table",$x);
    }


    function cari_nim(){
        $data = $this->input->post();
        $data['nim'] = empty($data['nim'])?"qqqqq":$data['nim'];
       
        $this->db->order_by("nama_lengkap");
        $this->db->like("nim",$data['nim']);
        $this->db->or_like("nama_lengkap",$data['nim']);
        $this->db->select("username,nama_lengkap,nim,email, alamat,no_telp , level, nama_fakultas, nama_jurusan, nama_prodi, angkatan");
        $this->db->from("users");
        $this->db->join("master_fakultas", "master_fakultas.id_fakultas = users.id_fakultas");
        $this->db->join("master_jurusan", "master_jurusan.id_jurusan  = users.id_jurusan");
        $this->db->join("master_prodi", "master_prodi.id_prodi = users.id_prodi");
        $this->db->where("level","user");
        $this->db->where("deleted","N");
        $x['record']  = $this->db->get();

        $x['target_nim']  = $data['target_nim'];
        if ($data["nim"] == "qqqqq") {
             $x['keyword'] = "";
        } else {
             $x['keyword'] = $data['nim'];
        }
       
    // echo $this->db->last_query();
        $this->load->view("search_nim_table",$x);
    }

    function get_data_parent_nim(){
        $ret_arr = array();
        $data = $this->input->post();
        $this->db->where("nim",$data['nim']);
        $this->db->select("username,nama_lengkap,nim,email, alamat,no_telp , level, nama_fakultas, nama_jurusan, nama_prodi, angkatan");
        $this->db->from("users");
        $this->db->join("master_fakultas", "master_fakultas.id_fakultas = users.id_fakultas");
        $this->db->join("master_jurusan", "master_jurusan.id_jurusan  = users.id_jurusan");
        $this->db->join("master_prodi", "master_prodi.id_prodi = users.id_prodi");
        $this->db->where("level","user");
        $this->db->where("deleted","N");
        $res = $this->db->get();
        // echo $this->db->last_query();
        if($res->num_rows() > 0 ){
            $ret_arr = $res->row_array();
        }
        else {
            $ret_arr = array();
        }
        echo json_encode($ret_arr);
    }

    function get_data_parent(){
        $ret_arr = array();
        $data = $this->input->post();
        $this->db->where("id_buku",$data['id_buku']);
        $res = $this->db->get("master_buku");
        // echo $this->db->last_query();
        if($res->num_rows() > 0 ){
            $ret_arr = $res->row_array();
        }
        else {
            $ret_arr = array();
        }
        $kode = $ret_arr["kode_buku"];
        if ($kode <> "") {
           $ret_arr["kode"] = "<img src=".site_url('/admin_buku/bikin_barcode/'.$kode).">";
        }
        echo json_encode($ret_arr);
    }
    
}
