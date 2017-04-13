<?php
include("conn.php");
if(!session_id()) session_start();
$kd_organisasi = $_SESSION["kodeorganisasi"];
$kata = $_POST['q'];
$query = mysql_query("SELECT distinct nama_pengajar, nip FROM pengajar WHERE nama_pengajar like '%$kata%' limit 7");
echo "<div class='suggestionsBox'><div class='suggestionList'>";
while($k = mysql_fetch_array($query)){
	echo '<li onClick="isi(\''.$k[0].'\'); isiNip(\''.$k[1].'\');" style="cursor:pointer">'.$k[0].'</li>';
}

echo "</div></div>"
?>

<style>
	.suggestionsBox {
		position: absolute;
		left: 41px;<!---->
		margin: 40px 0px 0px 0px;
		width: 250px;
		background-color: gray;
		border-radius: 3px 3px 3px 3px;
		-border-radius: 3px 3px 3px 3px;
		-moz-border-radius: 3px 3px 3px 3px;
		-webkit-border-radius: 3px 3px 3px 3px;
		border: 2px solid gray;	
		color: #fff;
		z-index:99;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: orange;
	}
</style>