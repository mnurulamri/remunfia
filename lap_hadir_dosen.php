<?
//koneksi ke database
include("conn.php");

#setting session, hadir aktual, tahun dan bulan
if(!session_id()) session_start();

$nip = $_SESSION["nip"];
$tahun = $_POST["tahun"];
$tahun_akad = $tahun;
$semester = $_POST["semester"];
//$_SESSION["semester"] = $semester;
$vtahun = $tahun + 1;
$tahunakademik = $tahun."/".$vtahun;
$hak_akses = $_SESSION["hak_akses"];

if($semester == "Gasal"){
	$bulan = array("HadirSeptember","HadirOktober","HadirNovember","HadirDesember","HadirJanuari");
	$header = array("Hadir September","Hadir Oktober","Hadir November","Hadir Desember","Hadir Januari");
} else {
	$bulan = array("HadirFebruari","HadirMaret","HadirApril","HadirMei","HadirJuni");
	$header = array("Hadir Februari","Hadir Maret","Hadir April","Hadir Mei","Hadir Juni");
}

if($semester == "Gasal"){
	$smt = 1;
	//$tahun = $tahun;
} else {
	$smt = 2;
	$tahun = $tahun + 1;
}

#ambil data di tabel dan masukkan ke array
//$judullaporan = "Rekap Honor Pengajar Semester $semester Tahun Akademik $tahunakademik";
//$_SESSION["judullaporan"] = $judullaporan;

if ($_SESSION["hak_akses"] == 3){	
	
	if ($semester == "Gasal"){

		$query = "SELECT Program, ProgramStudi as `Program Studi`, NamaMataKuliah as `Nama Mata Kuliah`, NamaKelas as `Nama Kelas`,
					sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='09',hadiraktual,0)) as September,
					sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='10',hadiraktual,0)) as Oktober,
					sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='11',hadiraktual,0)) as November,
					sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='12',hadiraktual,0)) as Desember,
					sum(if(tahun_akad=$tahun_akad and tahun=$tahun+1 and bulan='01',hadiraktual,0)) as Januari,
					
					sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='09',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='10',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='11',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='12',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun+1 and bulan='01',hadiraktual,0)) as Total,
					
					KehadiranSeharusnya as `Wajib Hadir`
				FROM kalban
				WHERE nip = $nip and tahun_akad = $tahun_akad and semester = $smt and flagaep=0 and flagtampil=1 and kodepdpt=0
				group by kode
				order by Program,Program,NamaMataKuliah, NamaKelas";
		
	} else { //jika semester genap

		$query = "SELECT Program, ProgramStudi as `Program Studi`, NamaMataKuliah as `Nama Mata Kuliah`, NamaKelas as `Nama Kelas`,
					sum(if(tahun_akad=$tahun_akad and  tahun=$tahun and bulan='02',hadiraktual,0)) as 'Februari',		   
					sum(if(tahun_akad=$tahun_akad and  tahun=$tahun and bulan='03',hadiraktual,0)) as 'Maret',		   
					sum(if(tahun_akad=$tahun_akad and  tahun=$tahun and bulan='04',hadiraktual,0)) as 'April',		   
					sum(if(tahun_akad=$tahun_akad and  tahun=$tahun and bulan='05',hadiraktual,0)) as 'Mei',		   
					sum(if(tahun_akad=$tahun_akad and  tahun=$tahun and bulan='06',hadiraktual,0)) as 'Juni',
					
					sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='02',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='03',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='04',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='05',hadiraktual,0))+sum(if(tahun_akad=$tahun_akad and tahun=$tahun and bulan='06',hadiraktual,0)) as Total,
					
					KehadiranSeharusnya as `Wajib Hadir`
				FROM kalban
				WHERE nip = $nip and tahun_akad = $tahun_akad and semester = $smt and flagaep=0 and flagtampil=1 and kodepdpt=0
				group by kode
				order by Program,Program,NamaMataKuliah, NamaKelas";

	}		
	
	$result = mysql_query ($query) or die ("Pesan Error : ".mysql_error());
	$data = array();
	
	echo '
	<table>
		<thead>
			<tr>';
	for($i = 0; $i < mysql_num_fields($result); $i++){
		$col = mysql_field_name($result, $i);
		echo '<th>'.$col.'</th>';
	}
	echo '
			</tr>
		</thead>
		<tbody>';
		
	while($rows = mysql_fetch_array($result)){
		echo '<tr>';
		for($i = 0; $i < mysql_num_fields($result); $i++){			
			$col = mysql_field_name($result, $i);
				$cell = $rows[$col];
			if ($i==0 || $i==1 || $i==2 || $i==3){
				if ($rows[$col] == "S1"){$cell = "S1 Reguler";}
				echo '<td>'.$cell.'</td>';
			} else {
				echo '<td class="middle">'.$cell.'</td>';
			}
						
		}
		echo '</tr>';
	}
	echo '
		</tbody></table>';	
	//echo "NIP = ".$nip." TAHUN = ".$tahun." - ".$smt." Hak Akses = ".$hak_akses." ".$tahun_akad." ".$smt." ".$semester;
}
?>