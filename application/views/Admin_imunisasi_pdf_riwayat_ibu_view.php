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
			font-size:10px;
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
	<p  class="judulz"><strong><br>RIWAYAT PEMBERIAN IMUNISASI IBU</strong></p>
	
	<table width="100%" cellspacing="4">	
		<tr>
			<td ><strong>DATA IBU</strong></td>
		</tr>

		<tr>
			<td width="20%">NIK</td>
			<td width="2%">:</td>
			<td ><?php echo $res->no_kia  ?></td>
			
		</tr>
		<tr>
			<td >Nama</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama))  ?></td>
			
		</tr>
		
		
		<tr>
			<td >Tempat, Tgl Lahir</td>
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
			<td  ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($res->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->om->web_me()->kabupaten)) ?></td>
			<?php } else { ?>
				<td  ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($res->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->fm->web_me()->kabupaten)) ?></td>
			<?php } ?>
		</tr>
		<tr>
			<td colspan="6"></td>
		</tr>
		
	</table>
	<!-- <hr> -->
	<!-- <p>Riwayat : </p> -->

	<table class="tabel" width="100%">
		<tr style="background-color: #ADD8E6; font-weight: bold; ">
			<td colspan="7" width="101%" align="center" style="font-size: 12px">RIWAYAT IMUNISASI</td>
			
		</tr>
		<tr style="background-color: #FFE4C4; font-weight: bold;">
			<td width="5%" align="center">No.</td>
			<td width="16%" align="center">No. Imunisasi</td>
			<td width="16%" align="center">Jenis Vaksin</td>
			<td width="17%" align="center">Vaksin Umur</td>
			<td width="12%" align="center">Tanggal Imunisasi</td>
			<td width="15%" align="center">Tahun/ Bulan Imunisasi</td>
			<td width="20%" align="center">Tempat Pelayanan</td>
		</tr>
		<?php 
		$i = 0;
		foreach ($record->result() as $row) : 
			$i++ ?>
			<tr>
				<td align="center"><?php echo $i ?>.</td>
				<td align="center"><?php echo $row->id_imunisasi_ibu ?></td>
				
				<td><?php echo arr_vaksin_ibu($row->jenis_vaksin) ?></td>
				<td><?php echo $row->vaksin_umur ?></td>
				<td align="center"><?php echo tgl_view($row->tgl_suntik) ?></td>
				<td ><?php echo tahun_view(tgl_view($row->tgl_suntik))."/ ".bulan_view_only((($row->tgl_suntik)))  ?></td>
				<td><?php echo ucwords(strtolower($row->tempat_pelayanan)) ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<p></p>
	
	<?php $this->load->view("ttd_riwayat") ?>
	<p></p>
	<img style="width: 70px;" src="<?php echo $savename;?>">
</body>

</html>