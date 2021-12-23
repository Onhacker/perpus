<html>
<head>

	<title>
		<?php echo $title ?>
	</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/admin/img/favicon.ico') ?>">
	<style>
	
		.judul {
			font-size:12px;
			font-weight:bold;
		}
		
		

		.tabel {
			border-collapse: collapse;
			border-spacing: 0px;
		}

		.tabel th {
			border: 0.2px solid #000;
			/*padding: 2px;*/
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
			text-align: center;
			font-weight: bold;
			background-color: #D7EDFB;
		}


		.head th {
			/*border: 1px solid #000;*/
			/*padding: 2px;*/
			font-family: "Times New Roman", Times, serif; 
			font-size : 10px;
			text-align: left;
			font-weight: bold;
		}



		.tabel td {
			border: 0.2px solid #000;
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 10px;
		}

		.ttd {
			/*border: 1px solid #000;*/
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 10px;
		}
		

	</style> 
</head>

<body>
	<?php
		$jdl = "LAPORAN IMUNISASI RUTIN COVID-19 DINAS KESEHATAN";
	?>
	<p align="center" class="judul"><strong><?php echo $jdl ?></strong></p>

	<table width="100%" class="head">
		<tr>
			<th width="15%">KABUPATEN</th>
			<th width="2%">:</th>
			<th width="60%"><?php echo $this->om->web_me()->kabupaten ?></th>
		
			<th width="10%">Bulan</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo getBulan($bulan) ?></th>
		</tr>
		<tr>
			<th width="15%">PROVINSI</th>
			<th width="2%">:</th>
			<th width="60%"><?php echo $this->om->web_me()->propinsi ?></th>
		
			<th width="10%">Tahun</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $tahun ?></th>
		</tr>
	</table>


	<br><br>
	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th style="font-size: 8px" width="5%">NO</th>
				<th style="font-size: 8px" width="50%">PUSKESMAS</th>
				<th style="font-size: 8px" width="14%" >L</th>
				<th style="font-size: 8px" width="14%" >P</th>
				<th style="font-size: 8px" width="15%" >JUMLAH</th>
			</tr>
			
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
			<tr>
				<td align="center" width="5%"><?php echo $i ?>.</td>
				<td width="50%" ><?php echo ucwords(strtolower($row->nama_pkm)) ?></td>
				<!-- HB0 (< 24 JAM) -->
				<?php
					// HB0 (< 24 JAM) L
					$this->db->where(array("id_pkm" => $row->id_pkm, "tahun" => $tahun, "bulan" => $bulan, "jk" => "L")); 
					$hbl = $this->db->get("imunisasi_covid");
					// HB0 (< 24 JAM) P
					$this->db->where(array("id_pkm" => $row->id_pkm, "tahun" => $tahun, "bulan" => $bulan, "jk" => "P")); 
					$hbp = $this->db->get("imunisasi_covid");
				?>
				<td width="14%" align="center"><?php echo uang($hbl->num_rows()) ?></td>
				<td width="14%" align="center"><?php echo uang($hbp->num_rows()) ?></td>
				<td width="15%" align="center"><?php echo uang($hbl->num_rows() + $hbp->num_rows()) ?></td>
				<!-- END OF  HB0 (< 24 JAM) -->

			
			</tr>
		<?php endforeach; ?>
			<tr>
				
				<td width="55%" align="center" rowspan="2" colspan="2" >JUMLAH</td>
			
				<!-- HB0 (< 24 JAM) -->
				<?php
					// HB0 (< 24 JAM) L
					$this->db->where(array("tahun" => $tahun, "bulan" => $bulan, "jk" => "L")); 
					$hbl = $this->db->get("imunisasi_covid");
					// HB0 (< 24 JAM) P
					$this->db->where(array("tahun" => $tahun, "bulan" => $bulan,"jk" => "P")); 
					$hbp = $this->db->get("imunisasi_covid");
				?>
				<td width="14%" align="center"><?php echo uang($hbl->num_rows()) ?></td>
				<td width="14%" align="center"><?php echo uang($hbp->num_rows()) ?></td>
				<td width="15%" align="center"><?php echo uang($hbl->num_rows() + $hbp->num_rows()) ?></td>
				<!-- END OF  HB0 (< 24 JAM) -->

			</tr>
	</table>
<p></p>
<table width="100%" border="0" cellpadding="0" class="ttd">
  <?php if ($ttd == "kadis") {?> 
  	<tr>
  		<td width="70%">Mengetahui,</td>
  		<td width="50%" align="left"><?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>
  <?php } elseif ($ttd == "kasi") { ?>
  	<tr>
  		<td width="70%">An. Kepala Dinas Kesehatan</td>
  		<td width="50%" align="left"><?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>


<?php } elseif ($ttd == "kabid") { ?>
  	<tr>
  		<td width="70%">Mengetahui,</td>
  		<td width="50%" align="left"><?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>
 <?php  } ?>
 
  
  <tr>
    <!-- <td></td> -->
    <td></td>
    <td align="left">&nbsp;</td>
    
  </tr>
  <tr>
    
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
   
    <td></td>
    <td></td>
  </tr>
   <tr>
  
    <td></td>
    <td></td>
  </tr>
   <tr>
   
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td><?php echo $ttd_nama ?></td>
    <td><?php echo $this->om->user()->nama_lengkap ?></td>
  </tr>
  <tr>
    <?php if (empty($ttd_nip)) {?>
    	<td></td>
    <?php } else {?>
    	<td>NIP.<?php echo $ttd_nip ?></td>
    <?php } ?>
    <?php if (empty($this->om->user()->nip_operator_dinas)) {?>
    	<td></td>
    <?php } else {?>
    	<td>NIP.<?php echo $this->om->user()->nip_operator_dinas ?></td>
    <?php } ?>
  </tr>
 
</table>
</body>

</html>
