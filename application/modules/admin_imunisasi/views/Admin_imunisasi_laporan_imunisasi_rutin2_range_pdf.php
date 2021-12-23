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
	
	if ($id_pkm != "") {
		$jdl = "LAPORAN IMUNISASI RUTIN ".strtoupper($this->om->bentuk_admin($id_pkm,"p")) ." ".strtoupper($this->om->identitas_general($id_pkm)->nama_pkm);

	} 
	?>
	<p align="center" class="judul"><strong><?php echo $jdl ?></strong></p>

	<table width="100%" class="head">
		<tr>
			<th width="10%">KABUPATEN</th>
			<th width="2%">:</th>
			<th width="70%"><?php echo $this->om->web_me()->kabupaten ?></th>
		
		<!-- 	<th width="10%">Bulan</th>
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
				<th style="font-size: 8px" width="8%" rowspan="2">DESA</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">IPV</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">MR</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">IDL IPV</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">IDL NON IPV</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">BAYI (SI) TAHUN LALU</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">PENTAVALEN LANJUTAN</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">CAMPAK LANJUTAN</th>
				<th style="font-size: 8px" width="7.5%" colspan="3">MR LANJUTAN</th>
				<th style="font-size: 8px" width="2.5%" rowspan="2">BUMIL</th>
				<th style="font-size: 8px" width="10%" colspan="5">TT BUMIL</th>
				<th style="font-size: 8px" width="2.5%" rowspan="2">LL</th>
				<th style="font-size: 8px" width="3%" rowspan="2">WUS</th>
				<th style="font-size: 8px" width="10%" colspan="5">TT WUS TIDAK HAMIL</th>
				<th style="font-size: 8px" width="2%" rowspan="2">LL</th>
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
				<th style="font-size: 8px" >L</th>
				<th style="font-size: 8px" >P</th>
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
				<th style="font-size: 8px">1</th>
				<th style="font-size: 8px">2</th>
				<th style="font-size: 8px">3</th>
				<th style="font-size: 8px">4</th>
				<th style="font-size: 8px">5</th>
				<th style="font-size: 8px">1</th>
				<th style="font-size: 8px">2</th>
				<th style="font-size: 8px">3</th>
				<th style="font-size: 8px">4</th>
				<th style="font-size: 8px">5</th>
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
			<tr>
				<td align="center" width="2%"><?php echo $i ?></td>
				<td width="8%" ><?php echo ucwords(strtolower($row->desa)) ?></td>
				<!-- IPV (< 24 JAM) -->
				<?php
					// IPV (< 24 JAM) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "121", "jk" => "L")); 
					$hbl = $this->db->get("imunisasi");
					// IPV (< 24 JAM) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "121", "jk" => "P")); 
					$hbp = $this->db->get("imunisasi");
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows() + $hbp->num_rows()) ?></td>
				<!-- END OF  IPV (< 24 JAM) -->

				<!-- MR (1<7 HARI) -->
				<?php
					// MR (1<7 HARI) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "124", "jk" => "L")); 
					$hbl1 = $this->db->get("imunisasi");
					// MR (1<7 HARI) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "124", "jk" => "P")); 
					$hbp2 = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp2->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows() + $hbp2->num_rows()) ?></td>
				<!-- END OF  MR (1<7 HARI) -->

				<!-- IDL -->
				<?php
				$thu = substr($akhir, 6,4);
				
				
				$bln = substr($awal, 3,2);
				$bln2 = substr($awal, 0,2);
				$bln = $bln."-".$bln2;
				$tahun_1 = $thu-1;
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa,"jk" => "L")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
				$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_ipv = $this->db->get();

				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa,"jk" => "P")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
				$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_opcp = $this->db->get();
				// echo $this->db->last_query();
				// exit();
			
				?>
				<td width="2.5%" align="center"><?php echo uang($idl_ipv->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_opcp->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_ipv->num_rows() + $idl_opcp->num_rows()) ?></td>
				<!-- END OF  IDL -->



				<!-- IDL NON -->
				<?php
				
				$thu = substr($akhir, 6,4);
				
				
				$bln = substr($awal, 3,2);
				$bln2 = substr($awal, 0,2);
				$bln = $bln."-".$bln2;
				$tahun_1 = $thu-1;
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa,"jk" => "L")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
				$this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_non_ipv = $this->db->get();

				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa,"jk" => "P")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
				$this->db->select("sum(jenis_vaksin) as idl_non_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_non_i = $this->db->get();
				// echo $this->db->last_query();
				// exit();
			
				?>
				<td width="2.5%" align="center"><?php echo uang($idl_non_ipv->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_non_i->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_non_ipv->num_rows() + $idl_non_i->num_rows()) ?></td>
				<!-- END OF  IDL -->

				<td width="2.5%" align="center"><?php echo uang($row->bayi_si_tahun_lalu_l) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_si_tahun_lalu_p) ?></td>
				<td width="2.5%" align="center"><?php echo uang($row->bayi_si_tahun_lalu_p+$row->bayi_si_tahun_lalu_l) ?></td>
				
				<!-- PENTAVALEN LANJUTAN -->
				<?php
					// PENTAVALEN LANJUTAN L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "129", "jk" => "L")); 
					$polio1l = $this->db->get("imunisasi");
					// PENTAVALEN LANJUTAN P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "129", "jk" => "P")); 
					$polio1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows() + $polio1p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN LANJUTAN -->

				<!-- CAMPAK LANJUTAN -->
				<?php
					// CAMPAK LANJUTAN L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "120", "jk" => "L")); 
					$pentavaln1l = $this->db->get("imunisasi");
					// CAMPAK LANJUTAN P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "120", "jk" => "P")); 
					$pentabalen1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows() + $pentabalen1p->num_rows()) ?></td>
				<!-- END OF  CAMPAK LANJUTAN -->

				<?php
					// MR LANJUTAN L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "138", "jk" => "L")); 
				$polio2l = $this->db->get("imunisasi");
					// MR LANJUTAN P
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "138", "jk" => "P")); 
				$polio2p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows() + $polio2p->num_rows()) ?></td>
				<!-- END OF  MR LANJUTAN -->

				<td width="2.5%" align="center"><?php echo uang($row->wus_hamil) ?></td>
				
				<!-- BUMIL TT1 -->
				<?php
					
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "tt1")); 
				$tt1 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "tt2")); 
				$tt2 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "tt3")); 
				$tt3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "tt3")); 
				$tt3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "tt4")); 
				$tt4 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "tt5")); 
				$tt5 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttll")); 
				$ttll = $this->db->get("imunisasi_ibu");


				?>
				<td width="2%" align="center"><?php echo uang($tt1->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt2->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt3->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt4->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt5->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($ttll->num_rows()) ?></td>

				<td width="3%" align="center"><?php echo ($row->wus_jumlah-$row->wus_hamil) ?></td>


				<!-- BUMIL TT1 -->
				<?php
					
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttw1")); 
				$ttw1 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttw2")); 
				$ttw2 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttw3")); 
				$ttw3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttw3")); 
				$ttw3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttw4")); 
				$ttw4 = $this->db->get("imunisasi_ibu");
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttw5")); 
				$ttw5 = $this->db->get("imunisasi_ibu");
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "id_desa" => $row->id_desa, "jenis_vaksin" => "ttwll")); 
				$ttwll = $this->db->get("imunisasi_ibu");


				?>
				<td width="2%" align="center"><?php echo uang($ttw1->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw2->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw3->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw4->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw5->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttwll->num_rows()) ?></td>



			</tr>
		<?php endforeach; ?>
			<tr>
				<td width="10%" align="center" rowspan="2" colspan="2" >JUMLAH</td>
				<!-- IPV (< 24 JAM) -->
				<?php
					// IPV (< 24 JAM) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "121", "jk" => "L")); 
					$hbl = $this->db->get("imunisasi");
					// IPV (< 24 JAM) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "121", "jk" => "P")); 
					$hbp = $this->db->get("imunisasi");
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl->num_rows() + $hbp->num_rows()) ?></td>
				<!-- END OF  IPV (< 24 JAM) -->

				<!-- MR (1<7 HARI) -->
				<?php
					// MR (1<7 HARI) L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "124", "jk" => "L")); 
					$hbl1 = $this->db->get("imunisasi");
					// MR (1<7 HARI) P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "124", "jk" => "P")); 
					$hbp2 = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbp2->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($hbl1->num_rows() + $hbp2->num_rows()) ?></td>
				<!-- END OF  MR (1<7 HARI) -->

				<!-- IDL -->
				<?php
					// IDL L
				$thu = substr($akhir, 6,4);
				
				
				$bln = substr($awal, 3,2);
				$bln2 = substr($awal, 0,2);
				$bln = $bln."-".$bln2;
				$tahun_1 = $thu-1;
				$this->db->where(array("id_pkm" => $id_pkm,"jk" => "L")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
				$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_ipv_t = $this->db->get();

				$this->db->where(array("id_pkm" => $id_pkm,"jk" => "P")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
				$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_opcp_t = $this->db->get();
				// echo $this->db->last_query();
				// exit();

				?>
				<td width="2.5%" align="center"><?php echo uang($idl_ipv_t->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_opcp_t->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_ipv_t->num_rows() + $idl_opcp_t->num_rows()) ?></td>
				<!-- END OF  IDL -->

				<?php
					// IDL L
				$thu = substr($akhir, 6,4);
				
				
				$bln = substr($awal, 3,2);
				$bln2 = substr($awal, 0,2);
				$bln = $bln."-".$bln2;
				$tahun_1 = $thu-1;
				$this->db->where(array("id_pkm" => $id_pkm,"jk" => "L")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
				$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_ipv_t = $this->db->get();

				$this->db->where(array("id_pkm" => $id_pkm,"jk" => "P")); 
				$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'" and "'.tgl_simpan($akhir).'"');
				$this->db->group_by("id_anak");
				$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
				$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
				$idl_opcp_t = $this->db->get();
				// echo $this->db->last_query();
				// exit();

				?>
				<td width="2.5%" align="center"><?php echo uang($idl_ipv_t->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_opcp_t->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($idl_ipv_t->num_rows() + $idl_opcp_t->num_rows()) ?></td>
				<!-- END OF  IDL -->
				<?php 
				if (strlen($jum_bayi_si_tahun_lalu_l) > 4) {
				 	$st = "8px";
				} else {
					$st = "10px";
				}
				if (strlen($jum_bayi_si_tahun_lalu_p) > 4) {
				 	$st1 = "8px";
				} else {
					$st1 = "10px";
				}

				if (strlen($jum_bayi_si_tahun_lalu_p+$jum_bayi_si_tahun_lalu_l) > 4) {
				 	$st2 = "8px";
				} else {
					$st2 = "10px";
				}
				 ?>
				<td width="2.5%" align="center" style="font-size: <?php echo $st ?>"><?php echo uang($jum_bayi_si_tahun_lalu_l) ?></td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st1 ?>"><?php echo uang($jum_bayi_si_tahun_lalu_p) ?></td>
				<td width="2.5%" align="center" style="font-size: <?php echo $st2 ?>"><?php echo uang($jum_bayi_si_tahun_lalu_p+$jum_bayi_si_tahun_lalu_l) ?></td>


				<!-- PENTAVALEN LANJUTAN -->
				<?php
					// PENTAVALEN LANJUTAN L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "129", "jk" => "L")); 
				$polio1l = $this->db->get("imunisasi");
					// PENTAVALEN LANJUTAN P
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "129", "jk" => "P")); 
				$polio1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio1l->num_rows() + $polio1p->num_rows()) ?></td>
				<!-- END OF  PENTAVALEN LANJUTAN -->

				<!-- CAMPAK LANJUTAN -->
				<?php
					// CAMPAK LANJUTAN L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "120", "jk" => "L")); 
					$pentavaln1l = $this->db->get("imunisasi");
					// CAMPAK LANJUTAN P
					$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
					$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "120", "jk" => "P")); 
					$pentabalen1p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentabalen1p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($pentavaln1l->num_rows() + $pentabalen1p->num_rows()) ?></td>
				<!-- END OF  CAMPAK LANJUTAN -->

				<?php
					// MR LANJUTAN L
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "138", "jk" => "L")); 
				$polio2l = $this->db->get("imunisasi");
					// MR LANJUTAN P
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "138", "jk" => "P")); 
				$polio2p = $this->db->get("imunisasi");

					// echo $this->db->last_query();
					// exit();
				?>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2p->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($polio2l->num_rows() + $polio2p->num_rows()) ?></td>
				<!-- END OF  MR LANJUTAN -->
				<?php 
				if (strlen($jum_wus_hamil) > 4) {
				 	$st4 = "8px";
				} else {
					$st4 = "10px";
				}
				 ?>
				

				<td width="2.5%" align="center" style="font-size: <?php echo $st4 ?>"><?php echo uang($jum_wus_hamil) ?></td>
				<!-- BUMIL TT1 -->
				<?php
				
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "tt1")); 
				$tt1 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "tt2")); 
				$tt2 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "tt3")); 
				$tt3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "tt3")); 
				$tt3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "tt4")); 
				$tt4 = $this->db->get("imunisasi_ibu");
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "tt5")); 
				$tt5 = $this->db->get("imunisasi_ibu");
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttll")); 
				$ttll = $this->db->get("imunisasi_ibu");


				?>
				<td width="2%" align="center"><?php echo uang($tt1->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt2->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt3->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt4->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($tt5->num_rows()) ?></td>
				<td width="2.5%" align="center"><?php echo uang($ttll->num_rows()) ?></td>
				<?php 
				if (strlen($$jum_wus_jumlah-$jum_wus_hamil) > 4) {
				 	$st5 = "8px";
				} else {
					$st5 = "10px";
				}
				 ?>
				<td width="3%" align="center" style="font-size: <?php echo $st5 ?>"><?php echo ($jum_wus_jumlah-$jum_wus_hamil) ?></td>

				<?php
					
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttw1")); 
				$ttw1 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttw2")); 
				$ttw2 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttw3")); 
				$ttw3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttw3")); 
				$ttw3 = $this->db->get("imunisasi_ibu");

				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttw4")); 
				$ttw4 = $this->db->get("imunisasi_ibu");
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttw5")); 
				$ttw5 = $this->db->get("imunisasi_ibu");
				$this->db->where("tgl_suntik BETWEEN '".tgl_simpan($awal)."' AND '".tgl_simpan($akhir)."'");
				$this->db->where(array("id_pkm" => $id_pkm, "jenis_vaksin" => "ttwll")); 
				$ttwll = $this->db->get("imunisasi_ibu");


				?>
				<td width="2%" align="center"><?php echo uang($ttw1->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw2->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw3->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw4->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttw5->num_rows()) ?></td>
				<td width="2%" align="center"><?php echo uang($ttwll->num_rows()) ?></td>
			</tr>
	</table>
<p></p>
<?php echo $this->load->view("ttd_pkm") ?>
</body>

</html>
