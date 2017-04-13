<?
include ('crypt.php');
$plain_text = "Ternyata Blog";
$encoded = encode($plain_text);
echo "Encoded Text : ".$encoded;
$decoded = decode($encoded);
echo "Decoded Text : ".$decoded;
?>