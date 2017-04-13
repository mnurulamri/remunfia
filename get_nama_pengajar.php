<?php
include("conn.php");
if(!session_id()) session_start();
$username = $_SESSION["username"];
$kd_organisasi = $_SESSION["kodeorganisasi"];
$kata = $_POST['q'];

/*
if ($username == "admin" or $username == "remunerasifisipui"){
	$query = mysql_query("SELECT distinct nama_pengajar, nip FROM pengajar WHERE tahun = 2013 and nama_pengajar like '%$kata%' limit 15");
} else {
	$query = mysql_query("SELECT distinct namapengajar, nip FROM kalban WHERE tahun = 2013 and namapengajar like '%$kata%' and $kd_organisasi limit 15");
}
*/

$query = mysql_query("SELECT nama_pengajar, nip FROM master_pengajar WHERE nama_pengajar like '%$kata%' limit 15");

echo "<div class='suggestionsBox'><div class='suggestionList'>";
while($k = mysql_fetch_array($query)){
	echo '<li onClick="isi(\''.$k[0].'\'); isiNip(\''.$k[1].'\');" style="cursor:pointer">'.$k[0].'</li>';
}

echo "</div></div>"
?>

<style>
	.suggestionsBox {
		position: absolute;
		left: 40%;
		margin: 10px 0px 0px 0px;
		width: 300px;
		background-color: gray;
		border-radius: 7px;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid gray;	
		color: #fff;
		z-index:99;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		text-align:left;
		margin: 0px 0px 3px 5px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: orange;
	}
</style>