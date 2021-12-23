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
	<?php if ($res->wilayah == "1") {?>
		<p  class="judulz"><strong>TANDA BUKTI PELAPORAN KEJADIAN IKUTAN PASCA IMUNISASI (KIPI) </strong></p>
	<?php } else {?>
		<p  class="judulz"><strong>TANDA BUKTI PELAPORAN KEJADIAN IKUTAN PASCA IMUNISASI (KIPI)<br> LUAR WILAYAH <?php echo strtoupper($this->om->bentuk_admin($res->id_pkm,"p"))." ". strtoupper($this->om->identitas_general($res->id_pkm)->nama_pkm)  ?></strong></p>
	<?php } ?>
	

	<table width="100%" cellspacing="4">
		<tr>
			<td colspan="3"><strong>Data Kejadian</strong></td>
		</tr>
		
		<tr>
			<td width="40%">Tahun/ Bulan</td>
			<td width="2%">:</td>
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
			<td >Jenis Vaksin 1 </td>
			<td >:</td>
			<td ><?php echo $jenis_vaksin_1  ?></td>
		</tr>
		<tr>
			<td >No Batch / Exp Date Vaksin 1 </td>
			<td >:</td>
			<td ><?php echo $res->no_vaksin_1  ?></td>
		</tr>
		<tr>
			<td >Jenis Vaksin 2 </td>
			<td >:</td>
			<td ><?php echo $jenis_vaksin_2  ?></td>
		</tr>
		
		<tr>
			<td >No Batch / Exp Date Vaksin 2 </td>
			<td >:</td>
			<td ><?php echo $res->no_vaksin_2  ?></td>
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
			<?php 

			if ($res->demam == "Y") {
				$ge1 = "Demam, ";
			} else {
				$ge1 = "";
			}
			if ($res->bengkak == "Y") {
				$ge2 = "Bengkak, ";
			} else {
				$ge2 = "";
			}
			if ($res->merah == "Y") {
				$ge3 = "Merah, ";
			} else {
				$ge3 = "";
			}
			if ($res->muntah == "Y") {
				$ge4 = "Muntah, ";
			} else {
				$ge4 = "";
			}
			$ad = $ge1.$ge2.$ge3.$ge4.$res->lainnya;
			$ko1 = substr($ad, -100,-2);

			?>
			<td>Gejala</td>
			<td>:</td>
			<td><?php echo $ko1 ?></td>
		</tr>
		<tr>
			<td colspan="3"><strong></strong></td>
		</tr>

		<tr>
			<td colspan="3"><strong>Data Anak</strong></td>
		</tr>

		<tr>
			<td width="40%">Nama</td>
			<td width="2%">:</td>
			<td width="58%"><?php echo ucwords(strtolower($res->nama))  ?></td>
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
		<?php if ($res->wilayah == "1") {?>
			<tr>
				<td >Alamat</td>
				<td >:</td>
				<td ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($nama_desa->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->om->web_me()->kabupaten)) ?></td>
			</tr>
		<?php } else {?>
			<tr>
				<td >NIK Ibu</td>
				<td >:</td>
				<td ><?php echo ucwords(strtolower($res->nik_ibu))  ?></td>
			</tr>
			<tr>
				<td >Nama Ibu</td>
				<td >:</td>
				<td ><?php echo ucwords(strtolower($res->nama_ibu))  ?></td>
			</tr>
			<tr>
				<td >Alamat</td>
				<td >:</td>
				<td ><?php echo ucwords(strtolower($res->alamat)) ?></td>
			</tr>
		<?php } ?>
		
		<tr>
			<td colspan="3"><strong></strong></td>
		</tr>
		<?php if ($res->wilayah == "1") {?>
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
		<?php } else {?>

		<?php } ?>
	</table>



	<p></p>
	<?php $this->load->view("ttd_biodata") ?>
	<img style="width: 50px;" src="<?php echo $savename;?>">
</body>

</html>