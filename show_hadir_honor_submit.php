<?
include("../remun/conn.php");

$kodekelas = $_GET["kodekelas"];

if ($kodekelas == ""){?>
<?} else {?>
	<input type="submit" value="Submit" onclick="document.getElementById('Hasil').style.display = 'block';"/>
	<input type="reset" value="Reset" onclick="document.getElementById('MataKuliah').style.display = 'none'; document.getElementById('Kelas').style.display = 'none'; document.getElementById('Detail').style.display = 'none'; document.getElementById('result').style.display = 'none'; document.getElementById('Hasil').style.display = 'none';">
	<!--<input type="reset" value="Reset" onclick="return hideContent(HadirHonor);">-->
	<input name="kodekelas" type="hidden" value="<?echo $kodekelas?>"/>
<?}?>