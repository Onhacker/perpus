<?php
class Admin_Controller extends MX_Controller {
	function __construct() {
		parent::__construct();
		$this->timezone();
		$this->load->helper("cpu");
		cek_session_on_login();	
		$this->load->model("Ram_model","om");
		$this->load->helper("on");
		$this->notif();
		error_reporting(0);

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

           // echo  $rules = "Link Reset Password telah dikirim ke Email ". $x->email." Silahkan cek inbox atau spam";

        }

        // echo json_encode($ret);
    }

	function render($data){
		$this->om->validasiOnLogin();     // keluarkan jika perintah keluarkan dari prangkat lain
		$this->load->view("backend/admin_template",$data);
	}

	function timezone(){
		$this->db->where("id_identitas", "1");
		$s = $this->db->get("identitas")->row();
		return date_default_timezone_set($s->waktu);
	}

	function format_header($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(
					"borders" => array("top"        =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => true,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format($arr) {
		foreach($arr['arr_kolom'] as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $arr['baris'])->applyFromArray(
				array(
					"borders" => array("top"        =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => $arr['bold'],
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => isset($arr['align'])?PHPExcel_Style_Alignment::HORIZONTAL_CENTER:PHPExcel_Style_Alignment::HORIZONTAL_LEFT ,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_baris($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(
					"borders" => array("top"        =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_center($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_center_header($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => true,
						'italic'    => false,
						'size'        => 14
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_left($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

	function format_center_line($arr_kolom,$baris) {

		foreach($arr_kolom as $kolom) : 

			$this->excel->getActiveSheet()->getStyle($kolom . $baris)->applyFromArray(
				array(
					"borders" => array("top"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"bottom"     =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"left"       =>array('style'=>PHPExcel_Style_Border::BORDER_THIN),
						"right"      =>array('style'=>PHPExcel_Style_Border::BORDER_THIN)),  

					'font' => array(
						'name'         => 'Calibri',
						'bold'         => false,
						'italic'    => false,
						'size'        => 12
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
						'wrap'       => true
					) ) );
		endforeach;
	}

}
?>