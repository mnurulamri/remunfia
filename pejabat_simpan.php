<?
if(!session_id()) session_start();

include("conn.php");

$kodeorganisasi = $_SESSION["kd_organisasi"];

$nama = htmlspecialchars($_POST["namapengajar"]);

$_SESSION["ketuaprogram"] = $nama;

$_SESSION['nip'] = $_POST["nip"];

$nip = htmlspecialchars($_POST["nip"]);

$query = "UPDATE organisasi SET ketuaprogramstudi = '$nama', nip = '$nip' WHERE kodeorganisasi = '$kodeorganisasi'";

mysql_query($query) or die;

?>