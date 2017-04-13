<?include 'menu.php';?>
<link href="css/table.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.js"></script>
<script>
function gets(){
	//alert(form_filter.tahun.value+' '+form_filter.bulan.value)
	$.post('sstruktural_trans_data.php', {tahun:form_filter.tahun.value, bulan:form_filter.bulan.value}, 
		function(output){
			$('#result').html(output).show();
		}
	);
}
</script>
<style>
.tab {height:1.5em;position:relative;width:20em;background:#ddd;padding-top:.5em;color:#444;font-family:helvetica;padding-left:1em;border-radius:5px 0 0 0;text-shadow:0 1px 0 rgba(255,255,255,.8);}
.tab:after {content:'';height:.6em;top:0;position:absolute;right:-.5em;width:0px;background:#ddd;padding:.7em 3.5em;border-radius:0 5px 0 0;transform:skew(20deg);/*background-image: linear-gradient(to bottom, #fff, #ddd);*/}
.head:hover{color:#fa0;}
table tfoot tr th{font-weight:bold;text-align:center;background-color:gold;background-image: -webkit-gradient(linear, left top, left bottom, from(#eee), to(gold));background-image: -webkit-linear-gradient(top, #eee, gold);background-image:-moz-linear-gradient(top, #eee, gold);background-image:-ms-linear-gradient(top, #eee, gold);background-image:-o-linear-gradient(top, #eee, gold);background-image:linear-gradient(top, #eee, gold);-webkit-box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;-moz-box-shadow:0 1px 0 rgba(255,255,255,.8) inset;box-shadow: 0 1px 0 rgba(255,255,255,.8) inset;border-top: none;text-shadow: 0 1px 0 rgba(255,255,255,.5); 
}
</style>
<body style="background-color:#eee">
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
</div>
</body>