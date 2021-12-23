  <p></p>
  <p style="font-weight: bold;" class="text-primary">Hasil Pencarian : <code><?php echo $keyword ?></code> </p>
  <table id="datatable-buttons" class=" table table-striped table-bordered"  cellspacing="0" width="100%">
  	<thead style="background-color: #191970; color: white">
  		<tr>
  			<th>Pilih</th>
  			<th> NO. </th>
  			<th> NIM</th>
  			<th> Nama </th>
  			<th> No. Hp </th>
  			<th> Fakultas </th>
  			<th> jurusan</th>
  			<th>Prodi</th>
  			<th>Angkatan</th>
  			
  		</tr> 
  	</thead>

	<?php 
	if ($record->num_rows() == 0) {
		echo "<tr><td colspan ='9' align='center'><span class = 'text-danger'>Data tidak ditemukan</span></td></tr>";
	}
	$i=0;
	foreach ($record->result() as $row) : 
		 $i++;
	?>
	<tr>
	<td align="center"><a href="javascript:void(0)" onclick="pilih_nim('<?php echo $row->nim ?>','<?php echo $row->nim ?>', '<?php echo "#".$target_nim; ?>');" > <span class="badge badge-primary">Pilih</span> </a></td>
	<td align="center"><?php echo $i; ?>.</td>
	<td><?php echo $row->nim; ?></td>
	<td><?php echo $row->nama_lengkap; ?></td>
	<td><?php echo $row->no_telp; ?></td>
	<td><?php echo $row->nama_fakultas; ?></td>
	<td><?php echo $row->nama_jurusan; ?></td>
	<td><?php echo $row->nama_prodi; ?></td>
	<td><?php echo $row->angkatan; ?></td>

	
</tr>
<?php endforeach; ?>
</table>