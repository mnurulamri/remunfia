<?
include("menu.php");
include("bulan.php");
?>

<link href="style.css" rel="stylesheet" type="text/css" />

<body style="background:#eee;">
	<br><br><br><br>
	<div class="raised">
		<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
			<div class="boxcontent">
				<h1 style="color:#fff">Upload Data Kalkulator Beban</h1>
			</div>
		<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
	</div>
	<br>
	<div class='inset'>
		<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
			<div class='boxcontent'>
				<p>
					<form name="f1" method="post" enctype="multipart/form-data">
						<div style="font-family:arial; font-size:13px; font-weight:bold; text-align:center; color:#555545;">
							<p style="padding-top:10px;">
								Tahun:
								<select name="tahun">
									<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
									<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
									<option value="<?echo date('Y')-2?>"><?echo date('Y')-2?></option>
									<option value="<?echo date('Y')-3?>"><?echo date('Y')-3?></option>
								</select>
								Bulan:
								<select name="bulan">
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
							</p>
							<p style="margin-top:10px;">
								Silahkan Pilih File Excel: <input name="userfile" type="file" style="border:2px solid #eee; "/>
								<input name="upload" type="submit" value="Import"/>
							</p>
						</div>
					</form>
				</p>
			</div>
		<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>
	<br>
	<div class='inset'>
		<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
			<div class='boxcontent'>
				<div style="font-family:arial; font-size:10px; font-weight:bold; text-align:left; color:#555545;">
					<p>
						<u>Cara penggunaan:</u><br>
						- File yang akan di upload dalam format XLSX atau XLS<br>
						- Source data di-download dari data Kalkulator Beban<br>
						- Ubah format <b>currency</b> menjadi <b>general</b><br>
					</p>
				</div>
			</div>
		<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>
</body>
<?
if((!empty($_FILES["userfile"])) && ($_FILES['userfile']['error'] == 0)) {
	//get file
	$fileName	= basename($_FILES['userfile']['name']);
	$fileExt	= substr($fileName, strrpos($fileName, '.') + 1);
	
	//cek file ekstension
	if ($fileExt == 'xlsx'){
		include('import_proses_xlsx.php');
	} else if($fileExt == 'xls'){
		include('import_proses.php');
	} else {
		echo 'silahkan upload file dengan ekstensi xlsx atau xls!';
	}
}
?>