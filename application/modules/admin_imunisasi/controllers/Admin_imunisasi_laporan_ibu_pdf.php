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
		$jv = "<br>".strtoupper($er->nama_penyakit);
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
		$jdl = "DATA IMUNISASI " .$re." ".strtoupper($this->om->bentuk_admin($id_pkm,"p")) ." ".strtoupper($this->om->identitas_general($id_pkm)->nama_pkm);

	} 
	if ($id_desa != "x") {
		$this->db->where("id_desa",$id_desa);
		$s = $this->db->get("master_desa")->row();

	

		$this->db->where("id_kecamatan", $s->id_kecamatan);
		$as = $this->db->get("master_kecamatan")->row();

		$de = strtoupper("<br>Desa ".$s->desa." Kecamatan ".$as->kecamatan);


	}
	
	?>
	<p align="center" class="judul"><strong><?php echo $jdl.$de." KABUPATEN ".$this->om->web_me()->kabupaten ?><br> TAHUN <?php echo $tahun." BULAN ".strtoupper(getBulan($bulan)).$jv ?></strong></p>

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
				<th width="10%">Nama/<br>No.Imunisasi</th>
				<th width="3%">JK</th>
				<th width="12%">Tempat, Tgl Lahir</th>
				<th width="10%">Waktu Suntik</th>
				<th width="10%">Vaksin Umur</th>
				<th width="10%">Jenis Vaksin</th>
				<th width="12%">Tempat Pelayanan</th>
				<!-- <th width="10%">Pekerjaan Ayah</th> -->
				
				<!-- <th width="10%">Pekerjaan Ibu</th> -->
				<th width="20%">Alamat</th>
				<th width="10%">Nama IBU</th>
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
			<tr>
				<td align="center" width="3%"><?php echo $i ?>.</td>
				<td width="10%" ><?php echo "<strong>".$row->nama."</strong><br>".$row->id_imunisasi ?></td>
				<td width="3%" align="center"><?php echo $row->jk ?></td>
				<td width="12%"><?php echo $row->tempat_lahir.", ".tgl_view($row->tgl_lahir) ?></td>
				<td width="10%" align="center" ><?php echo tgl_view($row->tgl_suntik) ?></td>
				<td width="10%" align="left" ><?php echo $row->vaksin_umur ?></td>
				<?php 
					$this->db->where("id_penyakit",$row->jenis_vaksin);
					$ag = $this->db->get("master_penyakit")->row();
				 ?>
				<td width="10%"><?php echo ucwords(strtolower($ag->nama_penyakit)) ?></td>
				<td width="12%" align="left" ><?php echo $row->tempat_pelayanan ?></td>
				<!-- <td width="10%" align="left" ></td> -->
				<!-- <?php 
					$this->db->where("id_pekerjaan",$row->id_pekerjaan_ayah);
					$ag = $this->db->get("im_pekerjaan")->row();
				 ?>
				<td width="10%"><?php echo ucwords(strtolower($ag->pekerjaan)) ?></td> -->
				
				<!-- <?php 
					$this->db->where("id_pekerjaan",$row->id_pekerjaan_ibu);
					$ag = $this->db->get("im_pekerjaan")->row();
				 ?> -->
				 <?php 
					$this->db->where("id_desa",$row->id_desa);
					$agg = $this->db->get("master_desa")->row();
				 ?>

				  <?php 
					$this->db->where("id_desa",$row->id_desa);
					$as = $this->db->get("master_desa")->row();

					$this->db->where("id_kecamatan", $as->id_kecamatan);
					$as = $this->db->get("master_kecamatan")->row();
				 ?>
				<!-- <td width="10%"><?php echo ucwords(strtolower($ag->pekerjaan)) ?></td> -->
				<td width="20%"><?php echo ucwords(strtolower($row->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($agg->desa))." Kec. ".ucwords(strtolower($as->kecamatan)) ?></td>
				<td width="10%" align="left" ><?php echo $row->nama_ibu ?></td>
				
			</tr>
		<?php endforeach; ?>
	
	</table>
<p></p>
<table width="100%" border="0" cellpadding="0" class="ttd">

	<tr>

		<td width="80%">Mengetahui,</td>
		<td width="40%" align="left">Dicetak <?php echo tgl_indo(date("Y-m-d")) ?></td>
	</tr>
	<tr>

		<td>Kepala <?php echo $this->om->bentuk_admin($id_pkm,"p")." ".$this->om->identitas_general($id_pkm)->nama_pkm ?></td>
		<td align="left">Pengelola Imunisasi,</td>
	</tr>
	<tr>

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

		<td style="font-weight: bold;"><?php echo $this->om->user_general($id_pkm)->pimpinan ?></td>
		<td style="font-weight: bold;"><?php echo $this->om->user_general($id_pkm)->nama_lengkap ?></td>
	</tr>
	<tr>

		<?php if (empty($this->om->user_general($id_pkm)->nip_pimpinan)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($id_pkm)->nip_pimpinan ?></td>
		<?php } ?>
		<?php if (empty($this->om->user_general($id_pkm)->nip_operator_dinas)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($id_pkm)->nip_operator_dinas ?></td>
		<?php } ?>

		<td></td>
	</tr>

</table>
</body>

</html>
