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
	<?php $this->load->view("kop") ?>
	<hr>
	<p  class="judulz"><strong>TANDA BUKTI VAKSIN LUAR WILAYAH <?php echo strtoupper($this->om->bentuk_admin($res->id_pkm,"p"))." ".strtoupper($this->om->identitas_general($res->id_pkm)->nama_pkm) ?></strong></p>
	
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
			<td colspan="3"><strong>Data Bayi</strong></td>
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
			<td >Tanggal Lahir</td>
			<td >:</td>
			<td ><?php echo tgl_indo($res->tgl_lahir)  ?></td>
		</tr>
		<!-- <tr>
			<td >Umur</td>
			<td >:</td>
			<td ><?php echo umur($res->tgl_lahir)  ?></td>
		</tr> -->
	
		<tr>
			<td >Alamat Lengkap</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower(($res->alamat))) ?></td>
		</tr>
		<tr>
			<td >Nama Orang Tua</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_ibu)) ?></td>
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
	<?php $this->load->view("ttd_biodata") ?>
	<img style="width: 50px;" src="<?php echo $savename;?>">
	

</body>

</html>