<?php
if(!session_id()) session_start();
include("menu.php"); 
include("bulan.php");
include("conn.php");

$kodeorganisasi = $_SESSION["kd_organisasi"];
$query = "SELECT ketuaprogramstudi, nip FROM organisasi WHERE kodeorganisasi = '$kodeorganisasi'";
$result = mysql_query($query);
$rows = mysql_fetch_array($result);

$vnama = $rows["ketuaprogramstudi"];
$vnip = $rows["nip"]; 
?>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css"/>
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="js/autocomplete.js" type="text/javascript"></script>

<script>
$(document).ready(function(){	
	$("form#pejabat").submit(function(){
		var nama = $("#namapengajar").attr("value");
		var nip = $("#nip").attr("value");		
		$.ajax({
			type: "POST",
			url: "pejabat_simpan.php",
			data: "namapengajar="+ nama + "&nip="+ nip,
			success: function(){				
				alert("data sudah disimpan...");
				clock.start();
			}
		});	
		return false		
	});
});
</script>

<body bgcolor="#eee" style="background-color:#eee">
	<div style="border:solid #eee"><font style="color:#eee">XXXX</font></div>
	<form action="pejabat_simpan.php" method="post" name="form" id="pejabat">
		<div style="border:solid #eee">	
			<br><br><br>
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
		<b class='b1'></b><b class='b2' style='background-color:#800080'></b><b class='b3' style='background-color:#800080'></b><b class='b4' style='background-color:#800080'></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas------------------------------------- -->		

					<div style="font:bold 15px verdana; color:#eee; background-color:#800080">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1 style="color:#ddd;">Update Nama Ketua Program Studi<br></h1>
						</div>
					</div>
				<br>
				<div style="font:bold 12px verdana; color:#555">
					<span align="right">
						<label>Nama Ketua Program Studi</label>
					</span>
					<span align="center">:
					</span>
					<span>
							<input type="text" id="namapengajar" style="font:bold 11px verdana;" name="namapengajar" value="<?echo $vnama?>" size="50" onkeyup="lihat(this.value)"/>							
							
					<div id="kotaksugest"></div>
					</span>				
				</div>
				<div>
					<span colspan="3" height="15px"><br></span>
				</div>

				<div style="font:bold 12px verdana; color:#555">
					<span align="right"><label>NIP/NUP</label></span>
					<span align="center">:</span>
					<span>
						<input type="text" name="nip" id="nip" value="<?echo $vnip?>" readonly="readonly" size="25" style="font:bold 11px verdana; color:gray;"/>
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
						<button style="font:bold 11px verdana; height: 2.5em; :hover">simpan</button>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" value="clear" onclick="document.getElementById('namapengajar').value = ''; document.getElementById('nip').value = ''; document.getElementById('namapengajar').focus();"/>
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