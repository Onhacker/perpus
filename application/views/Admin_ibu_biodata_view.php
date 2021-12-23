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
	if ($this->session->userdata("admin_login") == true) {
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
	} else {
		$desa = $this->fm->identitas_general_l_a($res->id_pkm)->bentuk;
		if ($this->session->userdata("admin_level") == "admin") {
			$yi = $this->fm->identitas_general_l_a($res->id_pkm);
			$xi = $this->fm->user_general($res->id_pkm);
		} else {
			$yi = $this->fm->identitas_general_l_a($res->id_pkm);
			$xi = $this->fm->user();
		}
		if ($yi->bentuk == "1") {
			$er = strtoupper($this->fm->bentuk_admin($res->id_pkm,"p"));
		} else {
			$er = "RUMAH SAKIT";
		}
	}
?>
<body>
	<?php $this->load->view("kop") ?>
	<hr>
	<p  class="judul"><strong>KARTU IMUNISASI RUTIN IBU HAMIL <br><?php echo strtoupper($res->nama) ?></strong></p>
	
	<table width="100%" cellspacing="4">
		<!-- <tr>
			<td colspan="3"><strong>Data</strong></td>
		</tr> -->
		<tr>
			<td width="30%">NIK</td>
			<td width="2%">:</td>
			<td width="68%"><?php echo $res->no_kia  ?></td>
		</tr>
		<tr>
			<td width="30%">Tanggal Registrasi</td>
			<td width="2%">:</td>
			<td width="68%"><?php echo tgl_indo($res->create_date)  ?></td>
		</tr>
		<tr>
			<td >Nama</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama))  ?></td>
		</tr>
		
		<tr>
			<td >Tempat, Tanggal Lahir</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->tempat_lahir)).", ".tgl_indo($res->tgl_lahir)  ?></td>
		</tr>
		
		<tr>
			<td >Golongan Darah</td>
			<td >:</td>
			<td ><?php echo ($res->golda)  ?></td>
		</tr>
		<tr>
			<td >Pekerjaan Ibu</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($pekerjaan_ibu))  ?></td>
		</tr>
		<tr>
			<td >Alamat</td>
			<td >:</td>
			<?php if ($this->session->userdata("admin_login") == true) { ?>
			<td ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($res->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->om->web_me()->kabupaten)) ?></td>
			<?php } else { ?>
				<td ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($res->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->fm->web_me()->kabupaten)) ?></td>
			<?php } ?>
		</tr>
		

<p></p>
	<?php if ($this->session->userdata("admin_login") == true) { ?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">
	<tr>

		<td width="60%"></td>
		<td width="40%" align="left">
			<?php echo ($this->om->identitas_general($res->id_pkm)->nama_pkm)  ?>,
			<?php echo tgl_indo($res->create_date) ?></td>
		</tr>
		<tr>

			<td></td>
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
			<td style="font-weight: bold;"></td>
			<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_pkm)->nama_lengkap ?></td>
		</tr>
		<tr>
			<td></td>
			<?php if (empty($this->om->user_general($res->id_pkm)->nip_operator_dinas)) {?>
				<td></td>
			<?php } else {?>
				<td>NIP. <?php echo $this->om->user_general($res->id_pkm)->nip_operator_dinas ?></td>
			<?php } ?>
			
		</tr>
</table>
<?php } else { ?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">
	<tr>

		<td width="60%"></td>
		<td width="40%" align="left">
			<?php echo ($this->fm->identitas_general($res->id_pkm)->nama_pkm)  ?>,
			<?php echo tgl_indo($res->create_date) ?></td>
		</tr>
		<tr>

			<td></td>
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
			<td style="font-weight: bold;"></td>
			<td style="font-weight: bold;"><?php echo $this->fm->user_general($res->id_pkm)->nama_lengkap ?></td>
		</tr>
		<tr>
			<td></td>
			<?php if (empty($this->fm->user_general($res->id_pkm)->nip_operator_dinas)) {?>
				<td></td>
			<?php } else {?>
				<td>NIP. <?php echo $this->fm->user_general($res->id_pkm)->nip_operator_dinas ?></td>
			<?php } ?>
			
		</tr>
</table>
<?php } ?>
<img style="width: 80px;" src="<?php echo $savename;?>">
<p></p>
<p></p>
<p style="color: red; font-size: 10px"><i>Catatan : Harap membawa kartu ini saat imunisasi</i></p>
</body>

</html>