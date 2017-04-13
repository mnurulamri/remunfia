<?
include("bulan.php");
include("menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Bimbingan</title>
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/sunny/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/ui.jqgrid.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/pemanis.css" />
		<script src="jqgrid/js/jquery-1.5.2.min.js" type="text/javascript"></script>
		<script src="jqgrid/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
		<script src="jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
		<script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
	
		<script type="text/javascript">
			$(document).ready(function(){
				var grid = $("#list2");
				grid.jqGrid({
					url: 'honor_pengajaran_rekap_json.php', //URL Tujuan Yg Mengenerate data Json nya
					datatype: "json", //Datatype yg di gunakan
					height: "auto", //Mengset Tinggi table jadi Auto menyesuaikan dengan isi table
					mtype: "GET",
					colNames: ['tahun','Bulan','XuSkemaInti','XfSkemaInti','XfSkemaLain','XfLintasFak','pdpt','HonorFak','TotalHonor'],
					colModel: [
					{name:'tahun', index:'tahun', hidden:false,editable:false,editrules:{required:true}},
					{name:'bulan',width:70, index:'bulan',editable:true,editrules:{required:true}},
					{name:'XuSkemaInti',width:70, index:'XuSkemaInti',editable:true,editrules:{required:true}},
					{name:'XfSkemaInti', width:70, index:'XfSkemaInti',align:'right',editable:true,editrules:{required:true}},
					{name:'XfSkemaLain',width:70, index:'XfSkemaLain',editable:true,editrules:{required:true}},
					{name:'XfLintasFak', width:70, index:'XfLintasFak',align:'right',editable:true,editrules:{required:true}},
					{name:'pdpt', width:70, index:'pdpt',align:'right',editable:true,editrules:{required:true}},
					{name:'HonorFak',width:70, index:'HonorFak',editable:true,editrules:{required:true}},
					{name:'TotalHonor', width:70, index:'TotalHonor',align:'right',editable:true,editrules:{required:true}}
					],
					rownumbers:true,
					rowNum: 10,
					rowList: [10,20,30],
					pager: '#pager2',
					sortname: 'program',
					viewrecords: true,
					sortorder: "desc",
					multiselect: false,
					caption: "Record Test",
					subGrid: true,
					caption: "Rekap Honor Pengajaran",
					footerrow : true, 
					userDataOnFooter : true, 
					altRows : true,

					subGridRowExpanded: function(subgrid_id, row_id) {
						
						// we pass two parameters
						// subgrid_id is a id of the div tag created whitin a table data
						// the id of this elemenet is a combination of the "sg_" + id of the row
						// the row_id is the id of the row
						// If we wan to pass additinal parameters to the url we can use
						// a method getRowData(row_id) - which returns associative array in type name-value
						// here we can easy construct the flowing
						
						var subgrid_table_id, pager_id;
						subgrid_table_id = subgrid_id + "_t";
						pager_id = "p_" + subgrid_table_id;
						$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"' class='scroll'></table><div id='"+pager_id+"' class='scroll'></div>");
						var tahun = jQuery("#tahun").val();
						var bulan = jQuery("#bulan").val();
						jQuery("#"+subgrid_table_id).jqGrid({
														
							url:"bimbingan_admin_json2.php?id="+row_id+"&tahun="+tahun+"&bulan="+bulan,
							datatype: "json",
							colNames: ['Nama Pengajar','Jenis Bimbingan','Jml Mhs','Harga Satuan','Honor'],
							colModel: [
								{name:'nama_pengajar', index:'nama_pengajar'},
								{name:'jenis_bimbingan', index:'jenis_bimbingan'},
								{name:'jml_mhs', width:45, index:'jml_mhs', align:'center'},
								{name:'harga_satuan', width:70, index:'harga_satuan', align:'right'},
								{name:'honor', width:70, index:'honor', align:'right'}							
							],
							rownumbers:true,
							rowNum:30,
							pager: pager_id,
							sortname: 'num',
							sortorder: "asc",
							height: '100%'
						});
						jQuery("#"+subgrid_table_id).jqGrid('navGrid',"#"+pager_id,{edit:false,add:false,del:false});
					},
				
					subGridRowColapsed: function(subgrid_id, row_id) {
					
					}
				});
				grid.jqGrid('navGrid','#pager2',{view:true,edit:false,add:false,del:false});				
			});
			
			function gridReload(){	
				var tahun_akad = jQuery("#tahun_akad").val();
				var semester = jQuery("#semester").val();
				jQuery("#list2").jqGrid('setGridParam',{url:"honor_pengajaran_rekap_json.php?tahun_akad="+tahun_akad+"&semester="+semester,page:1}).trigger("reloadGrid");	
			}
		</script>
	</head>
	<body style="background:#336666">
		<br><br>
		<form method="post" action="honor_pengajaran_rekap_json.php" name="form1" id="form1">
			<input type="hidden" name="oper" value="add">
			<table border="0" cellpadding="3" cellspacing="0" id="center" style="margin-left:auto; margin-right:auto;">
				<tr>
					<td id="label">Tahun</td>
					<td>:</td>
					<td>
						<select style="font:bold 11px verdana; color:#555" name="tahun_akad" id="tahun_akad" onchange="gridReload()">								
							<!--<option value='2013'>2013/2014</option>-->
							<option value="<?echo date('Y')-1?>"><?echo date('Y')-1?>/<?echo date('Y')?></option>
							<option value="<?echo date('Y')-2?>"><?echo date('Y')-2?>/<?echo date('Y')-1?></option>
						</select>
					</td>			
					<td id="label">Bulan</td>
					<td>:</td>
					<td>
						<select style="font:bold 11px verdana; color:#555" name="semester" id="semester" onchange="gridReload()">
							<option style="color:magenta" value="1">Gasal</option>
							<option style="color:blue" value="2">Genap</option>
						</select>							
					</td>
				</tr>
			</table>								
		</form>	
		<br>
		<table id="list2" class="scroll" cellpadding="0" cellspacing="0"></table>
		<div id="pager2" class="scroll" style="text-align:center;"></div>
	</body>
</html>