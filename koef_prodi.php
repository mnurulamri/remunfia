<?php
include("menu.php");
include("conn.php");

$query = "select * from koef_prodi order by kelas, programstudi";
$sql = mysql_query("$query") or die ("Data Tidak Ditemukan");

echo "
<body bgcolor=\"#eee\">
<div style='margin:2% 0% auto 5%; text-align:center' >	
<table>
	<tr  style='float:left; background: #0c2c65 url(images/head-bcg.jpg) no-repeat right top; 	margin:0;
				padding: 14px 0 0 24px; width: 801px;
				height: 55px;
				color:#FFF;
				font-size:13px;'>
		<td>
			<font style='font: bold 22px Arial, Helvetica, sans-serif;'>Koefesien Xf Program Studi</font>
			<br>
			<font style='font: bold 13px Arial, Helvetica, sans-serif;'>Fakultas Ilmu Administrasi</font>
		</td>	
	</tr>
	<tr style='background: #e4ebf8 url(images/center-blue.png) repeat-y left top; float:left; padding: 8px 0 0 0; 
	           height: 20px; border-right: 1px solid #ced9ec; border-bottom: 1px solid #b3c1db;	font: bold 11.4px Arial, Helvetica, sans-serif; 
			   color:#1f3d71; '>
		<td style='width: 34px; text-align:center;'>
			No
		</td>
		<td style='width: 150px; text-align:center;'>
			Kode Organisasi
		</td>
		<td style='width: 260px; text-align:left;'>
			Program Studi
		</td>
		<td style='width: 130px; text-align:left;'>
			Kelas
		</td>
		<td style='width: 200px; '>
			Kategori Koefesien
		</td>
		<td style='width: 50px; text-align:center;'>
			Koef
		</td>
	</tr>
";

$i = 1;
while ($row = mysql_fetch_array($sql)){
	$no = $row['no'];
	$kodeorganisasi = $row['kodeorganisasi'];
	$programstudi = $row['programstudi'];
	$kelas = $row['kelas'];
	$kategorikoefesien = $row['kategorikoefesien'];
	$koef = $row['koef'];
	
	echo "
		<tr style='float:left; background: #f6f6f6;font: bold 11px Arial, Helvetica, sans-serif; 
		            padding: 8 0 0 0; height: 20px; border-bottom: 1px solid #b3c1db; 
					border-right: 1px solid #ced9ec; color:#747474;' onmouseout=\"this.style.backgroundColor='#f6f6f6'; this.style.fontSize=11; this.style.color='#747474'; \" onmouseover=\"this.style.backgroundColor='#FFDEFF'; this.style.fontSize=13; this.style.color='#555555'; \">
			<td style='margin:0; width: 34px; text-align:center;'>
				$i
			</td>
			<td style='width: 150px; text-align:center;'>
				$kodeorganisasi
			</td>
			<td style='width: 260px; text-align:left;'>
				$programstudi
			</td>
			<td style='width: 130px; text-align:left;'>
				$kelas
			</td>
			<td style='width: 200px; text-align:left;'>
				$kategorikoefesien
			</td>
			<td style='width: 38px; text-align:right;padding-right:12px;' onmouseout='this.style.fontSize=11' onmouseover='this.style.fontSize=20'>
				$koef
			</td>
		</tr>
	";
       $i+=1;		
}
echo "
				
			</table>
		</div>
</body>
	";
?>