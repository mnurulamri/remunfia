<?
session_start();
include("conn.php");
include("bulan.php");
?>

<script src="jqgrid/js/autocomplete.js" type="text/javascript"></script>
<script src="js/jquery.formatCurrency.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	//Mempercantik Button dengan Jquery UI
	$("#submit").button();
	$("#reset").button();
	$("#AddBimbingan").button();
	$("#clear").button();
	
	$("#tunjangan").keyup(function(){
		var tunjangan = $("#tunjangan").val();
		$("#vtunjangan").val(tunjangan);
		$("#vtunjangan").toNumber();
		$("#tunjangan").formatCurrency();		
	});	
});	

//fungsi clear nama dosen
function kosongkan(){
	document.getElementById('nama_pengajar').value = ''; 
	document.getElementById('nip').value = ''; 
	document.getElementById('nama_pengajar').focus();
	document.getElementById('jabatan').value = '';
	document.getElementById('tunjangan').value = 0;
	document.getElementById('vtunjangan').value = 0;
	document.getElementById('periode').value = 0;
}

</script>
<div >
<fieldset id="center">
	<legend>Add</legend>
	<form method="post" action="tunjangan_struktural_crud.php" name="form1" id="form1">
		<input type="hidden" name="oper" value="add">
		<table border="0" cellpadding="3" cellspacing="0" id="center">
			<tr>
				<td id="label">Tahun</td>
				<td>:&nbsp;</td>
				<td>
					<select name="tahun" id="tahun" class="ui-widget ui-widget-content padding ui-corner-all" onchange="gridReload()">
						<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
						<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
					</select>
				</td>			
				<td id="label">Bulan</td>
				<td>:</td>
				<td>
					<select name="bulan" id="bulan" class="ui-widget ui-widget-content padding ui-corner-all" onchange="gridReload()">
						<option style="color:blue;" value="<?php echo $vbulan ?>"><?php echo $month ?></option>
						<option style="color:magenta;" value="01">Januari</option>									
						<option style="color:blue;" value="02">Februari</option>
						<option style="color:green;" value="03">Maret</option>
						<option style="color:purple;" value="04">April</option>
						<option style="color:red;" value="05">Mei</option>
						<option style="color:blue;" value="06">Juni</option>
						<option style="color:green;" value="07">Juli</option>
						<option style="color:purple;" value="08">Agustus</option>
						<option style="color:red;" value="09">September</option>
						<option style="color:blue;" value="10">Oktober</option>
						<option style="color:green;" value="11">November</option>
						<option style="color:purple;" value="12">Desember</option>									
					</select>							
				</td>
				<td id="label">Periode</td>
				<td>:</td>
				<td><input type="text" name="periode" size="10" maxlength="10" id="periode" class="ui-widget ui-widget-content padding ui-corner-all" style="text-align: center"></td>				
			</tr>
			<tr>
				<td id="label">Nama Pengajar</td>
				<td>:</td>
				<td>
					<input type="text" name="nama_pengajar" id="nama_pengajar" size="27" class="ui-widget ui-widget-content padding ui-corner-all" onkeyup="lihat(this.value,document.getElementById('tahun').value,document.getElementById('bulan').value)"/>	
					<input type="button" value="clear" id="clear" class="button" onclick="kosongkan()"/>
					<div id="kotaksugest" ></div>					
				</td>
				<td id="label">NIP</td>
				<td>:&nbsp;</td>
				<td><input type="text" name="nip" id="nip" class="ui-widget ui-widget-content padding ui-corner-all"></td>
				<td colspan="3" align="center"></td>
			</tr>
			<tr>
				<td id="label">Jabatan</td>
				<td>:</td>
				<td>
					<input type="text" name="jabatan" id="jabatan" size="35" class="ui-widget ui-widget-content padding ui-corner-all"/>
				</td>
				<td id="label">Tunjangan</td>
				<td>:</td>
				<td><input type="text" name="tunjangan" id="tunjangan" value="0" onkeypress="return isNumberKey(event)" size="20" maxlength="10" onClick="this.select();" onblur="return formatCurrency(this.value,0,',','','','','','')" class="ui-widget ui-widget-content padding ui-corner-all" style="text-align: right;"></td>
				<td colspan="3" align="center">
					<input type="button" name="submit" id="submit" value="save" class="button"/>
					<input type="reset" name="reset" id="reset" value="reset"  class="button"/>
				</td>
			</tr>
			<input type="hidden" name="vtunjangan" id="vtunjangan" onkeypress="return isNumberKey(event)" class="ui-widget ui-widget-content padding ui-corner-all" style="text-align:right" />
		</table>								
	</form>
</fieldset>
</div>