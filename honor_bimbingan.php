<link href="css/table.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.js"></script>
<script>
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".msg_body").hide();
	//toggle the componenet with class msg_body
	$(".msg_head").click(function(){
		$(this).next(".msg_body").slideToggle(300);
	});
});
</script>
<body style="background-color:#336666">
<?
include ('conn.php');
if(!session_id()) session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['hak_akses']!=3) {
	session_destroy();
	header("Location:index.php");
}

$nip = $_SESSION["nip"];
$tahun = $_POST["tahun"];
$tahun_akad = $_POST["tahun"];
$semester = $_POST["semester"];

if ($semester == 'Gasal'){
	$bulan = "('09','10','11','12')";
	$where = "WHERE a.nip=$nip and tahun = $tahun and bulan in $bulan and kodeorganisasi = kd_organisasi
			  UNION
			  SELECT bulan, departemen, program, prodi, jenis_bimbingan, harga_satuan, jml_mhs, honor
			  FROM bimbingan a, organisasi b
			  WHERE a.nip=$nip and tahun = $tahun+1 and bulan = '01' and kodeorganisasi = kd_organisasi";
} else {
	$tahun = $_POST["tahun"] + 1; 
	$bulan = "('02','03','04','05','06','07','08')";
	$where = "WHERE a.nip=$nip and tahun = $tahun and bulan in $bulan and kodeorganisasi = kd_organisasi";
}

$bulanArr = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober', '11'=>'November', '12'=>'Desember');

$query = "SELECT bulan, departemen, program, prodi, jenis_bimbingan, harga_satuan, jml_mhs, honor
			FROM bimbingan a, organisasi b
			WHERE a.nip=$nip and tahun = $tahun and bulan in $bulan and kodeorganisasi = kd_organisasi";

$result = mysql_query ($query) or die ("error data bimbingan: ".mysql_error());
$rows = mysql_num_rows($result);

$data = "";
$data = array();

while ($row = mysql_fetch_object($result)) {
	$data[$row->bulan][] = $row;
}

echo '
<div class="msg_list" style="width:80%">';

foreach($data as $kBulan => $vBulan){
	echo '
	<div>&nbsp</div>
	<div class="msg_head">'.$bulanArr[$kBulan].'</div>		
	<div class="msg_body" style="display:none">
		<div class="table-head-row" style="line-height:12px; line-height:25px; padding-left:20px; font-size:11px;">
			<div class="table-head-cell">Program Studi</div>
			<div class="table-head-cell">Jenjang</div>
			<div class="table-head-cell">Jenis Bimbingan</div>
			<div class="table-head-cell">HS</div>
			<div class="table-head-cell">Jml</div>
			<div class="table-head-cell">Honor</div>			
		</div>';
	$j=1;
	$totalHonor = 0;
	foreach($vBulan as $kBimbingan =>$vBimbingan){
		echo '
		<div class="table-row" id="content">
			<div class="table-cell" style="width:20%">'.$vBimbingan->prodi.'</div>
			<div class="table-cell" style="width:15%">'.$vBimbingan->program.'</div>
			<div class="table-cell" style="width:45%">'.$vBimbingan->jenis_bimbingan.'</div>
			<div class="table-cell" style="width:5%; text-align:right;">'.number_format($vBimbingan->harga_satuan).'</div>
			<div class="table-cell" style="width:5%; text-align:center;">'.$vBimbingan->jml_mhs.'</div>
			<div class="table-cell" style="width:10%; text-align:right;">'.number_format($vBimbingan->honor).'</div>
		</div>';
		$j+=1;
		$totalHonor += $vBimbingan->honor;
	}
	echo '
		<div class="table-row"><div class="table-cell">&nbsp;</div><div class="table-cell">&nbsp;</div><div class="table-cell">&nbsp;</div><div class="table-cell">&nbsp;</div><div class="table-cell">&nbsp;</div><div class="table-cell" style="width:10%; text-align:right; text-shadow: 0 2px 2px gray; ">'.number_format($totalHonor).'</div></div>
	</div>';

}
echo '
</div>';
?>
</body>