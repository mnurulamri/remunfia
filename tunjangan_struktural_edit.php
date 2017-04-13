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
	})
});
	
</script>
<?php
	include("conn.php");
	
	#siapkan data untuk form edit
	if(!session_id()) session_start();
	$kd_organisasi = $_SESSION["kode"];	
	$id = $_GET['id'];	
	$sql = "SELECT id, a.nip as nip, nama_pengajar, jabatan, tunjangan, periode, a.tahun, b.bulan
		    FROM struktural a, pengajar b
		    WHERE a.nip = b.nip and a.tahun = b.tahun and a.bulan = b.bulan and a.id = $id";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	
	switch ($row["bulan"]){
	case "01":
		$month = "Januari";
		break;
	case "02":
		$month = "Februari";
		break;
	case "03":
		$month = "Maret";
		break;
	case "04":
		$month = "April";
		break;
	case "05":
		$month = "Mei";
		break;
	case "06":
		$month = "Juni";
		break;
	case "07":
		$month = "Juli";
		break;
	case "08":
		$month = "Agustus";
		break;
	case "09":
		$month = "September";
		break;
	case "10":
		$month = "Oktober";
		break;
	case "11":
		$month = "November";
		break;
	case "12":
		$month = "Desember";
		break;
	}
?>
<fieldset id="center" ">
	<legend>Edit Data</legend>
	<form method="post" action="tunjangan_struktural_crud.php" name="form1" id="form1">
		<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
		<input type="hidden" name="oper" value="edit">
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
						<option style="color:blue;" value="<? echo $bulan ?>"><? echo $month ?></option>
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
					<input type="text" name="nama_pengajar" id="nama_pengajar" value="<?echo $row['nama_pengajar']?>" size="27" class="ui-widget ui-widget-content padding ui-corner-all" onkeyup="lihat(this.value)"/>	
					<input type="button" value="clear" id="clear" class="button" onclick="kosongkan()"/>
					<div id="kotaksugest" ></div>					
				</td>
				<td id="label">NIP</td>
				<td>:&nbsp;</td>
				<td><input type="text" name="nip" id="nip" value="<?echo $row['nip']?>" class="ui-widget ui-widget-content padding ui-corner-all"></td>
				<td colspan="3" align="center"></td>
			</tr>
			<tr>
				<td id="label">Jabatan</td>
				<td>:</td>
				<td>
					<input type="text" name="jabatan" id="jabatan" value="<?echo $row['jabatan']?>" size="35" class="ui-widget ui-widget-content padding ui-corner-all"/>
					&nbsp;&nbsp;
				</td>
				<td id="label">Tunjangan</td>
				<td>:</td>
				<td><input type="text" name="tunjangan" id="tunjangan" value="<?echo number_format($row['tunjangan'])?>" onClick="this.select();" onkeypress="return isNumberKey(event)" size="20" maxlength="10" onblur="return formatCurrency(this.value,0,',','','','','','')" class="ui-widget ui-widget-content padding ui-corner-all" style="text-align: right;"></td>
				<td colspan="3" align="center">
					<input type="button" name="submit" id="submit" value="save" class="button"/>
					<input type="reset" name="reset" id="reset" value="reset"  class="button"/>
				</td>
			</tr>
			<input type="hidden" name="vtunjangan" id="vtunjangan" value="<?echo $row['tunjangan']?>" onkeypress="return isNumberKey(event)" class="ui-widget ui-widget-content padding ui-corner-all" style="text-align:right" />
		</table>																
	</form>
</fieldset>