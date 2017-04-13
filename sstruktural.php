<?include 'menu.php';?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-id.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/struktural.css" /><!---->
<link href="../DataTables/media/css/jquery.dataTables.test.css" rel="stylesheet"/>
<script language="javascript" type="text/javascript" src="../DataTables/media/js/jquery.dataTables.js"></script>
<script src="js/jquery.formatCurrency.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$.ajax({
	url: 'sstruktural_data.php',
	success: function(data) {
		$('#tabel').html(data);
	  }
	});
});
</script>

<body style="background-color:#eee">
<div>&nbsp;</div>
<div style="padding:10px; background-color:#eee">
	<div id="tabel" style="background-color:whitesmoke; padding:5px; border-radius: 6px 6px 6px 6px; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, .5);background-image: linear-gradient(to bottom, #EFEEEC, #ddd);"></div>
</div>

</body>