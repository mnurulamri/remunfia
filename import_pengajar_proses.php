<?php
// menggunakan class phpExcelReader
include("excel_reader2.php");

// koneksi ke mysql
include("conn.php");
// membaca file excel yang diupload
$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

// membaca jumlah baris dari data excel
$baris = $data->rowcount($sheet_index=0);

// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
$sukses = 0;
$gagal = 0;

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
	// membaca data
	$tahun = $data->val($i,1);
	$bulan = $data->val($i,2);
	$nip = $data->val($i,3);
	$nama_pengajar = $data->val($i,4);
	$induk_fakultas = $data->val($i,5);
	$status_pegawai = $data->val($i,6);
	$jabatan_fungsional = $data->val($i,7);
	$npwp = $data->val($i,8);
	$skema = $data->val($i,9);
	$status_nikah = $data->val($i,10);
	$golongan = $data->val($i,11);

  // setelah data dibaca, sisipkan ke dalam tabel kalban
	  $query = "INSERT INTO pengajar VALUES (
				$tahun,
				'$bulan',
				'$nip',
				'$nama_pengajar',
				'$induk_fakultas',
				'$status_pegawai',
				'$jabatan_fungsional',
				'$npwp',
				$skema,
				'$status_nikah',
				'$golongan')";
				
  $hasil = mysql_query($query);

  // jika proses insert data sukses, maka counter $sukses bertambah
  // jika gagal, maka counter $gagal yang bertambah
  if ($hasil) $sukses++;
  else $gagal++;
}

// tampilan status sukses dan gagal
echo "<h3>Proses import data selesai.</h3>";
echo "<p>Jumlah data yang sukses diimport : ".$sukses."<br>";
echo "Jumlah data yang gagal diimport : ".$gagal."</p>";

?>
