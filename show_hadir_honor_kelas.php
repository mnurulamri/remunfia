<?
if(!session_id()) session_start();
include("../remun/conn.php");
$kodemk = $_GET["kodemk"];
$tahun_akad = $_SESSION["xtahun_akad"];
$smt = $_SESSION["xsmt"];
$kodeorganisasi = $_SESSION["kodeorganisasi"];
?>

<span class="kelas">Nama Kelas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
<span>:</span>
<span><select name="namakelas" style="font:bold 11px verdana; color:#555" onchange="if(this.value=='') {document.getElementById('Hasil').style.display = 'none'; document.getElementById('Detail').style.display = 'none'} else {document.getElementById('Detail').style.display = 'block'; showKodeKelas(this.value)}">
	<option value="">Pilih Nama Kelas</option>

<?
$query = "SELECT distinct kodekelas, namakelas FROM kalban WHERE $kodeorganisasi and tahun_akad = $tahun_akad and semester = $smt and kodemk = '$kodemk'
			ORDER BY namakelas";

$result = mysql_query($query);

while ($row = mysql_fetch_array($result)){
	$kodekelas = $row["kodekelas"];
	echo "
	<option value='{$row[kodekelas]}'>{$row[namakelas]}</option>
	";
}
	
#mysql_close($con);
echo "Tahun Semester".$thsmt; 
?>
</select>
</span>