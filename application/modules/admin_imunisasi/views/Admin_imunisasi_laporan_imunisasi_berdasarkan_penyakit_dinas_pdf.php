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
			font-size : 11px;
		}

		.ttd {
			/*border: 1px solid #000;*/
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
		}
		

	</style> 
</head>

<body>
	<?php
		$jdl = "LAPORAN BERDASARKAN JENIS IMUNISASI DINAS KESEHATAN";
	?>
	<p align="center" class="judul"><strong><?php echo $jdl ?></strong></p>

	<table width="100%" class="head">
		<tr>
			<th width="15%">KABUPATEN</th>
			<th width="2%">:</th>
			<th width="60%"><?php echo $this->om->web_me()->kabupaten ?></th>
		
			<!-- <th width="10%">Bulan</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo getBulan($bulan) ?></th> -->
		</tr>
		<tr>
			<th width="15%">PROVINSI</th>
			<th width="2%">:</th>
			<th width="60%"><?php echo $this->om->web_me()->propinsi ?></th>
		
			<!-- <th width="10%">Tahun</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $tahun ?></th> -->
		</tr>
	</table>


	<br><br>
	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th rowspan="2" colspan="2" width="50%">JENIS IMUNISASI</th>
				<th colspan="6" width="50%">CAKUPAN</th>
			</tr>
				
			<tr>
				<th colspan="3"><?php echo strtoupper(getBulan($bulan)) ?></th>
				<th colspan="3">JANUARI - <?php echo strtoupper(getBulan($bulan)) ?></th>
			</tr>
			<tr>
				<th width="5%" style="background-color: #FDF8A5">A</th>
				<th width="45%" style="text-align: left; background-color: #FDF8A5">IMUNISASI BAYI</th>
				<th style="text-align: center; background-color: #FDF8A5">L</th>
				<th style="text-align: center; background-color: #FDF8A5">P</th>
				<th style="text-align: center; background-color: #FDF8A5">JML</th>
				<th style="text-align: center; background-color: #FDF8A5">L</th>
				<th style="text-align: center; background-color: #FDF8A5">P</th>
				<th style="text-align: center; background-color: #FDF8A5">JML</th>
			</tr>
		</thead>
		<?php 
			$no = 0;
			foreach ($res->result() as $row) :
			$no ++ ; ?>
			<tr>
				<td width="5%" align="center"><?php echo $no ?>.</td>
				<td width="45%"><?php echo strtoupper($row->nama_penyakit) ?></td>
				<?php 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jk" => "L")); 
				$l_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $l_i->num_rows() ?></td>
				<?php 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jk" => "P")); 
				$p_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $p_i->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $p_i->num_rows()+$l_i->num_rows() ?></td>

				<?php
				$this->db->where("bulan between '1' and ".$bulan." "); 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "jk" => "L")); 
				$ld_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $ld_i->num_rows() ?></td>
				<?php 
				$this->db->where("bulan between '1' and ".$bulan." "); 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "jk" => "P")); 
				$pd_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $pd_i->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $pd_i->num_rows()+$ld_i->num_rows() ?></td>
			</tr>
			
		<?php endforeach; ?>
		<tr>
			<?php
					// IDL L
			$bulan_a = strlen($bulan);
			if ($bulan_a == "1") {
				$bln = "0".$bulan;
			} else {
				$bln = $bulan;
			}
			$tahun_1 = $tahun-1;
			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$idl_ipv_t = $this->db->get();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$idl_opcp_t = $this->db->get();
				// echo $this->db->last_query();
				// exit();
			
			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-01-01" and "'. $tahun.'-01-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a1 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-02-01" and "'. $tahun.'-02-28"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a2 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-04-01" and "'. $tahun.'-04-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a4 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-05-01" and "'. $tahun.'-05-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a5 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-06-01" and "'. $tahun.'-06-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a6 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-07-01" and "'. $tahun.'-07-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a7 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-08-01" and "'. $tahun.'-08-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a8 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-09-01" and "'. $tahun.'-09-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a9 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-10-01" and "'. $tahun.'-10-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a10 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-11-01" and "'. $tahun.'-11-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a11 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-12-01" and "'. $tahun.'-12-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$a12 = $this->db->get()->num_rows();
			if ($bulan == "1") {
				$u = $a1;
			} elseif ($bulan == "2") {
				$u = $a1+$a2;
			} elseif ($bulan == "3") {
				$u = $a1+$a2+$a3;
			} elseif ($bulan == "4") {
				$u = $a1+$a2+$a3+$a4;
			} elseif ($bulan == "5") {
				$u = $a1+$a2+$a3+$a4+$a5;
			} elseif ($bulan == "6") {
				$u = $a1+$a2+$a3+$a4+$a5+$a6;
			} elseif ($bulan == "7") {
				$u = $a1+$a2+$a3+$a4+$a5+$a6+$a7;
			} elseif ($bulan == "8") {
				$u = $a1+$a2+$a3+$a4+$a5+$a6+$a7+$a8;
			} elseif ($bulan == "9") {
				$u = $a1+$a2+$a3+$a4+$a5+$a6+$a7+$a8+$a9;
			} elseif ($bulan == "10") {
				$u = $a1+$a2+$a3+$a4+$a5+$a6+$a7+$a8+$a9+$a10;
			} elseif ($bulan == "11") {
				$u = $a1+$a2+$a3+$a4+$a5+$a6+$a7+$a8+$a9+$a10+$a11;
			} elseif ($bulan == "12") {
				$u = $a1+$a2+$a3+$a4+$a5+$a6+$a7+$a8+$a9+$a10+$a11+$a12;
			}



			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-01-01" and "'. $tahun.'-01-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b1 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-02-01" and "'. $tahun.'-02-28"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b2 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-04-01" and "'. $tahun.'-04-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b4 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-05-01" and "'. $tahun.'-05-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b5 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-06-01" and "'. $tahun.'-06-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b6 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-07-01" and "'. $tahun.'-07-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b7 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-08-01" and "'. $tahun.'-08-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b8 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-09-01" and "'. $tahun.'-09-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b9 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-10-01" and "'. $tahun.'-10-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b10 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-11-01" and "'. $tahun.'-11-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b11 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-12-01" and "'. $tahun.'-12-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$b12 = $this->db->get()->num_rows();
			if ($bulan == "1") {
				$v = $b1;
			} elseif ($bulan == "2") {
				$v = $b1+$b2;
			} elseif ($bulan == "3") {
				$v = $b1+$b2+$b3;
			} elseif ($bulan == "4") {
				$v = $b1+$b2+$b3+$b4;
			} elseif ($bulan == "5") {
				$v = $b1+$b2+$b3+$b4+$b5;
			} elseif ($bulan == "6") {
				$v = $b1+$b2+$b3+$b4+$b5+$b6;
			} elseif ($bulan == "7") {
				$v = $b1+$b2+$b3+$b4+$b5+$b6+$b7;
			} elseif ($bulan == "8") {
				$v = $b1+$b2+$b3+$b4+$b5+$b6+$b7+$b8;
			} elseif ($bulan == "9") {
				$v = $b1+$b2+$b3+$b4+$b5+$b6+$b7+$b8+$b9;
			} elseif ($bulan == "10") {
				$v = $b1+$b2+$b3+$b4+$b5+$b6+$b7+$b8+$b9+$b10;
			} elseif ($bulan == "11") {
				$v = $b1+$b2+$b3+$b4+$b5+$b6+$b7+$b8+$b9+$b10+$b11;
			} elseif ($bulan == "12") {
				$v = $b1+$b2+$b3+$b4+$b5+$b6+$b7+$b8+$b9+$b10+$b11+$b12;
			}


			?>
			<td width="5%" align="center">13.</td>
			<td width="45%">IDL IPV</td>
			<td width="8.33%" align="center"><?php echo $idl_ipv_t->num_rows() ?></td>
			<td width="8.33%" align="center"><?php echo $idl_opcp_t->num_rows() ?></td>
			<td width="8.33%" align="center"><?php echo $idl_opcp_t->num_rows()+$idl_ipv_t->num_rows() ?></td>
			<td width="8.33%" align="center"><?php echo $u ?></td>
			<td width="8.33%" align="center"><?php echo $v ?></td>
			<td width="8.33%" align="center"><?php echo $v+$u ?></td>
		</tr>



		<tr>
			<?php
					// IDL L
			$bulan_a = strlen($bulan);
			if ($bulan_a == "1") {
				$bln = "0".$bulan;
			} else {
				$bln = $bulan;
			}
			$tahun_1 = $tahun-1;
			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$idl_ipv_tn = $this->db->get();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bln.'-01" and "'. $tahun.'-'.$bln.'-'.date("d").'"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$idl_opcp_tn = $this->db->get();
			
			
			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-01-01" and "'. $tahun.'-01-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c1 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-02-01" and "'. $tahun.'-02-28"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c2 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-04-01" and "'. $tahun.'-04-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c4 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-05-01" and "'. $tahun.'-05-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c5 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-06-01" and "'. $tahun.'-06-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c6 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-07-01" and "'. $tahun.'-07-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c7 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-08-01" and "'. $tahun.'-08-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c8 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-09-01" and "'. $tahun.'-09-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c9 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-10-01" and "'. $tahun.'-10-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c10 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-11-01" and "'. $tahun.'-11-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c11 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "P")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-12-01" and "'. $tahun.'-12-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$c12 = $this->db->get()->num_rows();
			if ($bulan == "1") {
				$w = $c1;
			} elseif ($bulan == "2") {
				$w = $c1+$c2;
			} elseif ($bulan == "3") {
				$w = $c1+$c2+$c3;
			} elseif ($bulan == "4") {
				$w = $c1+$c2+$c3+$c4;
			} elseif ($bulan == "5") {
				$w = $c1+$c2+$c3+$c4+$c5;
			} elseif ($bulan == "6") {
				$w = $c1+$c2+$c3+$c4+$c5+$c6;
			} elseif ($bulan == "7") {
				$w = $c1+$c2+$c3+$c4+$c5+$c6+$c7;
			} elseif ($bulan == "8") {
				$w = $c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8;
			} elseif ($bulan == "9") {
				$w = $c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8+$c9;
			} elseif ($bulan == "10") {
				$w = $c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8+$c9+$c10;
			} elseif ($bulan == "11") {
				$w = $c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8+$c9+$c10+$c11;
			} elseif ($bulan == "12") {
				$w = $c1+$c2+$c3+$c4+$c5+$c6+$c7+$c8+$c9+$c10+$c11+$c12;
			}



			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-01-01" and "'. $tahun.'-01-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d1 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-02-01" and "'. $tahun.'-02-28"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d2 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-04-01" and "'. $tahun.'-04-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d4 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-05-01" and "'. $tahun.'-05-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d5 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-06-01" and "'. $tahun.'-06-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d6 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-07-01" and "'. $tahun.'-07-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d7 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-08-01" and "'. $tahun.'-08-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d8 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-09-01" and "'. $tahun.'-09-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d9 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-10-01" and "'. $tahun.'-10-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d10 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-11-01" and "'. $tahun.'-11-30"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d11 = $this->db->get()->num_rows();

			$this->db->where(array("jk" => "L")); 
			$this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-12-01" and "'. $tahun.'-12-31"');
			$this->db->group_by("id_anak");
			$this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
			$this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
			$d12 = $this->db->get()->num_rows();
			if ($bulan == "1") {
				$x = $d1;
			} elseif ($bulan == "2") {
				$x = $d1+$d2;
			} elseif ($bulan == "3") {
				$x = $d1+$d2+$d3;
			} elseif ($bulan == "4") {
				$x = $d1+$d2+$d3+$d4;
			} elseif ($bulan == "5") {
				$x = $d1+$d2+$d3+$d4+$d5;
			} elseif ($bulan == "6") {
				$x = $d1+$d2+$d3+$d4+$d5+$d6;
			} elseif ($bulan == "7") {
				$x = $d1+$d2+$d3+$d4+$d5+$d6+$d7;
			} elseif ($bulan == "8") {
				$x = $d1+$d2+$d3+$d4+$d5+$d6+$d7+$d8;
			} elseif ($bulan == "9") {
				$x = $d1+$d2+$d3+$d4+$d5+$d6+$d7+$d8+$d9;
			} elseif ($bulan == "10") {
				$x = $d1+$d2+$d3+$d4+$d5+$d6+$d7+$d8+$d9+$d10;
			} elseif ($bulan == "11") {
				$x = $d1+$d2+$d3+$d4+$d5+$d6+$d7+$d8+$d9+$d10+$d11;
			} elseif ($bulan == "12") {
				$x = $d1+$d2+$d3+$d4+$d5+$d6+$d7+$d8+$d9+$d10+$d11+$d12;
			}


			?>
			<td width="5%" align="center">13.</td>
			<td width="45%">IDL NON IPV</td>
			<td width="8.33%" align="center"><?php echo $idl_ipv_tn->num_rows() ?></td>
			<td width="8.33%" align="center"><?php echo $idl_opcp_tn->num_rows() ?></td>
			<td width="8.33%" align="center"><?php echo $idl_opcp_tn->num_rows()+$idl_ipv_tn->num_rows() ?></td>
			<td width="8.33%" align="center"><?php echo $w ?></td>
			<td width="8.33%" align="center"><?php echo $x ?></td>
			<td width="8.33%" align="center"><?php echo $x+$w ?></td>
		</tr>
		<tr>
			<th width="5%" style="background-color: #D1A6F9">B</th>
			<th width="45%" style="text-align: left; background-color: #D1A6F9">IMUNISASI LANJUTAN</th>
			<th style="text-align: center; background-color: #D1A6F9">L</th>
			<th style="text-align: center; background-color: #D1A6F9">P</th>
			<th style="text-align: center; background-color: #D1A6F9">JML</th>
			<th style="text-align: center; background-color: #D1A6F9">L</th>
			<th style="text-align: center; background-color: #D1A6F9">P</th>
			<th style="text-align: center; background-color: #D1A6F9">JML</th>
		</tr>
		<?php 
			$no = 0;
			foreach ($res2->result() as $row) :
			$no ++ ; ?>
			<tr>
				<td width="5%" align="center"><?php echo $no ?>.</td>
				<td width="45%"><?php echo strtoupper($row->nama_penyakit) ?></td>
				<?php 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jk" => "L")); 
				$l_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $l_i->num_rows() ?></td>
				<?php 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan, "jk" => "P")); 
				$p_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $p_i->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $p_i->num_rows()+$l_i->num_rows() ?></td>

				<?php
				$this->db->where("bulan between '1' and ".$bulan." "); 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "jk" => "L")); 
				$ld_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $ld_i->num_rows() ?></td>
				<?php 
				$this->db->where("bulan between '1' and ".$bulan." "); 
				$this->db->where(array( "jenis_vaksin" => $row->id_penyakit, "year(tgl_suntik)" => $tahun, "jk" => "P")); 
				$pd_i = $this->db->get("imunisasi");
				?>
				<td width="8.33%" align="center"><?php echo $pd_i->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $pd_i->num_rows()+$ld_i->num_rows() ?></td>
			</tr>
			
		<?php endforeach; ?>

		<tr>
			<th width="5%" style="background-color: #D7F9A6">C</th>
			<th width="45%" style="text-align: left; background-color: #D7F9A6">IMUNISASI WUS</th>
			<th style="text-align: center; background-color: #D7F9A6">BML</th>
			<th style="text-align: center; background-color: #D7F9A6"># BML</th>
			<th style="text-align: center; background-color: #D7F9A6">JML</th>
			<th style="text-align: center; background-color: #D7F9A6">BML</th>
			<th style="text-align: center; background-color: #D7F9A6"># BML</th>
			<th style="text-align: center; background-color: #D7F9A6">JML</th>
		</tr>
		
			<tr>
				<td width="5%" align="center">1.</td>
				<td width="45%">Td 1 </td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "tt1", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$a = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $a->num_rows() ?></td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "ttw1", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$b = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $b->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $b->num_rows()+$a->num_rows() ?></td>

				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "tt1", "year(tgl_suntik)" => $tahun)); 
					$c = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $c->num_rows() ?></td>
				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "ttw1", "year(tgl_suntik)" => $tahun)); 
					$d = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $d->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $d->num_rows()+$c->num_rows() ?></td>

			</tr>
			<tr>
				<td width="5%" align="center">2.</td>
				<td width="45%">Td 2 </td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "tt2", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$a = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $a->num_rows() ?></td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "ttw2", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$b = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $b->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $b->num_rows()+$a->num_rows() ?></td>

				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "tt2", "year(tgl_suntik)" => $tahun)); 
					$c = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $c->num_rows() ?></td>
				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "ttw2", "year(tgl_suntik)" => $tahun)); 
					$d = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $d->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $d->num_rows()+$c->num_rows() ?></td>
			</tr>
			<tr>
				<td width="5%" align="center">3.</td>
				<td width="45%">Td 3 </td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "tt3", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$a = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $a->num_rows() ?></td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "ttw3", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$b = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $b->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $b->num_rows()+$a->num_rows() ?></td>

				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "tt3", "year(tgl_suntik)" => $tahun)); 
					$c = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $c->num_rows() ?></td>
				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "ttw3", "year(tgl_suntik)" => $tahun)); 
					$d = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $d->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $d->num_rows()+$c->num_rows() ?></td>
			</tr>
			<tr>
				<td width="5%" align="center">4.</td>
				<td width="45%">Td 4 </td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "tt4", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$a = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $a->num_rows() ?></td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "ttw4", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$b = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $b->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $b->num_rows()+$a->num_rows() ?></td>

				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "tt4", "year(tgl_suntik)" => $tahun)); 
					$c = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $c->num_rows() ?></td>
				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "ttw4", "year(tgl_suntik)" => $tahun)); 
					$d = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $d->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $d->num_rows()+$c->num_rows() ?></td>
			</tr>
			<tr>
				<td width="5%" align="center">5.</td>
				<td width="45%">Td 5 </td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "tt5", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$a = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $a->num_rows() ?></td>
				<?php 

					$this->db->where(array( "jenis_vaksin" => "ttw5", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$b = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $b->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $b->num_rows()+$a->num_rows() ?></td>

				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "tt5", "year(tgl_suntik)" => $tahun)); 
					$c = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $c->num_rows() ?></td>
				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "ttw5", "year(tgl_suntik)" => $tahun)); 
					$d = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $d->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $d->num_rows()+$c->num_rows() ?></td>
			</tr>
			<tr>
				<td width="5%" align="center">6.</td>
				<td width="45%">LONG LIFE </td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "ttll", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$a = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $a->num_rows() ?></td>
				<?php 
					$this->db->where(array( "jenis_vaksin" => "ttwll", "year(tgl_suntik)" => $tahun, "month(tgl_suntik)" => $bulan)); 
					$b = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $b->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $b->num_rows()+$a->num_rows() ?></td>

				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "ttll", "year(tgl_suntik)" => $tahun)); 
					$c = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $c->num_rows() ?></td>
				<?php 
					$this->db->where("bulan between '1' and ".$bulan." "); 
					$this->db->where(array( "jenis_vaksin" => "ttwll", "year(tgl_suntik)" => $tahun)); 
					$d = $this->db->get("imunisasi_ibu");
				?>
				<td width="8.33%" align="center"><?php echo $d->num_rows() ?></td>
				<td width="8.33%" align="center"><?php echo $d->num_rows()+$c->num_rows() ?></td>
			</tr>
	</table>
