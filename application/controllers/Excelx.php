<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excelx extends Admin_Controller {
	function __construct(){
		parent::__construct();
	}

	function index(){
		echo "
       fucek
        ";
    }

	function laporan_imunisasi_rutin_dinas_excel($tahun,$bulan,$ttd) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
            cek_session_admin();
        }
        
        $data["title"] = "Laporan Imunisasi Rutin Dinas";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;

        $this->db->order_by("master_pkm.id_pkm","ASC");
        $this->db->where("tahun",$tahun);
        $this->db->group_by("im_tahun_vaksin_isi.id_pkm");
        $this->db->join("master_pkm", "master_pkm.id_pkm = im_tahun_vaksin_isi.id_pkm");
        $this->db->select("master_pkm.nama_pkm,master_pkm.id_pkm,sum(penduduk_l) as penduduk_l,sum(penduduk_p) as penduduk_p,sum(bayi_l) as bayi_l,sum(bayi_p) as bayi_p,sum(bayi_si_l) as bayi_si_l,sum(bayi_si_p) as bayi_si_p,sum(bayi_si_tahun_lalu_l) as bayi_si_tahun_lalu_l,sum(bayi_si_tahun_lalu_p) as bayi_si_tahun_lalu_p,sum(wus_jumlah) as wus_jumlah,sum(wus_hamil) as wus_hamil");

        $this->db->from("im_tahun_vaksin_isi");
        $data["res"] = $this->db->get();
        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Data Imunisasi Anak ');

        $arr_kolom = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','aa','ab','ac','ad','ae','af','ag','ah','ai','aj','ak','al','am','an','ao','ap','aq','ar','as','at','au','av','aw','ax','ay','az','ba','bb','bc','bd','be','bf','bg','bh','bi','bj','bk','bl','bm','bn','bo','bp','bq','br','bs','bt','bu','bv','bw','bx');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AE')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AF')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AG')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AH')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AI')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AK')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AL')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AM')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AN')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AO')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AP')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AR')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AS')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AT')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AU')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AV')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AW')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AX')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AY')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('AZ')->setWidth(8);

        $this->excel->getActiveSheet()->getColumnDimension('BA')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('BB')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BC')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BD')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('BE')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BF')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('BG')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BH')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('BI')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('BJ')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('BK')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BL')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BM')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BN')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BO')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BP')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('BQ')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BR')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('BS')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BT')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BU')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BV')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BW')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BX')->setWidth(5);
        $baris = 1;

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "LAPORAN IMUNISASI RUTIN DINAS KESEHATAN ".$this->om->web_me()->kabupaten);
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "PROVINSI ".$this->om->web_me()->propinsi." KABUPATEN ".$this->om->web_me()->kabupaten);
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "TAHUN ".$tahun." BULAN ".strtoupper(getBulan($bulan)));
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $baris++; 

        // beri warna pada header table kolom B
        $this->excel->getActiveSheet()
        ->getStyle('B'.$baris)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FAED6A');
        // end of beri warna pada header table kolom B
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "NO.")->mergeCells('a'.$baris.':a'.($baris+1))
        ->setCellValue('B' . $baris, "PUSKESMAS")->mergeCells('b'.$baris.':b'.($baris+1))
        ->setCellValue('C' . $baris, "BAYI")->mergeCells('c'.$baris.':e'.$baris)
        ->setCellValue('F' . $baris, "BAYI SI")->mergeCells('f'.$baris.':h'.$baris)
        ->setCellValue('I' . $baris, "HB0 (< 24 JAM)")->mergeCells('i'.$baris.':k'.$baris)
        ->setCellValue('L' . $baris, "HB0 (1 < 7 HARI)")->mergeCells('l'.$baris.':n'.$baris)   
        ->setCellValue('O' . $baris, "BCG")->mergeCells('o'.$baris.':q'.$baris)
        ->setCellValue('R' . $baris, "POLIO (1)")->mergeCells('r'.$baris.':t'.$baris)
        ->setCellValue('U' . $baris, "PENTAVALEN (1)")->mergeCells('u'.$baris.':w'.$baris)
        ->setCellValue('X' . $baris, "POLIO (2)")->mergeCells('x'.$baris.':z'.$baris)
        ->setCellValue('aa' . $baris, "PENTAVALEN (2)")->mergeCells('aa'.$baris.':ac'.$baris)
        ->setCellValue('ad' . $baris, "POLIO (3)")->mergeCells('ad'.$baris.':af'.$baris)
        ->setCellValue('ag' . $baris, "PENTAVALEN (3)")->mergeCells('ag'.$baris.':ai'.$baris)
        ->setCellValue('aj' . $baris, "POLIO (4)")->mergeCells('aj'.$baris.':al'.$baris)
        ->setCellValue('am' . $baris, "IPV")->mergeCells('am'.$baris.':ao'.$baris)
        ->setCellValue('ap' . $baris, "MR")->mergeCells('ap'.$baris.':ar'.$baris)
        ->setCellValue('as' . $baris, "IDL IPV")->mergeCells('as'.$baris.':au'.$baris)
        ->setCellValue('av' . $baris, "IDL NON IPV")->mergeCells('av'.$baris.':ax'.$baris)
        ->setCellValue('ay' . $baris, "BAYI (SI) TAHUN LALU")->mergeCells('ay'.$baris.':ba'.$baris)
        ->setCellValue('bb' . $baris, "PENTAVALEN LANJUTAN")->mergeCells('bb'.$baris.':bd'.$baris)
        ->setCellValue('be' . $baris, "CAMPAK LANJUTAN")->mergeCells('be'.$baris.':bg'.$baris)
        ->setCellValue('bh' . $baris, "MR LANJUTAN")->mergeCells('bh'.$baris.':bj'.$baris)
        ->setCellValue('bk' . $baris, "BUMIL")->mergeCells('bk'.$baris.':bk'.($baris+1))
        ->setCellValue('bl' . $baris, "TT BUMIL")->mergeCells('bl'.$baris.':bp'.$baris)
        ->setCellValue('bq' . $baris, "LL")->mergeCells('bq'.$baris.':bq'.($baris+1))
        ->setCellValue('br' . $baris, "WUS")->mergeCells('br'.$baris.':br'.($baris+1))
        ->setCellValue('bs' . $baris, "TT WUS TIDAK HAMIL")->mergeCells('bs'.$baris.':bw'.$baris)
        ->setCellValue('bx' . $baris, "LL")->mergeCells('bx'.$baris.':bx'.($baris+1))
        ;
        $this->format_header($arr_kolom,$baris);
        $baris++;

        $this->excel->getActiveSheet()
        ->setCellValue('C' . $baris, "L")->setCellValue('D' . $baris, "P")->setCellValue('E' . $baris, "JML")->setCellValue('F' . $baris, "L")->setCellValue('G' . $baris, "P")->setCellValue('H' . $baris, "JML")->setCellValue('I' . $baris, "L")->setCellValue('J' . $baris, "P")->setCellValue('K' . $baris, "JML")->setCellValue('L' . $baris, "L")->setCellValue('M' . $baris, "P")->setCellValue('N' . $baris, "JML")->setCellValue('O' . $baris, "L")->setCellValue('P' . $baris, "P")->setCellValue('Q' . $baris, "JML")->setCellValue('R' . $baris, "L")->setCellValue('S' . $baris, "P")->setCellValue('T' . $baris, "JML")->setCellValue('U' . $baris, "L")->setCellValue('V' . $baris, "P")->setCellValue('W' . $baris, "JML")->setCellValue('X' . $baris, "L")->setCellValue('Y' . $baris, "P")->setCellValue('Z' . $baris, "JML")->setCellValue('AA' . $baris, "L")->setCellValue('AB' . $baris, "P")->setCellValue('AC' . $baris, "JML")->setCellValue('AD' . $baris, "L")->setCellValue('AE' . $baris, "P")->setCellValue('AF' . $baris, "JML")->setCellValue('AG' . $baris, "L")->setCellValue('AH' . $baris, "P")->setCellValue('AI' . $baris, "JML")->setCellValue('AJ' . $baris, "L")->setCellValue('AK' . $baris, "P")->setCellValue('AL' . $baris, "JML")->setCellValue('AM' . $baris, "L")->setCellValue('AN' . $baris, "P")->setCellValue('AO' . $baris, "JML")->setCellValue('AP' . $baris, "L")->setCellValue('AQ' . $baris, "P")->setCellValue('AR' . $baris, "JML")->setCellValue('AS' . $baris, "L")->setCellValue('AT' . $baris, "P")->setCellValue('AU' . $baris, "JML")->setCellValue('AV' . $baris, "L")->setCellValue('AW' . $baris, "P")->setCellValue('AX' . $baris, "JML")->setCellValue('AY' . $baris, "L")->setCellValue('AZ' . $baris, "P")->setCellValue('BA' . $baris, "JML")->setCellValue('BB' . $baris, "L")->setCellValue('BC' . $baris, "P")->setCellValue('BD' . $baris, "JML")->setCellValue('BE' . $baris, "L")->setCellValue('BF' . $baris, "P")->setCellValue('BG' . $baris, "JML")->setCellValue('BH' . $baris, "L")->setCellValue('BI' . $baris, "P")->setCellValue('BJ' . $baris, "JML")->setCellValue('BL' . $baris, "1")->setCellValue('BM' . $baris, "2")->setCellValue('BN' . $baris, "3")->setCellValue('BO' . $baris, "4")->setCellValue('BP' . $baris, "5")->setCellValue('BS' . $baris, "1")->setCellValue('BT' . $baris, "2")->setCellValue('BU' . $baris, "3")->setCellValue('BV' . $baris, "4")->setCellValue('BW' . $baris, "5");     

        $this->format_header($arr_kolom,$baris);
        $baris++;
        $n=0;
        foreach($data["res"]->result() as $row) : 
                     // HB0 (< 24 JAM)
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "154", "jk" => "L")); 
            $hbl = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "154", "jk" => "P")); 
            $hbp = $this->db->get("imunisasi");
                    // HB0 (1<7 HARI)
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "137", "jk" => "L")); 
            $hbl1 = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "137", "jk" => "P")); 
            $hbp2 = $this->db->get("imunisasi");
                    // BCG 
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "117", "jk" => "L")); 
            $bcgl = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "117", "jk" => "P")); 
            $bcgp = $this->db->get("imunisasi");
                    // POLIO (1)
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "127", "jk" => "L")); 
            $polio1l = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "127", "jk" => "P")); 
            $polio1p = $this->db->get("imunisasi");
                    // PENTAVALEN 1 (1) L
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "119", "jk" => "L")); 
            $pentavaln1l = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm, "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "119", "jk" => "P")); 
            $pentabalen1p = $this->db->get("imunisasi");
                        // POLIO (2) 
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "126", "jk" => "L")); 
            $polio2l = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "126", "jk" => "P")); 
            $polio2p = $this->db->get("imunisasi");
                    // PENTAVALEN 2 P
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "128", "jk" => "L")); 
            $pentavaln2l = $this->db->get("imunisasi");

            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "128", "jk" => "P")); 
            $pentabalen2p = $this->db->get("imunisasi");
                    // POLIO 3 P
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "122", "jk" => "L")); 
            $polio3l = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "122", "jk" => "P")); 
            $polio3p = $this->db->get("imunisasi");
                    // PENTAVALEN 3 L
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "125", "jk" => "L")); 
            $pentavaln3l = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "125", "jk" => "P")); 
            $pentabalen3p = $this->db->get("imunisasi");
                    // POLIO 3 L
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "130", "jk" => "L")); 
            $polio4l = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "130", "jk" => "P")); 
            $polio4p = $this->db->get("imunisasi");
                    // IPV (< 24 JAM) P
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "121", "jk" => "L")); 
            $ipvl = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "121", "jk" => "P")); 
            $ipvp = $this->db->get("imunisasi");
                    // MR (1<7 HARI) L
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "124", "jk" => "L")); 
            $mrl = $this->db->get("imunisasi");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "124", "jk" => "P")); 
            $mrp = $this->db->get("imunisasi");
                    // IDL
            $bulan_a = strlen($bulan);
            if ($bulan_a == "1") {
                $bln = "0".$bulan;
            } else {
                $bln = $bulan;
            }
            $tahun_1 = $tahun-1;
            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "L")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
            $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_ipv = $this->db->get();

            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "P")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
            $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_opcp = $this->db->get();
                    // IDL NON IPV
            $bulan_a = strlen($bulan);
            if ($bulan_a == "1") {
                $bln = "0".$bulan;
            } else {
                $bln = $bulan;
            }
            $tahun_1 = $tahun-1;
            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "L")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
            $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_non_ipv = $this->db->get();

            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "P")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
            $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_non_i = $this->db->get();
                    // PENTAVALEN LANJUTAN P
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "129", "jk" => "L")); 
            $pentavalen_lanjutan_l = $this->db->get("imunisasi");

            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "129", "jk" => "P")); 
            $pentavalen_lanjutan_p = $this->db->get("imunisasi");
                    // CAMPAK LANJUTAN P
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "120", "jk" => "L")); 
            $campak_lanjutan_l = $this->db->get("imunisasi");

            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "120", "jk" => "P")); 
            $campak_lanjutan_p = $this->db->get("imunisasi");
                    // MR LANJUTAN L
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "138", "jk" => "L")); 
            $mr_lanjutl = $this->db->get("imunisasi");
                    // MR LANJUTAN P
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "138", "jk" => "P")); 
            $mr_lanjutp = $this->db->get("imunisasi");
                    // BUMIL
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt1")); 
            $tt1 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt2")); 
            $tt2 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt3")); 
            $tt3 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt3")); 
            $tt3 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt4")); 
            $tt4 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt5")); 
            $tt5 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttll")); 
            $ttll = $this->db->get("imunisasi_ibu");
                    // TTW TIDAK HAMIL
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw1")); 
            $ttw1 = $this->db->get("imunisasi_ibu");

            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw2")); 
            $ttw2 = $this->db->get("imunisasi_ibu");

            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw3")); 
            $ttw3 = $this->db->get("imunisasi_ibu");

            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw3")); 
            $ttw3 = $this->db->get("imunisasi_ibu");

            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw4")); 
            $ttw4 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw5")); 
            $ttw5 = $this->db->get("imunisasi_ibu");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttwll")); 
            $ttwll = $this->db->get("imunisasi_ibu");

            $n++;
                    // beri backgorund color kolom B ke baris bawah
            $this->excel->getActiveSheet()
            ->getStyle('B'.$baris)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('FAED6A');
                    // end of beri backgorund color kolom B ke baris bawah

            $this->excel->getActiveSheet()
            ->setCellValue('A' . $baris, $n)
            ->setCellValue('B' . $baris, ucwords(strtolower($row->nama_pkm)))->freezePane('C'.($baris+15))
            ->setCellValue('C' . $baris, $row->bayi_l)
            ->setCellValue('D' . $baris, $row->bayi_p)
            ->setCellValue('E' . $baris, ($row->bayi_l+$row->bayi_p))
            ->setCellValue('F' . $baris, $row->bayi_si_l)
            ->setCellValue('G' . $baris, $row->bayi_si_p)
            ->setCellValue('H' . $baris, ($row->bayi_si_l+$row->bayi_si_p))
            ->setCellValue('I' . $baris, $hbl->num_rows())
            ->setCellValue('J' . $baris, $hbp->num_rows())
            ->setCellValue('K' . $baris, ($hbl->num_rows()+$hbp->num_rows()))
            ->setCellValue('L' . $baris, $hbl1->num_rows())
            ->setCellValue('M' . $baris, $hbp2->num_rows())
            ->setCellValue('N' . $baris, ($hbl1->num_rows()+$hbp2->num_rows()))
            ->setCellValue('O' . $baris, $bcgl->num_rows())
            ->setCellValue('P' . $baris, $bcgp->num_rows())
            ->setCellValue('Q' . $baris, ($bcgl->num_rows()+$bcgp->num_rows()))
            ->setCellValue('R' . $baris, $polio1l->num_rows())
            ->setCellValue('S' . $baris, $polio1p->num_rows())
            ->setCellValue('T' . $baris, ($polio1l->num_rows()+$polio1p->num_rows()))
            ->setCellValue('U' . $baris, $pentavaln1l->num_rows())
            ->setCellValue('V' . $baris, $pentabalen1p->num_rows())
            ->setCellValue('W' . $baris, ($pentavaln1l->num_rows()+$pentabalen1p->num_rows()))
            ->setCellValue('X' . $baris, $polio2l->num_rows())
            ->setCellValue('Y' . $baris, $polio2p->num_rows())
            ->setCellValue('Z' . $baris, ($polio2l->num_rows()+$polio2p->num_rows()))
            ->setCellValue('AA' . $baris, $pentavaln2l->num_rows())
            ->setCellValue('AB' . $baris, $pentabalen2p->num_rows())
            ->setCellValue('AC' . $baris, ($pentavaln2l->num_rows()+$pentabalen2p->num_rows()))
            ->setCellValue('AD' . $baris, $polio3l->num_rows())
            ->setCellValue('AE' . $baris, $polio3p->num_rows())
            ->setCellValue('AF' . $baris, ($polio3l->num_rows()+$polio3p->num_rows()))
            ->setCellValue('AG' . $baris, $pentavaln3l->num_rows())
            ->setCellValue('AH' . $baris, $pentabalen3p->num_rows())
            ->setCellValue('AI' . $baris, ($pentavaln3l->num_rows()+$pentabalen3p->num_rows()))
            ->setCellValue('AJ' . $baris, $polio4l->num_rows())
            ->setCellValue('AK' . $baris, $polio4p->num_rows())
            ->setCellValue('AL' . $baris, ($polio4l->num_rows()+$polio4p->num_rows()))
            ->setCellValue('AM' . $baris, $ipvl->num_rows())
            ->setCellValue('AN' . $baris, $ipvp->num_rows())
            ->setCellValue('AO' . $baris, ($ipvl->num_rows()+$ipvp->num_rows()))
            ->setCellValue('AP' . $baris, $mrl->num_rows())
            ->setCellValue('AQ' . $baris, $mrp->num_rows())
            ->setCellValue('AR' . $baris, ($mrl->num_rows()+$mrp->num_rows()))
            ->setCellValue('AS' . $baris, $idl_ipv->num_rows())
            ->setCellValue('AT' . $baris, $idl_opcp->num_rows())
            ->setCellValue('AU' . $baris, ($idl_ipv->num_rows()+$idl_opcp->num_rows()))
            ->setCellValue('AV' . $baris, $idl_non_ipv->num_rows())
            ->setCellValue('AW' . $baris, $idl_non_i->num_rows())
            ->setCellValue('AX' . $baris, ($idl_non_ipv->num_rows()+$idl_non_i->num_rows()))
            ->setCellValue('AY' . $baris, $row->bayi_si_tahun_lalu_l)
            ->setCellValue('AZ' . $baris, $row->bayi_si_tahun_lalu_p)
            ->setCellValue('BA' . $baris, ($row->bayi_si_tahun_lalu_l+$row->bayi_si_tahun_lalu_p))
            ->setCellValue('BB' . $baris, $pentavalen_lanjutan_l->num_rows())
            ->setCellValue('BC' . $baris, $pentavalen_lanjutan_p->num_rows())
            ->setCellValue('BD' . $baris, ($pentavalen_lanjutan_l->num_rows()+$pentavalen_lanjutan_p->num_rows()))
            ->setCellValue('BE' . $baris, $campak_lanjutan_l->num_rows())
            ->setCellValue('BF' . $baris, $campak_lanjutan_p->num_rows())
            ->setCellValue('BG' . $baris, ($campak_lanjutan_l->num_rows()+$campak_lanjutan_p->num_rows()))
            ->setCellValue('BH' . $baris, $mr_lanjutl->num_rows())
            ->setCellValue('BI' . $baris, $mr_lanjutp->num_rows())
            ->setCellValue('BJ' . $baris, ($mr_lanjutl->num_rows()+$mr_lanjutp->num_rows()))
            ->setCellValue('BK' . $baris, $row->wus_hamil)
            ->setCellValue('BL' . $baris, $tt1->num_rows())
            ->setCellValue('BM' . $baris, $tt2->num_rows())
            ->setCellValue('BN' . $baris, $tt3->num_rows())
            ->setCellValue('BO' . $baris, $tt4->num_rows())
            ->setCellValue('BP' . $baris, $tt5->num_rows())
            ->setCellValue('BQ' . $baris, $ttll->num_rows())
            ->setCellValue('BR' . $baris, ($row->wus_jumlah-$row->wus_hamil))

            ->setCellValue('BS' . $baris, $ttw1->num_rows())
            ->setCellValue('BT' . $baris, $ttw2->num_rows())
            ->setCellValue('BU' . $baris, $ttw3->num_rows())
            ->setCellValue('BV' . $baris, $ttw4->num_rows())
            ->setCellValue('BW' . $baris, $ttw5->num_rows())
            ->setCellValue('BX' . $baris, $ttwll->num_rows())
            ;  

            $this->format_center_line($arr_kolom,$baris);
                    // ratak kiri kolom B
            $this->excel->getActiveSheet()->getStyle("B" . $baris)->applyFromArray(
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
                    // end of rata kiri kolom B
            $baris++;

        endforeach;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_l) as jum_bayi_l');
        $jum_bayi_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_l"] = $jum_bayi_l->jum_bayi_l;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_p) as jum_bayi_p');
        $jum_bayi_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_p"] = $jum_bayi_p->jum_bayi_p;


        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_l) as jum_bayi_si_l');
        $jum_bayi_si_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_l"] = $jum_bayi_si_l->jum_bayi_si_l;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_p) as jum_bayi_si_p');
        $jum_bayi_si_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_p"] = $jum_bayi_si_p->jum_bayi_si_p;



                 // HB0 (< 24 JAM)
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "154", "jk" => "L")); 
        $hbl = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "154", "jk" => "P")); 
        $hbp = $this->db->get("imunisasi");
                    // HB0 (1<7 HARI)
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "137", "jk" => "L")); 
        $hbl1 = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "137", "jk" => "P")); 
        $hbp2 = $this->db->get("imunisasi");
                    // BCG 
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "117", "jk" => "L")); 
        $bcgl = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "117", "jk" => "P")); 
        $bcgp = $this->db->get("imunisasi");
                    // POLIO (1)
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "127", "jk" => "L")); 
        $polio1l = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "127", "jk" => "P")); 
        $polio1p = $this->db->get("imunisasi");
                    // PENTAVALEN 1 (1) L
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "119", "jk" => "L")); 
        $pentavaln1l = $this->db->get("imunisasi");
        $this->db->where(array("id_pkm" => $row->id_pkm, "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "119", "jk" => "P")); 
        $pentabalen1p = $this->db->get("imunisasi");
                        // POLIO (2) 
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "126", "jk" => "L")); 
        $polio2l = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "126", "jk" => "P")); 
        $polio2p = $this->db->get("imunisasi");
                    // PENTAVALEN 2 P
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "128", "jk" => "L")); 
        $pentavaln2l = $this->db->get("imunisasi");

        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "128", "jk" => "P")); 
        $pentabalen2p = $this->db->get("imunisasi");
                    // POLIO 3 P
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "122", "jk" => "L")); 
        $polio3l = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "122", "jk" => "P")); 
        $polio3p = $this->db->get("imunisasi");
                    // PENTAVALEN 3 L
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "125", "jk" => "L")); 
        $pentavaln3l = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "125", "jk" => "P")); 
        $pentabalen3p = $this->db->get("imunisasi");
                    // POLIO 3 L
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "130", "jk" => "L")); 
        $polio4l = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "130", "jk" => "P")); 
        $polio4p = $this->db->get("imunisasi");
                    // IPV (< 24 JAM) P
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "121", "jk" => "L")); 
        $ipvl = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "121", "jk" => "P")); 
        $ipvp = $this->db->get("imunisasi");
                    // MR (1<7 HARI) L
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "124", "jk" => "L")); 
        $mrl = $this->db->get("imunisasi");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "124", "jk" => "P")); 
        $mrp = $this->db->get("imunisasi");
                    // IDL
        $bulan_a = strlen($bulan);
        if ($bulan_a == "1") {
            $bln = "0".$bulan;
        } else {
            $bln = $bulan;
        }
        $tahun_1 = $tahun-1;
        $this->db->where(array("jk" => "L")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
        $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_ipv = $this->db->get();

        $this->db->where(array("jk" => "P")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
        $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_opcp = $this->db->get();
                    // IDL NON IPV
        $bulan_a = strlen($bulan);
        if ($bulan_a == "1") {
            $bln = "0".$bulan;
        } else {
            $bln = $bulan;
        }
        $tahun_1 = $tahun-1;
        $this->db->where(array("jk" => "L")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
        $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_non_ipv = $this->db->get();

        $this->db->where(array("jk" => "P")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
        $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_non_i = $this->db->get();
                    // PENTAVALEN LANJUTAN P
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "129", "jk" => "L")); 
        $pentavalen_lanjutan_l = $this->db->get("imunisasi");

        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "129", "jk" => "P")); 
        $pentavalen_lanjutan_p = $this->db->get("imunisasi");
                    // CAMPAK LANJUTAN P
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "120", "jk" => "L")); 
        $campak_lanjutan_l = $this->db->get("imunisasi");

        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "120", "jk" => "P")); 
        $campak_lanjutan_p = $this->db->get("imunisasi");
                    // MR LANJUTAN L
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "138", "jk" => "L")); 
        $mr_lanjutl = $this->db->get("imunisasi");
                    // MR LANJUTAN P
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "138", "jk" => "P")); 
        $mr_lanjutp = $this->db->get("imunisasi");
                    // BUMIL
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt1")); 
        $tt1 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt2")); 
        $tt2 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt3")); 
        $tt3 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt3")); 
        $tt3 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt4")); 
        $tt4 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "tt5")); 
        $tt5 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttll")); 
        $ttll = $this->db->get("imunisasi_ibu");
                    // TTW TIDAK HAMIL
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw1")); 
        $ttw1 = $this->db->get("imunisasi_ibu");

        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw2")); 
        $ttw2 = $this->db->get("imunisasi_ibu");

        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw3")); 
        $ttw3 = $this->db->get("imunisasi_ibu");

        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw3")); 
        $ttw3 = $this->db->get("imunisasi_ibu");

        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw4")); 
        $ttw4 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttw5")); 
        $ttw5 = $this->db->get("imunisasi_ibu");
        $this->db->where(array("year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jenis_vaksin" => "ttwll")); 
        $ttwll = $this->db->get("imunisasi_ibu");


        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_tahun_lalu_l) as jum_bayi_si_tahun_lalu_l');
        $jum_bayi_si_tahun_lalu_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_l"] = $jum_bayi_si_tahun_lalu_l->jum_bayi_si_tahun_lalu_l;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(bayi_si_tahun_lalu_p) as jum_bayi_si_tahun_lalu_p');
        $jum_bayi_si_tahun_lalu_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_p"] = $jum_bayi_si_tahun_lalu_p->jum_bayi_si_tahun_lalu_p;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(wus_hamil) as jum_wus_hamil');
        $jum_wus_hamil = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_hamil"] = $jum_wus_hamil->jum_wus_hamil;

        $this->db->where("tahun",$tahun);    
        $this->db->select('sum(wus_jumlah) as jum_wus_jumlah');
        $jum_wus_jumlah = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_jumlah"] = $jum_wus_jumlah->jum_wus_jumlah;

        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "JUMLAH")->mergeCells('a'.$baris.':b'.($baris))
        ->setCellValue('C' . $baris, $data["jum_bayi_l"])
        ->setCellValue('D' . $baris, $data["jum_bayi_p"])
        ->setCellValue('E' . $baris, ($data["jum_bayi_p"]+$data["jum_bayi_l"]))
        ->setCellValue('F' . $baris, $data["jum_bayi_si_l"])
        ->setCellValue('G' . $baris, $data["jum_bayi_si_p"])
        ->setCellValue('H' . $baris, ($data["jum_bayi_si_p"]+$data["jum_bayi_si_l"]))
        ->setCellValue('I' . $baris, $hbl->num_rows())
        ->setCellValue('J' . $baris, $hbp->num_rows())
        ->setCellValue('K' . $baris, ($hbl->num_rows()+$hbp->num_rows()))
        ->setCellValue('L' . $baris, $hbl1->num_rows())
        ->setCellValue('M' . $baris, $hbp2->num_rows())
        ->setCellValue('N' . $baris, ($hbl1->num_rows()+$hbp2->num_rows()))
        ->setCellValue('O' . $baris, $bcgl->num_rows())
        ->setCellValue('P' . $baris, $bcgp->num_rows())
        ->setCellValue('Q' . $baris, ($bcgl->num_rows()+$bcgp->num_rows()))
        ->setCellValue('R' . $baris, $polio1l->num_rows())
        ->setCellValue('S' . $baris, $polio1p->num_rows())
        ->setCellValue('T' . $baris, ($polio1l->num_rows()+$polio1p->num_rows()))
        ->setCellValue('U' . $baris, $pentavaln1l->num_rows())
        ->setCellValue('V' . $baris, $pentabalen1p->num_rows())
        ->setCellValue('W' . $baris, ($pentavaln1l->num_rows()+$pentabalen1p->num_rows()))
        ->setCellValue('X' . $baris, $polio2l->num_rows())
        ->setCellValue('Y' . $baris, $polio2p->num_rows())
        ->setCellValue('Z' . $baris, ($polio2l->num_rows()+$polio2p->num_rows()))
        ->setCellValue('AA' . $baris, $pentavaln2l->num_rows())
        ->setCellValue('AB' . $baris, $pentabalen2p->num_rows())
        ->setCellValue('AC' . $baris, ($pentavaln2l->num_rows()+$pentabalen2p->num_rows()))
        ->setCellValue('AD' . $baris, $polio3l->num_rows())
        ->setCellValue('AE' . $baris, $polio3p->num_rows())
        ->setCellValue('AF' . $baris, ($polio3l->num_rows()+$polio3p->num_rows()))
        ->setCellValue('AG' . $baris, $pentavaln3l->num_rows())
        ->setCellValue('AH' . $baris, $pentabalen3p->num_rows())
        ->setCellValue('AI' . $baris, ($pentavaln3l->num_rows()+$pentabalen3p->num_rows()))
        ->setCellValue('AJ' . $baris, $polio4l->num_rows())
        ->setCellValue('AK' . $baris, $polio4p->num_rows())
        ->setCellValue('AL' . $baris, ($polio4l->num_rows()+$polio4p->num_rows()))
        ->setCellValue('AM' . $baris, $ipvl->num_rows())
        ->setCellValue('AN' . $baris, $ipvp->num_rows())
        ->setCellValue('AO' . $baris, ($ipvl->num_rows()+$ipvp->num_rows()))
        ->setCellValue('AP' . $baris, $mrl->num_rows())
        ->setCellValue('AQ' . $baris, $mrp->num_rows())
        ->setCellValue('AR' . $baris, ($mrl->num_rows()+$mrp->num_rows()))
        ->setCellValue('AS' . $baris, $idl_ipv->num_rows())
        ->setCellValue('AT' . $baris, $idl_opcp->num_rows())
        ->setCellValue('AU' . $baris, ($idl_ipv->num_rows()+$idl_opcp->num_rows()))
        ->setCellValue('AV' . $baris, $idl_non_ipv->num_rows())
        ->setCellValue('AW' . $baris, $idl_non_i->num_rows())
        ->setCellValue('AX' . $baris, ($idl_non_ipv->num_rows()+$idl_non_i->num_rows()))
        ->setCellValue('AY' . $baris, $data["jum_bayi_si_tahun_lalu_l"])
        ->setCellValue('AZ' . $baris, $data["jum_bayi_si_tahun_lalu_p"])
        ->setCellValue('BA' . $baris, ($data["jum_bayi_si_tahun_lalu_l"]+$data["jum_bayi_si_tahun_lalu_p"]))
        ->setCellValue('BB' . $baris, $pentavalen_lanjutan_l->num_rows())
        ->setCellValue('BC' . $baris, $pentavalen_lanjutan_p->num_rows())
        ->setCellValue('BD' . $baris, ($pentavalen_lanjutan_l->num_rows()+$pentavalen_lanjutan_p->num_rows()))
        ->setCellValue('BE' . $baris, $campak_lanjutan_l->num_rows())
        ->setCellValue('BF' . $baris, $campak_lanjutan_p->num_rows())
        ->setCellValue('BG' . $baris, ($campak_lanjutan_l->num_rows()+$campak_lanjutan_p->num_rows()))
        ->setCellValue('BH' . $baris, $mr_lanjutl->num_rows())
        ->setCellValue('BI' . $baris, $mr_lanjutp->num_rows())
        ->setCellValue('BJ' . $baris, ($mr_lanjutl->num_rows()+$mr_lanjutp->num_rows()))
        ->setCellValue('BK' . $baris, $data["jum_wus_hamil"])
        ->setCellValue('BL' . $baris, $tt1->num_rows())
        ->setCellValue('BM' . $baris, $tt2->num_rows())
        ->setCellValue('BN' . $baris, $tt3->num_rows())
        ->setCellValue('BO' . $baris, $tt4->num_rows())
        ->setCellValue('BP' . $baris, $tt5->num_rows())
        ->setCellValue('BQ' . $baris, $ttll->num_rows())
        ->setCellValue('BR' . $baris, ($data["jum_wus_jumlah"]-$data["jum_wus_hamil"]))

        ->setCellValue('BS' . $baris, $ttw1->num_rows())
        ->setCellValue('BT' . $baris, $ttw2->num_rows())
        ->setCellValue('BU' . $baris, $ttw3->num_rows())
        ->setCellValue('BV' . $baris, $ttw4->num_rows())
        ->setCellValue('BW' . $baris, $ttw5->num_rows())
        ->setCellValue('BX' . $baris, $ttwll->num_rows())
        ;
        $this->format_header($arr_kolom,$baris);
        $baris++;


        // ttd area
        $data["ttd"] = $ttd;
        if ($ttd == "kadis") {
            $data["ttd_nama"] = $this->om->web_me()->kadis;
            $data["ttd_jabatan"] = "Kepala Dinas Kesehatan ";
            $data["ttd_nip"] = $this->om->web_me()->nip_kadis;
        } elseif ($ttd== "kasi") {
            $data["ttd_nama"] = $this->om->web_me()->kepala_seksi;
            $data["ttd_jabatan"] = "Ka. Seksi surveilans dan imunisasi ";
            $data["ttd_nip"] = $this->om->web_me()->nip_kepala_seksi;
        } else {
            $data["ttd_nama"] = $this->om->web_me()->kabid;
            $data["ttd_jabatan"] = "Kepala Bidang P2P";
            $data["ttd_nip"] = $this->om->web_me()->nip_kabid;
        }

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris)->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, "Mengetahui,")
        ->setCellValue('z' . $baris, $this->om->web_me()->alamat.", ".tgl_indo(date("Y-m-d")));
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, $data["ttd_jabatan"])
        ->setCellValue('z' . $baris, "Pengelola Imunisasi");
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris)->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris)->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, $data["ttd_nama"])
        ->setCellValue('z' . $baris, $this->om->user()->nama_lengkap );
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        if ($data["ttd_nip"] != "") {
            $nip_p = "NIP. ".$data["ttd_nip"];
        }
        if ($this->om->user()->nip_operator_dinas != "") {
            $nip_o = "NIP. ".$this->om->user()->nip_operator_dinas;
        }

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, $nip_p)
        ->setCellValue('z' . $baris, $nip_o );
        $this->format_left($arr_kolom,$baris);
        $baris++; 
        // endo of ttd
        // footer
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('z'.$baris.':bx'.$baris);
        // $baris++; 
        $this->excel->getActiveSheet()->setCellValue('z' . $baris, "Generate By ". $this->om->web_me()->nama_website);
        $this->excel->getActiveSheet()->getStyle("z" . $baris)->applyFromArray(
            array(
                'font' => array(
                    'name'         => 'Calibri',
                    'bold'         => false,
                    'italic'    => true,
                    'size'        => 10,
                    'color' => array('rgb' => '1429FC'),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => true
                ) ) );
                    // end of rata kiri kolom B
        $baris++;
        // end of footer
        $filename = "LAPORAN IMUNISASI RUTIN DINAS (".date("d-m-Y H:i:s").").xls";

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');

    }

    function laporan_bayi_excel($tahun,$bulan,$id_pkm,$id_desa,$jk,$jenis_vaksin) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
            cek_session_admin();
        }
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        $data["jenis_vaksin"] = $jenis_vaksin;
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $data["id_desa"] = $id_desa;
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('tgl_suntik', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }

        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }

        $data["res"] = $this->db->get("imunisasi");

        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Data Imunisasi Anak ');

        $arr_kolom = array('a','b','c','d','e','f','g','h','i','j','k','l');

        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18);  
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);  
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);  
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(35); 
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(35);  
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);  

        // header
        if ($jenis_vaksin <> "x") {
            $this->db->where("id_penyakit",$jenis_vaksin);
            $er = $this->db->get("master_penyakit")->row();
            $jv = "<br>".htmlspecialchars($er->nama_penyakit);
        } else {
            $jv = "";
        }
        if ($jk == "L") {
            $re = "LAKI-LAKI";
        } elseif ($jk == "P") {
            $re = "PEREMPUAN";
        } else {
            $re = "";
        }

        $baris = 1;
        if ($id_pkm != "") {
            $jdl = "DATA IMUNISASI ANAK " .$re." ".strtoupper($this->om->bentuk_admin($id_pkm,"p")) ." ".strtoupper($this->om->identitas_general($id_pkm)->nama_pkm);

        } 

        if ($id_desa != "x") {
            $this->db->where("id_desa",$id_desa);
            $s = $this->db->get("master_desa")->row();
            $this->db->where("id_kecamatan", $s->id_kecamatan);
            $as = $this->db->get("master_kecamatan")->row();
            $de = strtoupper("Desa ".$s->desa." Kecamatan ".$as->kecamatan);

            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $jdl);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 

            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $de." KABUPATEN ".$this->om->web_me()->kabupaten);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 

        } else {
            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $jdl.$de." KABUPATEN ".$this->om->web_me()->kabupaten);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 
        }

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "TAHUN ".$tahun." BULAN ".strtoupper(getBulan($bulan)));
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 

        if ($jenis_vaksin <> "x") {
            $this->db->where("id_penyakit",$jenis_vaksin);
            $er = $this->db->get("master_penyakit")->row();
            $jv = "".htmlspecialchars($er->nama_penyakit);
            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $jv);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 
        } else {
            $jv = "";
        }

        // end of header

        // Jumlah
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","L");  
        $data["jum_l"] = $this->db->get("imunisasi")->num_rows();


        $this->db->where('year(tgl_suntik)', $tahun); 
        $this->db->where('month(tgl_suntik)', $bulan); 
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_anak","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jk <> "x" ) {
            $this->db->where("jk",$jk);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","P");  
        $data["jum_p"] = $this->db->get("imunisasi")->num_rows();



        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "Laki-Laki :  ".$data["jum_l"]);
        $this->format_left($arr_kolom,$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "Perempuan :  ".$data["jum_p"]);
        $this->format_left($arr_kolom,$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "Total :  ".($data["jum_p"]+$data["jum_l"]));
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "NO.")
        ->setCellValue('B' . $baris, "NOMOR IMUNISASI")
        ->setCellValue('C' . $baris, "NAMA")
        ->setCellValue('D' . $baris, "JK")
        ->setCellValue('E' . $baris, "TEMPAT LAHIR")      
        ->setCellValue('F' . $baris, "TANGGAL LAHIR")
        ->setCellValue('G' . $baris, "WAKTU SUNTIK ")
        ->setCellValue('H' . $baris, "VAKSIN UMUR")
        ->setCellValue('I' . $baris, "JENIS VAKSIN")
        ->setCellValue('J' . $baris, "TEMPAT PELAYANAN")
        ->setCellValue('K' . $baris, "ALAMAT")
        ->setCellValue('L' . $baris, "NAMA IBU");     

        $this->format_header($arr_kolom,$baris);

        $baris++;

        $n=0;
        foreach($data["res"]->result() as $row) : 

            $this->db->where("id_penyakit",$row->jenis_vaksin);
            $ag = $this->db->get("master_penyakit")->row();

            $this->db->where("id_desa",$row->id_desa);
            $agg = $this->db->get("master_desa")->row();

            $this->db->where("id_desa",$row->id_desa);
            $as = $this->db->get("master_desa")->row();

            $this->db->where("id_kecamatan", $as->id_kecamatan);
            $as = $this->db->get("master_kecamatan")->row();

            $n++;
            $this->excel->getActiveSheet()
            ->setCellValue('A' . $baris, $n)
            ->setCellValueExplicit('B' . $baris, "$row->id_imunisasi")
            ->setCellValue('C' . $baris, ucwords(strtolower($row->nama)))
            ->setCellValue('D' . $baris, $row->jk)
            ->setCellValue('E' . $baris, ucwords(strtolower($row->tempat_lahir)))      
            ->setCellValue('F' . $baris, tgl_view($row->tgl_lahir))
            ->setCellValue('G' . $baris, tgl_view($row->tgl_suntik))
            ->setCellValue('H' . $baris, $row->vaksin_umur)
            ->setCellValue('I' . $baris, $ag->nama_penyakit)
            ->setCellValue('J' . $baris, ucwords(strtolower($row->tempat_pelayanan)))
            ->setCellValue('K' . $baris, ucwords(strtolower($row->alamat)).", Desa ".ucwords(strtolower($agg->desa))." Kec. ".ucwords(strtolower($as->kecamatan)))
            ->setCellValue('L' . $baris, ucwords(strtolower($row->nama_ibu )));  

            $this->format_baris($arr_kolom,$baris);
            $baris++;
        endforeach;

        // ttd area
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris)->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':h'.$baris)->mergeCells('i'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "Mengetahui,")
        ->setCellValue('I' . $baris, $this->om->identitas_general($id_pkm)->nama_pkm.", ".tgl_indo(date("Y-m-d")));
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':h'.$baris)->mergeCells('i'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "Kepala " .$this->om->bentuk_admin($id_pkm,"p")." ".$this->om->identitas_general($id_pkm)->nama_pkm )
        ->setCellValue('I' . $baris, "Pengelola Imunisasi");
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris)->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris)->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':h'.$baris)->mergeCells('i'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, $this->om->user_general($id_pkm)->pimpinan)
        ->setCellValue('I' . $baris, $this->om->user_general($id_pkm)->nama_lengkap );
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        if ($this->om->user_general($id_pkm)->nip_pimpinan != "") {
            $nip_p = "NIP. ".$this->om->user_general($id_pkm)->nip_pimpinan;
        }
        if ($this->om->user_general($id_pkm)->nip_operator_dinas != "") {
            $nip_o = "NIP. ".$this->om->user_general($id_pkm)->nip_operator_dinas;
        }

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':h'.$baris)->mergeCells('i'.$baris.':l'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, $nip_p)
        ->setCellValue('I' . $baris, $nip_o );
        $this->format_left($arr_kolom,$baris);
        $baris++; 
        // endo of ttd
        // footer
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':l'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('i'.$baris.':l'.$baris);
        // $baris++; 
        $this->excel->getActiveSheet()->setCellValue('i' . $baris, "Generate By ". $this->om->web_me()->nama_website);
        $this->excel->getActiveSheet()->getStyle("i" . $baris)->applyFromArray(
            array(
                'font' => array(
                    'name'         => 'Calibri',
                    'bold'         => false,
                    'italic'    => true,
                    'size'        => 10,
                    'color' => array('rgb' => '1429FC'),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => true
                ) ) );
                    // end of rata kiri kolom B
        $baris++;
        // end of footer
        $filename = "DATA IMUNISASI ANAK (".date("d-m-Y H:i:s").").xls";

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');

    } 

    function laporan_ibu_excel($tahun,$bulan,$id_pkm,$id_desa,$jenis_vaksin) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
            cek_session_admin();
        }
        $data["title"] = "Data Ibu";
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        $data["jenis_vaksin"] = ($jenis_vaksin);
        $data["jk"] = $jk;
        if ($this->session->userdata("admin_level") != "admin") {
            $id_pkm = $this->session->userdata("admin_pkm");
        }
        $data["id_pkm"] = $id_pkm;
        $data["id_desa"] = $id_desa; 
        $this->db->where('year(tgl_suntik)', $tahun); 
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by('tgl_suntik', 'DESC');
        $this->db->order_by('create_date', 'DESC');
        $this->db->order_by('create_time', 'DESC');
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }

        $data["res"] = $this->db->get("imunisasi_ibu");

        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Data Imunisasi Ibu ');

        $arr_kolom = array('a','b','c','d','e','f','g','h','i','j');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18);  
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(25);  
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(25);  
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(35); 

         // header
        $baris = 1;
        if ($id_pkm != "") {
            $jdl = "DATA IMUNISASI IBU  ".strtoupper($this->om->bentuk_admin($id_pkm,"p")) ." ".strtoupper($this->om->identitas_general($id_pkm)->nama_pkm);

        } 

        if ($jenis_vaksin <> "x") {
            $this->db->where("id_penyakit",$jenis_vaksin);
            $er = $this->db->get("master_penyakit")->row();
            $jv = "<br>".strtoupper(arr_vaksin_ibu_p($jenis_vaksin));
        } else {
            $jv = "";
        }
        if ($jk == "L") {
            $re = "LAKI-LAKI";
        } elseif ($jk == "P") {
            $re = "PEREMPUAN";
        } else {
            $re = "";
        }

        if ($id_desa != "x") {
            $this->db->where("id_desa",$id_desa);
            $s = $this->db->get("master_desa")->row();
            $this->db->where("id_kecamatan", $s->id_kecamatan);
            $as = $this->db->get("master_kecamatan")->row();
            $de = strtoupper("Desa ".$s->desa." Kecamatan ".$as->kecamatan);

            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $jdl);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 

            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $de." KABUPATEN ".$this->om->web_me()->kabupaten);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 

        } else {
            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $jdl.$de." KABUPATEN ".$this->om->web_me()->kabupaten);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 
        }

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "TAHUN ".$tahun." BULAN ".strtoupper(getBulan($bulan)));
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 

        if ($jenis_vaksin <> "x") {
            $this->db->where("id_penyakit",$jenis_vaksin);
            $er = $this->db->get("master_penyakit")->row();
            $jv = "".strtoupper(arr_vaksin_ibu_p($jenis_vaksin));;
            $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
            $this->excel->getActiveSheet()->setCellValue('A' . $baris, $jv);
            $this->format_center_header($arr_kolom,$baris);
            $baris++; 
        } else {
            $jv = "";
        }

        // end of header

        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_ibu","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","L");  
        $data["jum_l"] = $this->db->get("imunisasi_ibu")->num_rows();
        $this->db->where('year(tgl_suntik)', $tahun);
        $this->db->where('month(tgl_suntik)', $bulan);
        $this->db->where("id_pkm",$id_pkm);   
        $this->db->order_by("id_ibu","DESC");
        if ($id_desa != "x" ) {
            $this->db->where("id_desa",$id_desa);  
        }
        if ($jenis_vaksin <> "x" ) {
            $this->db->where("jenis_vaksin",$jenis_vaksin);  
        }
        $this->db->where("jk","P");  
        $data["jum_p"] = $this->db->get("imunisasi_ibu")->num_rows();

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "Total :  ".($data["jum_p"]+$data["jum_l"]));
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "NO.")
        ->setCellValue('B' . $baris, "NOMOR IMUNISASI")
        ->setCellValue('C' . $baris, "NAMA")
        ->setCellValue('D' . $baris, "TEMPAT LAHIR")
        ->setCellValue('E' . $baris, "TANGGAL LAHIR")      
        ->setCellValue('F' . $baris, "WAKTU SUNTIK")
        ->setCellValue('G' . $baris, "VAKSIN UMUR")
        ->setCellValue('H' . $baris, "JENIS VAKSIN")
        ->setCellValue('I' . $baris, "TEMPAT PELAYANAN")
        ->setCellValue('J' . $baris, "ALAMAT");     

        $this->format_header($arr_kolom,$baris);

        $baris++;

        $n=0;
        foreach($data["res"]->result() as $row) : 

            $this->db->where("id_penyakit",$row->jenis_vaksin);
            $ag = $this->db->get("master_penyakit")->row();

            $this->db->where("id_desa",$row->id_desa);
            $agg = $this->db->get("master_desa")->row();

            $this->db->where("id_desa",$row->id_desa);
            $as = $this->db->get("master_desa")->row();

            $this->db->where("id_kecamatan", $as->id_kecamatan);
            $as = $this->db->get("master_kecamatan")->row();

            $n++;
            $this->excel->getActiveSheet()
            ->setCellValue('A' . $baris, $n)
            ->setCellValueExplicit('B' . $baris, "$row->id_imunisasi_ibu")
            ->setCellValue('C' . $baris, ucwords(strtolower($row->nama)))
            ->setCellValue('D' . $baris, ucwords(strtolower($row->tempat_lahir)))      
            ->setCellValue('E' . $baris, tgl_view($row->tgl_lahir))
            ->setCellValue('F' . $baris, tgl_view($row->tgl_suntik))
            ->setCellValue('G' . $baris, $row->vaksin_umur)
            ->setCellValue('H' . $baris, arr_vaksin_ibu_p($row->jenis_vaksin))
            ->setCellValue('I' . $baris, ucwords(strtolower($row->tempat_pelayanan)))
            ->setCellValue('J' . $baris, ucwords(strtolower($row->alamat)).", Desa ".ucwords(strtolower($agg->desa))." Kec. ".ucwords(strtolower($as->kecamatan)));  

            $this->format_baris($arr_kolom,$baris);
            $baris++;
        endforeach;

         // ttd area
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris)->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':f'.$baris)->mergeCells('g'.$baris.':j'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "Mengetahui,")
        ->setCellValue('G' . $baris, $this->om->identitas_general($id_pkm)->nama_pkm.", ".tgl_indo(date("Y-m-d")));
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':f'.$baris)->mergeCells('g'.$baris.':j'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "Kepala " .$this->om->bentuk_admin($id_pkm,"p")." ".$this->om->identitas_general($id_pkm)->nama_pkm )
        ->setCellValue('G' . $baris, "Pengelola Imunisasi");
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris)->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris)->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':f'.$baris)->mergeCells('g'.$baris.':j'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, $this->om->user_general($id_pkm)->pimpinan)
        ->setCellValue('G' . $baris, $this->om->user_general($id_pkm)->nama_lengkap );
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        if ($this->om->user_general($id_pkm)->nip_pimpinan != "") {
            $nip_p = "NIP. ".$this->om->user_general($id_pkm)->nip_pimpinan;
        }
        if ($this->om->user_general($id_pkm)->nip_operator_dinas != "") {
            $nip_o = "NIP. ".$this->om->user_general($id_pkm)->nip_operator_dinas;
        }

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':f'.$baris)->mergeCells('g'.$baris.':j'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, $nip_p)
        ->setCellValue('G' . $baris, $nip_o );
        $this->format_left($arr_kolom,$baris);
        $baris++; 
        // endo of ttd
        // footer
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':j'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('g'.$baris.':j'.$baris);
        // $baris++; 
        $this->excel->getActiveSheet()->setCellValue('g' . $baris, "Generate By ". $this->om->web_me()->nama_website);
        $this->excel->getActiveSheet()->getStyle("g" . $baris)->applyFromArray(
            array(
                'font' => array(
                    'name'         => 'Calibri',
                    'bold'         => false,
                    'italic'    => true,
                    'size'        => 10,
                    'color' => array('rgb' => '1429FC'),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => true
                ) ) );
                    // end of rata kiri kolom B
        $baris++;
        // end of footer
        $filename = "DATA IMUNISASI IBU (".date("d-m-Y H:i:s").").xls";

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');
    } 

    function laporan_imunisasi_rutin_dinas_range_excel($awal,$akhir,$ttd) {
        if ($id_pkm <> $this->session->userdata("admin_pkm")) {
            cek_session_admin();
        }
        
        $data["title"] = "Laporan Imunisasi Rutin Dinas ". $awal. " sd ".$akhir;
        $data["tahun"] = $tahun;
        $data["bulan"] = $bulan;
        
        $data["awal"] = $awal;
        $data["akhir"] = $akhir;

        $this->db->order_by("master_pkm.id_pkm","ASC");
        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");
        $this->db->group_by("im_tahun_vaksin_isi.id_pkm");
        $this->db->join("master_pkm", "master_pkm.id_pkm = im_tahun_vaksin_isi.id_pkm");
        $this->db->select("master_pkm.nama_pkm,master_pkm.id_pkm,sum(penduduk_l) as penduduk_l,sum(penduduk_p) as penduduk_p,sum(bayi_l) as bayi_l,sum(bayi_p) as bayi_p,sum(bayi_si_l) as bayi_si_l,sum(bayi_si_p) as bayi_si_p,sum(bayi_si_tahun_lalu_l) as bayi_si_tahun_lalu_l,sum(bayi_si_tahun_lalu_p) as bayi_si_tahun_lalu_p,sum(wus_jumlah) as wus_jumlah,sum(wus_hamil) as wus_hamil");

        $this->db->from("im_tahun_vaksin_isi");
        $data["res"] = $this->db->get();
        $this->load->library('Excel');
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Data Imunisasi Anak ');

        $arr_kolom = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','aa','ab','ac','ad','ae','af','ag','ah','ai','aj','ak','al','am','an','ao','ap','aq','ar','as','at','au','av','aw','ax','ay','az','ba','bb','bc','bd','be','bf','bg','bh','bi','bj','bk','bl','bm','bn','bo','bp','bq','br','bs','bt','bu','bv','bw','bx');
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);  
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('R')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('S')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('T')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('U')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('V')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('W')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('X')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('Y')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('Z')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AA')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AB')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AC')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AD')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AE')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AF')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AG')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AH')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AI')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AJ')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('AK')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AL')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AM')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AN')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AO')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AP')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('AQ')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AR')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AS')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AT')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AU')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AV')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AW')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AX')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('AY')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('AZ')->setWidth(8);

        $this->excel->getActiveSheet()->getColumnDimension('BA')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('BB')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BC')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BD')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('BE')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BF')->setWidth(8); 
        $this->excel->getActiveSheet()->getColumnDimension('BG')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BH')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('BI')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('BJ')->setWidth(5); 
        $this->excel->getActiveSheet()->getColumnDimension('BK')->setWidth(8);  
        $this->excel->getActiveSheet()->getColumnDimension('BL')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BM')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BN')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BO')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BP')->setWidth(5);  
        $this->excel->getActiveSheet()->getColumnDimension('BQ')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BR')->setWidth(8);
        $this->excel->getActiveSheet()->getColumnDimension('BS')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BT')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BU')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BV')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BW')->setWidth(5);
        $this->excel->getActiveSheet()->getColumnDimension('BX')->setWidth(5);
        $baris = 1;

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "LAPORAN IMUNISASI RUTIN DINAS KESEHATAN ".$this->om->web_me()->kabupaten);
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "PROVINSI ".$this->om->web_me()->propinsi." KABUPATEN ".$this->om->web_me()->kabupaten);
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $this->excel->getActiveSheet()->setCellValue('A' . $baris, "PERIODE ".strtoupper(tgl_indo(tgl_simpan($awal))." - ".tgl_indo(tgl_simpan($akhir))));
        $this->format_center_header($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':ar'.$baris);
        $baris++; 

        // beri warna pada header table kolom B
        $this->excel->getActiveSheet()
        ->getStyle('B'.$baris)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FAED6A');
        // end of beri warna pada header table kolom B
        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "NO.")->mergeCells('a'.$baris.':a'.($baris+1))
        ->setCellValue('B' . $baris, "PUSKESMAS")->mergeCells('b'.$baris.':b'.($baris+1))
        ->setCellValue('C' . $baris, "BAYI")->mergeCells('c'.$baris.':e'.$baris)
        ->setCellValue('F' . $baris, "BAYI SI")->mergeCells('f'.$baris.':h'.$baris)
        ->setCellValue('I' . $baris, "HB0 (< 24 JAM)")->mergeCells('i'.$baris.':k'.$baris)
        ->setCellValue('L' . $baris, "HB0 (1 < 7 HARI)")->mergeCells('l'.$baris.':n'.$baris)   
        ->setCellValue('O' . $baris, "BCG")->mergeCells('o'.$baris.':q'.$baris)
        ->setCellValue('R' . $baris, "POLIO (1)")->mergeCells('r'.$baris.':t'.$baris)
        ->setCellValue('U' . $baris, "PENTAVALEN (1)")->mergeCells('u'.$baris.':w'.$baris)
        ->setCellValue('X' . $baris, "POLIO (2)")->mergeCells('x'.$baris.':z'.$baris)
        ->setCellValue('aa' . $baris, "PENTAVALEN (2)")->mergeCells('aa'.$baris.':ac'.$baris)
        ->setCellValue('ad' . $baris, "POLIO (3)")->mergeCells('ad'.$baris.':af'.$baris)
        ->setCellValue('ag' . $baris, "PENTAVALEN (3)")->mergeCells('ag'.$baris.':ai'.$baris)
        ->setCellValue('aj' . $baris, "POLIO (4)")->mergeCells('aj'.$baris.':al'.$baris)
        ->setCellValue('am' . $baris, "IPV")->mergeCells('am'.$baris.':ao'.$baris)
        ->setCellValue('ap' . $baris, "MR")->mergeCells('ap'.$baris.':ar'.$baris)
        ->setCellValue('as' . $baris, "IDL IPV")->mergeCells('as'.$baris.':au'.$baris)
        ->setCellValue('av' . $baris, "IDL NON IPV")->mergeCells('av'.$baris.':ax'.$baris)
        ->setCellValue('ay' . $baris, "BAYI (SI) TAHUN LALU")->mergeCells('ay'.$baris.':ba'.$baris)
        ->setCellValue('bb' . $baris, "PENTAVALEN LANJUTAN")->mergeCells('bb'.$baris.':bd'.$baris)
        ->setCellValue('be' . $baris, "CAMPAK LANJUTAN")->mergeCells('be'.$baris.':bg'.$baris)
        ->setCellValue('bh' . $baris, "MR LANJUTAN")->mergeCells('bh'.$baris.':bj'.$baris)
        ->setCellValue('bk' . $baris, "BUMIL")->mergeCells('bk'.$baris.':bk'.($baris+1))
        ->setCellValue('bl' . $baris, "TT BUMIL")->mergeCells('bl'.$baris.':bp'.$baris)
        ->setCellValue('bq' . $baris, "LL")->mergeCells('bq'.$baris.':bq'.($baris+1))
        ->setCellValue('br' . $baris, "WUS")->mergeCells('br'.$baris.':br'.($baris+1))
        ->setCellValue('bs' . $baris, "TT WUS TIDAK HAMIL")->mergeCells('bs'.$baris.':bw'.$baris)
        ->setCellValue('bx' . $baris, "LL")->mergeCells('bx'.$baris.':bx'.($baris+1))
        ;
        $this->format_header($arr_kolom,$baris);
        $baris++;

        $this->excel->getActiveSheet()
        ->setCellValue('C' . $baris, "L")->setCellValue('D' . $baris, "P")->setCellValue('E' . $baris, "JML")->setCellValue('F' . $baris, "L")->setCellValue('G' . $baris, "P")->setCellValue('H' . $baris, "JML")->setCellValue('I' . $baris, "L")->setCellValue('J' . $baris, "P")->setCellValue('K' . $baris, "JML")->setCellValue('L' . $baris, "L")->setCellValue('M' . $baris, "P")->setCellValue('N' . $baris, "JML")->setCellValue('O' . $baris, "L")->setCellValue('P' . $baris, "P")->setCellValue('Q' . $baris, "JML")->setCellValue('R' . $baris, "L")->setCellValue('S' . $baris, "P")->setCellValue('T' . $baris, "JML")->setCellValue('U' . $baris, "L")->setCellValue('V' . $baris, "P")->setCellValue('W' . $baris, "JML")->setCellValue('X' . $baris, "L")->setCellValue('Y' . $baris, "P")->setCellValue('Z' . $baris, "JML")->setCellValue('AA' . $baris, "L")->setCellValue('AB' . $baris, "P")->setCellValue('AC' . $baris, "JML")->setCellValue('AD' . $baris, "L")->setCellValue('AE' . $baris, "P")->setCellValue('AF' . $baris, "JML")->setCellValue('AG' . $baris, "L")->setCellValue('AH' . $baris, "P")->setCellValue('AI' . $baris, "JML")->setCellValue('AJ' . $baris, "L")->setCellValue('AK' . $baris, "P")->setCellValue('AL' . $baris, "JML")->setCellValue('AM' . $baris, "L")->setCellValue('AN' . $baris, "P")->setCellValue('AO' . $baris, "JML")->setCellValue('AP' . $baris, "L")->setCellValue('AQ' . $baris, "P")->setCellValue('AR' . $baris, "JML")->setCellValue('AS' . $baris, "L")->setCellValue('AT' . $baris, "P")->setCellValue('AU' . $baris, "JML")->setCellValue('AV' . $baris, "L")->setCellValue('AW' . $baris, "P")->setCellValue('AX' . $baris, "JML")->setCellValue('AY' . $baris, "L")->setCellValue('AZ' . $baris, "P")->setCellValue('BA' . $baris, "JML")->setCellValue('BB' . $baris, "L")->setCellValue('BC' . $baris, "P")->setCellValue('BD' . $baris, "JML")->setCellValue('BE' . $baris, "L")->setCellValue('BF' . $baris, "P")->setCellValue('BG' . $baris, "JML")->setCellValue('BH' . $baris, "L")->setCellValue('BI' . $baris, "P")->setCellValue('BJ' . $baris, "JML")->setCellValue('BL' . $baris, "1")->setCellValue('BM' . $baris, "2")->setCellValue('BN' . $baris, "3")->setCellValue('BO' . $baris, "4")->setCellValue('BP' . $baris, "5")->setCellValue('BS' . $baris, "1")->setCellValue('BT' . $baris, "2")->setCellValue('BU' . $baris, "3")->setCellValue('BV' . $baris, "4")->setCellValue('BW' . $baris, "5");     

        $this->format_header($arr_kolom,$baris);
        $baris++;
        $n=0;
        foreach($data["res"]->result() as $row) : 
                     // HB0 (< 24 JAM)
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "154", "jk" => "L")); 
            $hbl = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "154", "jk" => "P")); 
            $hbp = $this->db->get("imunisasi");
                    // HB0 (1<7 HARI)
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "137", "jk" => "L")); 
            $hbl1 = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "137", "jk" => "P")); 
            $hbp2 = $this->db->get("imunisasi");
                    // BCG 
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "117", "jk" => "L")); 
            $bcgl = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "117", "jk" => "P")); 
            $bcgp = $this->db->get("imunisasi");
                    // POLIO (1)
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "127", "jk" => "L")); 
            $polio1l = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "127", "jk" => "P")); 
            $polio1p = $this->db->get("imunisasi");
                    // PENTAVALEN 1 (1) L
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "119", "jk" => "L")); 
            $pentavaln1l = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "119", "jk" => "P")); 
            $pentabalen1p = $this->db->get("imunisasi");
                        // POLIO (2) 
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "126", "jk" => "L")); 
            $polio2l = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "126", "jk" => "P")); 
            $polio2p = $this->db->get("imunisasi");
                    // PENTAVALEN 2 P
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "128", "jk" => "L")); 
            $pentavaln2l = $this->db->get("imunisasi");

            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "128", "jk" => "P")); 
            $pentabalen2p = $this->db->get("imunisasi");
                    // POLIO 3 P
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "122", "jk" => "L")); 
            $polio3l = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "122", "jk" => "P")); 
            $polio3p = $this->db->get("imunisasi");
                    // PENTAVALEN 3 L
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "125", "jk" => "L")); 
            $pentavaln3l = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "125", "jk" => "P")); 
            $pentabalen3p = $this->db->get("imunisasi");
                    // POLIO 3 L
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "130", "jk" => "L")); 
            $polio4l = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "130", "jk" => "P")); 
            $polio4p = $this->db->get("imunisasi");
                    // IPV (< 24 JAM) P
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "121", "jk" => "L")); 
            $ipvl = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "121", "jk" => "P")); 
            $ipvp = $this->db->get("imunisasi");
                    // MR (1<7 HARI) L
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "124", "jk" => "L")); 
            $mrl = $this->db->get("imunisasi");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "124", "jk" => "P")); 
            $mrp = $this->db->get("imunisasi");
                    // IDL
            $thu = substr($akhir, 6,4);
            $bln = substr($awal, 3,2);
            $bln2 = substr($awal, 0,2);
            $bln = $bln."-".$bln2;
            $tahun_1 = $thu-1;
            
            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "L")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
            $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_ipv = $this->db->get();

            
            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "P")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
            $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_opcp = $this->db->get();
                    // IDL NON IPV
            $thu = substr($akhir, 6,4);
            $bln = substr($awal, 3,2);
            $bln2 = substr($awal, 0,2);
            $bln = $bln."-".$bln2;
            $tahun_1 = $thu-1;
            
            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "L")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
            $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_non_ipv = $this->db->get();

            
            $this->db->where(array("id_pkm" => $row->id_pkm,"jk" => "P")); 
            $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
            $this->db->group_by("id_anak");
            $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
            $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
            $idl_non_i = $this->db->get();
                    // PENTAVALEN LANJUTAN P
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "129", "jk" => "L")); 
            $pentavalen_lanjutan_l = $this->db->get("imunisasi");

            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "129", "jk" => "P")); 
            $pentavalen_lanjutan_p = $this->db->get("imunisasi");
                    // CAMPAK LANJUTAN P
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "120", "jk" => "L")); 
            $campak_lanjutan_l = $this->db->get("imunisasi");

            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "120", "jk" => "P")); 
            $campak_lanjutan_p = $this->db->get("imunisasi");
                    // MR LANJUTAN L
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "138", "jk" => "L")); 
            $mr_lanjutl = $this->db->get("imunisasi");
                    // MR LANJUTAN P
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "138", "jk" => "P")); 
            $mr_lanjutp = $this->db->get("imunisasi");
                    // BUMIL
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "tt1")); 
            $tt1 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "tt2")); 
            $tt2 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "tt3")); 
            $tt3 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "tt3")); 
            $tt3 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "tt4")); 
            $tt4 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "tt5")); 
            $tt5 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttll")); 
            $ttll = $this->db->get("imunisasi_ibu");
                    // TTW TIDAK HAMIL
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttw1")); 
            $ttw1 = $this->db->get("imunisasi_ibu");

            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttw2")); 
            $ttw2 = $this->db->get("imunisasi_ibu");

            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttw3")); 
            $ttw3 = $this->db->get("imunisasi_ibu");

            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttw3")); 
            $ttw3 = $this->db->get("imunisasi_ibu");

            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttw4")); 
            $ttw4 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttw5")); 
            $ttw5 = $this->db->get("imunisasi_ibu");
            $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
            $this->db->where(array("id_pkm" => $row->id_pkm,  "jenis_vaksin" => "ttwll")); 
            $ttwll = $this->db->get("imunisasi_ibu");

            $n++;
                    // beri backgorund color kolom B ke baris bawah
            $this->excel->getActiveSheet()
            ->getStyle('B'.$baris)
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('FAED6A');
                    // end of beri backgorund color kolom B ke baris bawah

            $this->excel->getActiveSheet()
            ->setCellValue('A' . $baris, $n)
            ->setCellValue('B' . $baris, ucwords(strtolower($row->nama_pkm)))->freezePane('C'.($baris+15))
            ->setCellValue('C' . $baris, $row->bayi_l)
            ->setCellValue('D' . $baris, $row->bayi_p)
            ->setCellValue('E' . $baris, ($row->bayi_l+$row->bayi_p))
            ->setCellValue('F' . $baris, $row->bayi_si_l)
            ->setCellValue('G' . $baris, $row->bayi_si_p)
            ->setCellValue('H' . $baris, ($row->bayi_si_l+$row->bayi_si_p))
            ->setCellValue('I' . $baris, $hbl->num_rows())
            ->setCellValue('J' . $baris, $hbp->num_rows())
            ->setCellValue('K' . $baris, ($hbl->num_rows()+$hbp->num_rows()))
            ->setCellValue('L' . $baris, $hbl1->num_rows())
            ->setCellValue('M' . $baris, $hbp2->num_rows())
            ->setCellValue('N' . $baris, ($hbl1->num_rows()+$hbp2->num_rows()))
            ->setCellValue('O' . $baris, $bcgl->num_rows())
            ->setCellValue('P' . $baris, $bcgp->num_rows())
            ->setCellValue('Q' . $baris, ($bcgl->num_rows()+$bcgp->num_rows()))
            ->setCellValue('R' . $baris, $polio1l->num_rows())
            ->setCellValue('S' . $baris, $polio1p->num_rows())
            ->setCellValue('T' . $baris, ($polio1l->num_rows()+$polio1p->num_rows()))
            ->setCellValue('U' . $baris, $pentavaln1l->num_rows())
            ->setCellValue('V' . $baris, $pentabalen1p->num_rows())
            ->setCellValue('W' . $baris, ($pentavaln1l->num_rows()+$pentabalen1p->num_rows()))
            ->setCellValue('X' . $baris, $polio2l->num_rows())
            ->setCellValue('Y' . $baris, $polio2p->num_rows())
            ->setCellValue('Z' . $baris, ($polio2l->num_rows()+$polio2p->num_rows()))
            ->setCellValue('AA' . $baris, $pentavaln2l->num_rows())
            ->setCellValue('AB' . $baris, $pentabalen2p->num_rows())
            ->setCellValue('AC' . $baris, ($pentavaln2l->num_rows()+$pentabalen2p->num_rows()))
            ->setCellValue('AD' . $baris, $polio3l->num_rows())
            ->setCellValue('AE' . $baris, $polio3p->num_rows())
            ->setCellValue('AF' . $baris, ($polio3l->num_rows()+$polio3p->num_rows()))
            ->setCellValue('AG' . $baris, $pentavaln3l->num_rows())
            ->setCellValue('AH' . $baris, $pentabalen3p->num_rows())
            ->setCellValue('AI' . $baris, ($pentavaln3l->num_rows()+$pentabalen3p->num_rows()))
            ->setCellValue('AJ' . $baris, $polio4l->num_rows())
            ->setCellValue('AK' . $baris, $polio4p->num_rows())
            ->setCellValue('AL' . $baris, ($polio4l->num_rows()+$polio4p->num_rows()))
            ->setCellValue('AM' . $baris, $ipvl->num_rows())
            ->setCellValue('AN' . $baris, $ipvp->num_rows())
            ->setCellValue('AO' . $baris, ($ipvl->num_rows()+$ipvp->num_rows()))
            ->setCellValue('AP' . $baris, $mrl->num_rows())
            ->setCellValue('AQ' . $baris, $mrp->num_rows())
            ->setCellValue('AR' . $baris, ($mrl->num_rows()+$mrp->num_rows()))
            ->setCellValue('AS' . $baris, $idl_ipv->num_rows())
            ->setCellValue('AT' . $baris, $idl_opcp->num_rows())
            ->setCellValue('AU' . $baris, ($idl_ipv->num_rows()+$idl_opcp->num_rows()))
            ->setCellValue('AV' . $baris, $idl_non_ipv->num_rows())
            ->setCellValue('AW' . $baris, $idl_non_i->num_rows())
            ->setCellValue('AX' . $baris, ($idl_non_ipv->num_rows()+$idl_non_i->num_rows()))
            ->setCellValue('AY' . $baris, $row->bayi_si_tahun_lalu_l)
            ->setCellValue('AZ' . $baris, $row->bayi_si_tahun_lalu_p)
            ->setCellValue('BA' . $baris, ($row->bayi_si_tahun_lalu_l+$row->bayi_si_tahun_lalu_p))
            ->setCellValue('BB' . $baris, $pentavalen_lanjutan_l->num_rows())
            ->setCellValue('BC' . $baris, $pentavalen_lanjutan_p->num_rows())
            ->setCellValue('BD' . $baris, ($pentavalen_lanjutan_l->num_rows()+$pentavalen_lanjutan_p->num_rows()))
            ->setCellValue('BE' . $baris, $campak_lanjutan_l->num_rows())
            ->setCellValue('BF' . $baris, $campak_lanjutan_p->num_rows())
            ->setCellValue('BG' . $baris, ($campak_lanjutan_l->num_rows()+$campak_lanjutan_p->num_rows()))
            ->setCellValue('BH' . $baris, $mr_lanjutl->num_rows())
            ->setCellValue('BI' . $baris, $mr_lanjutp->num_rows())
            ->setCellValue('BJ' . $baris, ($mr_lanjutl->num_rows()+$mr_lanjutp->num_rows()))
            ->setCellValue('BK' . $baris, $row->wus_hamil)
            ->setCellValue('BL' . $baris, $tt1->num_rows())
            ->setCellValue('BM' . $baris, $tt2->num_rows())
            ->setCellValue('BN' . $baris, $tt3->num_rows())
            ->setCellValue('BO' . $baris, $tt4->num_rows())
            ->setCellValue('BP' . $baris, $tt5->num_rows())
            ->setCellValue('BQ' . $baris, $ttll->num_rows())
            ->setCellValue('BR' . $baris, ($row->wus_jumlah-$row->wus_hamil))

            ->setCellValue('BS' . $baris, $ttw1->num_rows())
            ->setCellValue('BT' . $baris, $ttw2->num_rows())
            ->setCellValue('BU' . $baris, $ttw3->num_rows())
            ->setCellValue('BV' . $baris, $ttw4->num_rows())
            ->setCellValue('BW' . $baris, $ttw5->num_rows())
            ->setCellValue('BX' . $baris, $ttwll->num_rows())
            ;  

            $this->format_center_line($arr_kolom,$baris);
                    // ratak kiri kolom B
            $this->excel->getActiveSheet()->getStyle("B" . $baris)->applyFromArray(
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
                    // end of rata kiri kolom B
            $baris++;

        endforeach;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_l) as jum_bayi_l');
        $jum_bayi_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_l"] = $jum_bayi_l->jum_bayi_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_p) as jum_bayi_p');
        $jum_bayi_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_p"] = $jum_bayi_p->jum_bayi_p;


        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_l) as jum_bayi_si_l');
        $jum_bayi_si_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_l"] = $jum_bayi_si_l->jum_bayi_si_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_p) as jum_bayi_si_p');
        $jum_bayi_si_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_p"] = $jum_bayi_si_p->jum_bayi_si_p;



                 // HB0 (< 24 JAM)
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "154", "jk" => "L")); 
        $hbl = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "154", "jk" => "P")); 
        $hbp = $this->db->get("imunisasi");
                    // HB0 (1<7 HARI)
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "137", "jk" => "L")); 
        $hbl1 = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "137", "jk" => "P")); 
        $hbp2 = $this->db->get("imunisasi");
                    // BCG 
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "117", "jk" => "L")); 
        $bcgl = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "117", "jk" => "P")); 
        $bcgp = $this->db->get("imunisasi");
                    // POLIO (1)
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "127", "jk" => "L")); 
        $polio1l = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "127", "jk" => "P")); 
        $polio1p = $this->db->get("imunisasi");
                    // PENTAVALEN 1 (1) L
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "119", "jk" => "L")); 
        $pentavaln1l = $this->db->get("imunisasi");
        $this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "119", "jk" => "P")); 
        $pentabalen1p = $this->db->get("imunisasi");
                        // POLIO (2) 
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "126", "jk" => "L")); 
        $polio2l = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "126", "jk" => "P")); 
        $polio2p = $this->db->get("imunisasi");
                    // PENTAVALEN 2 P
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "128", "jk" => "L")); 
        $pentavaln2l = $this->db->get("imunisasi");

        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "128", "jk" => "P")); 
        $pentabalen2p = $this->db->get("imunisasi");
                    // POLIO 3 P
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "122", "jk" => "L")); 
        $polio3l = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "122", "jk" => "P")); 
        $polio3p = $this->db->get("imunisasi");
                    // PENTAVALEN 3 L
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "125", "jk" => "L")); 
        $pentavaln3l = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "125", "jk" => "P")); 
        $pentabalen3p = $this->db->get("imunisasi");
                    // POLIO 3 L
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "130", "jk" => "L")); 
        $polio4l = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "130", "jk" => "P")); 
        $polio4p = $this->db->get("imunisasi");
                    // IPV (< 24 JAM) P
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "121", "jk" => "L")); 
        $ipvl = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "121", "jk" => "P")); 
        $ipvp = $this->db->get("imunisasi");
                    // MR (1<7 HARI) L
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "124", "jk" => "L")); 
        $mrl = $this->db->get("imunisasi");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "124", "jk" => "P")); 
        $mrp = $this->db->get("imunisasi");
                    // IDL
        $thu = substr($akhir, 6,4);
        $bln = substr($awal, 3,2);
        $bln2 = substr($awal, 0,2);
        $bln = $bln."-".$bln2;
        $tahun_1 = $thu-1;
        $this->db->where(array("jk" => "L")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
        $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_ipv = $this->db->get();

        $this->db->where(array("jk" => "P")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
        $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_opcp = $this->db->get();
                    // IDL NON IPV
        $thu = substr($akhir, 6,4);
        $bln = substr($awal, 3,2);
        $bln2 = substr($awal, 0,2);
        $bln = $bln."-".$bln2;
        $tahun_1 = $thu-1;
        $this->db->where(array("jk" => "L")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
        $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_non_ipv = $this->db->get();

        $this->db->where(array("jk" => "P")); 
        $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
        $this->db->group_by("id_anak");
        $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
        $this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
        $idl_non_i = $this->db->get();
                    // PENTAVALEN LANJUTAN P
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "129", "jk" => "L")); 
        $pentavalen_lanjutan_l = $this->db->get("imunisasi");

        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "129", "jk" => "P")); 
        $pentavalen_lanjutan_p = $this->db->get("imunisasi");
                    // CAMPAK LANJUTAN P
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "120", "jk" => "L")); 
        $campak_lanjutan_l = $this->db->get("imunisasi");

        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "120", "jk" => "P")); 
        $campak_lanjutan_p = $this->db->get("imunisasi");
                    // MR LANJUTAN L
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "138", "jk" => "L")); 
        $mr_lanjutl = $this->db->get("imunisasi");
                    // MR LANJUTAN P
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "138", "jk" => "P")); 
        $mr_lanjutp = $this->db->get("imunisasi");
                    // BUMIL
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "tt1")); 
        $tt1 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "tt2")); 
        $tt2 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "tt3")); 
        $tt3 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "tt3")); 
        $tt3 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "tt4")); 
        $tt4 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "tt5")); 
        $tt5 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttll")); 
        $ttll = $this->db->get("imunisasi_ibu");
                    // TTW TIDAK HAMIL
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttw1")); 
        $ttw1 = $this->db->get("imunisasi_ibu");

        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttw2")); 
        $ttw2 = $this->db->get("imunisasi_ibu");

        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttw3")); 
        $ttw3 = $this->db->get("imunisasi_ibu");

        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttw3")); 
        $ttw3 = $this->db->get("imunisasi_ibu");

        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttw4")); 
        $ttw4 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttw5")); 
        $ttw5 = $this->db->get("imunisasi_ibu");
        $this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
        $this->db->where(array("jenis_vaksin" => "ttwll")); 
        $ttwll = $this->db->get("imunisasi_ibu");


        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_tahun_lalu_l) as jum_bayi_si_tahun_lalu_l');
        $jum_bayi_si_tahun_lalu_l = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_l"] = $jum_bayi_si_tahun_lalu_l->jum_bayi_si_tahun_lalu_l;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(bayi_si_tahun_lalu_p) as jum_bayi_si_tahun_lalu_p');
        $jum_bayi_si_tahun_lalu_p = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_bayi_si_tahun_lalu_p"] = $jum_bayi_si_tahun_lalu_p->jum_bayi_si_tahun_lalu_p;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(wus_hamil) as jum_wus_hamil');
        $jum_wus_hamil = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_hamil"] = $jum_wus_hamil->jum_wus_hamil;

        $this->db->where("tahun between ".tahun_view($awal)." and ".tahun_view($akhir)." ");    
        $this->db->select('sum(wus_jumlah) as jum_wus_jumlah');
        $jum_wus_jumlah = $this->db->get("im_tahun_vaksin_isi")->row();
        $data["jum_wus_jumlah"] = $jum_wus_jumlah->jum_wus_jumlah;

        $this->excel->getActiveSheet()
        ->setCellValue('A' . $baris, "JUMLAH")->mergeCells('a'.$baris.':b'.($baris))
        ->setCellValue('C' . $baris, $data["jum_bayi_l"])
        ->setCellValue('D' . $baris, $data["jum_bayi_p"])
        ->setCellValue('E' . $baris, ($data["jum_bayi_p"]+$data["jum_bayi_l"]))
        ->setCellValue('F' . $baris, $data["jum_bayi_si_l"])
        ->setCellValue('G' . $baris, $data["jum_bayi_si_p"])
        ->setCellValue('H' . $baris, ($data["jum_bayi_si_p"]+$data["jum_bayi_si_l"]))
        ->setCellValue('I' . $baris, $hbl->num_rows())
        ->setCellValue('J' . $baris, $hbp->num_rows())
        ->setCellValue('K' . $baris, ($hbl->num_rows()+$hbp->num_rows()))
        ->setCellValue('L' . $baris, $hbl1->num_rows())
        ->setCellValue('M' . $baris, $hbp2->num_rows())
        ->setCellValue('N' . $baris, ($hbl1->num_rows()+$hbp2->num_rows()))
        ->setCellValue('O' . $baris, $bcgl->num_rows())
        ->setCellValue('P' . $baris, $bcgp->num_rows())
        ->setCellValue('Q' . $baris, ($bcgl->num_rows()+$bcgp->num_rows()))
        ->setCellValue('R' . $baris, $polio1l->num_rows())
        ->setCellValue('S' . $baris, $polio1p->num_rows())
        ->setCellValue('T' . $baris, ($polio1l->num_rows()+$polio1p->num_rows()))
        ->setCellValue('U' . $baris, $pentavaln1l->num_rows())
        ->setCellValue('V' . $baris, $pentabalen1p->num_rows())
        ->setCellValue('W' . $baris, ($pentavaln1l->num_rows()+$pentabalen1p->num_rows()))
        ->setCellValue('X' . $baris, $polio2l->num_rows())
        ->setCellValue('Y' . $baris, $polio2p->num_rows())
        ->setCellValue('Z' . $baris, ($polio2l->num_rows()+$polio2p->num_rows()))
        ->setCellValue('AA' . $baris, $pentavaln2l->num_rows())
        ->setCellValue('AB' . $baris, $pentabalen2p->num_rows())
        ->setCellValue('AC' . $baris, ($pentavaln2l->num_rows()+$pentabalen2p->num_rows()))
        ->setCellValue('AD' . $baris, $polio3l->num_rows())
        ->setCellValue('AE' . $baris, $polio3p->num_rows())
        ->setCellValue('AF' . $baris, ($polio3l->num_rows()+$polio3p->num_rows()))
        ->setCellValue('AG' . $baris, $pentavaln3l->num_rows())
        ->setCellValue('AH' . $baris, $pentabalen3p->num_rows())
        ->setCellValue('AI' . $baris, ($pentavaln3l->num_rows()+$pentabalen3p->num_rows()))
        ->setCellValue('AJ' . $baris, $polio4l->num_rows())
        ->setCellValue('AK' . $baris, $polio4p->num_rows())
        ->setCellValue('AL' . $baris, ($polio4l->num_rows()+$polio4p->num_rows()))
        ->setCellValue('AM' . $baris, $ipvl->num_rows())
        ->setCellValue('AN' . $baris, $ipvp->num_rows())
        ->setCellValue('AO' . $baris, ($ipvl->num_rows()+$ipvp->num_rows()))
        ->setCellValue('AP' . $baris, $mrl->num_rows())
        ->setCellValue('AQ' . $baris, $mrp->num_rows())
        ->setCellValue('AR' . $baris, ($mrl->num_rows()+$mrp->num_rows()))
        ->setCellValue('AS' . $baris, $idl_ipv->num_rows())
        ->setCellValue('AT' . $baris, $idl_opcp->num_rows())
        ->setCellValue('AU' . $baris, ($idl_ipv->num_rows()+$idl_opcp->num_rows()))
        ->setCellValue('AV' . $baris, $idl_non_ipv->num_rows())
        ->setCellValue('AW' . $baris, $idl_non_i->num_rows())
        ->setCellValue('AX' . $baris, ($idl_non_ipv->num_rows()+$idl_non_i->num_rows()))
        ->setCellValue('AY' . $baris, $data["jum_bayi_si_tahun_lalu_l"])
        ->setCellValue('AZ' . $baris, $data["jum_bayi_si_tahun_lalu_p"])
        ->setCellValue('BA' . $baris, ($data["jum_bayi_si_tahun_lalu_l"]+$data["jum_bayi_si_tahun_lalu_p"]))
        ->setCellValue('BB' . $baris, $pentavalen_lanjutan_l->num_rows())
        ->setCellValue('BC' . $baris, $pentavalen_lanjutan_p->num_rows())
        ->setCellValue('BD' . $baris, ($pentavalen_lanjutan_l->num_rows()+$pentavalen_lanjutan_p->num_rows()))
        ->setCellValue('BE' . $baris, $campak_lanjutan_l->num_rows())
        ->setCellValue('BF' . $baris, $campak_lanjutan_p->num_rows())
        ->setCellValue('BG' . $baris, ($campak_lanjutan_l->num_rows()+$campak_lanjutan_p->num_rows()))
        ->setCellValue('BH' . $baris, $mr_lanjutl->num_rows())
        ->setCellValue('BI' . $baris, $mr_lanjutp->num_rows())
        ->setCellValue('BJ' . $baris, ($mr_lanjutl->num_rows()+$mr_lanjutp->num_rows()))
        ->setCellValue('BK' . $baris, $data["jum_wus_hamil"])
        ->setCellValue('BL' . $baris, $tt1->num_rows())
        ->setCellValue('BM' . $baris, $tt2->num_rows())
        ->setCellValue('BN' . $baris, $tt3->num_rows())
        ->setCellValue('BO' . $baris, $tt4->num_rows())
        ->setCellValue('BP' . $baris, $tt5->num_rows())
        ->setCellValue('BQ' . $baris, $ttll->num_rows())
        ->setCellValue('BR' . $baris, ($data["jum_wus_jumlah"]-$data["jum_wus_hamil"]))

        ->setCellValue('BS' . $baris, $ttw1->num_rows())
        ->setCellValue('BT' . $baris, $ttw2->num_rows())
        ->setCellValue('BU' . $baris, $ttw3->num_rows())
        ->setCellValue('BV' . $baris, $ttw4->num_rows())
        ->setCellValue('BW' . $baris, $ttw5->num_rows())
        ->setCellValue('BX' . $baris, $ttwll->num_rows())
        ;
        $this->format_header($arr_kolom,$baris);
        $baris++;


        // ttd area
        $data["ttd"] = $ttd;
        if ($ttd == "kadis") {
            $data["ttd_nama"] = $this->om->web_me()->kadis;
            $data["ttd_jabatan"] = "Kepala Dinas Kesehatan ";
            $data["ttd_nip"] = $this->om->web_me()->nip_kadis;
        } elseif ($ttd== "kasi") {
            $data["ttd_nama"] = $this->om->web_me()->kepala_seksi;
            $data["ttd_jabatan"] = "Ka. Seksi surveilans dan imunisasi ";
            $data["ttd_nip"] = $this->om->web_me()->nip_kepala_seksi;
        } else {
            $data["ttd_nama"] = $this->om->web_me()->kabid;
            $data["ttd_jabatan"] = "Kepala Bidang P2P";
            $data["ttd_nip"] = $this->om->web_me()->nip_kabid;
        }

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris)->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, "Mengetahui,")
        ->setCellValue('z' . $baris, $this->om->web_me()->alamat.", ".tgl_indo(date("Y-m-d")));
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, $data["ttd_jabatan"])
        ->setCellValue('z' . $baris, "Pengelola Imunisasi");
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris)->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris)->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':bx'.$baris);
        $baris++; 

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, $data["ttd_nama"])
        ->setCellValue('z' . $baris, $this->om->user()->nama_lengkap );
        $this->format_left($arr_kolom,$baris);
        $baris++; 

        if ($data["ttd_nip"] != "") {
            $nip_p = "NIP. ".$data["ttd_nip"];
        }
        if ($this->om->user()->nip_operator_dinas != "") {
            $nip_o = "NIP. ".$this->om->user()->nip_operator_dinas;
        }

        $this->excel->getActiveSheet()->mergeCells('c'.$baris.':y'.$baris)->mergeCells('z'.$baris.':bx'.$baris);
        $this->excel->getActiveSheet()
        ->setCellValue('c' . $baris, $nip_p)
        ->setCellValue('z' . $baris, $nip_o );
        $this->format_left($arr_kolom,$baris);
        $baris++; 
        // endo of ttd
        // footer
        $this->excel->getActiveSheet()->mergeCells('a'.$baris.':bx'.$baris);
        $baris++; 
        $this->excel->getActiveSheet()->mergeCells('z'.$baris.':bx'.$baris);
        // $baris++; 
        $this->excel->getActiveSheet()->setCellValue('z' . $baris, "Generate By ". $this->om->web_me()->nama_website);
        $this->excel->getActiveSheet()->getStyle("z" . $baris)->applyFromArray(
            array(
                'font' => array(
                    'name'         => 'Calibri',
                    'bold'         => false,
                    'italic'    => true,
                    'size'        => 10,
                    'color' => array('rgb' => '1429FC'),
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                    'wrap'       => true
                ) ) );
                    // end of rata kiri kolom B
        $baris++;
        // end of footer
        $filename = "LAPORAN IMUNISASI RUTIN DINAS PERIODE ". $awal. " sd ".$akhir.").xls";

        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0'); //no cache
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');

    }

}
