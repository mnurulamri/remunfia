<?php 
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
		return displayDiv(document.form.semester.selectedIndex);
	}
</script>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css">

<body bgcolor="#eee" style="background-color:#eee">
<div style="border:solid #eee; height:70px"><font style="color:#eee">&nbsp;</font></div>
	<form action="export_bimbingan.php" method="post" name="form">
		<div style="border:solid #eee">	
		
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background-color:#800080"></b><b class="b3" style="background-color:#800080"></b><b class="b4" style="background-color:#800080"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas------------------------------------- -->		

					<div style="font:bold 15px verdana; color:#eee; background-color:#800080">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1 style="color:#fff">Export Bimbingan dan Insentif<br>Per Bulan</h1>
						</div>
					</div>
					<div>
						<br>
					</div>
					<div style="font:bold 12px verdana; color:#555">
						<span align="right"><label>Tahun</label></span>
						<span align="center">:</span>
						<span>
							<select style="font:bold 11px verdana; color:#555" name="tahun">
								<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
								<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
							</select>
						</span>
						<span>&nbsp;&nbsp;&nbsp;</span>							
						<span align="right"><label>Bulan</label></span>
						<span align="center"><font color="#555">:</font></span>
						<span>
							<span>							
								<select style="font:bold 11px verdana; color:#555; width: 10em;" name="bulan" >
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
							</span>
						</span>
					</div>
					<div>
						<span>&nbsp;</span>
					</div>					
					<div>
						<hr style="color:#eee"></hr>
					</div>
					<div>
						<div align="center">							
							<input type="submit" value="generate" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover"/>
						</div>
					</div>

			<!--------------------------kotak bawah--------------------------------- -->
				</div>
				<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
			</div>
			<!--------------------------kotak bawah-------------------------------- -->
			
		</div>
	</form>
</body>