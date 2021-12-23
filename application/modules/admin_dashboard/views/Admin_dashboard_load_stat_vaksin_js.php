<script type="text/javascript">

    Highcharts.chart('tampil_stat', {
        chart: {
            type: 'column'
        },

        title: {
            text: 'Statistik Imunisasi Berdasarkan Jenis Vaksin ',
        },

        subtitle: {
            <?php 
                if ($id_desa <> "x") {
                    $this->db->where("id_desa", $id_desa);
                    $desa = $this->db->get("master_desa")->row();
                    $desa = "Desa ".ucwords(strtolower($desa->desa));
                } else {
                    $desa = "Semua Desa";
                }
                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_pkm",$id_pkm);
                        $pkm = $this->db->get("master_pkm")->row();
                        $pkm = "Puskesmas ".$pkm->nama_pkm;
                    } else {
                        $pkm = "Semua Puskesmas";
                    } 

                } else {
                    $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                    $pkm = $this->db->get("master_pkm")->row();
                    $pkm = "Puskesmas ".$pkm->nama_pkm;
                }
                if ($tahun <> "x") {
                    $thn = "Tahun ".$tahun;
                } else {
                    $thn = "Semua Tahun ";
                }
                if ($bulan <> "x") {
                    $bln = "Bulan ".getBulan($bulan);
                } else {
                    $bln = "Semua Bulan";
                }

            ?>
            text: 'Data Berdasarkan <?php echo $pkm.". ".$desa.". ".$thn.". ".$bln ?>'
        },
        xAxis: {
         categories: [<?php  
            foreach ($vaksin->result() as $row) : 
                echo "'".(($row->nama_penyakit))."',";
            endforeach;
            ?>]
        },



        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} Anak</b>  </td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
        },
        yAxis: {
            title: {
                text: 'Anak'
            }
        },
        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        colors: ['#087EC1','#9400D3','#26B20C'],
        series: [
        {
          name: 'Laki-Laki',
          data: 
          [<?php  
            foreach ($vaksin->result() as $v) :
                if ($id_desa <> "x") {
                    $this->db->where("id_desa", $id_desa);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_pkm",$id_pkm);
                    } 

                } else {
                    $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                }
                $this->db->where("jk","L");
                $this->db->where("jenis_vaksin", $v->id_penyakit);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },
        {
          name: 'Perempuan',
          data: 
          [<?php  
            foreach ($vaksin->result() as $v) :
                if ($id_desa <> "x") {
                    $this->db->where("id_desa", $id_desa);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_pkm",$id_pkm);
                    } 

                } else {
                    $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                }
                $this->db->where("jk","P");
                $this->db->where("jenis_vaksin", $v->id_penyakit);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },

        {
          name: 'Total',
          data: 
          [<?php  
            foreach ($vaksin->result() as $v) :
                if ($id_desa <> "x") {
                    $this->db->where("id_desa", $id_desa);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_pkm",$id_pkm);
                    } 

                } else {
                    $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                }
                $this->db->where("jenis_vaksin", $v->id_penyakit);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },
       
        ]
    },function(chart){
        if(chart.series[0].data.length == 0) 
            swal({   
                 title: "Data tidak ditemukan",   
                 type: "warning", 
                 html: "Data Imunisasi belum ada untuk ditampilkan di Statistik",
                 confirmButtonColor: "#22af47",   
            });
    });

</script>


