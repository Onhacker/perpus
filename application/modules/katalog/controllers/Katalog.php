<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Katalog extends Onhacker_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
		$this->load->model("M_katalog_buku", "dm");
	}

	function index(){
		$data["controller"] = get_class($this);	
		$data['title'] = "KATALOG ".$this->fm->web_me()->nama_website;
		$data["description"] = ucwords(strtolower($data['title'])).". ".cetak_meta($this->fm->web_me()->meta_deskripsi,0,1000);
        $data["keywords"] = $this->fm->web_me()->meta_keyword;
        $data["content"] = $this->load->view(onhacker(get_class($this)),$data,true); 
        $this->render($data);
	}

	function bikin_barcode($kode){
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        Zend_Barcode::render('code128', 'image', array('text'=>$kode), array());
    }

    function get_data(){  
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            

            $no++;
            $row = array();
            $this->db->where("status", "1");
            $this->db->select("*");
            $this->db->from("sirkulasi");
            $this->db->where("id_buku", $res->id_buku);
            $k = $this->db->get()->num_rows();

            $pinjam = $res->jumlah_unit - $k;

            if ($pinjam == $res->jumlah_unit) {
                $pinjam = 0;
            } else {
                $pinjam = $res->jumlah_unit - $k;
            }


            $row["kode_buku"] = $res->kode_buku;
            $row["judul_buku"] = '<h4 class = "text-primary mb-1">'.$res->judul_buku.'</h4>
            <div class="font-14 text-success mb-2 text-truncate">
            Pengarang : '.$res->nama_pengarang.'
            </div>
            <p align = "justify" class = "font-14"><b>Penerbit : </b><span>'.$res->nama_penerbit.'</span><br><b>Tahun Penerbit : </b><span>'.$res->tahun_terbit.'</span><br><b>Jumlah Unit : </b><span>'.$res->jumlah_unit.' </span>
            - <span><b>Dipinjam</b> : '.$k.' </span>
            - <span><b>Sisa</b> : '.$pinjam.' </span>
            <br>
            <b>Deskripsi :</b>
            <br>
            <span class="text-black" >'.$res->deskripsi.'</span>
            </p>
            <div class="">
            <img src="'.site_url('/katalog/bikin_barcode/'.$res->kode_buku).'">
            </div>' ;
           
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
	
}
