<?php
if(!session_id()) session_start();
include("menu.php"); 
include("bulan.php");

//Closing data hadir
$sql = "SELECT bulan, lock_data FROM data_hadir_lock WHERE tahun_akad = 2015 AND semester = 1";
$result = mysql_query($sql) or die();

while($rows = mysql_fetch_object($result)){
	$data[$rows->bulan] = $rows->lock_data;
}

//menentukan bulan apa yang akan di closing
if(isset($data['09'])){$txtSep = $data['09'] == 1 ? null : 'text';}
if(isset($data['10'])){$txtOkt = $data['10'] == 1 ? null : 'text';}
if(isset($data['11'])){$txtNov = $data['11'] == 1 ? null : 'text';}
if(isset($data['12'])){$txtDes = $data['12'] == 1 ? null : 'text';}
if(isset($data['01'])){$txtJan = $data['01'] == 1 ? null : 'text';}
?>

<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){	
	$("form").submit(function(){
		var tahun = $("#tahun").attr("value");
		var bulan = $("#bulan").attr("value");		
		$.ajax({
			type: "POST",
			url: "inputdatahadir_closing_controller.php",
			data: "tahun="+ tahun + "&bulan="+ bulan,
			success: function(data){
				//alert("record bimbingan dan insentif sudah diclosing...");
				$('#result').html(data);
			}
		});	
		return false		
	});
});
</script>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css">


<body bgcolor="#336666" style="background-color:#336666">
<div style="border:solid #336666; height:70px"><font style="color:#336666"> </font></div>
	<form action="inputdatahadir_closing_controller.php" method="post" name="form">
		<div style="border:solid #336666">	
		
			<!----------------------------kotak atas-------------------------------------->
			<div class="inset">
				<b class="b1"></b><b class="b2" style="background-color:#fa0"></b><b class="b3" style="background-color:#fa0"></b><b class="b4" style="background-color:#fa0"></b>
				<div class="boxcontent" style="text-align:center;">
			<!---------------------------kotak atas--------------------------------------->		

					<div style="font:bold 15px verdana; color:#336666; background-color:#fa0">
						<div valign="center" align="center" colspan="3" height="22%">
						<h1>Closing Data Kehadiran</h1>
						</div>
					</div>
					<br><br>
					<div>
						<div colspan="3" height="15px"></div>
					</div>
					<div style="font:bold 12px verdana; color:#555">
						<span align="right"><label>Tahun</label></span>
						<span align="center">:</span>
						<span>
							<select style="font:bold 11px verdana; color:#555" name="tahun" id="tahun">
								<option value="<?echo date('Y')+1?>"><?echo date('Y')+1?></option>
								<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
								<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>								
							</select>
						</span>
						<span>   </span>							
						<span align="right"><label>Bulan</label></span>
						<span align="center"><font color="#555">:</font></span>
						<span>
							<span id="div0">							
								<select style="font:bold 11px verdana; color:#555; width: 10em;" name="bulan" id="bulan" >
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
						<span> </span>
					</div>					
					<div>
						<hr style="color:#fa0"></hr>
					</div>
					<div>
						<div align="center">							
							<input type="submit" value="closing" name="generate" style="font:bold 11px verdana; height: 2.5em; :hover" onclick="document.getElementById('Hasil').style.display = 'block';"/>
						</div>
					</div>

			<!--------------------------kotak bawah----------------------------------->
				</div>
				<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
			</div>
			<!--------------------------kotak bawah----------------------------------->
			
		</div>
	</form>
	<div id="result"></div>
</body>