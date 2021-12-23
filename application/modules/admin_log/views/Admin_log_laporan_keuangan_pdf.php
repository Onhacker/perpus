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
			font-size : 11px;
			text-align: center;
			font-weight: bold;
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

<body>
	<p align="center" class="judul"><strong><?php echo $title ?> </strong></p>

	
	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th width="3%">No.</th>
				<th width="15%">NIM</th>
				<th width="15%">Nama</th>
				<th width="20%">Judul Buku</th>
				<th width="15%">Waktu Peminjaman</th>
				<th width="12%">Tanggal Dikembalikan</th>
				<th width="10%">Lewat</th>
				<th width="10%">Denda</th>
				
				
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
				$tgl_peminjaman = explode(" ", $row->tgl_peminjaman);
				$tgl_pengembalian = explode(" ", $row->tgl_pengembalian);
				$tgl_dikembalikan = explode(" ", $row->tgl_dikembalikan);
			$i++; ?>
			<tr>
				<td align="center" width="3%"><?php echo $i ?>.</td>
				<td width="15%" align="center"><?php echo $row->nim ?></td>
				<td width="15%" ><?php echo "<strong>".ucwords(strtolower($row->nama_mahasiswa))."</strong>" ?></td>
				<td width="20%" align="left"><?php echo $row->judul_buku ?></td>
				<td width="15%" align="left"><?php echo flipdate($tgl_peminjaman[0])." ".$tgl_peminjaman[1]." s/d ".flipdate($tgl_pengembalian[0])." ".$tgl_pengembalian[1] ?></td>
				<td width="12%" align="center"><?php echo flipdate($tgl_dikembalikan[0])." ".$tgl_dikembalikan[1] ?></td>
				<td width="10%" align="right" ><?php echo $row->lewat." Hari" ?></td>
				<td width="10%" align="right" ><?php echo uang($row->uang) ?></td>
			</tr>
		<?php endforeach; ?>
			<tr>
				<td colspan="7" align="right"><strong>Total</strong></td>
				<td align="right"><strong><?php echo uang($jumlah_denda) ?></strong></td>

			</tr>
	</table>

</body>

</html>
