<?php 
class M_admin_dashboard extends CI_model{
    function grafik_kunjungan(){
        return $this->db->query("SELECT count(*) as jumlah, tanggal FROM statistik GROUP BY tanggal ORDER BY tanggal DESC LIMIT 14");
    }

    function arr_pkm(){
        $this->db->order_by("bentuk", "ASC");
        $this->db->order_by("nama_pkm", "ASC");
        $res = $this->db->get("master_pkm");
        $arr["x"]  = "== Semua PKM == ";
        foreach($res->result() as $row) :
            $arr[$row->id_pkm]  = $this->om->bentuk($row->bentuk)." ".$row->nama_pkm;
        endforeach;
        return $arr;
    }

    function arr_tahun(){
        $this->db->group_by("tahun");
        $res = $this->db->get("imunisasi");
        $arr["x"]  = "== Semua Tahun == ";
        foreach($res->result() as $row) :
            $arr[$row->tahun]  = $row->tahun;
        endforeach;
        return $arr;
    }

    function arr_bulan(){
        $this->db->order_by("bulan", "DESC");
        $this->db->group_by("bulan");
        $res = $this->db->get("imunisasi");
        $arr["x"]  = "== Semua Bulan == ";
        foreach($res->result() as $row) :
            $arr[$row->bulan]  = getBulan($row->bulan);
        endforeach;
        return $arr;
    }

    function arr_desa2($id=""){
        if ($this->session->userdata("admin_level") == "admin") {
            $this->db->where("id_pkm",$id);
        } else {
            $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
        }
        
        $this->db->order_by("desa", "ASC");
        $res = $this->db->get("master_desa");
        $arr["x"]  = "== Semua Desa == ";
        foreach($res->result() as $row) :
            $arr[$row->id_desa]  = $row->desa;
        endforeach;
        return $arr;
    }

    function arr_vaksin_formx(){
        $this->db->order_by("urutan", "ASC");
        $res = $this->db->get("master_penyakit");
        $arr["x"]  = "== Semua Vaksin == ";
        foreach($res->result() as $row) :
            $arr[$row->id_penyakit]  = $row->nama_penyakit;
        endforeach;
        $arr["9999"]  = "IDL IPV";
        $arr["8888"]  = "IDL NON-IPV";
        return $arr;
    }

    function arr_vaksin(){
        $this->db->order_by("urutan", "ASC");
        $res = $this->db->get("master_penyakit");
        $arr["x"]  = "== Semua Vaksin == ";
        foreach($res->result() as $row) :
            $arr[$row->id_penyakit]  = $row->nama_penyakit;
        endforeach;
        return $arr;
    }

    function arr_minggu_ke(){
        $a = $this->om->web_me()->tahun_awal;
        $b = $this->om->web_me()->tahun_akhir;
        $this->db->order_by("minggu_ke", "DESC");
        $this->db->where("tahap_survey",$a.$b);
        $res = $this->db->get("kalender");
        $arr["x"]  = "== Pilih Minggu Ke == ";
        foreach($res->result() as $row) :
            $arr[$row->minggu_ke]  = "Minggu ke - ".$row->minggu_ke." (".tgl_view($row->periode_awal)." s/d ".tgl_view($row->periode_akhir).")";
        endforeach;
        return $arr;
    }

}