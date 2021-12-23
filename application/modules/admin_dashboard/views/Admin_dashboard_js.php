<script src="<?php echo base_url("assets/admin") ?>/chart/highcharts.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/exporting.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/export-data.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/chart/accessibility.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		// $("#btn-loader").hide();
	});

	

    Highcharts.chart('tren_new', {
        chart: {
            type: 'line',
        },
        credits: {
            text: '<?php echo $credits[0] ?>',
            href: '<?php echo $credits[1] ?>'
        },
        title: {
            text: 'Trend Pengunjung',
        },

        subtitle: {
            text: 'Trend Pengunjung Harian Web '
        },
        xAxis: {
         categories: [<?php  
            foreach ($grafik->result() as $row) : 
                echo "'".tgl_view($row->tanggal)."',";
            endforeach;
            ?>],
            reversed: true
        },

        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} Orang</b>  </td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        yAxis: {
            title: {
                text: 'Jumlah'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        colors: ['#28a745', '#e2a03f', '#e7515a'],
        series: [{
          name: 'Pengunjung',
          data: [<?php  foreach ($grafik->result() as $row) : 
            echo ($row->jumlah).",";
            endforeach; ?>]
        }]
    });

</script>