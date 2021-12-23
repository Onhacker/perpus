  <p></p>
  <p style="font-weight: bold;" class="text-primary">Hasil Pencarian : <span id="ketikan"></span></p>
  <table id="datatable-buttons" class=" table table-striped table-bordered"  cellspacing="0" width="100%">
  	<thead>
  		<tr>
  			<th>Pilih</th>
  			<th> NO. </th>
  			<th> No KIA</th>
  			<th> Nama </th>
  			<th> JK </th>
  			<th> TTL </th>
  			<th> UMUR </th>
  			<th> NAMA IBU </th>
  			<th> ALAMAT</th>
  			

  		</tr> 
  	</thead>

	<?php 
	if ($record->num_rows() == 0) {
		echo "<tr><td colspan ='9' align='center'><span class = 'text-danger'>Data tidak ditemukan. Silahkan register data Bumil terlbih dahulu</span></td></tr>";
	}
	$i=0;
	foreach ($record->result() as $row) : 
		 $i++;
	?>
	<tr>
	<td align="center"><a href="javascript:void(0)" onclick="pilih('<?php echo $row->id_ibu ?>','<?php echo $row->id_ibu ?>', '<?php echo "#".$target; ?>');" > <span class="badge badge-primary">Pilih</span> </a></td>
	<td align="center"><?php echo $i; ?>.</td>
	<td><?php echo $row->no_kia; ?></td>
	<td><?php echo $row->nama; ?></td>
	<td><?php echo $row->jk; ?></td>
	<td><?php echo $row->tempat_lahir.", ".tgl_view($row->tgl_lahir); ?></td>
	<td><?php echo umur($row->tgl_lahir); ?></td>
	<td><?php echo ($row->nama_ibu); ?></td>
	<?php  
		$this->db->where("id_desa",$row->id_desa);
        $de = $this->db->get("master_desa")->row(); 
    ?>
	<td ><?php echo ucwords(strtolower($row->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($de->desa))?></td>
	
	
	
</tr>
<?php endforeach; ?>
</table>