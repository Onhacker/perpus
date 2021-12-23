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
			border: 1px solid #000;
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
			text-align: center;
			font-weight: bold;
		}


		.head th {
			/*border: 1px solid #000;*/
			/*padding: 2px;*/
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
			text-align: left;
			font-weight: bold;
		}



		.tabel td {
			border: 1px solid #000;
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

	if ($id_pkm != "") {
		$jdl = "DATA IMUNISASI LUAR WILAYAH<br>" .$re." ".strtoupper($this->om->bentuk_admin($id_pkm,"p")) ." ".strtoupper($this->om->identitas_general($id_pkm)->nama_pkm);

	} 
	
	
	?>
	<p align="center" class="judul"><strong><?php echo $jdl." KABUPATEN ".$this->om->web_me()->kabupaten ?> TAHUN <?php echo $tahun." BULAN ".strtoupper(getBulan($bulan)).$jv ?></strong></p>

	<table width="100%" class="head">
		<?php if ($jum_l > 0) {?>
		
		<tr>
			<th width="10%">Laki-Laki</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $jum_l ?></th>
			
			
		</tr>
		<?php } ?>
		<?php if ($jum_p > 0) {?>
		<tr>
			<th width="10%">Perempuan</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $jum_p ?></th>
		
		</tr>
		<?php } ?>
		<tr>
			<th width="10%">Total</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $jum_p+$jum_l ?></th>
		
			
		</tr>
	</table>


	<br><br>
	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th width="3%">No.</th>
				<th width="15%">Nama/<br>No.Imunisasi</th>
				<th width="3%">JK</th>
				<th width="8%">Tgl Lahir</th>
				<th width="10%">Nama Orang Tua</th>
				<th width="10%">Waktu Suntik</th>
				<th width="10%">Vaksin Umur</th>
				<th width="10%">Jenis Vaksin</th>
				<th width="12%">Tempat Pelayanan</th>
				<th width="20%">Alamat</th>
				
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
			<tr>
				<td align="center" width="3%"><?php echo $i ?>.</td>
				<td width="15%" ><?php echo "<strong>".ucwords(strtolower($row->nama))."</strong><br>".$row->id_imunisasi ?></td>
				<td width="3%" align="center"><?php echo $row->jk ?></td>
				<td width="8%" align="center"><?php echo tgl_view($row->tgl_lahir) ?></td>
				<td width="10%" align="left" ><?php echo ucwords(strtolower($row->nama_ibu)) ?></td>
				<td width="10%" align="center" ><?php echo tgl_view($row->tgl_suntik) ?></td>
				<td width="10%" align="left" ><?php echo $row->vaksin_umur ?></td>
				<?php 
					$this->db->where("id_penyakit",$row->jenis_vaksin);
					$ag = $this->db->get("master_penyakit")->row();
				 ?>
				<td width="10%"><?php echo (($ag->nama_penyakit)) ?></td>
				<td width="12%" align="left" ><?php echo ucwords(strtolower($row->tempat_pelayanan)) ?></td>
				
				<td width="20%"><?php echo ucwords(strtolower($row->alamat))  ?> </td>
				
				
			</tr>
		<?php endforeach; ?>
	
	</table>
<p></p>
<?php $this->load->view("ttd_pkm") ?>
</body>

</html>
