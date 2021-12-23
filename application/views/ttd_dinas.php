<table width="100%" border="0" cellpadding="0" class="ttd">
  <?php if ($ttd == "kadis") {?> 
  	<tr>
  		<td width="80%">Mengetahui,</td>
  		<td width="50%" align="left"><?php echo $this->om->web_me()->alamat ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>
  <?php } elseif ($ttd == "kasi") { ?>
  	<tr>
  		<td width="80%">An. Kepala Dinas Kesehatan</td>
  		<td width="50%" align="left"><?php echo $this->om->web_me()->alamat ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>


<?php } elseif ($ttd == "kabid") { ?>
  	<tr>
  		<td width="80%">Mengetahui,</td>
  		<td width="50%" align="left"><?php echo $this->om->web_me()->alamat ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
  	</tr>
  	<tr>
  		<td><?php echo $ttd_jabatan ?></td>
  		<td align="left">Pengelola Imunisasi,</td>
  	</tr>
 <?php  } ?>
 
  
  <tr>
    <!-- <td></td> -->
    <td></td>
    <td align="left">&nbsp;</td>
    
  </tr>
  <tr>
    
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
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
    <td><?php echo $ttd_nama ?></td>
    <td><?php echo $this->om->user()->nama_lengkap ?></td>
  </tr>
  <tr>
    <?php if (empty($ttd_nip)) {?>
    	<td></td>
    <?php } else {?>
    	<td>NIP.<?php echo $ttd_nip ?></td>
    <?php } ?>
    <?php if (empty($this->om->user()->nip_operator_dinas)) {?>
    	<td></td>
    <?php } else {?>
    	<td>NIP.<?php echo $this->om->user()->nip_operator_dinas ?></td>
    <?php } ?>
  </tr>
 
</table>