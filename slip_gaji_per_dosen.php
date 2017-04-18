<?
$tahun = $_POST['tahun'];
$bulan = $_POST['bulan_gasal'];

$tahun_bulan = '201704';

switch($bulan)
{
	case "Januari":
		$periode_bulan = "01";
		$hadiraktual = "hadirjanuari";
		break;
	case "Februari":
		$periode_bulan = "02";
		$hadiraktual = "hadirfebruari";
		break;
	case "Maret":
		$periode_bulan = "03";
		$hadiraktual = "hadirmaret";
		break;
	case "April":
		$periode_bulan = "04";
		$hadiraktual = "hadirapril";
		break;
	case "Mei":
		$periode_bulan = "05";
		$hadiraktual = "hadirmei";
		break;
	case "Juni":
		$periode_bulan = "06";
		$hadiraktual = "hadirjuni";
		break;
	case "Juli":
		$periode_bulan = "07";
		$hadiraktual = "hadirjuli";
		break;
	case "Agustus":
		$periode_bulan = "08";
		$hadiraktual = "hadiragustus";
		break;
	case "September":
		$periode_bulan = "09";
		$hadiraktual = "hadirseptember";
		break;
	case "Oktober":
		$periode_bulan = "10";
		$hadiraktual = "hadiroktober";
		break;
	case "November":
		$periode_bulan = "11";
		$hadiraktual = "hadirnovember";
		break;
	case "Desember":
		$periode_bulan = "12";
		$hadiraktual = "hadirdesember";
		break;
}

$vtahun_bulan = $tahun.$periode_bulan;
//$flag = ($vtahun_bulan < $tahun_bulan) ? 'di bawah' : 'di atas' ;

if ($vtahun_bulan < $tahun_bulan) {
	include 'lap_honor_per_dosen2.php';
} else {
	include 'lap_honor_per_dosen2_new.php';
}
?>
