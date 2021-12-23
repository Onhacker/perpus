<table width="100%" border="0" cellpadding="0" class="ttd">

	<tr>

		<td width="80%">Mengetahui,</td>
		<td width="40%" align="left"><?php echo $this->om->identitas_general($id_pkm)->nama_pkm ?>, <?php echo tgl_indo(date("Y-m-d")) ?></td>
	</tr>
	<tr>

		<td>Kepala <?php echo $this->om->bentuk_admin($id_pkm,"p")." ".$this->om->identitas_general($id_pkm)->nama_pkm ?></td>
		<td align="left">Pengelola Imunisasi,</td>
	</tr>
	<tr>

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

		<td style="font-weight: bold;"><?php echo $this->om->user_general($id_pkm)->pimpinan ?></td>
		<td style="font-weight: bold;"><?php echo $this->om->user_general($id_pkm)->nama_lengkap ?></td>
	</tr>
	<tr>

		<?php if (empty($this->om->user_general($id_pkm)->nip_pimpinan)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($id_pkm)->nip_pimpinan ?></td>
		<?php } ?>
		<?php if (empty($this->om->user_general($id_pkm)->nip_operator_dinas)) {?>
			<td></td>
		<?php } else {?>
			<td>NIP.<?php echo $this->om->user_general($id_pkm)->nip_operator_dinas ?></td>
		<?php } ?>

		<td></td>
	</tr>

</table>