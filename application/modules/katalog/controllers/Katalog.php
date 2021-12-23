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
            $row["judul_buku"] = '
            <div class="card-box bg-pattern">
            <div class="text-center">
            
            <img src="'.site_url('/katalog/bikin_barcode/'.$res->kode_buku).'" alt="logo" class="mb-1">
            <h4 class="mb-1 text-primary font-20">'.$res->judul_buku.'</h4>
            <p class="font-14 text-success mb-2 text-truncate">Pengarang : '.$res->nama_pengarang.'</p>
            </div>

            <p class="font-14 text-center text-black">
            '.$res->deskripsi.'
            </p>

            <div class="text-center">
            <p class="mb-1">
            <span class="pr-2 text-nowrap mb-2 d-inline-block">
            <i class="mdi mdi-octagram text-muted"></i>
            <b>Penerbit</b> : '.$res->nama_penerbit.'
            </span>
            <span class="text-nowrap mb-2 d-inline-block">
            <i class="mdi mdi-calendar-clock text-muted"></i>
            <b>Tahun Terbit : </b> '.$res->tahun_terbit.'
            </span>
            </p>
            </div>

            <div class="row mt-1 text-center">
            
            <div class="col-4">
            <h5 class="font-weight-normal text-black">Jumlah</h5>
            <h4>'.$res->jumlah_unit.' buku</h4>
            </div>

            <div class="col-4">
            <h5 class="font-weight-normal text-black">Dipinjam</h5>
            <h4>'.$k.' buku</h4>
            </div>

            <div class="col-4">
            <h5 class="font-weight-normal text-black">Sisa</h5>
            <h4>'.$pinjam.' buku</h4>
            </div>


            </div>
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
