<?php if ($this->session->userdata("admin_login") == true) { ?>
		
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">

	<tr>

		<td width="60%">Mengetahui,</td>
		<td width="40%" align="left"><?php echo$this->om->identitas_general($res->id_pkm)->nama_pkm ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
	</tr>
	<tr>

		<td>Kepala <?php echo $this->om->bentuk_admin($res->id_pkm,"p")." ".$this->om->identitas_general($res->id_pkm)->nama_pkm ?></td>
		<td align="left">Pengelola Imunisasi,</td>
	</tr>
	<tr>

		<td></td>
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

		<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_pkm)->pimpinan ?></td>
		<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_pkm)->nama_lengkap ?></td>
	</tr>
	<tr>

		<?php if (empty($this->om->user_general($res->id_pkm)->nip_pimpinan)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($res->id_pkm)->nip_pimpinan ?></td>
		<?php } ?>
		<?php if (empty($this->om->user_general($res->id_pkm)->nip_operator_dinas)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($res->id_pkm)->nip_operator_dinas ?></td>
		<?php } ?>

		<td></td>
	</tr>

</table>
<?php } else {?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">

	<tr>

		<td width="60%">Mengetahui,</td>
		<td width="40%" align="left"><?php echo$this->fm->identitas_general($res->id_pkm)->nama_pkm ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
	</tr>
	<tr>

		<td>Kepala <?php echo $this->fm->bentuk_admin($res->id_pkm,"p")." ".$this->fm->identitas_general($res->id_pkm)->nama_pkm ?></td>
		<td align="left">Pengelola Imunisasi,</td>
	</tr>
	<tr>

		<td></td>
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

		<td style="font-weight: bold;"><?php echo $this->fm->user_general($res->id_pkm)->pimpinan ?></td>
		<td style="font-weight: bold;"><?php echo $this->fm->user_general($res->id_pkm)->nama_lengkap ?></td>
	</tr>
	<tr>

		<?php if (empty($this->fm->user_general($res->id_pkm)->nip_pimpinan)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->fm->user_general($res->id_pkm)->nip_pimpinan ?></td>
		<?php } ?>
		<?php if (empty($this->fm->user_general($res->id_pkm)->nip_operator_dinas)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->fm->user_general($res->id_pkm)->nip_operator_dinas ?></td>
		<?php } ?>

		<td></td>
	</tr>

</table>
<?php } ?>
