<?

function getToken(){
	if(!isset($_SESSION['user_token'])){
		$token = md5(crypt(base64_encode(uniqid())));
		$_SESSION['user_token'] = $token;
	}
}

function checkToken(){
	include('config.php');
	$username = $_SESSION['username'];
	
	$sql = "SELECT token FROM user WHERE username = '$username'";
	$result = mysql_query($sql);
	while($row = mysql_fetch_object($result)){
		$token = $row->token;
	}
	
	mysql_close($res);
	
	if($token != $_SESSION['user_token'] or empty($_SESSION['username']) or empty($token) or $token <> $_SESSION['user_token']){
		header('location:404.php');
		exit;
	}
}

function getTokenField(){
	return '<input type="hidden" name="token" value="'.$_SESSION['user_token'].'"/>';
}

function destroyToken(){
	unset($_SESSION['token']);
}

function checkTokenUrl(){
	if($_GET['tokenUrl']){
		$tokenUrl = $_GET['tokenUrl'];
		if(base64_decode($tokenUrl)){
			
		}
	}
}
?>