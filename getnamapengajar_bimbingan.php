<?php
if(!session_id()) session_start();
$kd_organisasi = $_SESSION["kd_organisasi"];
$kodeorganisasi = $_SESSION["kodeorganisasi"];
$namapengajar = $_GET["namapengajar"];
$username = $_SESSION["username"];

$con = mysql_connect('localhost', 'remun', 'usbw');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("remun", $con);

if ($username == "admin" or $username == "remunerasifisipui"){
$sql="SELECT distinct nip, namapengajar FROM pengajar WHERE namapengajar like '%$namapengajar%' and tahun=2014";
} else {
#$sql="SELECT distinct nip, namapengajar FROM data WHERE namapengajar like '%$namapengajar%' and kodeorganisasi = '$kd_organisasi'";
$sql="SELECT distinct nip, namapengajar FROM pengajar WHERE namapengajar like '%$namapengajar%' and tahun=2014";
}

$result = mysql_query($sql);

echo "<table>
<tr><td height='10px'></td></tr>
<tr valign='center' bgcolor='orange' height='25px' style='border:1px solid orange;'>
<th style='font:bold 12px verdana; vertical-align:middle;'>Nama Pengajar</th>
</tr>";

while($row = mysql_fetch_array($result)) {
  $nip = $row["nip"];
  $namapengajar = $row["namapengajar"];
  echo "<tr bgcolor='#FFFFCC'>"; 
  echo "<td style='padding-left:10px; vertical-align:middle; font:bold 11px verdana; border:1px solid orange;' width='250px' height='20px' onmouseout=\"this.style.backgroundColor='#FFFFCC'\" onmouseover=\"this.style.backgroundColor='#FFCCFF'\"><a style='text-decoration:none; margin-left:2px;' href='inputdatabimbingan.php?nip=$nip&vnamapengajar=$namapengajar' onclick='windows.close()'>" . $namapengajar . "</td>";
  echo "</tr>";
}
echo "</table>";

mysql_close($con);
?> 