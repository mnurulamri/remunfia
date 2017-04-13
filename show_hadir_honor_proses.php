<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css"/>

<style type="text/css">
table {
	font-family: verdana,arial,sans-serif;
	font-size:11px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
	margin-left:auto;
	margin-right:auto;
}

table th {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #eeeeee;
}

table td {
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
	text-align:center;
	color:#666;
	font-weight:bold;
	horizontal-align:middle;
}

#mk {
	font-family: verdana,arial,sans-serif;
	font-size:12px;
	font-weight:bold;
	color:#fff;
	margin-left:auto;
	margin-right:auto;
	padding: 8px;
	background-color: #fa0;
}

#left {text-align:left}
#right {text-align:right; width:50px;}
#labelmk {text-align:center;}
#garis {border-left:1.5px solid #336666; solid #336666;}

.inset1 {background: transparent; width:100px; margin-left:auto; margin-right:auto;}
.inset1 .b1, .inset .b2, .inset .b3, .inset .b4, .inset .b1b, .inset .b2b, .inset .b3b, .inset .b4b {display:block; overflow:hidden; font-size:1px;}
.inset1 .b1, .inset .b2, .inset .b3, .inset .b1b, .inset .b2b, .inset .b3b {height:1px;}
.inset1 .b2 {background:#ccc; border-left:1px solid #999; border-right:1px solid #aaa;}
.inset1 .b3 {background:#ccc; border-left:1px solid #999; border-right:1px solid #ddd;}
.inset1 .b4 {background:#ccc; border-left:1px solid #999; border-right:1px solid #eee;}
.inset1 .b4b {background:#ccc; border-left:1px solid #aaa; border-right:1px solid #fff;}
.inset1 .b3b {background:#ccc; border-left:1px solid #ddd; border-right:1px solid #fff;}
.inset1 .b2b {background:#ccc; border-left:1px solid #eee; border-right:1px solid #fff;}
.inset1 .b1 {margin:0 5px; background:#999;}
.inset1 .b2, .inset .b2b {margin:0 3px; border-width:0 2px;}
.inset1 .b3, .inset .b3b {margin:0 2px;}
.inset1 .b4, .inset .b4b {height:2px; margin:0 1px;}
.inset1 .b1b {margin:0 5px; background:#fff;}
.inset1 .boxcontent1 {display:block; background:#ccc; border-left:1px solid #999; border-right:1px solid #fff;}


</style>

<?php
include("../remun/conn.php");

session_start();

$kodeorganisasi = $_SESSION["kodeorganisasi"];

$tahun_akad = $_POST["tahun"];

$smt = $_POST["smt"];

$kodekelas = $_POST["kodekelas"];

$matakuliah = $_POST["matakuliah"];

$namakelas = $_POST["namakelas"];

include("bulan.php");

include("flag.php");

if ($smt == 1){

	$query = "select namamatakuliah, namakelas, NamaPengajar, Skema,
				sum(if(tahun_akad=$tahun_akad and bulan='08' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirAgustus,
				sum(if(tahun_akad=$tahun_akad and bulan='08' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuAgustus,
				sum(if(tahun_akad=$tahun_akad and bulan='08' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfAgustus,
				sum(if(tahun_akad=$tahun_akad and bulan='09' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirSeptember,
				sum(if(tahun_akad=$tahun_akad and bulan='09' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuSeptember,
				sum(if(tahun_akad=$tahun_akad and bulan='09' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfSeptember,
				sum(if(tahun_akad=$tahun_akad and bulan='10' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirOktober,
				sum(if(tahun_akad=$tahun_akad and bulan='10' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuOktober,
				sum(if(tahun_akad=$tahun_akad and bulan='10' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfOktober,
				sum(if(tahun_akad=$tahun_akad and bulan='11' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirNovember,
				sum(if(tahun_akad=$tahun_akad and bulan='11' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuNovember,
				sum(if(tahun_akad=$tahun_akad and bulan='11' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfNovember,
				sum(if(tahun_akad=$tahun_akad and bulan='12' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirDesember,
				sum(if(tahun_akad=$tahun_akad and bulan='12' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuDesember,
				sum(if(tahun_akad=$tahun_akad and bulan='12' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfDesember,
				sum(if(tahun_akad=$tahun_akad and bulan='01' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirJanuari,
				sum(if(tahun_akad=$tahun_akad and bulan='01' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuJanuari,
				sum(if(tahun_akad=$tahun_akad and bulan='01' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfJanuari,
				sum(if(tahun_akad=$tahun_akad and bulan='$bulan_gasal' and kodekelas = $kodekelas, kehadiranseharusnya,0)) as 'KehadiranSeharusnya'
			from kalban
			where $kodeorganisasi and tahun_akad = $tahun_akad and semester = $smt and flagtampil = 1 and kodekelas = $kodekelas and kode <> 0
			group by namapengajar";
	
} else {

	$query = "select namamatakuliah, namakelas, NamaPengajar, Skema,
				sum(if(tahun_akad=$tahun_akad and bulan='02' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirFebruari,
				sum(if(tahun_akad=$tahun_akad and bulan='02' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuFebruari,
				sum(if(tahun_akad=$tahun_akad and bulan='02' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfFebruari,
				sum(if(tahun_akad=$tahun_akad and bulan='03' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirMaret,
				sum(if(tahun_akad=$tahun_akad and bulan='03' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuMaret,
				sum(if(tahun_akad=$tahun_akad and bulan='03' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfMaret,
				sum(if(tahun_akad=$tahun_akad and bulan='04' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirApril,
				sum(if(tahun_akad=$tahun_akad and bulan='04' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuApril,
				sum(if(tahun_akad=$tahun_akad and bulan='04' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfApril,
				sum(if(tahun_akad=$tahun_akad and bulan='05' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirMei,
				sum(if(tahun_akad=$tahun_akad and bulan='05' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuMei,
				sum(if(tahun_akad=$tahun_akad and bulan='05' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfMei,
				sum(if(tahun_akad=$tahun_akad and bulan='06' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirJuni,
				sum(if(tahun_akad=$tahun_akad and bulan='06' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuJuni,
				sum(if(tahun_akad=$tahun_akad and bulan='06' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfJuni,
				sum(if(tahun_akad=$tahun_akad and bulan='07' and kodekelas = $kodekelas ,hadiraktual,0)) as HadirJuli,
				sum(if(tahun_akad=$tahun_akad and bulan='07' and kodekelas = $kodekelas ,honorxuskemainti,0)) as XuJuli,
				sum(if(tahun_akad=$tahun_akad and bulan='07' and kodekelas = $kodekelas ,totalhonorfak,0)) as XfJuli,
				sum(if(tahun_akad=$tahun_akad and bulan='$bulan_genap' and kodekelas = $kodekelas, kehadiranseharusnya,0)) as 'KehadiranSeharusnya'
			from kalban
			where $kodeorganisasi and tahun_akad = $tahun_akad and semester = $smt and flagtampil = 1 and kodekelas = $kodekelas and kode <> 0
			group by namapengajar";

}
			
$result = mysql_query($query);

$data = "";

$data = array();

if (mysql_num_rows($result) == 0){

	Print "Tidak Ada Data";

} else {

	while ($row = mysql_fetch_object($result)){

		$data[$row->namamatakuliah][$row->namakelas][] = $row;

	}

	foreach ($data as $namamatakuliah => $namakelas_s){	

		foreach($namakelas_s as $namakelas => $baris){
			
		?>
			<div class="boxcontent" style="background-color:yellow; padding-bottom:0.5em; padding-top:0.2em;">
				<div style="color:#555555; text-align:center;">
					<div style="font: bold 1em arial,sans-serif;">
						<?print $namamatakuliah." - ".$namakelas?>
					</div>
				</div>			
			</div>
		<?
			
			if($smt == 1){
			
				headerTableGasal();
			
			} else {
			
				headerTableGenap();
			
			}
			
			foreach ($baris as $kolom){	
				
				if($smt == 1){
				
					$total_hadir = $kolom->HadirAgustus + $kolom->HadirSeptember + $kolom->HadirOktober + $kolom->HadirNovember + $kolom->HadirDesember + $kolom->HadirJanuari;
					
					$total_honor_xu = $kolom->XuAgustus + $kolom->XuSeptember + $kolom->XuOktober + $kolom->XuNovember + $kolom->XuDesember + $kolom->XuJanuari;
					
					$total_honor_xf = $kolom->XfAgustus + $kolom->XfSeptember + $kolom->XfOktober + $kolom->XfNovember + $kolom->XfDesember + $kolom->XfJanuari;
				
					print renderGasal($kolom, $total_hadir, $total_honor_xu, $total_honor_xf);
							
				} else {
				
					$total_hadir = $kolom->HadirFebruari + $kolom->HadirMaret + $kolom->HadirApril + $kolom->HadirMei + $kolom->HadirJuni + $kolom->HadirJuli;
					
					$total_honor_xu = $kolom->XuFebruari + $kolom->XuMaret + $kolom->XuApril + $kolom->XuMei + $kolom->XuJuni + $kolom->XuJuli;
					
					$total_honor_xf = $kolom->XfFebruari + $kolom->XfMaret + $kolom->XfApril + $kolom->XfMei + $kolom->XfJuni + $kolom->XfJuli;
				
					print renderGenap($kolom, $total_hadir, $total_honor_xu, $total_honor_xf);
				
				}
			}

		}
		
		print "</table>";
		
	}

}

function headerTableGasal(){	
	echo "	
	<table>
		<tr>
			<th rowspan='2' style='padding-top:18px;'>Nama Pengajar</th>
			<th rowspan='2' style='padding-top:20px;'>skema</th>
			<th rowspan='2' style='width:20px'>Wajib<br>Hadir</th>
			<th colspan='3' id='garis' style='background:#C5EFFD; color:#006295'>Agustus</th>
			<th colspan='3' id='garis' style='background:#FFE9E8; color:#990099'>September</th>
			<th colspan='3' id='garis' style='background:#CCFFCC; color:#336600'>Oktober</th>
			<th colspan='3' id='garis' style='background:#EEDDFF; color:#663399'>November</th>
			<th colspan='3' id='garis' style='background:#FFEE99; color:#CC7700'>Desember</th>
			<th colspan='3' id='garis' style='background:#FFECFF; color:#FF0099'>Januari</th>
			<th colspan='3' id='garis'>Total</th>
		</tr>
		<tr>
			<th id='garis' style='background:#C5EFFD; color:#006295''>Hadir</th>
			<th style='background:#C5EFFD; color:#006295''>Xu</th>
			<th style='background:#C5EFFD; color:#006295''>Xf</th>
			<th id='garis' style='background:#FFE9E8; color:#990099'>Hadir</th>
			<th style='background:#FFE9E8; color:#990099'>Xu</th>
			<th style='background:#FFE9E8; color:#990099'>Xf</th>
			<th id='garis' style='background:#CCFFCC; color:#336600'>Hadir</th>
			<th style='background:#CCFFCC; color:#336600'>Xu</th>
			<th style='background:#CCFFCC; color:#336600'>Xf</th>
			<th id='garis' style='background:#EEDDFF; color:#663399'>Hadir</th>
			<th style='background:#EEDDFF; color:#663399'>Xu</th>
			<th style='background:#EEDDFF; color:#663399'>Xf</th>
			<th id='garis' style='background:#FFEE99; color:#CC7700'>Hadir</th>
			<th style='background:#FFEE99; color:#CC7700'>Xu</th>
			<th style='background:#FFEE99; color:#CC7700'>Xf</th>
			<th id='garis' style='background:#FFECFF; color:#FF0099'>Hadir</th>
			<th style='background:#FFECFF; color:#FF0099'>Xu</th>
			<th style='background:#FFECFF; color:#FF0099'>Xf</th>
			<th id='garis'>Hadir</th>
			<th>Xu</th>
			<th>Xf</th>
		</tr>
	";
}

function headerTableGenap(){	
	echo "	
	<table>
		<tr>
			<th rowspan='2' style='padding-top:18px;'>Nama Pengajar</th>
			<th rowspan='2' style='padding-top:20px;'>skema</th>
			<th rowspan='2'>Wajib<br>Hadir</th>
			<th colspan='3' id='garis' style='background:#C5EFFD; color:#006295'>Februari</th>
			<th colspan='3' id='garis' style='background:#FFE9E8; color:#990099'>Maret</th>
			<th colspan='3' id='garis' style='background:#CCFFCC; color:#336600'>April</th>
			<th colspan='3' id='garis' style='background:#EEDDFF; color:#663399'>Mei</th>
			<th colspan='3' id='garis' style='background:#FFEE99; color:#CC7700'>Juni</th>
			<th colspan='3' id='garis' style='background:#FFECFF; color:#FF0099'>Juli</th>
			<th colspan='3' id='garis'>Total</th>
		</tr>
		<tr>
			<th id='garis' style='background:#C5EFFD; color:#006295'>Hadir</th>
			<th style='background:#C5EFFD; color:#006295'>Xu</th>
			<th style='background:#C5EFFD; color:#006295'>Xf</th>
			<th id='garis' style='background:#FFE9E8; color:#990099'>Hadir</th>
			<th style='background:#FFE9E8; color:#990099'>Xu</th>
			<th style='background:#FFE9E8; color:#990099'>Xf</th>
			<th id='garis' style='background:#CCFFCC; color:#336600'>Hadir</th>
			<th style='background:#CCFFCC; color:#336600'>Xu</th>
			<th style='background:#CCFFCC; color:#336600'>Xf</th>
			<th id='garis' style='background:#EEDDFF; color:#663399'>Hadir</th>
			<th style='background:#EEDDFF; color:#663399'>Xu</th>
			<th style='background:#EEDDFF; color:#663399'>Xf</th>
			<th id='garis' style='background:#FFEE99; color:#CC7700'>Hadir</th>
			<th style='background:#FFEE99; color:#CC7700'>Xu</th>
			<th style='background:#FFEE99; color:#CC7700'>Xf</th>
			<th id='garis' style='background:#FFECFF; color:#FF0099'>Hadir</th>
			<th style='background:#FFECFF; color:#FF0099'>Xu</th>
			<th style='background:#FFECFF; color:#FF0099'>Xf</th>
			<th id='garis'>Hadir</th>
			<th>Xu</th>
			<th>Xf</th>
		</tr>
	";
}	
	
function renderGasal($kolom, $total_hadir, $total_honor_xu, $total_honor_xf){
	$output = "<tr>\n";
	$output .= "<td id='left'>{$kolom->NamaPengajar}</td>\n";
	$output .= "<td>{$kolom->Skema}</td>\n";
	$output .= "<td style='width:20px'>{$kolom->KehadiranSeharusnya}</td>\n";
	$output .= "<td id='garis' style='color:#006295'>{$kolom->HadirAgustus}</td>\n";
	$output .= "<td id='right' style='color:#006295'>".number_format($kolom->XuAgustus)."</td>\n";
	$output .= "<td id='right' style='color:#006295'>".number_format($kolom->XfAgustus)."</td>\n";
	$output .= "<td id='garis' style='color:#990099'>{$kolom->HadirSeptember}</td>\n";
	$output .= "<td id='right' style='color:#990099'>".number_format($kolom->XuSeptember)."</td>\n";
	$output .= "<td id='right' style='color:#990099'>".number_format($kolom->XfSeptember)."</td>\n";
	$output .= "<td id='garis' style='color:#336600'>{$kolom->HadirOktober}</td>\n";
	$output .= "<td id='right' style='color:#336600'>".number_format($kolom->XuOktober)."</td>\n";
	$output .= "<td id='right' style='color:#336600'>".number_format($kolom->XfOktober)."</td>\n";	
	$output .= "<td id='garis' style='color:#663399'>{$kolom->HadirNovember}</td>\n";
	$output .= "<td id='right' style='color:#663399'>".number_format($kolom->XuNovember)."</td>\n";
	$output .= "<td id='right' style='color:#663399'>".number_format($kolom->XfNovember)."</td>\n";
	$output .= "<td id='garis' style='color:#CC7700'>{$kolom->HadirDesember}</td>\n";
	$output .= "<td id='right' style='color:#CC7700'>".number_format($kolom->XuDesember)."</td>\n";
	$output .= "<td id='right' style='color:#CC7700'>".number_format($kolom->XfDesember)."</td>\n";
	$output .= "<td id='garis' style='color:#FF0099'>{$kolom->HadirJanuari}</td>\n";
	$output .= "<td id='right' style='color:#FF0099'>".number_format($kolom->XuJanuari)."</td>\n";
	$output .= "<td id='right' style='color:#FF0099'>".number_format($kolom->XfJanuari)."</td>\n";
	$output .= "<td id='garis'>".$total_hadir."</td>\n";
	$output .= "<td id='right'>".number_format($total_honor_xu)."</td>\n";
	$output .= "<td id='right'>".number_format($total_honor_xf)."</td>\n";
	$output .= "</tr>\n";
	return $output;
}

function renderGenap($kolom, $total_hadir, $total_honor_xu, $total_honor_xf){
	$output = "<tr>\n";
	$output .= "<td id='left'>{$kolom->NamaPengajar}</td>\n";
	$output .= "<td>{$kolom->Skema}</td>\n";
	$output .= "<td>{$kolom->KehadiranSeharusnya}</td>\n";
	$output .= "<td id='garis' style='color:#006295'>{$kolom->HadirFebruari}</td>\n";
	$output .= "<td id='right' style='color:#006295'>".number_format($kolom->XuFebruari)."</td>\n";
	$output .= "<td id='right' style='color:#006295'>".number_format($kolom->XfFebruari)."</td>\n";
	$output .= "<td id='garis' style='color:#990099'>{$kolom->HadirMaret}</td>\n";
	$output .= "<td id='right' style='color:#990099'>".number_format($kolom->XuMaret)."</td>\n";
	$output .= "<td id='right' style='color:#990099'>".number_format($kolom->XfMaret)."</td>\n";
	$output .= "<td id='garis' style='color:#336600'>{$kolom->HadirApril}</td>\n";
	$output .= "<td id='right' style='color:#336600'>".number_format($kolom->XuApril)."</td>\n";
	$output .= "<td id='right' style='color:#336600'>".number_format($kolom->XfApril)."</td>\n";	
	$output .= "<td id='garis' style='color:#663399'>{$kolom->HadirMei}</td>\n";
	$output .= "<td id='right' style='color:#663399'>".number_format($kolom->XuMei)."</td>\n";
	$output .= "<td id='right' style='color:#663399'>".number_format($kolom->XfMei)."</td>\n";
	$output .= "<td id='garis' style='color:#CC7700'>{$kolom->HadirJuni}</td>\n";
	$output .= "<td id='right' style='color:#CC7700'>".number_format($kolom->XuJuni)."</td>\n";
	$output .= "<td id='right' style='color:#CC7700'>".number_format($kolom->XfJuni)."</td>\n";
	$output .= "<td id='garis' style='color:#FF0099'>{$kolom->HadirJuli}</td>\n";
	$output .= "<td id='right' style='color:#FF0099'>".number_format($kolom->XuJuli)."</td>\n";
	$output .= "<td id='right' style='color:#FF0099'>".number_format($kolom->XfJuli)."</td>\n";
	$output .= "<td id='garis'>".$total_hadir."</td>\n";
	$output .= "<td id='right'>".number_format($total_honor_xu)."</td>\n";
	$output .= "<td id='right'>".number_format($total_honor_xf)."</td>\n";
	$output .= "</tr>\n";	
	return $output;
}
	
?>