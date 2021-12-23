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

		.judulz {
			font-size:12px;
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
	<p  class="judulz"><strong>TANDA BUKTI VAKSIN </strong></p>

	<table width="100%" cellspacing="4">
		<tr>
			<td colspan="3"><strong>Data Imunisasi</strong></td>
		</tr>
		
		<tr>
			<td width="30%">No. Imunisasi</td>
			<td width="2%">:</td>
			<td width="68%"><?php echo $res->id_imunisasi  ?></td>
		</tr>
		<tr>
			<td >Tahun/ Bulan</td>
			<td >:</td>
			<td ><?php echo tahun_view(tgl_view($res->tgl_suntik))."/ ".bulan_view_only((($res->tgl_suntik)))  ?></td>
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
			<td ><?php echo $jenis_vaksinx  ?></td>
		</tr>
		<tr>
			<td >Vaksin Berikutnya</td>
			<td >:</td>
			<td ><?php echo str_replace("<br>", "<br>Jenis Vaksin ", imun_berikut($res->jenis_vaksin,$res->tgl_lahir));  ?></td>
		</tr>
		<tr>
			<td >Pemberi Imunisasi</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->pemberi_imunisasi))  ?></td>
		</tr>
		<tr>
			<td >Tempat Pelayanan</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->tempat_pelayanan))  ?></td>
		</tr>
		<tr>
			<td colspan="3"><strong></strong></td>
		</tr>

		<tr>
			<td colspan="3"><strong>Data Anak</strong></td>
		</tr>
	
		<tr>
			<td width="30%">No. Registrasi KIA</td>
			<td width="2%">:</td>
			<td width="68%"><?php echo $res->no_kia  ?></td>
		</tr>
		<tr>
			<td >Nama</td>
			<td >:</td>
			<td ><strong><?php echo ucwords(strtolower($res->nama))  ?></strong></td>
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
			<td >Alamat</td>
			<td >:</td>
			<?php if ($this->session->userdata("admin_login") == true) { ?>
			<td ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($res->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->om->web_me()->kabupaten)) ?></td>
			<?php } else { ?>
				<td ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($res->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->fm->web_me()->kabupaten)) ?></td>
			<?php } ?>
		</tr>
		<tr>
			<td colspan="3"><strong></strong></td>
		</tr>
		<tr>
			<td colspan="3"><strong>Data Orang Tua Bayi</strong></td>
		</tr>
		<tr>
			<td >NIK Ayah</td>
			<td >:</td>
			<td ><?php if ($res->nik_ayah == 0) {
				echo "";
			} else {
				echo $res->nik_ayah;
			}  ?></td>
		</tr>
		<tr>
			<td >Nama Ayah</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_ayah))  ?></td>
		</tr>
		<tr>
			<td >Pekerjaan Ayah</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($pekerjaan_ayah))  ?></td>
		</tr>
		<tr>
			<td >NIK Ibu</td>
			<td >:</td>
			<td ><?php if ($res->nik_ibu == 0) {
				echo "";
			} else {
				echo $res->nik_ibu;
			}  ?></td>
		</tr>
		<tr>
			<td >Nama Ibu</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_ibu))  ?></td>
		</tr>
		<tr>
			<td >Pekerjaan Ibu</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($pekerjaan_ibu))  ?></td>
		</tr>
		</table>
		


	<p></p>
	<?php $this->load->view("ttd_biodata") ?>
	<img style="width: 80px;" src="<?php echo $savename;?>">
</body>

</html>