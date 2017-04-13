<?php
include("menu.php");
?>
<html>

<style>
	#line {
		border: 3px inset #eee;
		margin-top: 55px;
		padding-bottom: 20px;
		margin-left: 20%;
		margin-right: 20%;
	}
	
	#line1 {
		border-top: 2px solid yellow; border-bottom: 2px solid yellow; border-left: 2px solid yellow; border-right: 2px solid yellow;
	}
	
	#line2 {
		border-top: 2px solid orange; border-bottom: 2px solid orange; border-left: 2px solid orange; border-right: 2px solid orange;
	}
	
	#top {		
		padding: 15px 0 0 0;
		font: bold 13px Verdana Arial, Helvetica, sans-serif;
		text-align: center;
		color: purple;
	}
	
	#top-cell-ui {
	padding: 6px 6px 6px 6px;
	text-align:center;
	border-right: 1px solid #ced9ec;
	color:#1f3d71;
	font: bold 13px Verdana Arial, Helvetica, sans-serif;
	background: #F0D64E;
	}
	
	#top-cell-fak {
	padding: 6px 6px 6px 6px;
	text-align:center;
	border-right: 1px solid #8D0B93;
	color:gold;
	font: bold 13px Verdana Arial, Helvetica, sans-serif;
	background: #8D0B93;
	}

	#cell {
		margin:0;
		padding: 6px 6px 6px 6px;
		text-align:center;
		border-right: 1px solid #ced9ec;
		border-bottom: 1px solid #ced9ec;
		background: #f6f6f6 url(images/center-bcg.png) repeat-y right top;
		13px Arial, Helvetica, sans-serif;
		font: bold 13px Arial, Helvetica, sans-serif;
	}
</style>

<body bgcolor="#eee">
<div  align="center" id="">
	<table border='1' align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td id="top" colspan="2">Koefesien Harga Hadir Universitas</td>		
		</tr>
		<tr>
			<td id="top-cell-ui">Harga Satuan</td>
			<td id="top-cell-ui">Keterangan</td>
		</tr>
		<tr>
			<td id="cell">200.000</td>
			<td id="cell">/sks/100% kehadiran</td>
		</tr>
	</table>		
	<table border='1' align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td id="top" colspan="4">Koefesien Harga Hadir Fakultas</td>
		</tr>
		<tr>
			<td id="top-cell-fak">Skema Lain</td>
			<td id="top-cell-fak">Inti Pengajaran</td>
			<td id="top-cell-fak">Inti Penelitian</td>
			<td id="top-cell-fak">Keterangan</td>
		</tr>
		<tr>
			<td id="cell">1.500.000</td>
			<td id="cell">1.000.000</td>
			<td id="cell">1.000.000</td>
			<td id="cell">/sks/semester/100% kehadiran</td>
		</tr>
	</table>
	<table border="1" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td id="top" colspan="4">Koefesien Harga Hadir Pengantar Bahasa Asing</td>
		</tr>
		<tr>
			<td id="top-cell-fak">Skema Lain</td>
			<td id="top-cell-fak">Inti Pengajaran</td>
			<td id="top-cell-fak">Inti Penelitian</td>
			<td id="top-cell-fak">Keterangan</td>
		</tr>
		<tr>
			<td id="cell">600.000</td>
			<td id="cell">600.000</td>
			<td id="cell">600.000</td>
			<td id="cell">/sks/semester/100% kehadiran</td>
		</tr>
	</table>

</div>