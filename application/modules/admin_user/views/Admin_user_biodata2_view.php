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

<body>
	<?php $this->load->view("kop") ?>
	<table width="100%" cellspacing="4">
		
		<tr>
			<td colspan="3" align="center" style="font-weight: bold;">BIODATA MEMBER</td>
		</tr>
		<tr>
			<td width="25%">Tgl. Registrasi</td>
			<td width="2%">:</td>
			<td width="73%"><?php echo tgl_indo($res->tanggal_reg)  ?></td>
		</tr>
		<tr>
			<td >Nama</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_lengkap))  ?></td>
		</tr>
		<tr>
			<td width="25%">NIM</td>
			<td width="2%">:</td>
			<td width="73%"><?php echo $res->nim  ?></td>
		</tr>
		<tr>
			<td >Email</td>
			<td >:</td>
			<td ><?php echo (($res->email))  ?></td>
		</tr>
		<tr>
			<td >No. Telepon</td>
			<td >:</td>
			<td ><?php echo (($res->no_telp))  ?></td>
		</tr>
		<tr>
			<td >Alamat</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->alamat))  ?></td>
		</tr>
		<tr>
			<td >Fakultas</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_fakultas))  ?></td>
		</tr>
		<tr>
			<td >Jurusan</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_jurusan))  ?></td>
		</tr>
		<tr>
			<td >Program Studi</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_prodi))  ?></td>
		</tr>
		<tr>
			<td >Angkatan</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->angkatan))  ?></td>
		</tr>
		
	</table>
</body>

</html>