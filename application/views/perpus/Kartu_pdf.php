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
	
<table width="100%">
	<tr>
		<td width="10%"><img style="width: 45px" src="<?php echo FCPATH."assets/images/".$this->fm->web_me()->gambar; ?>"></td>
		<td class="judul" width="85%">PERPUSTAKAAN <?php echo $this->fm->web_me()->universitas ?><br>Alamat : <?php echo $this->fm->web_me()->alamat."<br>Telepon ".$this->fm->web_me()->no_telp ?><br></td>
	
	</tr>
	<tr>
		<td colspan="2"><hr></td>
	</tr>

</table>

	<table width="100%" cellspacing="4">
		
		
		<tr>
			<td colspan="3" align="center" style="font-weight: bold;">SURAT KETERANGAN BEBAS PUSTAKA</td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td colspan="3">Yang bertanda tangan dibawah ini menerangkan bahwa :</td>
		</tr>
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td width="25%">Nomor Anggota</td>
			<td width="2%">:</td>
			<?php 
				$a = hash("sha512", md5($res->username));
				$b = preg_replace("/[^0-9]/","",$a);
				$c = substr($b, 0,8);
			?>
			<td width="73%"><?php echo $c  ?></td>
		</tr>
		<tr>
			<td >Nama</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_lengkap))  ?></td>
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
		<tr>
			<td colspan="3"></td>
		</tr>
		<tr>
			<td colspan="3">Mahasiswa tersebut tidak memiliki pinjaman koleksi milik Perpustakaan <?php echo ucwords(strtolower($this->fm->web_me()->universitas)) ?>.</td>
		</tr>
		<tr>
			<td colspan="3">Demikian surat ini untuk dipergunakan sebagaimana mestinya.</td>
		</tr>
		
	</table>
	<p></p>
	<table width="100%">
		<tr>
			<td width="50%"></td>
			<td align="center"><?php echo $this->fm->web_me()->kabupaten.", ".tgl_indo(date("Y-m-d")) ?></td>
		</tr>
		<tr>
			<td></td>
			<td align="center">Kepala Perpustakaan<br><?php echo $this->fm->web_me()->nama_website ?></td>
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
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td align="center"><?php echo $this->fm->web_me()->kepala_perpus ?></td>
		</tr>

	</table>
</body>

</html>