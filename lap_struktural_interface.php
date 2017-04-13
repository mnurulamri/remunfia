<?php 
if(!session_id()) session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']))	header("Location:index.php");
$username = $_SESSION["username"];
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
	<form action="lap_honor_struktural.php" method="post" name="form">
		<div style="border:solid #eee">	
		
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background-color:#800080"></b><b class="b3" style="background-color:#800080"></b><b class="b4" style="background-color:#800080"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas------------------------------------- -->		

					<div style="font:bold 15px verdana; color:#eee; background-color:#800080">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1 style="color:#ddd;">Laporan Tunjangan Struktural<br>Per Bulan</h1>
						</div>
					</div>
					<table align="center" style="text:align:center">
						<tr>
							<td colspan="3" height="23px"></td>
						</tr>
						
						<!--====================== ganti pake hak akses ==========================================================-->	
						<? if ($_SESSION["hak_akses"] == 1){?>			
						
						<tr style="margin-left:30%; font:bold 12px verdana; color:#555">
							<td align="right"><label>Progam Studi</label></td>
							<td align="center">&nbsp;:&nbsp;</td>
							<td>
								<select style="font:bold 11px verdana; color:#555" name="kode">							
								<?
								$result = mysql_query("SELECT kodeorganisasi, program, prodi FROM organisasi WHERE substr(kodeorganisasi,7,2)='09' ORDER BY substr(kodeorganisasi,4,2), substr(kodeorganisasi,1,2)") or die(mysql_error());
								while($row = mysql_fetch_object($result)){
									echo'
									<option value="'.$row->kodeorganisasi.'">'.$row->program.' '.$row->prodi.'</option>';
								}
								?>
								</select>
							</td>
						</tr>
						<?}?>
						<!--====================================================================================-->	
					</table>	
					
					<div>
						<div colspan="3" height="15px"></div>
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
							<span id="div0">							
								<select style="font:bold 11px verdana; color:#555; width: 10em;" name="bulan" >
									<option style="color:blue;" value="<?php echo date('m') ?>"><?php echo $month ?></option>
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
							</span>
						</span>
					</div>
					<div>
						<span>&nbsp;</span>
					</div>					
					<div>
						<hr style="color:#fa0"></hr>
					</div>
					<div>
						<div align="center">							
							<input type="submit" value="generate" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover" onclick="this.form.target='_blank';return true;"/>
						</div>
					</div>

			<!--------------------------kotak bawah----------------------------------->
				</div>
				<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
			</div>
			<!--------------------------kotak bawah----------------------------------->
			
		</div>
	</form>
</body>