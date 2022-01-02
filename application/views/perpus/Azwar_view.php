
<table class="table table bordered">
	<tr>
		<td>No</td>
		<td>NIM</td>
		<td>Nama</td>
	</tr>

<?php 
$i = 0;
foreach($mahasiswa->result() as $row) :
$i++;
?>
<tr>
	<td><?php echo $i ?></td>
	<td><?php echo $row->nim ?></td>
	<td><?php echo $row->nama_lengkap ?></td>
</tr>


<?php endforeach;


?>
</table>