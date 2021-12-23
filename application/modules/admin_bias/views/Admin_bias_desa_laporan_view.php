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
			font-size : 10px;
			text-align: center;
			background-color: #E7FBCA;
			/*font-weight: bold;*/
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
<?php if ($this->session->userdata("admin_level") == "admin") {
	$a = $this->om->identitas_general($admin_bias->id_pkm)->nama_pkm;
} else {
	$a = $this->om->identitas()->nama_pkm;
} ?>
<body>
	<p align="center" class="judul"><strong>REKAPITULASI HASIL CAKUPAN BULAN IMUNISASI ANAK SEKOLAH ( BIAS )<br><?php echo strtoupper($this->om->bentuk_admin($admin_bias->id_pkm,"p")). " ".strtoupper($a) ?> TAHUN <?php echo $admin_bias->tahun ?></strong></p>

	<!-- <table width="100%" class="head">
		<thead class="thead-light">
		<tr>
			<th width="10%">KABUPATEN</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $this->om->web_me()->kabupaten ?></th>
			<th align="center">Kepala <?php echo $this->om->bentuk_admin($admin_bias->id_pkm,"p") ?></th>
			<th align="center">Pengelola Imunisasi</th>
			
		</tr>
		<tr>
			<th>PROVINSI</th>
			<th>:</th>
			<th><?php echo $this->om->web_me()->rekening ?></th>
			<th align="center"><?php echo $admin_bias->pimpinan ?></th>
			<th align="center"><?php echo $admin_bias->pengelola ?></th>
			
		</tr>
		<tr>
			<th>TAHUN</th>
			<th>:</th>
			<th><?php echo $admin_bias->tahun ?></th>
			<?php if ($admin_bias->nip_pimpinan !="") {?>
				<th align="center">Nip. <?php echo $admin_bias->nip_pimpinan ?></th>
			<?php } else {?>
				<th align="center"></th>
			<?php } ?>
			<?php if ($admin_bias->nip_pengelola !="") {?>
				<th align="center">Nip. <?php echo $admin_bias->nip_pengelola ?></th>
			<?php } else {?>
				<th align="center"></th>
			<?php } ?>
			
		</tr>
		<thead class="thead-light">
	</table>

 -->
	<br><br>
	<table id="basic-datatable" class="tabel" width="100%">
		<thead class="thead-light">
			<tr>
				
				<th rowspan="4" width="2.5%" ><br><br>NO</th>
				<th rowspan="4" width="11%" ><br><br>DESA</th>
				<th colspan="9" rowspan="2" width="22.5%">JUMLAH MURID<br>DALAM ABSEN</th>
				<th colspan="16" width="40%">JUMLAH MURID DIIMUNISASI</th>
				<th colspan="6" rowspan="2" width="15%">JUMLAH VAKSIN YANG DIPAKAI</th>
				<th colspan="2" rowspan="3" width="10%">JUMLAH LOGISTIK YANG DIPAKAI (ADS)</th>
			

            <!--                             
				<th rowspan="2" width="2.5%"><br><br>No</th>
				<th rowspan="2" width="10%"><br><br>SEKOLAH</th>
				<th colspan="3">JUMLAH<br>PENDUDUK</th>
				<th colspan="3">BAYI</th>
				<th colspan="3">BAYI (SI)</th>
				<th colspan="3">BAYI (SI)<br>TAHUN LALU</th>
				<th colspan="3">TOTAL SASARAN WUS (Hamil + Tidak Hamil)</th> -->
			</tr>
			<tr>
				<th colspan="8" width="20%">KLS 1</th>
				<th colspan="4" width="10%">KLS 2</th>
				<th colspan="4" width="10%">KLS 5</th>

			</tr>
			<tr>
				<th colspan="3" width="7.5%">KLS 1</th>
				<th colspan="3" width="7.5%">KLS 2</th>
				<th colspan="3" width="7.5%">KLS 5</th>
				<th colspan="4" width="10%">DT</th>
				<th colspan="4" width="10%">CPK</th>
				<th colspan="4" width="10%">TD</th>
				<th colspan="4" width="10%">TD</th>
				<!-- .... -->
				<th rowspan="2" width="2.5%">DT</th>
				<th rowspan="2" width="2.5%">IP</th>
				<th rowspan="2" width="2.5%">CPK</th>
				<th rowspan="2" width="2.5%">IP</th>
				<th rowspan="2" width="2.5%">TD</th>
				<th rowspan="2" width="2.5%">IP</th>
			</tr>
			<tr>
				<th width="2.5%">L</th>
				<th width="2.5%">P</th>
				<th width="2.5%">Jml</th>
				<th width="2.5%">L</th>
				<th width="2.5%">P</th>
				<th width="2.5%">Jml</th>
				<th width="2.5%">L</th>
				<th width="2.5%">P</th>
				<th width="2.5%">Jml</th>
				<!-- batas jumlah murid abes -->
				<th width="2.5%">L</th>
				<th width="2.5%">P</th>
				<th width="2.5%">Jml</th>
				<th width="2.5%">%</th>
				<th width="2.5%">L</th>
				<th width="2.5%">P</th>
				<th width="2.5%">Jml</th>
				<th width="2.5%">%</th>
				<!-- batas jumlah murid abes -->
				<th width="2.5%">L</th>
				<th width="2.5%">P</th>
				<th width="2.5%">Jml</th>
				<th width="2.5%">%</th>
				<th width="2.5%">L</th>
				<th width="2.5%">P</th>
				<th width="2.5%">Jml</th>
				<th width="2.5%">%</th>
				<!-- ... -->
				<th  width="5%" >5 ml</th>
				<th  width="5%" >0,5 ml</th>

				
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
			<tr>
				<?php if ($desa == "2") {
					$des = $row->desa;
				} else {
					$des = ucwords(strtolower($row->desa));
				} ?>
				<td align="center" width="2.5%"><?php echo $i ?></td>
				<td width="11%"><?php echo (($row->desa)) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_1_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_1_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_1_p+$row->absen_kelas_1_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_2_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_2_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_2_p+$row->absen_kelas_2_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_5_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_5_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->absen_kelas_5_p+$row->absen_kelas_5_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_1_l_dt) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_1_p_dt) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_1_l_dt+$row->imun_kelas_1_p_dt) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb((($row->imun_kelas_1_l_dt+$row->imun_kelas_1_p_dt)/($row->absen_kelas_1_p+$row->absen_kelas_1_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_1_l_cpk) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_1_p_cpk) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_1_p_cpk+$row->imun_kelas_1_l_cpk) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb((($row->imun_kelas_1_p_cpk+$row->imun_kelas_1_l_cpk)/($row->absen_kelas_1_p+$row->absen_kelas_1_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_2_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_2_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_2_l+$row->imun_kelas_2_p) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb((($row->imun_kelas_2_l+$row->imun_kelas_2_p)/($row->absen_kelas_2_p+$row->absen_kelas_2_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_5_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_5_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->imun_kelas_5_l+$row->imun_kelas_5_p) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb((($row->imun_kelas_5_l+$row->imun_kelas_5_p)/($row->absen_kelas_5_p+$row->absen_kelas_5_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->vaksin_dt) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb($row->vaksin_dt/($row->imun_kelas_1_l_dt+$row->imun_kelas_1_p_dt) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->vaksin_cpk) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb($row->vaksin_cpk/($row->imun_kelas_1_p_cpk+$row->imun_kelas_1_l_cpk) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($row->vaksin_td) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb($row->vaksin_td/($row->imun_kelas_2_l+$row->imun_kelas_2_p+$row->imun_kelas_5_l+$row->imun_kelas_5_p) * 100) ?></td>
				<td align="center" width="5%"><?php echo ve($row->logistik_5ml) ?></td>
				<td align="center" width="5%"><?php echo ve($row->logistik_05ml) ?></td>
			</tr>
		<?php endforeach; ?>
	
			<tr>
				<td align="center" colspan="2">Total</td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_1_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_1_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_1_p+$jum->absen_kelas_1_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_2_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_2_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_2_p+$jum->absen_kelas_2_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_5_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_5_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->absen_kelas_5_p+$jum->absen_kelas_5_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_1_l_dt) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_1_p_dt) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_1_l_dt+$jum->imun_kelas_1_p_dt) ?></td>
				<td align="center" width="2.5%"  style="font-size: 8px"><?php echo numb((($jum->imun_kelas_1_l_dt+$jum->imun_kelas_1_p_dt)/($jum->absen_kelas_1_p+$jum->absen_kelas_1_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_1_l_cpk) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_1_p_cpk) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_1_p_cpk+$jum->imun_kelas_1_l_cpk) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb((($jum->imun_kelas_1_p_cpk+$jum->imun_kelas_1_l_cpk)/($jum->absen_kelas_1_p+$jum->absen_kelas_1_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_2_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_2_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_2_l+$jum->imun_kelas_2_p) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb((($jum->imun_kelas_2_l+$jum->imun_kelas_2_p)/($jum->absen_kelas_2_p+$jum->absen_kelas_2_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_5_l) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_5_p) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->imun_kelas_5_l+$jum->imun_kelas_5_p) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb((($jum->imun_kelas_5_l+$jum->imun_kelas_5_p)/($jum->absen_kelas_5_p+$jum->absen_kelas_5_l)) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->vaksin_dt) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb($jum->vaksin_dt/($jum->imun_kelas_1_l_dt+$jum->imun_kelas_1_p_dt) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->vaksin_cpk) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb($jum->vaksin_cpk/($jum->imun_kelas_1_p_cpk+$jum->imun_kelas_1_l_cpk) * 100) ?></td>
				<td align="center" width="2.5%"><?php echo ve($jum->vaksin_td) ?></td>
				<td align="center" width="2.5%" style="font-size: 8px"><?php echo numb($jum->vaksin_td/($jum->imun_kelas_2_l+$jum->imun_kelas_2_p+$jum->imun_kelas_5_l+$jum->imun_kelas_5_p) * 100) ?></td>
				<td align="center" width="5%"><?php echo ve($jum->logistik_5ml) ?></td>
				<td align="center" width="5%"><?php echo ve($jum->logistik_05ml) ?></td>
				
			</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" class="ttd">
		<tr>
			<td colspan="2"></td>
		</tr>
		<tr>

			<td width="80%">Mengetahui,</td>
			<td width="40%" align="left"><?php echo tgl_indo($admin_bias->create_date) ?></td>
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
