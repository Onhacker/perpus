<script type="text/javascript">

    Highcharts.chart('tampil_stat', {
        chart: {
            type: 'line'
        },

        title: {
            text: 'Trend Imunisasi Berdasarkan Bulan ',
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
                if ($jenis_vaksin <> "x") {
                    $this->db->where("id_penyakit", $jenis_vaksin);
                    $nama_penyakit = $this->db->get("master_penyakit")->row();
                    $nama_penyakit = "Vaksin ".(($nama_penyakit->nama_penyakit));
                } else {
                    $nama_penyakit = "Semua Vaksin";
                }

            ?>
            text: 'Data Berdasarkan <?php echo $pkm.". ".$desa.". ".$thn.". ".$nama_penyakit ?>'
        },
        xAxis: {
         categories: [<?php  
            for ($i=1; $i <= 12 ; $i++) { 
                echo "'".(getBulan($i))."',";
            }
            // foreach ($trend_bulan->result() as $row) : 
            //     echo "'".(getBulan($row->bulan))."',";
            // endforeach;
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
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            },
            // series: {
            //     label: {
            //         connectorAllowed: false
            //     }
            // }
        },
        colors: ['#087EC1','#9400D3','#26B20C'],
        series: [
        {
          name: 'Laki-Laki',
          data: 
          [<?php  

            for ($i=1; $i <= 12 ; $i++) { 
                if ($id_desa <> "x") {
                    $this->db->where("id_desa", $id_desa);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($jenis_vaksin <> "x") {
                    $this->db->where('jenis_vaksin',$jenis_vaksin);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_pkm",$id_pkm);
                    } 

                } else {
                    $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                }
                $this->db->where("jk","L");
                $this->db->where("month(tgl_suntik)", $i);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            }; ?>]
        },
        {
          name: 'Perempuan',
          data: 
          [<?php  
            for ($i=1; $i <= 12 ; $i++) { 
                if ($id_desa <> "x") {
                    $this->db->where("id_desa", $id_desa);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($jenis_vaksin <> "x") {
                    $this->db->where('jenis_vaksin',$jenis_vaksin);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_pkm",$id_pkm);
                    } 

                } else {
                    $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                }
                $this->db->where("jk","P");
                $this->db->where("month(tgl_suntik)", $i);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            }; ?>]
        },

        {
          name: 'Total',
          data: 
          [<?php  
            for ($i=1; $i <= 12 ; $i++) { 
                if ($id_desa <> "x") {
                    $this->db->where("id_desa", $id_desa);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($jenis_vaksin <> "x") {
                    $this->db->where('jenis_vaksin',$jenis_vaksin);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_pkm <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_pkm",$id_pkm);
                    } 

                } else {
                    $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
                }
                $this->db->where("month(tgl_suntik)", $i);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            }; ?>]
        },
       
        ],

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


