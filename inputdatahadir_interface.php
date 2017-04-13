<?php 
if(!session_id()) session_start();
if(empty($_SESSION['username']))	header("Location:index.php");
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
	<form action="inputdatahadir_temp.php" method="post" name="form">
		<div style="border:solid #eee">	
		
			<!----------------------------kotak atas------------------------------------ -->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background:#800080"></b><b class="b3" style="background:#800080"></b><b class="b4" style="background:#800080"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas------------------------------------- -->		

					<div style="font:bold 15px verdana; color:#336666; background-color:#800080">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1 style="color:#ddd">Input Data Kehadiran Pengajar<br></h1>
						</div>
					</div>
					<br><br>
						
						<!--====================================================================================-->	
					<? if ($_SESSION["username"] == "admin" or $_SESSION["username"] == "remunerasifisipui"){?>							
					<table align="center" style="text:align:center">
						<tr>
							<td colspan="3" height="23px"></td>
						</tr>						
						<div style="font:bold 12px verdana; color:#555; text-align:center">
							<span align="right"><label>Progam Studi</label></span>
							<span align="center">&nbsp;:&nbsp;</span>
							<span>
								<select style="font:bold 11px verdana; color:#555" name="kode_prodi">
									<option value="02.01.09.01">S1 Reguler Ilmu Komunikasi</option>
									<option value="01.02.09.01">S1 Reguler Ilmu Politik</option>
									<option value="05.03.09.01">S1 Reguler Ilmu Administrasi Fiskal</option>
									<option value="06.03.09.01">S1 Reguler Ilmu Administrasi Negara</option>
									<option value="07.03.09.01">S1 Reguler Ilmu Administrasi Niaga</option>
									<option value="01.04.09.01">S1 Reguler Sosiologi</option>
									<option value="01.05.09.01">S1 Reguler Kriminologi</option>
									<option value="01.06.09.01">S1 Reguler Ilmu Kesejahteraan Sosial</option>
									<option value="02.07.09.01">S1 Reguler Antropologi Sosial</option>
									<option value="01.08.09.01">S1 Reguler Ilmu Hubungan Internasional</option>
									<option value="06.01.09.01">S1 Paralel Ilmu Komunikasi</option>
									<option value="05.02.09.01">S1 Paralel Ilmu Politik</option>
									<option value="13.03.09.01">S1 Paralel Ilmu Administrasi Fiskal</option>
									<option value="14.03.09.01">S1 Paralel Ilmu Administrasi Negara</option>
									<option value="15.03.09.01">S1 Paralel Ilmu Administrasi Niaga</option>
									<option value="05.05.09.01">S1 Paralel Kriminologi</option>
									<option value="07.01.09.01">S1 Kls Internasional Ilmu Komunikasi</option>
									<option value="03.01.09.01">S1 Ekstensi Ilmu Komunikasi - Ekstensi</option>
									<option value="02.02.09.01">S1 Ekstensi Ilmu Politik - Ekstensi</option>
									<option value="08.03.09.01">S1 Ekstensi Ilmu Administrasi Fiskal - Ekstensi</option>
									<option value="09.03.09.01">S1 Ekstensi Ilmu Administrasi Negara - Ekstensi</option>
									<option value="10.03.09.01">S1 Ekstensi Ilmu Administrasi Niaga - Ekstensi</option>
									<option value="02.05.09.01">S1 Ekstensi Kriminologi - Ekstensi</option>
									<option value="04.01.09.01">S2 Ilmu Komunikasi</option>
									<option value="03.02.09.01">S2 Ilmu Politik</option>
									<option value="11.03.09.01">S2 Ilmu Administrasi</option>
									<option value="02.04.09.01">S2 Sosiologi</option>
									<option value="03.05.09.01">S2 Kriminologi</option>
									<option value="02.06.09.01">S2 Ilmu Kesejahteraan Sosial</option>
									<option value="03.07.09.01">S2 Antropologi</option>
									<option value="02.08.09.01">S2 Ilmu Hub Internasional</option>
									<option value="03.08.09.01">S2 Kajian Terorisme & Keamanan Internasional</option>
									<option value="05.01.09.01">S3 Ilmu Komunikasi</option>
									<option value="04.02.09.01">S3 Ilmu Politik</option>
									<option value="12.03.09.01">S3 Ilmu Administrasi</option>
									<option value="03.04.09.01">S3 Sosiologi</option>
									<option value="04.05.09.01">S3 Kriminologi</option>
									<option value="03.06.09.01">S3 Ilmu Kesejahteraan Sosial</option>
									<option value="04.07.09.01">S3 Antropologi</option>
								</select>
							</span>
						</div>
						<div>
							<div colspan="3" height="15px"></div>
						</div>		
					</table>					
					<?}?>
						<!--====================================================================================-->	

					<div style="font:bold 12px verdana; color:#555">
						<span align="right"><label>Tahun Akademik</label></span>
						<span align="center">:</span>
						<span>
							<select style="font:bold 11px verdana; color:#555" name="tahun_akad">								
								<!--<option value='2013'>2013/2014</option>-->
								<option value="<?echo date('Y')?>"><?echo date('Y')?>/<?echo date('Y')+1?></option>
								<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?>/<?echo date('Y')?></option>
								<option value="<?echo date('Y')-2?>"><?echo date('Y')-2?>/<?echo date('Y')-1?></option>
							</select>
						</span>
						<span>&nbsp;&nbsp;&nbsp;</span>							
						<span align="right"><label>Semester</label></span>
						<span align="center"><font color="#555">:</font></span>
						<span>
							<span id="div0">							
								<select style="font:bold 11px verdana; color:#555" name="semester">
									<option style="color:magenta" value="gasal">Gasal</option>
									<option style="color:blue" value="genap">Genap</option>
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
							<input type="submit" value="generate" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover"/>
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