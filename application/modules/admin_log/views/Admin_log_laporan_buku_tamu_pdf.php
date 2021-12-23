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
	<p align="center" class="judul"><strong><?php echo $title ?></strong></p>

	
	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th width="3%">No.</th>
				<th width="15%">Nama</th>
				<th width="15%">Email</th>
				<th width="15%">Alamat</th>
				<th width="10%">Tanggal</th>
				<th width="42%">Pesan</th>
				
				
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
				$tgl = explode(" ", $row->tanggal);
			$i++; ?>
			<tr>
				<td align="center" width="3%"><?php echo $i ?>.</td>
				<td width="15%" ><?php echo "<strong>".ucwords(strtolower($row->nama))."</strong>" ?></td>
				<td width="15%" align="center"><?php echo $row->email ?></td>
				<td width="15%" align="center"><?php echo $row->alamat ?></td>
				<td width="10%" align="center"><?php echo tgl_indo($tgl[0])." ".$tgl[1] ?></td>
				<td width="42%" align="left" ><?php echo $row->pesan ?></td>
				
				
			</tr>
		<?php endforeach; ?>
	
	</table>

</body>

</html>
