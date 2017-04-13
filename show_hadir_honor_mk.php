<?
include("../remun/conn.php");
if(!session_id()) session_start();
$kodeorganisasi = $_SESSION["kodeorganisasi"];
$thsmt = $_GET["thsmt"];
$tahun = substr($thsmt,0,4);
$smt = substr($thsmt,5,1);
$_SESSION["xtahun_akad"]=$tahun;
$_SESSION["xsmt"]=$smt;
?>

<span class="mataKuliah">Nama Mata Kuliah</span>
<span>:</span>
<span><select name="matakuliah" style="font:bold 11px verdana; color:#555" onchange="if(this.value=='') {document.getElementById('Kelas').style.display = 'none'; document.getElementById('Detail').style.display = 'none';  document.getElementById('Hasil').style.display = 'none'} else {document.getElementById('Kelas').style.display = 'block'; showKelas(this.value)}">
	<option value="">Pilih Nama Mata Kuliah</option>

<?
$query = "	SELECT distinct namamatakuliah, kodemk 
			FROM kalban 
			WHERE $kodeorganisasi and tahun_akad = $tahun and semester = $smt 
			ORDER BY namamatakuliah";
			
$result = mysql_query($query);
$data = array();

while($row = mysql_fetch_array($result)) {		
	array_push($data, $row);
		$mk = $row['namamatakuliah'];
	echo "
	<option value='{$row[kodemk]}'>{$row[namamatakuliah]}</option>
	";
}

?>
<input type="hidden" name="tahun" value="<?echo $tahun?>"/>
<input type="hidden" name="smt" value="<?echo $smt?>"/>
<input id="mk" type="hidden" name="mk" value="<?echo $mk?>"/>
</select>
</span>
