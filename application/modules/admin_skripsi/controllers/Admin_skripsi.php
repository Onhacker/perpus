<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_skripsi extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_skripsi", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);		
		$data["title"] = "Jurnal";
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
          $row["id"] = $res->id_skripsi;
          if (empty($res->file)) {
            $row["file"] = "<span class='text-danger'>
            File tidak ada
            </span>";
          } else {
            $row["file"] = "<a href='#' onclick='view(".$res->id_skripsi.") '>Lihat</a>";
            // $row["file"] = $res->file;
          }
          $row["judul"] = $res->judul;
          $row["pengarang"] = $res->pengarang;
          $row["tahun"] = $res->tahun;
          $row["tgl_diterima"] = tgl_indo($res->tgl_diterima);

          $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_skripsi.'"><label></label></div>';

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
    $data["tgl_diterima"] = flipdate($data["tgl_diterima"]);
    $data["file"] = '
    <embed src="'.site_url("upload/file/").$data["file"].'#toolbar=0" frameborder="0" width="100%" height="500px">';
    echo json_encode($data);
}


function hapus_gambar($id){
   $this->db->where("id_skripsi", $id);
   $gbr = $this->db->get("skripsi")->row();
   $path = 'upload/file/';
   $filename =  $path.$gbr->file;
   unlink($filename);
   $data["file"] = "";
   $this->db->where("id_skripsi",$id);
   $res = $this->db->update("skripsi",$data);
   // rec(get_class($this));
   if($res) {    
       $ret = array("success" => true,
          "title" => "Berhasil",
          "pesan" => "File berhasil dihapus");
   } else {
       $ret = array("success" => false,
          "title" => "Berhasil",
          "pesan" => "File Berhasil dihapus");
   }

   echo json_encode($ret);

}


function add(){
    $data = $this->db->escape_str($this->input->post());
    $data2 = $this->input->post();
    $this->load->library('form_validation');
    $this->form_validation->set_rules('judul','Judul','required'); 
    $this->form_validation->set_rules('pengarang','Pengarang','required'); 
    $this->form_validation->set_rules('tahun','Tahun','required'); 

    $this->form_validation->set_message('required', '* %s Harus diisi ');
    $this->form_validation->set_error_delimiters('<br> ', ' ');
    if($this->form_validation->run() == TRUE ) { 
        // $data["kode"] = md5(date("Ymdhis"));
        $data["tgl_diterima"] = tgl_simpan($data["tgl_diterima"]);
        $new_name = "Skripsi_".date("dmYHis");
        $config['file_name']  = $new_name;
        $config['upload_path'] = 'upload/file/';
        $config['allowed_types'] = 'pdf';
            $config['max_size'] = '10000'; // kb
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('file')) {
                $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

            } else {
                $this->db->where("id_skripsi", $data["id_skripsi"]);
                $gbr = $this->db->get("skripsi")->row();
                $path = 'upload/file/';
                $filename =  $path.$gbr->file;
                unlink($filename);
                $fdata =  $this->upload->data();
                $data['file'] = $fdata['file_name'];    
                $res  = $this->db->insert("skripsi",$data);   
            }
            
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil Disimpan".$file_size["file"]);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal Disimpan ".$this->upload->display_errors("<br>",$rules));
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
      $this->form_validation->set_rules('judul','Judul','required'); 
      $this->form_validation->set_rules('pengarang','Pengarang','required'); 
      $this->form_validation->set_rules('tahun','Tahun','required'); 
      $this->form_validation->set_message('required', '* %s Harus diisi ');
      $this->form_validation->set_error_delimiters('<br> ', ' ');
      if($this->form_validation->run() == TRUE ) { 
            $data["tgl_diterima"] = tgl_simpan($data["tgl_diterima"]);
             $new_name = "Skripsi_".date("dmYHis");
             $config['file_name']  = $new_name;
             $config['upload_path'] = 'upload/file/';
             $config['allowed_types'] = 'pdf';
              $config['max_size'] = '10000'; // kb
            $this->load->library('upload', $config);

            if (empty($_FILES['file']["name"])){
                $this->db->where("id_skripsi",$data["id_skripsi"]);
                $res  = $this->db->update("skripsi",$data);
            } 

            if (! $this->upload->do_upload('file')) {
                $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";

            } else {
                $this->db->where("id_skripsi", $data["id_skripsi"]);
                $gbr = $this->db->get("skripsi")->row();
                $path = 'upload/file/';
                $filename =  $path.$gbr->file;
                if ($this->session->userdata("admin_level") == "admin") {
                	unlink($filename);
                } elseif ($this->session->userdata("admin_username") == $gbr->username) {
                	unlink($filename);
                }
                $fdata =  $this->upload->data();
                $data['file'] = $fdata['file_name'];	
                $this->db->where("id_skripsi",$data["id_skripsi"]);
                $res  = $this->db->update("skripsi",$data);
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
        
        $this->db->where("id_skripsi", $id);
        $gbr = $this->db->get("skripsi")->row();
        $path = 'upload/file/';
        $filename =  $path.$gbr->file;
        unlink($filename);
        $this->db->where("id_skripsi",$id);
        $res =$this->db->delete("skripsi");
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
