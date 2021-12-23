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
			border: 0.2px solid #000;
			/*padding: 2px;*/
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
			text-align: center;
			font-weight: bold;
			background-color: #D7EDFB;
		}


		.head th {
			/*border: 1px solid #000;*/
			/*padding: 2px;*/
			font-family: "Times New Roman", Times, serif; 
			font-size : 10px;
			text-align: left;
			font-weight: bold;
		}



		.tabel td {
			border: 0.2px solid #000;
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
		$jdl = "LAPORAN IMUNISASI RUTIN DINAS KESEHATAN";
	?>
	<p align="center" class="judul"><strong><?php echo $jdl."<br>Periode ".tgl_indo(tgl_simpan($awal))." - ".tgl_indo(tgl_simpan($akhir)) ?></strong></p>

	<table width="100%" class="head">
		<tr>
			<th width="10%">KABUPATEN</th>
			<th width="2%">:</th>
			<th width="70%"><?php echo $this->om->web_me()->kabupaten ?></th>
		
			<!-- <th width="10%">Bulan</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo getBulan($bulan) ?></th> -->
		</tr>
		<tr>
			<th width="10%">PROVINSI</th>
			<th width="2%">:</th>
			<th width="70%"><?php echo $this->om->web_me()->propinsi ?></th>
		
			<!-- <th width="10%">Tahun</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $tahun ?></th> -->
		</tr>
	</table>


	<br><br>
	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th style="font-size: 8px" width="2%" rowspan="2">NO</th>
				<th style="font-size: 8px" width="8%" rowspan="2">PUSKESMAS</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">BAYI</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">BAYI (SI)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">HB0 (< 24 JAM)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">HB0 (1 < 7 HARI)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">BCG</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">POLIO (1)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">PENTAVALEN (1)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">POLIO (2)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">PENTAVALEN (2)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">POLIO (3)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">PENTAVALEN (3)</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">POLIO (4)</th>
			</tr>
			<tr>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
				<th style="font-size: 8px">L</th>
				<th style="font-size: 8px">P</th>
				<th style="font-size: 8px">JML</th>
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
			<tr>
				<td align="center" width="2%"><?php echo $i ?></td>
				<td width="8%" ><?php echo ucwords(strtolower($row->nama_pkm)) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_l) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_p) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_p+$row->bayi_l) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_si_l) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_si_p) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_si_p+$row->bayi_si_l) ?></td>
				<!-- HB0 (< 24 JAM) -->
				<?php
					// HB0 (< 24 JAM) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "154", "jk" => "L")); 
					$hbl = $this->db->get("imunisasi");
					// HB0 (< 24 JAM) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "154", "jk" => "P")); 
					$hbp = $this->db->get("imunisasi");
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows() + $hbp->num_rows()) ?></td>
				<!-- END OF  HB0 (< 24 JAM) -->

				<!-- HB0 (1<7 HARI) -->
				<?php
					// HB0 (1<7 HARI) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "137", "jk" => "L")); 
					$hbl1 = $this->db->get("imunisasi");
					// HB0 (1<7 HARI) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "137", "jk" => "P")); 
					$hbp2 = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp2->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows() + $hbp2->num_rows()) ?></td>
				<!-- END OF  HB0 (1<7 HARI) -->

				<!-- BCG -->
				<?php
					// BCG L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "117", "jk" => "L")); 
					$bcgl = $this->db->get("imunisasi");
					// BCG P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "117", "jk" => "P")); 
					$bcgp = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($bcgl->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($bcgp->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($bcgl->num_rows() + $bcgp->num_rows()) ?></td>
				<!-- END OF  BCG -->

				<!-- POLIO (1) -->
				<?php
					// POLIO (1) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "127", "jk" => "L")); 
					$polio1l = $this->db->get("imunisasi");
					// POLIO (1) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "127", "jk" => "P")); 
					$polio1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows() + $polio1p->num_rows()) ?></td>
				<!-- END OF  POLIO (1) -->

				<!-- PENTAVALEN 1 (1) -->
				<?php
					// PENTAVALEN 1 (1) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "119", "jk" => "L")); 
					$pentavaln1l = $this->db->get("imunisasi");
					// PENTAVALEN 1 (1) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "119", "jk" => "P")); 
					$pentabalen1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows() + $pentabalen1p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN 1 (1) -->

				<?php
					// POLIO (2) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "126", "jk" => "L")); 
				$polio2l = $this->db->get("imunisasi");
					// POLIO (2) P
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "126", "jk" => "P")); 
				$polio2p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows() + $polio2p->num_rows()) ?></td>
				<!-- END OF  POLIO (2) -->


				<!-- PENTAVALEN 2 -->
				<?php
					// PENTAVALEN 2 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "128", "jk" => "L")); 
					$pentavaln2l = $this->db->get("imunisasi");
					// PENTAVALEN 2 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "128", "jk" => "P")); 
					$pentabalen2p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln2l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen2p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln2l->num_rows() + $pentabalen2p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN 2 -->

				<!-- POLIO 3 -->
				<?php
					// POLIO 3 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "122", "jk" => "L")); 
					$polio3l = $this->db->get("imunisasi");
					// POLIO 3 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "122", "jk" => "P")); 
					$polio3p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio3l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio3p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio3l->num_rows() + $polio3p->num_rows()) ?></td>
				<!-- END OF  POLIO 3 -->
				
				<!-- PENTAVALEN 3 -->
				<?php
					// PENTAVALEN 3 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "125", "jk" => "L")); 
					$pentavaln3l = $this->db->get("imunisasi");
					// PENTAVALEN 3 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "125", "jk" => "P")); 
					$pentabalen3p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln3l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen3p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln3l->num_rows() + $pentabalen3p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN 3 -->

				<!-- POLIO 3 -->
				<?php
					// POLIO 3 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "130", "jk" => "L")); 
					$polio4l = $this->db->get("imunisasi");
					// POLIO 3 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $row->id_pkm, "jenis_vaksin" => "130", "jk" => "P")); 
					$polio4p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio4l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio4p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio4l->num_rows() + $polio4p->num_rows()) ?></td>
				<!-- END OF  POLIO 3 -->
			</tr>
		<?php endforeach; ?>
			<tr>
				<?php 
				if (strlen($jum_bayi_l) > 3) {
				 	$st = "8px";
				} else {
					$st = "10px";
				}
				if (strlen($jum_bayi_p) > 3) {
				 	$st1 = "8px";
				} else {
					$st1 = "10px";
				}

				if (strlen($jum_bayi_l+$jum_bayi_p) > 3) {
				 	$st2 = "8px";
				} else {
					$st2 = "10px";
				}

				if (strlen($jum_bayi_si_l) > 3) {
				 	$st3 = "8px";
				} else {
					$st3 = "10px";
				}
				if (strlen($jum_bayi_si_p) > 3) {
				 	$st4 = "8px";
				} else {
					$st4 = "10px";
				}

				if (strlen($jum_bayi_si_l+$jum_bayi_si_p) > 3) {
				 	$st5 = "8px";
				} else {
					$st5 = "10px";
				}

				?>
				<td width="10%" align="center" rowspan="2" colspan="2" >JUMLAH</td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st ?>"><?php echo $jum_bayi_l ?></td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st1 ?>"><?php echo $jum_bayi_p ?></td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st2 ?>"><?php echo $jum_bayi_p + $jum_bayi_l?></td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st3 ?>"><?php echo $jum_bayi_si_l ?></td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st4 ?>"><?php echo $jum_bayi_si_p ?></td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st5 ?>"><?php echo $jum_bayi_si_p + $jum_bayi_si_l?></td>
				<!-- HB0 (< 24 JAM) -->
				<?php
					// HB0 (< 24 JAM) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "154", "jk" => "L")); 
					$hbl = $this->db->get("imunisasi");
					// HB0 (< 24 JAM) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "154", "jk" => "P")); 
					$hbp = $this->db->get("imunisasi");
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows() + $hbp->num_rows()) ?></td>
				<!-- END OF  HB0 (< 24 JAM) -->

				<!-- HB0 (1<7 HARI) -->
				<?php
					// HB0 (1<7 HARI) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "137", "jk" => "L")); 
					$hbl1 = $this->db->get("imunisasi");
					// HB0 (1<7 HARI) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "137", "jk" => "P")); 
					$hbp2 = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp2->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows() + $hbp2->num_rows()) ?></td>
				<!-- END OF  HB0 (1<7 HARI) -->

				<!-- BCG -->
				<?php
					// BCG L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "117", "jk" => "L")); 
					$bcgl = $this->db->get("imunisasi");
					// BCG P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "117", "jk" => "P")); 
					$bcgp = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($bcgl->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($bcgp->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($bcgl->num_rows() + $bcgp->num_rows()) ?></td>
				<!-- END OF  BCG -->

				<!-- POLIO (1) -->
				<?php
					// POLIO (1) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "127", "jk" => "L")); 
					$polio1l = $this->db->get("imunisasi");
					// POLIO (1) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "127", "jk" => "P")); 
					$polio1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows() + $polio1p->num_rows()) ?></td>
				<!-- END OF  POLIO (1) -->

				<!-- PENTAVALEN 1 (1) -->
				<?php
					// PENTAVALEN 1 (1) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "119", "jk" => "L")); 
					$pentavaln1l = $this->db->get("imunisasi");
					// PENTAVALEN 1 (1) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "119", "jk" => "P")); 
					$pentabalen1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows() + $pentabalen1p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN 1 (1) -->

				<?php
					// POLIO (2) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("jenis_vaksin" => "126", "jk" => "L")); 
				$polio2l = $this->db->get("imunisasi");
					// POLIO (2) P
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("jenis_vaksin" => "126", "jk" => "P")); 
				$polio2p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows() + $polio2p->num_rows()) ?></td>
				<!-- END OF  POLIO (2) -->


				<!-- PENTAVALEN 2 -->
				<?php
					// PENTAVALEN 2 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "128", "jk" => "L")); 
					$pentavaln2l = $this->db->get("imunisasi");
					// PENTAVALEN 2 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "128", "jk" => "P")); 
					$pentabalen2p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln2l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen2p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln2l->num_rows() + $pentabalen2p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN 2 -->

				<!-- POLIO 3 -->
				<?php
					// POLIO 3 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "122", "jk" => "L")); 
					$polio3l = $this->db->get("imunisasi");
					// POLIO 3 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "122", "jk" => "P")); 
					$polio3p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio3l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio3p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio3l->num_rows() + $polio3p->num_rows()) ?></td>
				<!-- END OF  POLIO 3 -->
				
				<!-- PENTAVALEN 3 -->
				<?php
					// PENTAVALEN 3 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "125", "jk" => "L")); 
					$pentavaln3l = $this->db->get("imunisasi");
					// PENTAVALEN 3 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "125", "jk" => "P")); 
					$pentabalen3p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln3l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen3p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln3l->num_rows() + $pentabalen3p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN 3 -->

				<!-- POLIO 3 -->
				<?php
					// POLIO 3 L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "130", "jk" => "L")); 
					$polio4l = $this->db->get("imunisasi");
					// POLIO 3 P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("jenis_vaksin" => "130", "jk" => "P")); 
					$polio4p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio4l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio4p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio4l->num_rows() + $polio4p->num_rows()) ?></td>
				<!-- END OF  POLIO 3 -->

			</tr>
	</table>
<p></p>
<?php $this->load->view("ttd_dinas") ?>
</body>

</html>
