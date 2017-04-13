<? 
if(!session_id()) session_start();
if (!isset($_SESSION["username"])){
	header( "Location: http://remun.fia.ui.ac.id/ldap_login.php" ) ;
} else {
	header( "Location: http://remun.fia.ui.ac.id/a.php" ) ;
}

/*-------------  testing  --------------

if (!isset($_SESSION["username"])){
	include('ldap_login.php');
} else {
	include('a.php');
	
	
	if(empty($_GET['p'])){
		exit();
	} else {
		/*$url = $_GET['p'];
		echo 'url = '.$url.'<br>';
		$sql = "SELECT id, link FROM menu";
		$result = mysql_query($sql);
		$link = '';
		$data = array();
		while($row = mysql_fetch_assoc($result)){
			$link[$row['id']] = $row['link'];
			echo 'test<br>';
		}
		
		echo 'link = '.$link[$url];
		
		switch($url){
			case $url:
				include $link[$url];				
				break;
		}
		
		foreach($link as $k=>$v){
			echo 'key = '.$k.'value = '.$v.'<br>';
		}
	}
	--------------------------------------	
}*/
?>
