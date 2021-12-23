<?php if ($this->session->userdata("admin_login") == true) { ?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">
	<tr>

		<td width="60%"></td>
		<td width="40%" align="left">
			<?php echo ($this->om->identitas_general($res->id_pkm)->nama_pkm)  ?>,
			<?php echo tgl_indo($res->tgl_suntik) ?></td>
		</tr>
		<tr>

			<td></td>
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
			<td style="font-weight: bold;"></td>
			<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_pkm)->nama_lengkap ?></td>
		</tr>
		<tr>
			<td></td>
			<?php if (empty($this->om->user_general($res->id_pkm)->nip_operator_dinas)) {?>
				<td></td>
			<?php } else {?>
				<td>NIP. <?php echo $this->om->user_general($res->id_pkm)->nip_operator_dinas ?></td>
			<?php } ?>
			
		</tr>
</table>
<?php } else { ?>
<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">
	<tr>

		<td width="60%"></td>
		<td width="40%" align="left">
			<?php echo ($this->fm->identitas_general($res->id_pkm)->nama_pkm)  ?>,
			<?php echo tgl_indo($res->tgl_suntik) ?></td>
		</tr>
		<tr>

			<td></td>
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
			<td style="font-weight: bold;"></td>
			<td style="font-weight: bold;"><?php echo $this->fm->user_general($res->id_pkm)->nama_lengkap ?></td>
		</tr>
		<tr>
			<td></td>
			<?php if (empty($this->fm->user_general($res->id_pkm)->nip_operator_dinas)) {?>
				<td></td>
			<?php } else {?>
				<td>NIP. <?php echo $this->fm->user_general($res->id_pkm)->nip_operator_dinas ?></td>
			<?php } ?>
			
		</tr>
</table>
<?php } ?>