<!--<link href="css/contoh-1.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="css/table.css" media="screen, projection" rel="stylesheet" type="text/css">-->
<?
//set session
if(!session_id()) session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['hak_akses']!=3) header("Location:index.php");

//set koneksi
include ('conn.php');
include("bulan.php");

//set variabel
$nip = $_SESSION["nip"];
$tahun = $_POST["tahun"];
$tahun_akad = $_POST["tahun"];
$semester = $_POST["semester"];

if($semester == "Gasal"){
	$smt = 1;
	//$tahun = $tahun;
} else {
	$smt = 2;
	$tahun = $tahun + 1;
}

$bulan_arr = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober', '11'=>'November', '12'=>'Desember');

//ambil data
$sql = "SELECT bulan, program as Program, programstudi as `Program Studi`, namamatakuliah as `Nama Mata Kuliah`, namakelas as `Nama Kelas`, bobotkontribusi as Bobot, bobotkontribusi/100*sks as `SKS Ekivalen`, kodemk as `Kode Mata Kuliah`, sks as SKS, hadiraktual as Hadir, kehadiranseharusnya as `Wajib Hadir`, honorxuskemainti as `Honor Xu`, honorxfskemainti + honorxfskemalain + honorxflintasfak as `Honor Xf`, totalhonor as `Total Honor`, ikuthitung
			FROM kalban 
			WHERE nip = $nip and tahun_akad = $tahun_akad and semester = $smt and kodepdpt=0 and bulan <> '13'
			ORDER BY tahun, bulan, ikuthitung desc, program, programstudi, namamatakuliah, kodekelas";
			
$result = mysql_query ($sql) or die ("Gagal ngambil data Mata Kuliah: ".mysql_error());
$data = array();

while ($row = mysql_fetch_object($result)) {
	$data[$row->bulan][$row->ikuthitung][] = $row;
}


//tampilkan tabel honor mk
echo '
<body>
	<div class="main">
		<ul class="tabs">';
		
$i=1; //settingan jumlah tab

foreach ($data as $kBulan => $vBulan){
	echo '
	<li>';
		if($i==1) {echo '<input type="radio" checked name="tabs" id="tab'.$i.'">';} else {echo '<input type="radio" name="tabs" id="tab'.$i.'">';}
		//$bulan = $kBulan;
		echo '
		<label for="tab'.$i.'">'.$bulan_arr[$kBulan].'</label>
		<div id="tab-content'.$i.'" class="tab-content animated fadeIn">
			<div class="table">';
	
	//untuk tiap-tiap bulan
	foreach($vBulan as $kIkutHitung => $vIkutHitung){
	
		//set keterangan header masing-masing ikut hitung
		echo '<div style="line-height:8px">&nbsp;</div>';		
		if($kIkutHitung==1){
			echo '<div style="text-shadow:0px 1px 1px gray; color:green; font:bold italic 11px verdana;">Rincian Data Honor Pengajaran Sesuai Ketetapan Universitas</div>';
		} else {
			echo '<div style="text-shadow:0px 1px 1px gray; color:#f20; font:bold italic 11px verdana;">Rincian Data Honor Pengajaran Sesuai Ketetapan Universitas Tidak Terbayarkan</div>';
		}
		echo '
				<div style="line-height:5px">&nbsp;</div>
				<div class="table-head-row">';
		
		//tampilkan nama kolom tabel honor mk
		for($j = 1; $j < mysql_num_fields($result); $j++){  
			if($j!=14){
				$col = mysql_field_name($result, $j);
				echo '
					<div class="table-head-cell">'.$col.'</div>';
			}
		}
		echo '
				</div>';
		
		//preparation total
		$totalXu = 0;
		$totalXf = 0;
		$totalHonor = 0;
		
		foreach($vIkutHitung as $kBaris => $vBaris){
			echo '
				<div class="table-row">';
			$k = 0;
			foreach($vBaris as $cell){
				if($k==11) $totalXu += $cell;
				if($k==12) $totalXf += $cell;
				if($k==13) $totalHonor += $cell;
				if ($k!=0 and $k!=14) {  //menyembunyikan kode bulan
					if (($k>=5 && $k<=10) || $k==14){
						echo '<div class="table-cell-center">'.$cell.'</div>';
					} else if($k>=11 && $k<=13){
						echo '<div class="table-cell-right">'.number_format($cell).'</div>';
					} else {
						echo '<div class="table-cell">'.$cell.'</div>';
					}
				}
				$k+=1;
			}
			echo '
				</div>';
		}
		
		//tampilkan footer tabel honor mk
		for($j = 1; $j < mysql_num_fields($result); $j++){  
			$col = mysql_field_name($result, $j);
			switch($j){
				case 11: echo '<div class="table-cell-right" style="background:#ddd; text-shadow:0px 1px 0px white; color:#4d4d4d;">'.number_format($totalXu).'</div>'; break;
				case 12: echo '<div class="table-cell-right" style="background:#ddd; text-shadow:0px 1px 0px white; color:#4d4d4d;">'.number_format($totalXf).'</div>'; break;
				case 13: echo '<div class="table-cell-right" style="background:#ddd; text-shadow:0px 1px 0px white; color:#4d4d4d;">'.number_format($totalHonor).'</div>'; break;
				default: echo '<div class="table-space">&nbsp;</div>';
			}
			
		}
	}
	echo '
	</div>
	</li>';
	$i+=1;
}
		echo '
		</ul>
	</div>
</body>';
?>