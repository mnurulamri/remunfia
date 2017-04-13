<?php
if(!session_id()) session_start();
session_destroy();
header("location: ldap_login.php");
exit;
?>