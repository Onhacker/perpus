<html>
<head>
	<title>
		Laporan
	</title>
	<style>
		* {
			font-size:8px;
		}
		.judul {
			font-size:8px;
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
	<table width="100%"  >
		<tr>
			<td>
				<table border="1px" width="85%">
					<tr>
						<td>
							<table width="100%" cellpadding="1" style="background-color: #192f59; color: white;">
								<tr>
									<td width="15%">&nbsp;<img style="width: 50px; " src="<?php echo FCPATH."assets/images/".$this->om->web_me()->favicon; ?>"></td>
									<td class="judul" width="85%" colspan="2"><?php echo $this->om->web_me()->universitas ?><br><span style="font-size: 7px !important; font-weight: bold !important;"><?php echo strtoupper($this->om->web_me()->alamat) ?></span><br><span style="font-size: 6px !important; font-weight: normal !important;">Telepon <?php echo $this->om->web_me()->no_telp ?></span></td>
								</tr>
							</table>
							<hr>
	
							<table width="100%" cellspacing="2">
								<tr>
									<td colspan="3" align="center" style="font-weight: bold;">KARTU ANGGOTA PERPUSTAKAAN</td>
								</tr>
								<tr>
									<td width="25%">NIM</td>
									<td width="2%">:</td>
									
									<td width="73%"><?php echo $res->nim  ?></td>
								</tr>
								<tr>
									<td >Nama</td>
									<td >:</td>
									<td ><?php echo ucwords(strtolower($res->nama_lengkap))  ?></td>
								</tr>
								<tr>
									<td width="25%">Fakultas</td>
									<td width="2%">:</td>
									<td width="73%"><?php echo $res->nama_fakultas  ?></td>
								</tr>
								<tr>
									<td width="25%">Jurusan</td>
									<td width="2%">:</td>
									<td width="73%"><?php echo $res->nama_jurusan  ?></td>
								</tr>
								<tr>
									<td width="25%">Program Studi</td>
									<td width="2%">:</td>
									<td width="73%"><?php echo $res->nama_prodi  ?></td>
								</tr>
								
								
								<tr>
									<td colspan="2" rowspan="2"><img style="width: 30px;" src="<?php echo $savename;?>"></td>
									<td align="right"></td>
								</tr>
								<tr>
									<!-- <td colspan="2"></td> -->
									<td align="right">Terdaftar <?php echo tgl_indo(date($res->tanggal_reg)) ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>


			<td>
				<table border="1px" width="85%" >
					<tr>
						<td>
							<table width="100%" cellspacing="4" >
								<tr>
									<td colspan="2" align="center" style="font-size: 9px; font-weight: bold"><?php echo (($this->om->web_me()->nama_website)) ?>	</td>
								</tr>
								<tr>
									<td colspan="2"><hr></td>
								</tr>
								<tr>
									<td colspan="2">Syarat dan Ketentuan : </td>
								</tr>
								<tr>
									<td width="8%">1.</td>
									<td width="92%">Kartu ini harap dibawa ketika ingin meminjam buku di <?php echo ucwords(strtolower($this->om->web_me()->universitas)) ?>	
									</td>
								</tr>
								<tr>
									<td>2.</td>
									<td>Apabila kartu ini disalahgunakan, akan dikenakan sanksi</td>
								</tr>
								<tr>
									<td>3.</td>
									<td>Kartu ini tidak dapat digunakan oleh orang lain</td>
								</tr>
								
								
								<tr>
									<td colspan="2"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
								</tr>
								<br>
								<tr>
									<td colspan="2" >Telp. <?php echo $this->om->web_me()->telp  ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>

						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


</body>

</html>