<?
//$query = mysql_real_escape_string($_POST['query']);
$query = $_POST['query'];

if(isset($_POST['query'])){
	include("conn.php");
	//$query = $_POST["query"];
	$sql = $query;
	$result = mysql_query($sql) or die(mysql_error());
	echo '
	<div>
		<table id="mytable">
			<thead>
				<tr>';
					for($i = 0; $i < mysql_num_fields($result); $i++){
						$col = mysql_field_name($result, $i);
						echo '<th>'.$col.'</th>';
					}
	echo '
				<tr>
			<thead>
			<tbody>';
	
				while($rows = mysql_fetch_array($result)){
	echo '
				<tr>';
					for($i = 0; $i < mysql_num_fields($result); $i++){			
						$col = mysql_field_name($result, $i);
						echo '<td>'.$rows[$col].'</td>';			
					}
	echo '
				</tr>';
				}
	echo '
			</tbody>
		</table>
	</div>
	';
}

/************************** file lama *****************************
if(isset($_POST['query'])){
	include("conn.php");
	//$query = $_POST["query"];
	$sql = $query;
	$result = mysql_query($sql) or die(mysql_error());
	echo '<div style=""><table style="margin:auto; border-collapse:collapse;background:white;"><tr style="border:solid 1px gray; background:lightgray">';
	for($i = 0; $i < mysql_num_fields($result); $i++){
		$col = mysql_field_name($result, $i);
		echo '<th style="border:solid 1px gray; padding:3px;">'.$col.'</th>';
	}
	while($rows = mysql_fetch_array($result)){
		echo '<tr onMouseOver="this.style.backgroundColor=\'lightgray\'" onMouseOut="this.style.backgroundColor=\'#FFFFFF\'">';
		for($i = 0; $i < mysql_num_fields($result); $i++){			
			$col = mysql_field_name($result, $i);
			echo '<td style="border:solid 1px gray; padding:2px;" onMouseOver="this.style.backgroundColor=\'yellow\'" onMouseOut="this.style.backgroundColor=\'#FFFFFF\'">'.$rows[$col].'</td>';			
		}
		echo '</tr>';
	}
	echo '</table></div>';
} 
*******************************************************************/

?>