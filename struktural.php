<?include 'menu.php';?>

<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-id.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/struktural.css" /><!-- -->
<link href="../DataTables/media/css/jquery.dataTables.test.css" rel="stylesheet"/>
<script language="javascript" type="text/javascript" src="../DataTables/media/js/jquery.dataTables.js"></script>
<script src="js/jquery.formatCurrency.js" type="text/javascript"></script>
<link href="../icon/css/font-awesome.min.css" rel="stylesheet">
<script>
/* ----------------------------------- fungsi autocomplete ---------------------------------------------------- */
var drz;

function lihat(kata){
	if(kata.length==0){
		document.getElementById("kotaksugest").style.visibility = "hidden";
	}else{
		drz = buatajax();
		var url="get_nama.php";
		drz.onreadystatechange = stateChanged;
		var params = "q="+kata;
		drz.open("POST",url,true);
		//beberapa http header harus kita set kalau menggunakan POST
		drz.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		drz.setRequestHeader("Content-length", params.length);
		drz.setRequestHeader("Connection", "close");23
		drz.send(params);
	}
}

function buatajax(){
	if (window.XMLHttpRequest){
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject){
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function stateChanged(){
	var data;
	if (drz.readyState==4 && drz.status==200){
		data = drz.responseText;
		if(data.length>0){
			document.getElementById("kotaksugest").innerHTML = data;
			document.getElementById("kotaksugest").style.visibility = "";
		}else{
			document.getElementById("kotaksugest").innerHTML = "";
			document.getElementById("kotaksugest").style.visibility = "hidden";
		}
	}
}

function isi(kata){
	document.getElementById("nama_pengajar").value = kata;
	document.getElementById("kotaksugest").style.visibility = "hidden";
	document.getElementById("kotaksugest").innerHTML = "";
}

function isiNip(kata){
		document.getElementById("nip").value = kata;
}
/*---------------------------------------------------------------------------------------------------------------*/

$(document).ready(function() {
	$.ajax({
		url: 'struktural_data.php',
		success: function(data) {
			$('#tabel').html(data);
		}
	});

	$( "#tgl_awal,#tgl_akhir" ).datepicker({
	  dateFormat:'dd MM yy',
	  changeMonth: true,
	  changeYear: true 
	});
	
	$('#dialog').dialog({	
		autoOpen: false,
		width: 450,
		buttons: {
			"Ok": function() { 
				id = $('#id').val();
				oper = $("#oper").val();
				var kd_organisasi = '06.01.09.01';
				nip = $("#nip").val();
				jabatan = $("#jabatan").val();
				tunjangan = $("#tunjangan").val();
				no_sk = $("#no_sk").val();
				tgl_awal = $("#tgl_awal").val();
				tgl_akhir = $("#tgl_akhir").val();
							
				var form_data=$("#form1").serializeArray();
				var error_free=true;
				//input validation
				var form_data=$("#form1").serializeArray();
				var error_free=true;
				if($('#nip').val()==''){$('span',$('#nip').parent()).removeClass("error").addClass("error_show"); error_free=false;} else {$('span',$('#nip').parent()).removeClass("error_show").addClass("error");}
				if($('#nama_pengajar').val()==''){$('span',$('#nama_pengajar').parent()).removeClass("error").addClass("error_show"); error_free=false;} else {$('span',$('#nama_pengajar').parent()).removeClass("error_show").addClass("error");}
				if($('#jabatan').val()==''){$('span',$('#jabatan').parent()).removeClass("error").addClass("error_show"); error_free=false;} else {$('span',$('#jabatan').parent()).removeClass("error_show").addClass("error");}
				if($('#tunjangan').val()==''){$('span',$('#tunjangan').parent()).removeClass("error").addClass("error_show"); error_free=false;} else {$('span',$('#tunjangan').parent()).removeClass("error_show").addClass("error");}
				if($('#no_sk').val()==''){$('span',$('#no_sk').parent()).removeClass("error").addClass("error_show"); error_free=false;} else {$('span',$('#no_sk').parent()).removeClass("error_show").addClass("error");}
				if($('#tgl_awal').val()==''){$('span',$('#tgl_awal').parent()).removeClass("error").addClass("error_show"); error_free=false;} else {$('span',$('#tgl_awal').parent()).removeClass("error_show").addClass("error");}
				if($('#tgl_akhir').val()==''){$('span',$('#tgl_akhir').parent()).removeClass("error").addClass("error_show"); error_free=false;} else {$('span',$('#tgl_akhir').parent()).removeClass("error_show").addClass("error");}
				
				/*---------------- bisa diringkas pake ini tapi masih gagal :-( -----------------------------------------------------------------------
				var i = 0;
				for (var input in form_data){
					if(i<=2){
						var valid = true;
					} else {
						var element=$("#"+form_data[input]['name']);
						var valid=element.hasClass("valid");
						var error_element=$("span", element.parent());
						if (!valid){error_element.removeClass("error").addClass("error_show"); error_free=false;}else{error_element.removeClass("error_show").addClass("error");}						
					}
					i=i+1;
				}---------------------------------------------------------------------------------------*/
				if (!error_free){
					event.preventDefault(); 
				}
				else{
					//Form will be submitted	
					$.post('struktural_crud.php', {id:id, kd_organisasi:kd_organisasi, nip:nip, jabatan:jabatan, tunjangan:tunjangan.replace(/,/g,''), no_sk:no_sk, tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, oper:oper}, 
						function(){
							$.ajax({
								url: 'struktural_data.php',
								success: function(data) {
									$('#tabel').html(data);
								}
							});
							//alert('data sudah disimpan');
						}
					);				
				$(this).dialog("close"); 
				}
			}, 
			"Cancel": function() { 
				$(this).dialog("close"); 
			} 
		}
	});	
	
	$('#dialog_link').click(function(){
		$('#id').val('');
		$('#oper').val(1);
		$("#nip").val('');
		$("#nama_pengajar").val('');
		$("#jabatan").val('');
		$("#tunjangan").val('');
		$("#no_sk").val('');
		$("#no_sk").val('');
		$("#tgl_awal").val('');
		$("#tgl_akhir").val('');
		$('#dialog').dialog('open');	
		return false;
	});	
	
	$("#tunjangan").keyup(function(){
		$("#tunjangan").formatCurrency();
	});	
	
	$("#tunjangan").change(function(){
		$("#tunjangan").formatCurrency();
	});	
	
	//validasi
	$('#nama_pengajar').on('input', function() {
		var input=$(this);
		var is_nama_pengajar=input.val();
		if(is_nama_pengajar){input.removeClass("invalid").addClass("valid");}
		else{input.removeClass("valid").addClass("invalid");}
	});
	
	$('#jabatan').on('input', function() {
		var input=$(this);
		var is_jabatan=input.val();
		if(is_jabatan){input.removeClass("invalid").addClass("valid");}
		else{input.removeClass("valid").addClass("invalid");}
	});

	$('#tunjangan').on('input', function() {
		var input=$(this);
		var is_tunjangan=input.val();
		if(is_tunjangan){input.removeClass("invalid").addClass("valid");}
		else{input.removeClass("valid").addClass("invalid");}
	});	

	$('#no_sk').on('input', function() {
		var input=$(this);
		var is_no_sk=input.val();
		if(is_no_sk){input.removeClass("invalid").addClass("valid");}
		else{input.removeClass("valid").addClass("invalid");}
	});	
	
	$('#tgl_awal').on('change', function() {
		var input=$(this);
		var is_tgl_awal=input.val();
		if(is_tgl_awal){input.removeClass("invalid").addClass("valid");}
		else{input.removeClass("valid").addClass("invalid");}
	});	
	
	$('#tgl_akhir').on('change', function() {
		var input=$(this);
		var is_tgl_akhir=input.val();
		if(is_tgl_akhir){input.removeClass("invalid").addClass("valid");}
		else{input.removeClass("valid").addClass("invalid");}
	});	
});

function dialog_add(){
	$('#id').val('');
	$('#oper').val(1);
	$("#nip").val('');
	$("#nama_pengajar").val('');
	$("#jabatan").val('');
	$("#tunjangan").val('');
	$("#no_sk").val('');
	$("#no_sk").val('');
	$("#tgl_awal").val('');
	$("#tgl_akhir").val('');
	$('#dialog').dialog('open');
	$('#dialog').dialog('option','title','Add');
}

function add(){
	id = $("#id").val();
	oper = $("#oper").val();
	kd_organisasi = '<?echo $_SESSION["kd_organisasi"]?>';
	nip = $("#nip").val();
	jabatan = $("#jabatan").val();
	tunjangan = $("#tunjangan").val();
	no_sk = $("#no_sk").val();
	tgl_awal = $("#tgl_awal").val();
	tgl_akhir = $("#tgl_akhir").val();
	//alert(oper+' '+kd_organisasi+' '+nip+' '+jabatan+' '+tunjangan.replace(/,/g,'')+' '+no_sk+' '+tgl_awal);
	$.post('struktural_crud.php', {id:id, kd_organisasi:kd_organisasi, nip:nip, jabatan:jabatan, tunjangan:tunjangan, no_sk:no_sk, tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, oper:oper}, 
		function(output){
			$('#kotaksugest').html(output).show();
		}
	);/**/
}

function edit(id){
	$('#oper').val(2);
	nip = $('#nip_'+id).html();
	nama_pengajar = $('#nama_pengajar_'+id).html();
	jabatan = $('#jabatan_'+id).html();
	tunjangan = $('#tunjangan_'+id).html();
	no_sk = $('#no_sk_'+id).html();
	tgl_awal = $('#tgl_awal_'+id).html();
	tgl_akhir = $('#tgl_akhir_'+id).html();
	$('#id').val(id);
	$('#nip').val(nip);
	$('#nama_pengajar').val(nama_pengajar);
	$('#jabatan').val(jabatan);
	$('#tunjangan').val(tunjangan);
	$('#no_sk').val(no_sk);
	$('#tgl_awal').val(tgl_awal);
	$('#tgl_akhir').val(tgl_akhir);
	$('#dialog').dialog('open');
	$('#dialog').dialog('option','title','Edit');
}

function del(id){
	$('#oper').val(3);
	nip = $('#nip_'+id).html();
	nama_pengajar = $('#nama_pengajar_'+id).html();
	jabatan = $('#jabatan_'+id).html();
	tunjangan = $('#tunjangan_'+id).html();
	no_sk = $('#no_sk_'+id).html();
	tgl_awal = $('#tgl_awal_'+id).html();
	tgl_akhir = $('#tgl_akhir_'+id).html();
	$('#id').val(id);
	$('#nip').val(nip);
	$('#nama_pengajar').val(nama_pengajar);
	$('#jabatan').val(jabatan);
	$('#tunjangan').val(tunjangan);
	$('#no_sk').val(no_sk);
	$('#tgl_awal').val(tgl_awal);
	$('#tgl_akhir').val(tgl_akhir);
	$('#dialog').dialog('open');
	$('#dialog').dialog('option','title','Delete');
}
</script>
<body style="background-color:#eee">
<div id="dialog" style="font: normal 13px/150% Arial, Helvetica, sans-serif, verdana;">
	<div>
		<fieldset id="center" style="border:none; padding:25px;">
			<form method="post" action="tunjangan_struktural_crud.php" name="form1" id="form1">
				<div>
					<input type="hidden" name="oper" id="oper"/>
					<input type="hidden" name="id" id="id" class="ui-corner-all"/>
				</div>
				<div class="table">
					<div class="row">
						<div class="col">
							<label>NIP/NUP</label><br>
							<input type="text" name="nip" id="nip" class="" readonly/>
							<span class="error">*</span>
						</div>			
						<div class="col">
							<label>Nama Pengajar</label><br>
							<input type="text" name="nama_pengajar" id="nama_pengajar" size="40" class="" onkeyup="lihat(this.value)"/>
							<span class="error">*</span>
							<div id="kotaksugest" style="margin-left:-40px"></div>
							
						</div>
						<div class="col">
							<label>Jabatan</label><br>
							<input type="text" name="jabatan" id="jabatan" size="40" class=""/>
							<span class="error">*</span>
						</div>
						<div class="col">
							<label>Tunjangan</label><br>
							<input type="text" name="tunjangan" id="tunjangan" value="0" onkeypress="return isNumberKey(event)" size="20" maxlength="10" onblur="return formatCurrency(this.value,0,',','','','','','')" class="" style="text-align: right;"/>
							<span class="error">*</span>
						</div>
						<div class="col">
							<label>Nomor SK/Surat Tugas</label><br>
							<input type="text" name="no_sk" id="no_sk" size="40" class=""/>
							<span class="error">*</span>
						</div>		
						<div class="col">
							<label>Periode</label><br>
							<input type="text" name="tgl_awal" id="tgl_awal" size="20" class="" onclick="tgl_awal()"/>
							<span class="error">*</span>
							<input type="text" name="tgl_akhir" id="tgl_akhir" size="20" class="" onclick="tgl_awal()"/>
							<span class="error">*</span>
						</div>			
					</div>
					<div class="row">
						<!--<input type="button" name="tambah" id="tambah" size="20" value="simpan" class="cupid-green" onclick="add()"/>-->
					</div>
				</div>
			</form>
		</fieldset>
	</div>
	
</div>
<div>&nbsp;
	<!--<a href="#" id="dialog_link" class="ui-state-default"  style="border:none">
		<font class="ui-icon ui-icon-circle-plus" style="border:none"></font>
		<font class="fa fa-plus"></font>
	</a>-->
</div>
<div style="padding:10px; background-color:#eee">
	<div id="tabel" style="background-color:whitesmoke; padding:5px; border-radius: 6px 6px 6px 6px; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, .5);background-image: linear-gradient(to bottom, #EFEEEC, #ddd);"></div>
</div>

<style>
.col {
	padding:5px; font-weight:bold;
}

.error{
	display: none;
	/*margin-left: 10px;*/
}		

.error_show{
	color: red;
	/*margin-left: 10px;*/
}

input.invalid, textarea.invalid{
	border: 2px solid red;
}

input.valid, textarea.valid{
	/*border: 2px solid green;*/
}


input {
	color:#666362;
}
label {
	color:#666362;
}
.edit:hover, .del:hover {
	cursor:pointer;
}
 .footer {
	line-height:5px;
	background: rgb(252,234,187); /* Old browsers */
	background: -moz-linear-gradient(top, rgba(252,234,187,1) 0%, rgba(251,223,147,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(252,234,187,1)), color-stop(100%,rgba(251,223,147,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top, rgba(252,234,187,1) 0%,rgba(251,223,147,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top, rgba(252,234,187,1) 0%,rgba(251,223,147,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top, rgba(252,234,187,1) 0%,rgba(251,223,147,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom, rgba(252,234,187,1) 0%,rgba(251,223,147,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fceabb', endColorstr='#fbdf93',GradientType=0 ); /* IE6-9 */ 
}

a.tooltip {outline:none; } a.tooltip strong {line-height:2px;} a.tooltip:hover {text-decoration:none;} a.tooltip span { z-index:10;display:none; padding:5px 5px; margin-top:0px; margin-left:20px; /*width:300px;*/ line-height:16px; } a.tooltip:hover span{ display:inline; position:absolute; color:#444; border:1px solid #DCA; background:#fffAF0;font-family:arial;font-size:12px;}  /*CSS3 extras*/ a.tooltip span { border-radius:4px; box-shadow: 5px 5px 8px #CCC; }
</style>
</body>