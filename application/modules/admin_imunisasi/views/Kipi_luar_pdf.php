<html>
<head>

	<title>
		<?php echo $title ?>
	</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/admin/img/favicon.ico') ?>">
	<style>
	
		.judul {
			font-size:11px;
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
			font-size : 9px;
			text-align: center;
			font-weight: bold;
		}


		.head th {
			/*border: 1px solid #000;*/
			/*padding: 2px;*/
			font-family: "Times New Roman", Times, serif; 
			font-size : 9px;
			text-align: left;
			font-weight: bold;
		}



		.tabel td {
			border: 1px solid #000;
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 9px;
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
		$jdl = "LAPORAN KEJADIAN IKUTAN PASCA IMUNISASI (KIPI) LUAR WILAYAH<br>" .$re." ".strtoupper($this->om->bentuk_admin($id_pkm,"p")) ." ".strtoupper($this->om->identitas_general($id_pkm)->nama_pkm);

	} 
	if ($id_desa != "x") {
		$this->db->where("id_desa",$id_desa);
		$s = $this->db->get("master_desa")->row();

	

		$this->db->where("id_kecamatan", $s->id_kecamatan);
		$as = $this->db->get("master_kecamatan")->row();

		$de = strtoupper("<br>Desa ".$s->desa." Kecamatan ".$as->kecamatan);


	}
	
	?>
	<p align="center" class="judul"><strong><?php echo $jdl. " KABUPATEN ".$this->om->web_me()->kabupaten ?><br> TAHUN <?php echo $tahun." BULAN ".strtoupper(getBulan($bulan)) ?></strong></p>

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
				<th width="3%" rowspan="2">No.</th>
				<th colspan="6" width="39%">Identitas</th>
				<th rowspan="2" width="8%">Jenis Vaksin 1<br>No Batch / Exp Date Vaksin 1</th>
				<th rowspan="2" width="8%">Jenis Vaksin 2<br>No Batch / Exp Date Vaksin 2</th>
				<th rowspan="2" width="7%">Pemberi Imunisasi</th>
				<th rowspan="2" width="7%">Tempat Pelayanan</th>
				<th rowspan="2" width="6%">Tgl Imunisasi</th>
				<th colspan="5" width="22.5%">Gejala Yang Dialami</th>
			</tr>
			<tr>
				
				<th width="8%">Nama Anak</th>
				<th width="3%">JK</th>
				<th width="7%">Tmp, Tgl Lahir</th>
				
				<th width="4%">Umur</th>
				<th width="7%">Nama Orang Tua</th>
				<th width="10%">Alamat</th>
				
				<th width="4.5%" style="font-size: 8px">Demam</th>
				<th width="4.5%" style="font-size: 8px">Bengkak</th>
				<th width="4.5%" style="font-size: 8px">Merah</th>
				<th width="4.5%" style="font-size: 8px">Muntah</th>
				<th width="4.5%" style="font-size: 8px">Lainnya</th>
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
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
			<tr>
				<td align="center" width="3%"><?php echo $i ?>.</td>
				<td width="8%" ><?php echo "<strong>".ucwords(strtolower($row->nama))."</strong>" ?></td>
				<td width="3%" align="center"><?php echo $row->jk ?></td>
				<td width="7%"><?php echo ucwords(strtolower($row->tempat_lahir)).", ".tgl_view($row->tgl_lahir) ?></td>
				
				<td width="4%" align="left" ><?php echo umur_bulan($row->tgl_lahir) ?></td>
				<td width="7%" align="left" ><?php echo ucwords(strtolower($row->nama_ibu)) ?></td>
				<td width="10%"><?php echo ucwords(strtolower($row->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($agg->desa))." Kec. ".ucwords(strtolower($as->kecamatan)) ?></td>
				<?php 
					$this->db->where("id_penyakit",$row->jenis_vaksin_1);
					$ag = $this->db->get("master_penyakit")->row();
					$this->db->where("id_penyakit",$row->jenis_vaksin_2);
					$ad = $this->db->get("master_penyakit")->row();
				 ?>
				<td width="8%"><?php echo $ag->nama_penyakit."<br>".$row->no_vaksin_1 ?></td>
				<td width="8%"><?php echo $ad->nama_penyakit."<br>".$row->no_vaksin_2 ?></td>
				<td width="7%" align="left" ><?php echo ucwords(strtolower($row->pemberi_imunisasi)) ?></td>
				<td width="7%" align="left" ><?php echo ucwords(strtolower($row->tempat_pelayanan)) ?></td>

				<td width="6%" align="center" ><?php echo tgl_view($row->tgl_suntik) ?></td>
				<?php 

				if ($row->demam == "Y") {
					$ge1 = "Ya";
				} else {
					$ge1 = "Tidak";
				}
				if ($row->bengkak == "Y") {
					$ge2 = "Ya";
				} else {
					$ge2 = "Tidak";
				}
				if ($row->merah == "Y") {
					$ge3 = "Ya";
				} else {
					$ge3 = "Tidak";
				}
				if ($row->muntah == "Y") {
					$ge4 = "Ya";
				} else {
					$ge4 = "Tidak";
				}
				

				?>
				<td width="4.5%"  align="center"><?php echo $ge1 ?></td>
				<td width="4.5%"  align="center"><?php echo $ge2 ?></td>
				<td width="4.5%"  align="center"><?php echo $ge3 ?></td>
				<td width="4.5%"  align="center"><?php echo $ge4 ?></td>
				<td width="4.5%"  align="center"><?php echo $row->lainnya ?></td>
				
				
				
				
			</tr>
		<?php endforeach; ?>
	
	</table>
<p></p>
<?php $this->load->view("ttd_pkm") ?>
</body>

</html>
