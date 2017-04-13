<?
include("conn.php");
include("menu.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
<style>
	#tahun, #MataKuliah, #Kelas {padding-left:3%; font:bold 11px verdana; color:#555; text-align:left; border:solid #ccc}	
</style>

<link href="style.css" media="screen, projection" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="js/jquery-1.2.3.min.js"></script>
<script type="text/javascript">

function showMataKuliah(str){
	if (str=="")
	  {
	  document.getElementById("MataKuliah").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("MataKuliah").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","show_hadir_honor_mk.php?thsmt="+str,true);
	xmlhttp.send();
	clock.start();
}

function showKelas(str){
	if (str=="")
	  {
	  document.getElementById("Kelas").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("Kelas").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","show_hadir_honor_kelas.php?kodemk="+str,true);
	xmlhttp.send();
	clock.start();
}

function showKodeKelas(str){
	if (str=="")
	  {
	  document.getElementById("Detail").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("Detail").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","show_hadir_honor_submit.php?kodekelas="+str,true);
	xmlhttp.send();
}

$(document).ready(function() {

	$().ajaxStart(function() {
		$('#loading').show();
		$('#result').hide();
	}).ajaxStop(function() {
		$('#loading').hide();
		$('#result').fadeIn('slow');
		clock.start();
	});

	$('#myForm').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				$('#result').html(data);
			}
		})
		return false;
	});
})

	function hideContent(HadirHonor) {
		$("#MataKuliah").fadeOut("slow");
		$("#Kelas").fadeOut("slow");
		$("#Detail").fadeOut("slow");
		$("#Hasil").fadeOut("slow");
		$("#result").fadeOut("slow");
		return false;
	}

</script>
</head>
<body style="background:#eee">
<br>
<?KotakAtas()?>

<div style="font:bold 12px verdana; color:#fff; background-color:#800080">
	<div valign="center" align="center" colspan="3" height="22%">
	<h1 style="color:#ddd;">Data Kehadiran dan Honor Pengajar Per Mata Kuliah<br></h1>
	</div>
</div>

<form id="myForm" method="post" action="show_hadir_honor_proses.php">
<br>
<div id="tahun">
	<span class="tahun">Tahun Akademik&nbsp;&nbsp;</span>
	<span>:</span>
	<span>
		<select style="font:bold 11px verdana; color:#555" name="thsmt" onchange="if(this.value==''){document.getElementById('MataKuliah').style.display = 'none'; document.getElementById('Kelas').style.display = 'none'; document.getElementById('Detail').style.display = 'none'; document.getElementById('Hasil').style.display = 'none';} else {document.getElementById('MataKuliah').style.display = 'block'; showMataKuliah(this.value);}">								
			<option value="">Pilih Tahun Akademik..</option>
			<option value="2015-2">2015/2016 - Genap</option>
			<option value="2015-1">2015/2016 - Gasal</option>
			<option value="2014-2">2014/2015 - Genap</option>
			<option value="2014-1">2014/2015 - Gasal</option>
		</select>
	</span>	
</div>
</select>
<div id="MataKuliah"><b></b></div>
<div id="Kelas"><b></b></div>
<div>&nbsp;</div>
<div id="Detail"><b></b></div>
<div id="Aksi"></div>
</form>

<?KotakBawah()?>
<br>
<div id='Hasil' style="display:none;">
	<?KotakAtasResult()?>
	<div id="loading" style="display:none;"><img src="../remun/images/indicator.gif" alt="loading..." /></div>
	<div id="result" style="display:none;"> tes 123..<input type="text" value="document.getElementById('matakuliah').value;"/></div>
	<?KotakBawahResult()?>
</div>
</body>
</html> 

<?
function KotakAtas(){
	echo "
	<div class='inset'>
		<b class='b1'></b><b class='b2' style='background-color:#800080'></b><b class='b3' style='background-color:#800080'></b><b class='b4' style='background-color:#800080'></b>
		<div class='boxcontent' style='text-align:center;'>
	";
}

function KotakBawah(){
	echo "
		</div>
		<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
	</div>
	";
}

function KotakAtasResult(){
	echo "
	<div class='inset' style='width:100%'>
		<b class='b1'></b><b class='b2' style='background-color:yellow'></b><b class='b3' style='background-color:yellow'></b><b class='b4' style='background-color:yellow'></b>
		<div class='boxcontent' style='text-align:center; background-color:yellow'>
	";
}

function KotakBawahResult(){
	echo "
		</div>
		<b class='b4b' style='background-color:yellow'></b><b class='b3b' style='background-color:yellow'></b><b class='b2b' style='background-color:yellow'></b><b class='b1b' style='background-color:yellow'></b>
	</div>
	";
}
?>