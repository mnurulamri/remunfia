
$(document).ready(function(){
	//Mempercantik Button dengan Jquery UI
	$("#AddButton").button();
	
	var grid = $("#list2");
	grid.jqGrid({
		url: 'tunjangan_struktural_json.php', //URL Tujuan Yg Mengenerate data Json nya
		datatype: "json", //Datatype yg di gunakan
		height: "auto", //Mengset Tinggi table jadi Auto menyesuaikan dengan isi table
		mtype: "GET",
		colNames: ['edit','hapus','id','Nip','Nama Pengajar','Jabatan','Tunjangan','Periode'],
		colModel: [						
			{name:'act', sortable:false, width: 30, align: 'center'},
			{name:'delete', sortable:false, width: 30, align: 'center'},
			{name:'id', key:true, index:'id', hidden:true,editable:false,editrules:{required:true}},
			{name:'nip',index:'nip'},
			{name:'nama_pengajar',index:'nama_pengajar'},
			{name:'jabatan',index:'jabatan',align:'center'},
			{name:'tunjangan',index:'tunjangan',align:'right'},
			{name:'periode',index:'periode',align:'center'}
		],
		rownumbers:true,
		rowNum: 10,
		rowList: [10,20,30,40],
		pager: '#pager2',
		sortname: 'nama_pengajar',
		viewrecords: true,
		sortorder: "desc",
		editurl: "tunjangan_struktural_crud.php",
		multiselect: false,
		caption: "Tunjangan Struktural",
		footerrow : true, 
		userDataOnFooter : true, 
		altRows : true
	});
	grid.jqGrid('navGrid','#pager2',{view:true,edit:false,add:false,del:false,search:true});
	

	
	$("#submit").live("click", function(){
		if($("#nama_pengajar").val()=="") {
			alert('Field Nama tidak boleh kosong!');
			$("#nama_pengajar").focus();
			return false;
		}
		if($("#jabatan").val()=="") {
			alert('Field Jabatan tidak boleh kosong!');
			$("#jabatan").focus();
			return false;
		}
		if($("#tunjangan").val()=="") {
			alert('Field Tunjangan tidak boleh kosong!');
			$("#tunjangan").focus();
			return false;
		}
		/*if($("#periode").val()=="") {
			alert('Field Periode tidak boleh kosong!');
			$("#periode").focus();
			return false;
		}*/
		var jwb = confirm('Anda Yakin ?');
		var kosong = "";
		if (jwb == 1)
		{						
			return $.ajax({
				type: $("#form1").attr("method"),
				url: $("#form1").attr("action"),
				data : $("#form1").serialize(),
				async: false,
				success: function(data) {
					if(data.error) {
						alert(data);
					} else {
						//alert("Update Sukses");
						$('#list2').trigger('reloadGrid'); //Triger Untuk Reload List JQGrid
						$("#tahun").val("");
						$("#bulan").val("");
						$("#nama_pengajar").val("");
						$("#nip").val("");
						$("#jabatan").val("");
						$("#tunjangan").val("");
						$("#periode").val("");
					}
				}								
			}).responseText
		}
		else {
			return false;
		}
	});
	
	$('a.add').live('click',function(){		
		page = $(this).attr("href");
		$('#formInput').html('<img src="jqgrid/loading.gif" style="margin-left: auto; margin-right: auto; display:block;">').load(page);
		return false;
	});

});

//Fungsi Javascript Numeric Only
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	return false;		
	return true;
}			


//////////////////////////...tambahan fungsi searching...//////////////////////////////////////////////////////////////////
var timeoutHnd;
var flAuto = false;

function doSearch(ev){
	if(!flAuto)
		return;
//	var elem = ev.target||ev.srcElement;
	if(timeoutHnd)
		clearTimeout(timeoutHnd)
	timeoutHnd = setTimeout(gridReload,500)
}

function gridReload(){
	var tahun = jQuery("#tahun").val();
	var bulan = jQuery("#bulan").val();
	jQuery("#list2").jqGrid('setGridParam',{url:"tunjangan_struktural_json.php?tahun="+tahun+"&bulan="+bulan,page:1}).trigger("reloadGrid");
	//kosongkan box input
	document.form1.nip.value = "";
	document.form1.nama_pengajar.value = "";
	document.form1.jabatan.value = "";
	document.form1.tunjangan.value = 0;
	document.form1.periode.value = 0;
}

function enableAutosubmit(state){
	flAuto = state;
	jQuery("#submitButton").attr("disabled",state);
}