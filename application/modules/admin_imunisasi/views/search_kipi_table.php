  <p></p>
  <p style="font-weight: bold;" class="text-primary">Hasil Pencarian : <span id="ketikan"></span></p>
  <table id="datatable-buttons" class=" table table-striped table-bordered"  cellspacing="0" width="100%">
  	<thead>
  		<tr>
  			<th>Pilih</th>
  			<th> NO. </th>
  			<th> TGL SUNTIK </th>
  			<th> JENIS VAKSIN 1</th>
  			<th> JENIS VAKSIN 2</th>
  			<th> NAMA </th>
  			<th> JK </th>
  			<th> TTL </th>
  			<th> UMUR </th>
  			<th> NAMA IBU </th>
  			<th> ALAMAT</th>
  			

  		</tr> 
  	</thead>

	<?php 
	if ($record->num_rows() == 0) {
		echo "<tr><td colspan ='9' align='center'><span class = 'text-danger'>Data tidak ditemukan. Silahkan register data Anak terlbih dahulu</span></td></tr>";
	}
	$i=0;
	foreach ($record->result() as $row) : 
		 $i++;
	?>
	<tr>
	<td align="center"><a href="javascript:void(0)" onclick="pilih('<?php echo $row->id_anak."_".$row->tgl_suntik ?>','<?php echo $row->id_anak."_".$row->tgl_suntik ?>', '<?php echo "#".$target; ?>');" > <span class="badge badge-primary">Pilih</span> </a></td>
	<td align="center"><?php echo $i; ?>.</td>
	<td><?php echo tgl_view($row->tgl_suntik); ?></td>
	<?php 
		$tahun = $this->om->web_me()->tahun_akhir;
		$this->db->where("id_anak",$row->id_anak);
		$this->db->where("tahun",$tahun);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
		$this->db->where("tgl_suntik",$row->tgl_suntik);
		$this->db->select("jenis_vaksin");
		$this->db->from("imunisasi");
		$this->db->limit(1,0);
		$this->db->order_by("urutan","ASC");
		$v1 = $this->db->get()->row();

		$tahun = $this->om->web_me()->tahun_akhir;
		$this->db->where("id_anak",$row->id_anak);
		$this->db->where("tahun",$tahun);
        $this->db->where("id_pkm",$this->session->userdata("admin_pkm"));
		$this->db->where("tgl_suntik",$row->tgl_suntik);
		$this->db->select("jenis_vaksin");
		$this->db->from("imunisasi");
		$this->db->limit(1,1);
		$this->db->order_by("urutan","ASC");
		$v2 = $this->db->get()->row();

		$this->db->where("id_penyakit",$v1->jenis_vaksin);
		$v11 = $this->db->get("master_penyakit")->row();

		$this->db->where("id_penyakit",$v2->jenis_vaksin);
		$v22 = $this->db->get("master_penyakit")->row();
	?>
	<td><?php echo ($v11->nama_penyakit); ?></td>
	<td><?php echo ($v22->nama_penyakit); ?></td>
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