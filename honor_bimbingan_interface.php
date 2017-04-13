<?php 
if(!session_id()) session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['hak_akses']!=3) {
	session_destroy();
	header("Location:index.php");
}

include("menu.php"); 
include("bulan.php");
?>
<link href="css/contoh-1.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="css/table.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
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
	
	function gets(){
		$.post('honor_bimbingan.php', {tahun:form.tahun.value, semester:form.semester.value}, 
			function(output){
				$('#result').html(output).show();
			}
		);
	}
</script>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css">

<body bgcolor="#336666" style="background-color:#336666">
<div style="border:solid #336666; height:20px"><font style="color:#336666"> </font></div>
	<form action="#" method="post" name="form">
		<div style="border:solid #336666">	
		
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background-color:#fa0"></b><b class="b3" style="background-color:#fa0"></b><b class="b4" style="background-color:#fa0"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas--------------------------------------->		

					<div style="font:bold 15px verdana; color:#336666; background-color:#fa0">
						<div valign="center" align="center" colspan="3" height="22%">
							<h1>Honor Lain-lain</h1>
						</div>
					</div>
					<div style="font:bold 12px verdana; color:#555">
						<br/>
						<span align="right"><label>Tahun Akademik</label></span>
						<span align="center">:</span>
						<span>
							<select style="font:bold 11px verdana; color:#555" name="tahun" onchange="gets();">
								<option value="<?echo date('Y')?>"><?echo date('Y')?>/<?echo date('Y')+1?></option>
								<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?>/<?echo date('Y')?></option>
								<option value="<?echo date('Y')-2?>"><?echo date('Y')-2?>/<?echo date('Y')-1?></option>
								<option value="<?echo date('Y')-3?>"><?echo date('Y')-3?>/<?echo date('Y')-2?></option>
							</select>
						</span>
						<span></span>							
						<span align="right"><label>Semester</label></span>
						<span align="center"><font color="#555">:</font></span>
						<span>
							<span id="div0">							
								<select style="font:bold 11px verdana; color:#555" name="semester" onchange="gets();">
									<option style="color:magenta" value="Gasal">Gasal</option>
									<option style="color:blue" value="Genap">Genap</option>
								</select>						
							</span>
						</span>
					</div>				
					<div>
						<hr style="color:#fa0"></hr>
					</div>
					<div>
						<div align="center">							
							<!--<input type="submit" value="generate" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover" onclick="this.form.target='_blank';return true;"/>-->
							<input type="button" name="get" value="OK" onclick="gets();"/>
						</div>
					</div>

			<!--------------------------kotak bawah----------------------------------->
				</div>
				<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
			</div>
			<!--------------------------kotak bawah----------------------------------->
			
		</div>
	</form>
	<br/>
	<div id="result"></div>
</body>