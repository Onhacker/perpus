<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Skripsi extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
		$this->load->model("M_skripsi", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);	
		$data['title'] = "SKRIPSI ".$this->fm->web_me()->nama_website;
		$data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
	}

    function get_data(){  
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            if (empty($res->file)) {
                $row["file"] = "<span class='text-danger'>
                File tidak ada
                </span>";
            } else {
                $row["file"] = "<a href='#' onclick='view(".$res->id_skripsi.") '>Lihat</a>";
            // $row["file"] = $res->file;
            }
            $row["judul"] = '<h4 class = "text-primary mb-1">'.$res->judul.'</h4>
            <p class = "font-14">
            <b>Oleh : </b><span>'.$res->pengarang.'</span><br>
            <b>Tahun : </b><span>'.$res->tahun.'</span>
            <br><br>
            <button onclick="view('.$res->id_skripsi.') " type="button" class="btn btn-blue btn-xs waves-effect waves-light"><i class=" mdi mdi-file-pdf-box mr-1"></i> Lihat Skripsi</button>
            </p>
           ' ;
           // $row["file"] = 
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

    function view($id){
        $data = array();
        $res = $this->dm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        $data["file"] = '
        <iframe src="'.site_url("upload/file/").$data["file"].'#toolbar=0&navpanes=0"" frameborder="0" width="100%" height="500px">';
        echo json_encode($data);
    }
	
}
