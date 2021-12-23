<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses("Admin_hal",$this->session->userdata('admin_session'));
        cek_session_akses("Admin_post",$this->session->userdata('admin_session'));
	}

	function index(){
		echo "fuck";
	}

	function upload_summernote(){
        if(isset($_FILES["image"]["name"])){
            $new_name = nama_file("thumb","Admin_note");
            $config['upload_path'] = 'assets/images/';
            $config['allowed_types'] = 'jpeg|gif|jpg|png|JPG|JPEG|swf';
            $config['max_size'] = '3000'; // kb
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if (! $this->upload->do_upload('image')) {
                $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";
            } else {
                $data = $this->upload->data();
                //Compress Image
                $config['image_library']='gd2';
                $config['source_image']='assets/images/'.$data['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= TRUE;
                $config['quality']= '100%';
                // $config['width']= 400;
                // $config['height']= 400;
                $config['new_image']= 'assets/images/min_'.$data['file_name'];
               
                $this->load->library('image_lib', $config);
                $res =  $this->image_lib->resize();
                $path = 'assets/images/';
                $filename =  $path.$data['file_name'];
                unlink($filename);
            }

            if($res) {
                $ret = array("success" => true,
                    "img" => base_url().'assets/images/min_'.$data['file_name']);
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal diupdate ".$this->upload->display_errors("<br>",$rules));
            }
            echo json_encode($ret);
        }
    }

    function delete_summernote(){
        $src = $this->input->post('src');
        $file_name = str_replace(base_url(), '', $src);
        $res = unlink($file_name);
        if($res) {    
        	$ret = array("success" => true,
        		"title" => "Berhasil",
        		"pesan" => "Gambar berhasil dihapus");
        } else {
        	$ret = array("success" => false,
        		"title" => "Berhasil",
        		"pesan" => "Gambar berhasil dihapus");
        }
       echo json_encode($ret);

    }
	
}