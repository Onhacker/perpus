<html>
<head>
	<title>
		Laporan
	</title>
	<style>
		* {
			font-size:12px;
		}
		.judul {
			font-size:14px;
			font-weight:bold;
			text-align: center;
		}
		
		
		
.tabel {
	border-collapse: collapse;
	border-spacing: 0px;
}

.tabel th, .tabel td {
	border: 0px solid #000;
	padding: 2px;
	font-family: "Times New Roman", Times, serif; 
}

.tabel th {
	text-align: center;
}

.foot {
	font-size: 10px !important;
}



</style> 
</head>
<?php 
	$desa = $this->om->identitas_general_l_a($res->id_pkm)->bentuk;
	if ($this->session->userdata("admin_level") == "admin") {
		$yi = $this->om->identitas_general_l_a($res->id_pkm);
		$xi = $this->om->user_general($res->id_pkm);
	} else {
		$yi = $this->om->identitas_general_l_a($this->session->userdata("admin_pkm"));
		$xi = $this->om->user();
	}
	if ($yi->bentuk == "1") {
		$er = strtoupper($this->om->bentuk_admin($res->id_pkm,"p"));
	} else {
		$er = "RUMAH SAKIT";
	}
?>
<body>
	<img style="width: 50px;" src="<?php echo $savename;?>">
	<p  class="judul"><strong>TANDA BUKTI IMUNISASI COVID-19<br><?php echo strtoupper($this->om->bentuk_admin($res->id_pkm,"p"))." ".strtoupper($this->om->identitas_general($res->id_pkm)->nama_pkm)." KABUPATEN ".$this->om->web_me()->kabupaten ?><br> Bulan <?php echo getBulan($res->bulan)." Tahun ".($res->tahun) ?></strong></p>
	<hr>
	<p></p>
	<table width="100%" cellspacing="4">
		<tr>
			<td colspan="3"><strong>Data Imunisasi</strong></td>
		</tr>
		
		<tr>
			<td width="35%">No. Imunisasi</td>
			<td width="2%">:</td>
			<td width="63%"><?php echo $res->id_imunisasi_covid  ?></td>
		</tr>
		<tr>
			<td >Tahun/ Bulan</td>
			<td >:</td>
			<td ><?php echo $res->tahun."/ ".getBulan($res->bulan)  ?></td>
		</tr>
		<tr>
			<td >Waktu Vaksin</td>
			<td >:</td>
			<td ><?php echo hari_ini($res->tgl_suntik).", ".tgl_indo($res->tgl_suntik)  ?></td>
		</tr>
		<tr>
			<td >Divaksin Pada Umur</td>
			<td >:</td>
			<td ><?php echo $res->vaksin_umur  ?></td>
		</tr>
		<tr>
			<td >Jenis Vaksin</td>
			<td >:</td>
			<td >COVID - 19</td>
		</tr>
		<?php 
		if ($res->komorbid == "1") {
			
			if ($res->diabetes == "1") {
				$dia = "Diabetes, ";
			} 
			if ($res->hipertensi == "1") {
				$hip = "Hipertensi, ";
			}
			if ($res->jantung == "1") {
				$jan = "Penyakit Jantung, ";
			}
			if ($res->paru == "1") {
				$paru = "Penyakit Paru Kronis, ";
			}
			if ($res->ginjal == "1") {
				$gin = "Penyakit Ginjal, ";
			}
			if ($res->lainnya == "1") {
				$lainnya = "Lainnya, ";
			}
			$ko = $dia.$hip.$jan.$paru.$gin.$lainnya;
			$ko1 = substr($ko, -100,-2);
		} else {
			$ko1 = "Tidak ada";
		}

		if ($res->bpjs == "1") {
			$bp = "BPJS PBI";
		} elseif ($res->bpjs == "2") {
			$bp = "BPJS NON PBI";
		} elseif ($res->bpjs == "3") {
			$bp = "NON ANGGOTA";
		}
		if ($res->tempat_imunisasi == "1"){
			$ti = "Pusk/Pusk Pembantu";
		} elseif ($res->tempat_imunisasi == "2"){
			$ti = "Puskesmas Keliling/Pelayanan Kesehatan Bergerak";
		} elseif ($res->tempat_imunisasi == "3"){
			$ti = "FKTP Swasta";
		} elseif ($res->tempat_imunisasi == "4"){
			$ti = "RS Pemerintah";
		} elseif ($res->tempat_imunisasi == "5"){
			$ti = "RS Swasta";
		}

		if ($res->id_pekerjaan == "1") {
			$pek =  "Petugas Medis dan Non Medis di Fasilitas Pelayanan Kesehatan";
		} elseif ($res->id_pekerjaan == "2") {
			$pek =  "Petugas pelayanan publik yang berhadapan langsung dengan masyarakat";
		} elseif ($res->id_pekerjaan == "3") {
			$pek = "Administrator Pemerintahan";
		} elseif ($res->id_pekerjaan == "4") {
			$pek = "Lainnya";
		} elseif ($res->id_pekerjaan == "5") {
			$pek = "Tidak Bekerja";
		} 
		?>
		<tr>
			<td >Komorbid</td>
			<td >:</td>
			<td ><?php echo $ko1 ?></td>
		</tr>
		<tr>
			<td >Kepesertaan BPJS</td>
			<td >:</td>
			<td ><?php echo $bp ?></td>
		</tr>
		<tr>
			<td >Tempat Pemberian Imunisasi</td>
			<td >:</td>
			<td ><?php echo $ti ?></td>
		</tr>
		<tr>
			<td >Nama Tempat Pelayanan</td>
			<td >:</td>
			<td ><?php echo $res->tempat_pelayanan  ?></td>
		</tr>
		<tr>
			<td colspan="3"><strong></strong></td>
		</tr>

		<tr>
			<td colspan="3"><strong>Data Sasaran</strong></td>
		</tr>
	
		<tr>
			<td width="35%">NIK</td>
			<td width="2%">:</td>
			<td width="63%"><?php echo $res->no_kia  ?></td>
		</tr>
		<tr>
			<td >Nama</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama))  ?></td>
		</tr>
		
		<tr>
			<td >Jenis Kelamin</td>
			<td >:</td>
			<td ><?php  if ($res->jk == "L") {
				echo "Laki-Laki";
			} else {
				echo "Perempuan";
			}  ?></td>
		</tr>
		<!-- <tr>
			<td >Tempat, Tanggal Lahir</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->tempat_lahir)).", ".tgl_indo($res->tgl_lahir)  ?></td>
		</tr> -->
		<tr>
			<td >Tanggal Lahir</td>
			<td >:</td>
			<td ><?php echo tgl_indo($res->tgl_lahir)  ?></td>
		</tr>
		<tr>
			<td >Pekerjaan</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($pek))  ?></td>
		</tr>
		<tr>
			<td >Detail Pekerjaan</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($id_detail_pekerjaan))  ?></td>
		</tr>
		<tr>
			<td >Alamat</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->alamat))?></td>
		</tr>
		<tr>
			<td >No. HP</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->no_hp))?></td>
		</tr>
	</table>
		

		<!-- <table width="100%" >
		<tr>
			<td colspan="3"><strong></strong></td>
		</tr> -->
		
		<!-- <tr>
			<td></td>
			<td></td>
			<td align="right" ><i class="foot">Dicetak Tanggal <?php echo tgl_indo(date("Y-m-d")); ?></i></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td align="right" ><i class="foot">Data Tahun <?php echo $res->tahun; ?></i></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td align="right" ><i class="foot">Oleh <?php echo $er ?> <?php echo strtoupper($yi->nama_pkm) ?></i></td>
		</tr> -->
		
	<!-- </table> -->
	<p></p>
	<p></p>
	<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">

	<tr>

		<td width="70%">Mengetahui,</td>
		<td width="40%" align="left"><?php echo tgl_indo(date($res->create_date)) ?></td>
	</tr>
	<tr>

		<td>Kepala <?php echo $this->om->bentuk_admin($res->id_pkm,"p")." ".$this->om->identitas_general($res->id_pkm)->nama_pkm ?></td>
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

		<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_pkm)->pimpinan ?></td>
		<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_pkm)->nama_lengkap ?></td>
	</tr>
	<tr>

		<?php if (empty($this->om->user_general($res->id_pkm)->nip_pimpinan)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($res->id_pkm)->nip_pimpinan ?></td>
		<?php } ?>
		<?php if (empty($this->om->user_general($res->id_pkm)->nip_operator_dinas)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($res->id_pkm)->nip_operator_dinas ?></td>
		<?php } ?>

		<td></td>
	</tr>

</table>

</body>

</html>