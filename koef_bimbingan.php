<?php
include("menu.php");
include("conn.php");

$query = "select * from koef_bimbingan";
$sql = mysql_query("$query") or die ("Data Tidak Ditemukan");
$hover = "onmouseout=\"this.style.backgroundColor='#e4ebf8'; 
          this.style.fontSize=11; this.style.color='#1f3d71'; \" 
		  onmouseover=\"this.style.backgroundColor='#FFDEFF'; 
		  this.style.fontSize=13; this.style.color='#1f3d71'; \"";
echo "
	<style>
		#top {
			float:left; 
			background: #0c2c65 url(images/head-bcg.jpg) no-repeat right top; 	
			margin:55px;
			padding: 0 0 0 0; 
			width: 337px;
			height: 55px;
			color:#FFF;
			font-size:13px;
		}
		
		#top-cell {
			padding:20px;
		}
		
		#top-cell-id {
			background: #e4ebf8 ;
			float:left; 
			padding: 8px 0 0 0; 
			width: 34px;
	        height: 20px; 
			border-right: 1px solid #ced9ec; 
			border-bottom: 1px solid #b3c1db;
			font: bold 11.4px Arial, Helvetica, sans-serif; 
			color:#1f3d71;
			text-align:center;
		}
		
		#top-cell-jenisbimbingan {
			background: #e4ebf8;
			float:left; 
			padding: 8px 0 0 0; 
			width: 260px;
	        height: 20px; 
			border-right: 1px solid #ced9ec; 
			border-bottom: 1px solid #b3c1db;
			font: bold 11.4px Arial, Helvetica, sans-serif; 
			color:#1f3d71;
		}
		
		#top-cell-koef {
			background: #e4ebf8 ;
			float:left; 
			padding: 8px 0 0 0; 
			width: 40px;
	        height: 20px; 
			border-right: 1px solid #ced9ec; 
			border-bottom: 1px solid #b3c1db;
			font: bold 11.4px Arial, Helvetica, sans-serif; 
			color:#1f3d71;
			text-align:center;
		}
	</style>
	
	<body bgcolor=\"#eee\">
		<div>
		<div id='top'>
			<div style='padding-left:14px; padding-top:5px; padding-bottom:10px;' >
				<font style='font: bold 22px Arial, Helvetica, sans-serif;'>Koefesien Bimbingan</font>
				<br>
				<font style='font: bold 13px Arial, Helvetica, sans-serif;'>Fakultas Ilmu Administrasi</font>
			</div>	
		<div/>
		<div>
			<span id='top-cell-id'>
				ID
			</span>
			<span id='top-cell-jenisbimbingan'>
				Jenis Bimbingan
			</span>
			<span id='top-cell-koef'>
				Koef.
			</span>
		</div>
";

while ($row = mysql_fetch_array($sql)){
	$id = $row['id'];
	$jenisbimbingan = $row['jenisbimbingan'];
	$koef = $row['koef'];	
	
	echo "
		<div>
			<span id='top-cell-id' $hover>
				$id
			</span>
			<span id='top-cell-jenisbimbingan' $hover>
				$jenisbimbingan
			</span>
			<span id='top-cell-koef' $hover>
				$koef
			</span>
		</div>
	";		
}
echo "

		</div>
</body>
	";
?>