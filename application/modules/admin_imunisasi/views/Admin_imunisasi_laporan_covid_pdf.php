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
			background-color: #E7FBCA;
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
			font-size : 11px;
		}

		.ttd {
			/*border: 1px solid #000;*/
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
		}

	</style> 
</head>

<body>
	<?php 
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

	if ($id_pkm != "") {
		$jdl = "DATA IMUNISASI COVID - 19. ".strtoupper($this->om->bentuk_admin($id_pkm,"p")) ." ".strtoupper($this->om->identitas_general($id_pkm)->nama_pkm);

	} 
	
	
	?>
	<p align="center" class="judul"><strong><?php echo $jdl." KABUPATEN ".$this->om->web_me()->kabupaten ?><br> TAHUN <?php echo $tahun." BULAN ".strtoupper(getBulan($bulan)).$jv ?></strong></p>

	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th rowspan="2" width="3%">No.</th>
				<th rowspan="2" width="10%">Nama/<br>NIK</th>
				<th rowspan="2" width="3%">JK</th>
				<th rowspan="2" width="5%">Tgl Lahir</th>
				<th  width="25%" colspan="5">Pekerjaan</th>
				<th rowspan="2" width="5%">Alamat</th>
				<th rowspan="2" width="5%">No. HP</th>
				<th rowspan="2" width="8%">Komorbid</th>
				<th rowspan="2" width="5%">Kepesertaan BPJS</th>
				
				
				<th width="25%" colspan="5">Tempat Pemberian Imunisasi</th>
			</tr>
			<tr>
				<th>Petugas Medis dan Non Medis di Fasilitas Pelayanan Kesehatan</th>
				<th>Petugas pelayanan publik yang berhadapan langsung dengan masyarakat</th>
				<th>Administrator Pemerintahan</th>
				<th>Lainnya</th>
				<th>Tidak Bekerja</th>
				<th>Pusk/Pusk Pembantu </th>
				<th>Puskesmas Keliling/Pelayanan Kesehatan Bergerak</th>
				<th>FKTP Swasta</th>
				<th>RS Pemerintah</th>
				<th>RS Swasta</th>
			</tr>
		</thead>
	
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
				
			$i++; ?>
			<tr>
				<td align="center" width="3%"><?php echo $i ?>.</td>
				<td width="10%" ><?php echo "<strong>".$row->nama."</strong><br>".$row->no_kia ?></td>
				<td width="3%" align="center"><?php echo $row->jk ?></td>
				<td width="5%" align="center"><?php echo tgl_view($row->tgl_lahir) ?></td>
				<td width="5%" align="left" >
					<?php if ($row->id_pekerjaan == "1") {
						$this->db->where("id_pekerjaan", $row->id_detail_pekerjaan);
						$p1 = $this->db->get("im_pekerjaan")->row();
					echo  ucwords(strtolower($p1->pekerjaan));
					}  ?>
					
				</td>
				<td width="5%" align="left" >
					<?php if ($row->id_pekerjaan == "2") {
						$this->db->where("id_pekerjaan", $row->id_detail_pekerjaan);
						$p1 = $this->db->get("im_pekerjaan")->row();
					echo  ucwords(strtolower($p1->pekerjaan));
					}  ?>
					
				</td>
				<td width="5%" align="left" >
					<?php if ($row->id_pekerjaan == "3") {
						$this->db->where("id_pekerjaan", $row->id_detail_pekerjaan);
						$p1 = $this->db->get("im_pekerjaan")->row();
					echo  ucwords(strtolower($p1->pekerjaan));
					}  ?>
					
				</td>
				<td width="5%" align="left" >
					<?php if ($row->id_pekerjaan == "4") {
						$this->db->where("id_pekerjaan", $row->id_detail_pekerjaan);
						$p1 = $this->db->get("im_pekerjaan")->row();
					echo  ucwords(strtolower($p1->pekerjaan));
					}  ?>
					
				</td>
				<td width="5%" align="left" >
					<?php if ($row->id_pekerjaan == "5") {
						$this->db->where("id_pekerjaan", $row->id_detail_pekerjaan);
						$p1 = $this->db->get("im_pekerjaan")->row();
					echo  ucwords(strtolower($p1->pekerjaan));
					}  ?>
					
				</td>
				<td width="5%" align="left" ><?php echo $row->alamat ?></td>
				<td width="5%" align="left" ><?php echo $row->no_hp ?></td>
		
				<td width="5%"><?php 
				if ($row->komorbid == "1") {

					if ($row->diabetes == "1") {
						$dia = "Diabetes, ";
					} 
					if ($row->hipertensi == "1") {
						$hip = "Hipertensi, ";
					}
					if ($row->jantung == "1") {
						$jan = "Penyakit Jantung, ";
					}
					if ($row->paru == "1") {
						$paru = "Penyakit Paru Kronis, ";
					}
					if ($row->ginjal == "1") {
						$gin = "Penyakit Ginjal, ";
					}
					if ($row->lainnya == "1") {
						$lainnya = "Lainnya, ";
					}
					$ko = $dia.$hip.$jan.$paru.$gin.$lainnya;
					$ko1 = substr($ko, -100,-2);
				} else {
					$ko1 = "Tidak ada";
				}
				echo $ko1;
				 ?></td>
				<td width="5%" align="left" ><?php 

				if ($row->bpjs == "1") {
					$bp = "BPJS PBI";
				} elseif ($row->bpjs == "2") {
					$bp = "BPJS NON PBI";
				} elseif ($row->bpjs == "3") {
					$bp = "NON ANGGOTA";
				}
				echo $bp;
				?></td>
				 
				<td width="5%"><?php 
					if ($row->tempat_imunisasi == "1"){
						echo $row->tempat_pelayanan;
					} 
		 		?></td>
		 		<td width="5%"><?php 
					if ($row->tempat_imunisasi == "2"){
						echo $row->tempat_pelayanan;
					} 
		 		?></td>
		 		<td width="5%"><?php 
					if ($row->tempat_imunisasi == "3"){
						echo $row->tempat_pelayanan;
					} 
		 		?></td>
		 		<td width="5%"><?php 
					if ($row->tempat_imunisasi == "4"){
						echo $row->tempat_pelayanan;
					} 
		 		?></td>
		 		<td width="5%"><?php 
					if ($row->tempat_imunisasi == "5"){
						echo $row->tempat_pelayanan;
					} 
		 		?></td>
				<!-- <td width="20%"><?php echo ucwords(strtolower($row->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($agg->desa))." Kec. ".ucwords(strtolower($as->kecamatan)) ?></td> -->
				
				
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
