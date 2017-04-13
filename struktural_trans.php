<?include 'menu.php';?>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-id.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/struktural.css" /><!---->
<link href="../DataTables/media/css/jquery.dataTables.test.css" rel="stylesheet"/>
<script language="javascript" type="text/javascript" src="../DataTables/media/js/jquery.dataTables.js"></script>
<script src="js/jquery.formatCurrency.js" type="text/javascript"></script>
<link href="../icon/css/font-awesome.min.css" rel="stylesheet">
<script>

function formatNumber(numberString) {
    var commaIndex = numberString.indexOf(',');
    var int = numberString;
    var frac = '';

    if (~commaIndex) {
        int = numberString.slice(0, commaIndex);
        frac = ',' + numberString.slice(commaIndex + 1);
    }

    var firstSpanLength = int.length % 3;
    var firstSpan = int.slice(0, firstSpanLength);
    var result = [];

    if (firstSpan) {
        result.push(firstSpan);
    }

    int = int.slice(firstSpanLength);

    var restSpans = int.match(/\d{3}/g);

    if (restSpans) {
        result = result.concat(restSpans);
        return result.join(',') + frac;
    }

    return firstSpan + frac;
}

$(document).ready(function() {

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
				var kd_organisasi = '<?echo $_SESSION['kd_organisasi']?>';
				nip = $("#nip").val();
				jabatan = $("#jabatan").val();
				tunjangan = $("#tunjangan").val();
				no_sk = $("#no_sk").val();
				tgl_akhir = $("#tgl_akhir").val();
				tahun = $('#tahun').val();
				bulan = $('#bulan').val();
				var form_data=$("#form1").serializeArray();
				var error_free=true;
				
				//Form will be submitted	
				$.post('struktural_trans_crud.php', {tahun:tahun, bulan:bulan, id:id, kd_organisasi:kd_organisasi, nip:nip, tunjangan:tunjangan.replace(/,/g,''), oper:oper}, 
					//alert(tahun+' '+bulan+' '+id+' '+kd_organisasi+' '+nip+' '+tunjangan+' '+oper),
					function(){
						$.ajax({
							type: 'POST',
							url: 'struktural_trans_data.php',
							data: 'tahun='+tahun+'&bulan='+bulan,
							success: function(output) {
								$('#result').html(output).show();
							}
						});
					}
				);				
				$(this).dialog("close");
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
	
	$("table tbody tr td input tunjangan").keyup(function(){
		$("tunjangan").formatCurrency();
	});	
	
	$("input tunjangan").change(function(){
		$("tunjangan").formatCurrency();
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

function del(id){
	$('#oper').val(3);
	nip = $('#nip_'+id).html();
	nama_pengajar = $('#nama_pengajar_'+id).html();
	jabatan = $('#jabatan_'+id).html();
	tunjangan = $('#tunjangan_'+id).val();
	no_sk = $('#no_sk_'+id).html();
	tgl_akhir = $('#tgl_akhir_'+id).html();
	$('#id').val(id);
	$('#nip').val(nip);
	$('#nama_pengajar').val(nama_pengajar);
	$('#jabatan').val(jabatan);
	$('#tunjangan').val(tunjangan);
	$('#no_sk').val(no_sk);
	$('#tgl_akhir').val(tgl_akhir);
	$('#dialog').dialog('open');
	$('#dialog').dialog('option','title','Delete');
}

function gets(){
	//alert(form_filter.tahun.value+' '+form_filter.bulan.value)
	$.post('struktural_trans_data.php', {tahun:form_filter.tahun.value, bulan:form_filter.bulan.value}, 
		function(output){
			$('#result').html(output).show();
		}
	);
}

function init(n){
	document.getElementById('temp').value = n;
	document.getElementById('flag').value = 0;
}
function edit(id, honor){
	var txt;
	var r = confirm('edit data?');
	if(r==true){;
		$.post('struktural_trans_crud.php', {tahun:form_filter.tahun.value, bulan:form_filter.bulan.value, id:id, honor:honor, oper:2},
			function(output){
				$('#test').html(output).show();
			}
		);
	} else {
		var id = 'tunjangan_'+id;
		var temp_tunjangan = document.getElementById('temp').value;
		document.getElementById(id).value = temp_tunjangan;
	}
}

function view_data_master(){
	var tahun = form_filter.tahun.value, bulan = form_filter.bulan.value;
	//siapin data
	$.ajax({
		type: 'POST',
		url: 'struktural_trans_data_master.php',
		data: 'tahun='+tahun+'&bulan='+bulan,
		success: function(output) {
			//isi tag div dengan data master struktural
			$('#view_data_master').html(output);
			//tampilkan ke dialog
			$('#view_data_master').dialog('option','title','Master Data Struktural');
			$('#view_data_master').dialog({
				autoOpen:true,
				width:'85%'
			});			
		}
	});		

}

function tambah(id, tahun, bulan, nip, tunjangan){  // tambah data pengajuan honor tiap bulan
	var tahun = form_filter.tahun.value, bulan = form_filter.bulan.value;
	//alert(id+' '+tahun+' '+bulan+' '+nip);
	$('#view_data_master').dialog("close");
	$.ajax({
		type: 'POST',
		url: 'struktural_trans_crud.php',
		data: 'tahun='+tahun+'&bulan='+bulan+'&nip='+nip+'&id='+id+'&tunjangan='+tunjangan+'&oper='+1,
		success: function(output) {
			gets();
		}
	});	
}

function format_uang(honor, id){
	var duit = honor.replace(/,/g, '');
	var id = 'tunjangan_'+id;
	document.getElementById(id).value = formatNumber(duit);
}
</script>
<body style="background-color:#eee">
<div id="view_data_master" style="font: normal 11px Arial, Helvetica, sans-serif, verdana;"></div>

<!------------------------------------------------------------ DIALOG FORM ---------------------------------------------------------------------->
<div id="dialog" style="font: normal 13px/150% Arial, Helvetica, sans-serif, verdana;">
	<div>
		<fieldset id="center" style="border:none; padding:5px;">
			<form method="post" action="tunjangan_struktural_crud.php" name="form1" id="form1">
				<div>
					<input type="hidden" name="oper" id="oper"/>
					<input type="hidden" name="id" id="id" class="ui-corner-all"/>
				</div>
				<div class="">
					<table>
						<tr>
							<td class="col"><label>NIP/NUP</label></td>
							<td><input type="text" name="nip" id="nip" class="" readonly/></td>
						</tr>			
						<tr class="row">
							<td class="col"><label>Nama Pengajar</label></td>
							<td><input type="text" name="nama_pengajar" id="nama_pengajar" size="40" class="" onkeyup="lihat(this.value)"/></td>
						</tr>
						<tr>
							<td class="col"><label>Jabatan</label></td>
							<td><input type="text" name="jabatan" id="jabatan" size="40" class=""/></td>
						</tr>
						<tr>
							<td class="col"><label>Tunjangan</label></td>
							<td><input type="text" name="tunjangan" id="tunjangan" value="0" onkeypress="return isNumberKey(event)" size="20" maxlength="10" onblur="return formatCurrency(this.value,0,',','','','','','')" class="" style="text-align: right;"/></td>
						</tr>
						<tr>
							<td class="col"><label>Nomor SK/Surat Tugas</label></td>
							<td><input type="text" name="no_sk" id="no_sk" size="40" class=""/></td>
						</tr>		
						<tr class="row">
							<td class="col"><label>Berlaku</label></td>
							<td><input type="text" name="tgl_akhir" id="tgl_akhir" size="20" class="" onclick="tgl_awal()"/></td>
						</tr>
					</table>
				</div>
			</form>
		</fieldset>
	</div>	
</div>
<!------------------------------------------------------------ END OF DIALOG FORM ---------------------------------------------------------------------->

<div style="padding:10px; background-color:#eee">

<div class="tab">
	<form name="form_filter" id="form_filter">Periode 
		<select name="tahun" id="tahun" onchange="gets()">
			<?
			if(date('n') == 12){
				?>
				<option value="<?echo date('Y')+1?>"><?echo date('Y')+1?></option>
				<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
				<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
				<?			
			} else {
				?>
				<option value="<?echo date('Y')+1?>"><?echo date('Y')+1?></option>
				<option value="<?echo date('Y')?>"><?echo date('Y')?></option>
				<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?></option>
				<?
			}
			?>
		</select>
		<select name="bulan" id="bulan" onchange="gets()">
			<?
			$bulan_arr = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
			foreach($bulan_arr as $k => $v){
				echo '
				<option value="'.$k.'">'.$v.'</option>
				';
			}
			?>

		</select>
	</form>
</div>
	
	<div id="tabel" style="background:#ddd; padding:5px; border-radius: 0 6px 6px 6px; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, .5);">
		<div id="result"></div>
		
	</div>
	<div id="test"></div>
</div>

<style>
.tab {
	position:relative;
	width:20em;
	background:#ddd;
	padding-top:.5em;
	color:#444;
	font-family:helvetica;
	padding-left:1em;
	border-radius:5px 0 0 0;
	/*background-image: linear-gradient(to bottom, #fff, #ddd);*/
	text-shadow:0 1px 0 rgba(255,255,255,.8);
}

.tab:after {
	content:'';
	height:.5em;
	top:0;
	position:absolute;
	right:-.5em;
	width:0px;
	background:#ddd;
	padding:.7em 3.5em;
	border-radius:0 5px 0 0;
	transform:skew(20deg);
	/*background-image: linear-gradient(to bottom, #fff, #ddd);*/
}

.col {
	text-align:right;
	padding-right:2px;
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

.table{
	display:table;
}

.row {
	display:tabel-row;
}

input {
	color:#666362;
	padding-left:2px;
}
label {
	color:#666362;
	text-align:right;

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

.view_data_master table tr td {
	padding:1px;
}

.ui-dialog .ui-dialog-titlebar {
	padding:2px;
}

.ui-dialog-title {
	color:white !important;
}

.ui-dialog .ui-dialog-buttonpane button {
  background-color: #7fbf4d;
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7fbf4d), color-stop(100%, #63a62f));
  background-image: -webkit-linear-gradient(top, #7fbf4d, #63a62f);
  background-image: -moz-linear-gradient(top, #7fbf4d, #63a62f);
  background-image: -ms-linear-gradient(top, #7fbf4d, #63a62f);
  background-image: -o-linear-gradient(top, #7fbf4d, #63a62f);
  background-image: linear-gradient(top, #7fbf4d, #63a62f);
  border: 1px solid #63a62f;
  border-bottom: 1px solid #5b992b;
  border-radius: 3px;
  -webkit-box-shadow: inset 0 1px 0 0 #96ca6d;
  box-shadow: inset 0 1px 0 0 #96ca6d;
  color: #fff;
  font: bold 12px/1 "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif;
  padding: 2px 0 5px 0;
  text-align: center;
  text-shadow: 0 -1px 0 #4c9021;
  width: 80px; 
}

.ui-dialog .ui-dialog-buttonpane {
	padding:1px;
}

.ui-dialog .ui-dialog-buttonpane button:hover {
    background-color: #76b347;
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #76b347), color-stop(100%, #5e9e2e));
    background-image: -webkit-linear-gradient(top, #76b347, #5e9e2e);
    background-image: -moz-linear-gradient(top, #76b347, #5e9e2e);
    background-image: -ms-linear-gradient(top, #76b347, #5e9e2e);
    background-image: -o-linear-gradient(top, #76b347, #5e9e2e);
    background-image: linear-gradient(top, #76b347, #5e9e2e);
    -webkit-box-shadow: inset 0 1px 0 0 #8dbf67;
    box-shadow: inset 0 1px 0 0 #8dbf67;
    cursor: pointer; 
}
a.tooltip {outline:none; } a.tooltip strong {line-height:2px;} a.tooltip:hover {text-decoration:none;} a.tooltip span { z-index:10;display:none; padding:5px 5px; margin-top:0px; margin-left:20px; /*width:300px;*/ line-height:16px; } a.tooltip:hover span{ display:inline; position:absolute; color:#444; border:1px solid #DCA; background:#fffAF0;font-family:arial;font-size:12px;}  /*CSS3 extras*/ a.tooltip span { border-radius:4px; box-shadow: 5px 5px 8px #CCC; }
</style>
</body>