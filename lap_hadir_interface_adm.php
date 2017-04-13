<?php 
include("menu.php"); 
include("bulan.php");
#session_start();
$username = $_SESSION["username"];
?>
<script>
	var cur = 0;
	function displayDiv(idx) {
		if (cur==idx) return true;
		document.getElementById("div"+cur).style.display = "none";
		document.getElementById("div"+idx).style.display = "block";
		cur = idx;
		return true;
	}
		
	window.onload = function() {
		return displayDiv(document.form.semester.selectedIndex);
	}
</script>

<body bgcolor="#336666">
	<form action="lap_hadir_adm.php" method="post" name="form">
		<div>
		<table border="0" style="margin-top:5%; border: 5px groove yellow" width="30%">
			<tr  bgcolor="yellow"  style="font:bold 15px verdana; color:#336666">
				<td valign="center" align="center" colspan="3" height="22px">
					<h1>Laporan Kehadiran Pengajar</h1>
				</td>
			</tr>
			<tr>
				<td colspan="3" height="30px"></td>
			</tr>
			<tr style="margin-left:30%; font:bold 12px verdana; color:yellow">
				<td align="right">
					<label>Tahun</label>
				</td>
				<td align="center">:
				</td>
				<?php 
				if ($username == "mailanur"){?>
					<td>
					<select style="font:bold 11px verdana;" name="kodeprodi">
						<option value="">Pilih Program Studi...</option>
						<option value="06.03.09.01">S1 Reguler Ilmu Administrasi Negara</option>
						<option value="07.03.09.01">S1 Reguler Ilmu Administrasi Niaga</option>
						<option value="05.03.09.01">S1 Reguler Ilmu Administrasi Fiskal</option>
					</select>
					</td>
				<?php } else {?>
					<td>
					<select style="font:bold 11px verdana;" name="kodeprodi">
						<option value="">Pilih Program Studi...</option>
						<option value="14.03.09.01">S1 Paralel Ilmu Administrasi Negara</option>
						<option value="15.03.09.01">S1 Paralel Ilmu Administrasi Niaga</option>
						<option value="13.03.09.01">S1 Paralel Ilmu Administrasi Fiskal</option>
					</select>
					</td>
				<?php }	?>
			</tr>
			<tr>
				<td colspan="3" height="15px"></td>
			</tr>
			<tr style="margin-left:30%; font:bold 12px verdana; color:yellow">
				<td align="right">
					<label>Tahun</label>
				</td>
				<td align="center">:
				</td>
				<td>
					<select style="font:bold 11px verdana;" name="tahun">
						<option value="2011">2011</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" height="15px"></td>
			</tr>
			<tr  style="margin-left:30%; font:bold 12px verdana; color:yellow">
				<td align="right">
					<label>Semester</label>
				</td>
				<td align="center">:
				</td>
				<td>
					<select style="font:bold 11px verdana;" name="semester" onclick="return displayDiv(this.selectedIndex);">
						<option style="color:magenta" value="Gasal">Gasal</option>
						<option style="color:blue" value="Genap">Genap</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="3" height="15px"></td>
			</tr>
			<tr>
				<td colspan="3">
					
				</td>
			</tr>
			<tr style="margin-left:30%; font:bold 11px verdana; color:yellow">
				<td align="right">
					<label >Bulan</label>
				</td>
				<td align="center">
					<font color="yellow">:</font>
				</td>
				<td>
				<div id="div0">
					
						<select style="font:bold 11px verdana; width: 10em;" name="bulan_gasal" >
							<option style="color:blue;" value="<?php echo $month ?>"><?php echo $month ?></option>
							<option style="color:red;" value="September">September</option>
							<option style="color:blue;" value="Oktober">Oktober</option>
							<option style="color:green;" value="November">November</option>
							<option style="color:purple;" value="Desember">Desember</option>
							<option style="color:magenta;" value="Januari">Januari</option>
						</select>
					
				</div>
				<div id="div1" style="display:none;">
					
						<select style="font:bold 11px verdana; width: 10em;" name="bulan_genap">
							<option style="color:blue;" value="<?php echo $month ?>"><?php echo $month ?></option>
							<option style="color:blue;" value="Februari">Februari</option>
							<option style="color:green;" value="Maret">Maret</option>
							<option style="color:purple;" value="April">April</option>
							<option style="color:red;" value="Mei">Mei</option>
							<option style="color:blue;" value="Juni">Juni</option>
							<option style="color:green;" value="Juli">Juli</option>
							<option style="color:purple;" value="Agustus">Agustus</option>
						</select>
					</td>
				</div>
			</tr>
			<tr>
				<td colspan="3" height="15px"></td>
			</tr>
			<tr>
				<td colspan="3" bgcolor="yellow" height="1px"></td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<br>
					<input type="submit" value="generate" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover"/>
				</td>
			</tr>
			<tr>
				<td colspan="3" height="15px"></td>
			</tr>
		</table>
		</div>
	</form>
</body>