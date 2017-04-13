<link rel="icon" type="image/ico" href="Rupiah.ico"></link>
<link rel="shortcut icon" href="images/Rupiah.ico"></link>
<?php
if(!session_id()) session_start();

if(!empty($_SESSION['hak_akses'])){
	header( "Location: http://remun.ppaa.fisip.ui.ac.id/fia/a.php" ) ;
	exit;
}

include "header.php";
include('token.php');
getToken();
?>

<link href="style.css" rel="stylesheet" type="text/css" />

<body bgcolor="#eee" style="background:#ccc; text-align:center" >
<!--------------------------------------------- sso login------------------------------------------------------------- -->
<div style="height:10%"></div>
<div class="raised" style="width:670px; padding-top:1%">
	<b class="b1" style="background-color:#800080"></b><b class="b2" style="background-color:#800080"></b><b class="b3" style="background-color:#800080"></b><b class="b4" style="background-color:#800080"></b>
	
	<div class="boxcontent" style="background-color:#800080; padding-bottom:0.5em; padding-top:0.2em;">
		<div style="color:#eee; text-align:center;">
			<div style="font: bold 1.2em arial,sans-serif;">
				SISTEM INFORMASI REMUNERASI PENGAJAR
			</div>									
			<div style="font: bold 0.7em arial,sans-serif;">
				FAKULTAS ILMU ADMINSTRASI UNIVERSITAS INDONESIA
			</div>
		</div>
	</div>
		
	<div class="boxcontent" style="background-color:#444444; padding-bottom:1em;">	
	<br>
	<div style="height:40px; color:white; font-family:arial; font-size:12px; font-weight:bold"></div>
		<section id="">
			<form id="logSSO" name="login" action="ldap_otentifikasi.php" method="post">
			<div class="raised" style="width:50%">
				<div class="top">
					<div class="pull-right"><img src="images/logo-ui-3.png" width="160" height="45"/></div>
					<div class="sub1">SSO</div>
					<div class="sub2">Single Sign On</div>				
				</div>
				<div class="boxcontent" style="background: #eee">	
					<br>
					<h1 align="center">
						<table  border="0" style="color:#555555" align="center">
							<tr>
								<td width="" align="right"><b>username</b></td>
								<td width="" align="center">:</td>
								<td width=""><input name="username" type="text" size=""></td>
							</tr>
							<tr>
								<td width="" align="right"><b>password</b></td>
								<td width="" align="center">:</td>
								<td width=""><input name="password" type="password" size=""></td>
							</tr>
							<tr>
								<td height="8px"></td>
							</tr>
							<tr>
								<td colspan="3" align="right"><input type="submit" name="Submit" value="Login"></td>
							</tr>
						</table>
					</h1>
				</div>
				<b class="b4b" style="background: #eee"></b><b class="b3b" style="background: #eee"></b><b class="b2b" style="background: #eee"></b><b class="b1b"></b>
			</div>
			<?echo getTokenField()?>
			</form>
			<div class="button">
				<!--<a href="#">Download source file</a>>-->
			</div><!-- button -->
		</section><!-- content -->
		<div style="height:30px;"></div>
	<!--------------------------------------------- reguler login-------------------------------------------------------------		
	<div style="height:20px; color:white; font-family:arial; font-size:12px; font-weight:bold">atau:</div>		
		<div style="text-align:center; margin:auto;">
			<div bgcolor="yellow" style="text-align:center; color:#555;">
				<form name="logReg" method="post" action="login_cek.php">
					<input type="hidden" name="login" value="yes"/>		
					<div width="">
						<div class="raised" style="width:50%">
							<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
							<div class="boxcontent">
								<h1>Reguler Login</h1>			
								<h1 align="center">
									<table  border="0" style="color:#555555" align="center">
										<tr>
											<td height="20px"></td>
										</tr>
										<tr>
											<td width="" align="right"><b>username</b></td>
											<td width="" align="center">:</td>
											<td width=""><input name="username" type="text" size=""></td>
										</tr>
										<tr>
											<td width="" align="right"><b>password</b></td>
											<td width="" align="center">:</td>
											<td width=""><input name="password" type="password" size=""></td>
										</tr>
										<tr>
											<td height="8px"></td>
										</tr>
										<tr>
											<td colspan="3" align="right"><input type="submit" name="Submit" value="Login"></td>
										</tr>
									</table>
								</h1>			
							</div>
							<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
						</div>
					</div>
					<?//echo getTokenField()?>
				</form>
			</div>			
		</div>-->
	</div>
		<div class="boxcontent" style="background-color:rgb(237,67,55);">
			<div style="color:#555555; text-align:center;">
				<div style="font: bold 1.2em arial,sans-serif;">&nbsp;</div>
			</div>
		</div>
			<b class="b4b" style="background-color:rgb(237,67,55);"></b><b class="b3b" style="background-color:rgb(237,67,55);"></b><b class="b2b" style="background-color:rgb(237,67,55);"></b><b class="b1b"></b>
	</div>

<!--------------------------------------------- reguler login--------------------------------------------------------------->
<div style="height:10%"></div>
</body>
<style>
.pull-right{
	padding-right:0px;
	padding-left:0;
	border-left:0;
	text-align:right;
}
.top {
  padding: 14px 20px 20px 40px;
  height: 40px;
  background-color: #e1e1e1;
  border-bottom: 1px solid #c8c8c8;
  border-radius: 4px 4px 0 0;
  font-family:arial;
}

h1 {
	margin-top:-50px;
	margin-left:-250px;
	color: #666;
	font-size: 48px;
}

.top .sub1{
	color: #666;
	font-size: 40px;
	margin-top:-53px;
	margin-left:-240px;
	text-shadow: 0 1px 0 #fff;
}

.top .sub2{
	margin-top:-5px;
	margin-left:-240px;
	color: #777;
	font-size: 12px;
}
</style>
<?php
include "footer.php";
?>