<p></p>
<table width="100%" border="0" cellpadding="0" class="ttd">
  <?php if ($ttd == "kadis") {?> 
  	<tr>
  		<td width="70%">Mengetahui,</td>
  		<td width="50%" align="left"><?php echo $this->om->web_me()->alamat ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>
  <?php } elseif ($ttd == "kasi") { ?>
  	<tr>
  		<td width="70%">An. Kepala Dinas Kesehatan</td>
  		<td width="50%" align="left"><?php echo $this->om->web_me()->alamat ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>


<?php } elseif ($ttd == "kabid") { ?>
  	<tr>
  		<td width="70%">Mengetahui,</td>
  		<td width="50%" align="left"><?php echo $this->om->web_me()->alamat ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>
 <?php  } ?>
 
  
  <tr>
    <!-- <td></td> -->
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
  
    <td></td>
    <td></td>
  </tr>
   <tr>
   
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td><?php echo $ttd_nama ?></td>
    <td><?php echo $this->om->user()->nama_lengkap ?></td>
  </tr>
  <tr>
    <?php if (empty($ttd_nip)) {?>
    	<td></td>
    <?php } else {?>
    	<td>NIP.<?php echo $ttd_nip ?></td>
    <?php } ?>
    <?php if (empty($this->om->user()->nip_operator_dinas)) {?>
    	<td></td>
    <?php } else {?>
    	<td>NIP.<?php echo $this->om->user()->nip_operator_dinas ?></td>
    <?php } ?>
  </tr>
 
</table>
</body>

</html>
