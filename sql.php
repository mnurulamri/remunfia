<?
//tes
include("menu.php"); 
$verifyToken = md5('unique_salt' . time());
if($_SESSION['hak_akses']!=1 && $_SESSION['token']==$verifyToken){
	header("Location:a.php");
} else {
?>

<html>
<head>
<title>SQL</title>
<script src="js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="https://remun.ppaa.fisip.ui.ac.id/codemirror/lib/codemirror.js" type="text/javascript"></script>
<link href="https://remun.ppaa.fisip.ui.ac.id/codemirror/lib/codemirror.css" media="screen, projection" rel="stylesheet" type="text/css">
<link href="https://remun.ppaa.fisip.ui.ac.id/codemirror/lib/addon/hint/show-hint.css" rel="stylesheet" />
<script src="https://remun.ppaa.fisip.ui.ac.id/codemirror/lib/addon/hint/show-hint.js"></script>
<script src="https://remun.ppaa.fisip.ui.ac.id/codemirror/lib/addon/hint/sql-hint.js"></script>
<script src="https://remun.ppaa.fisip.ui.ac.id/codemirror/sql.js"></script>

<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/sunny/jquery-ui-1.8.16.custom.css" /> <!-- Mengincludekan JQueryUI CSS -->        
<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/ui.jqgrid.css" /><!-- Mengincludekan CSS Jqgrid -->
<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/center.css" />		
<script src="jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script><!-- Mengincludekan Locale untuk JQGrid -->        
<script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script><!-- Mengincludekan Library untuk JQGrid -->
</head>

<script>
window.onload = function() {
  var mime = 'text/x-mysql';
  // get mime type
  if (window.location.href.indexOf('mime=') > -1) {
    mime = window.location.href.substr(window.location.href.indexOf('mime=') + 5);
  }
  window.editor = CodeMirror.fromTextArea(document.getElementById('query'), {
    mode: mime,
    indentWithTabs: true,
    smartIndent: true,
    lineNumbers: true,
    matchBrackets : true,
    autofocus: true,
    extraKeys: {"Ctrl-Space": "autocomplete"},
    hintOptions: {tables: {
      users: {name: null, score: null, birthDate: null},
      countries: {name: null, population: null, size: null}
    }}
  });
  window.editor.setSize("90%", 100);
};

function gets(){
	clock.start();
	queryText = window.editor.getValue();
	$.post('sql-get.php', {query:queryText}, 
		function(output){
			$('#result').html(output).show("slow",0.8);
			tableToGrid("#mytable", {height:'350', caption: "SQL"});
		}
	);
}

</script>
<body  bgcolor="#eee" style="background-color:#eee">
<div style="margin-left:10%">
	<form name="fm" id="fm" method="post" action="sql-excel.php">
		<div style="color:yellow">Query : </div><div>
		<textarea id="query" name="query" cols="100%" rows="5"></textarea></div>
		<div style="margin-left:20%">
			<input type="button" name="get" value="execute" onclick="gets();"/>&nbsp;&nbsp;&nbsp;
			<input type="submit" name="excel" value="excel"/>&nbsp;&nbsp;&nbsp;
			<!--<input type="reset" value="clear" onclick="clear"/>-->
		</div>
	</form>
</div>
<div id="result"></div>
	<div><?echo $_SESSION['token'].'<br>'.$verifyToken?></div>
</body>
</html>
<?}?>