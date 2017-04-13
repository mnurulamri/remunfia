<?php
if(!session_id()) session_start();
$username = $_SESSION["username"];
if ($username == "mailanur" or $username == "joko"){
	if (isset($_POST['prodi'])) {
		$kode = $_POST['prodi'];		
		/*$nip = "197203141998021002";
		$ketuaprogram = "Prof. Dr. Irfan Ridwan Maksum, M.Si";		
		$_SESSION["nip"] = $nip;
		$_SESSION["ketuaprogram"] = $ketuaprogram;*/
		switch ($kode){
			case "05.03.09.01" : 
				$programstudi = "Program Sarjana Reguler Ilmu Administrasi Fiskal";	
				$kodeorganisasi = "kodeorganisasi = '05.03.09.01' and left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI' and kodemk <> 'ISP20036' and kodemk <> 'ISP20043' and kodemk <> 'ISP20044'";
				//$_SESSION["kd_organisasi"] = '05.03.09.01';
				$kode_prodi = '05.03.09.01';
				break;
			case "06.03.09.01" : 
				$programstudi = "Program Sarjana Reguler Ilmu Administrasi Negara";
				$kodeorganisasi = "kodeorganisasi = '06.03.09.01' and left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI' and kodemk <> 'ISP20036' and kodemk <> 'ISP20043' and kodemk <> 'ISP20044'";
				//$_SESSION["kd_organisasi"] = '06.03.09.01';
				$kode_prodi = '06.03.09.01';
				break;
			case "07.03.09.01" : 
				$programstudi = "Program Sarjana Reguler Ilmu Administrasi Niaga";
				$kodeorganisasi = "kodeorganisasi = '07.03.09.01' and left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI' and kodemk <> 'ISP20036' and kodemk <> 'ISP20043' and kodemk <> 'ISP20044'";
				//$_SESSION["kd_organisasi"] = '07.03.09.01';
				$kode_prodi = '07.03.09.01';
				break;
			case "13.03.09.01" : 
				$programstudi = "Program Sarjana Paralel Ilmu Administrasi Fiskal";
				$kodeorganisasi = "kodeorganisasi = '13.03.09.01' and left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI' and kodemk <> 'ISP20036' and kodemk <> 'ISP20043' and kodemk <> 'ISP20044'";
				//$_SESSION["kd_organisasi"] = '13.03.09.01';	
				$kode_prodi = '13.03.09.01';
				break;
			case "14.03.09.01" : 
				$programstudi = "Program Sarjana Paralel Ilmu Administrasi Negara";
				$kodeorganisasi = "kodeorganisasi = '14.03.09.01' and left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI' and kodemk <> 'ISP20036' and kodemk <> 'ISP20043' and kodemk <> 'ISP20044'";
				//$_SESSION["kd_organisasi"] = '14.03.09.01';
				$kode_prodi = '14.03.09.01';
				break;
			case "15.03.09.01" : 
				$programstudi = "Program Sarjana Paralel Ilmu Administrasi Niaga";
				$kodeorganisasi = "kodeorganisasi = '15.03.09.01' and left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI' and kodemk <> 'ISP20036' and kodemk <> 'ISP20043' and kodemk <> 'ISP20044'";
				//$_SESSION["kd_organisasi"] = '15.03.09.01';
				$kode_prodi = '15.03.09.01';
				break;
		}
		
		$sql = "select *
				from data
				where $kodeorganisasi and flagtampil = 1 and tahun = 2012
				order by flaghari, Jam, NamaMataKuliah, NamaKelas";			
		$_SESSION["sql"] = $sql;
		$_SESSION["kodeorganisasi"] = $kodeorganisasi;
		$_SESSION["programstudi"] = $programstudi;
		$_SESSION["kd_organisasi"] = $kode_prodi;
		header("location: a.php");
		#echo $_SESSION["kodeorganisasi"] $_SESSION["nip"] $_SESSION["ketuaprogram"] $_SESSION["programstudi"];		
	} else {
		echo "<script language='JavaScript'>alert('Anda belum memilih Program Studi!'); document.location='login_sukses.php' </script>";
	}
} else {
	header("location: a.php");	
}
?>