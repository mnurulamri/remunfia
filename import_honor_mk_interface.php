<?
include("menu.php");
include("bulan.php");
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
		return displayDiv(document.f.ShowLog.selectedIndex);
	}
</script>

<link href="style.css" rel="stylesheet" type="text/css" />
<body style="background:#eee;">
	<br><br><br><br>
	<div class="raised">
		<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
			<div class="boxcontent">
				<h1 style="color:#fff">Update Honor Xu dan Xf</h1>
			</div>
		<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
	</div>
	<br>
	<div class='inset'>
		<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
			<div class='boxcontent'>
				<p>
					<form name="f1" method="post" enctype="multipart/form-data" action="import_honor_mk_proses.php">
						<div style="font-family:arial; font-size:13px; font-weight:bold; text-align:center; color:#555545;">
							<p style="padding-top:10px;">
								Tahun:
								<select name="tahun">
									<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
									<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
								</select>
								Bulan:
								<select name="bulan">
									<option style="color:blue;" value="<?php echo $month ?>"><?php echo $month ?></option>
									<option style="color:magenta;" value="Januari">Januari</option>
									<option style="color:blue;" value="Februari">Februari</option>
									<option style="color:green;" value="Maret">Maret</option>
									<option style="color:purple;" value="April">April</option>
									<option style="color:red;" value="Mei">Mei</option>
									<option style="color:blue;" value="Juni">Juni</option>
									<option style="color:green;" value="Juli">Juli</option>
									<option style="color:purple;" value="Agustus">Agustus</option>				
									<option style="color:red;" value="September">September</option>
									<option style="color:blue;" value="Oktober">Oktober</option>
									<option style="color:green;" value="November">November</option>
									<option style="color:purple;" value="Desember">Desember</option>
								</select>
							</p>
							<p style="margin-top:10px;">
								Silahkan Pilih File Excel: <input name="userfile" type="file" style="border:2px solid orange; "/>
								<input name="upload" type="submit" value="Import"/>
							</p>
						</div>
					</form>
				</p>
			</div>
		<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>
	<br>
	<div class='inset'>
		<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
			<div class='boxcontent'>
				<div style="font-family:arial; font-size:10px; font-weight:bold; text-align:left; color:#555545;">
					<p>
						<u>Cara penggunaan:</u><br>
						- File yang akan di upload dalam format Excel 97-2003<br>
						- Source data di-download dari data kalban2<br>
						- Ubah format <b>currency</b> menjadi <b>general</b><br>
					</p>
				</div>
			</div>
		<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>

