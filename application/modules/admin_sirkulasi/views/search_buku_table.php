  <p></p>
  <p style="font-weight: bold;" class="text-primary">Hasil Pencarian : <code><?php echo $keyword ?></code> </p>
  <table id="datatable-buttons" class=" table table-striped table-bordered"  cellspacing="0" width="100%">
  	<thead style="background-color: #7B68EE; color: white">
  		<tr>
  			<th>Pilih</th>
  			<th> NO. </th>
  			<th> Kode Buku</th>
  			<th> Judul Buku </th>
  			<th> Pengarang </th>
  			<th> Penerbit </th>
  			<th> Tahun Terbit </th>
  			
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
	<td align="center"><a href="javascript:void(0)" onclick="pilih('<?php echo $row->id_buku ?>','<?php echo $row->id_buku ?>', '<?php echo "#".$target; ?>');" > <span class="badge badge-primary">Pilih</span> </a></td>
	<td align="center"><?php echo $i; ?>.</td>
	<td><?php echo $row->kode_buku; ?></td>
	<td><?php echo $row->judul_buku; ?></td>
	<td><?php echo $row->nama_pengarang; ?></td>
	<td><?php echo $row->nama_penerbit; ?></td>
	<td><?php echo $row->tahun_terbit; ?></td>

	
</tr>
<?php endforeach; ?>
</table>