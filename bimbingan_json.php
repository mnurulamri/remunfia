<?php
	include("conn.php");
	
	if(!session_id()) session_start();
	$kd_program_studi = $_SESSION["kode"];
	
	#include("../JSON.php");
	#$json = new Services_JSON();

	$page  = $_GET['page'];
	$limit = $_GET['rows'];
	$sidx  = $_GET['sidx'];
	$sord  = $_GET['sord'];
	
	if(!$sidx) $sidx=1;
	
	if(isset($_GET["tahun"]))
		$tahun = $_GET['tahun'];
	else
		$tahun = date("Y");
	
	if(isset($_GET["bulan"]))
		$bulan = $_GET['bulan'];
	else
		$bulan = date("m");
	
	
	function ToSql ($field, $oper, $val) {
		// we need here more advanced checking using the type of the field - i.e. integer, string, float
		switch ($field) {
			case 'nik':
				//return intval($val);
				//break;
			case 'nama':
			case 'alamat':
			case 'kota':
				//return floatval($val);
				//break;
			default :
				//mysql_real_escape_string is better
				if($oper=='bw' || $oper=='bn') return "'" . addslashes($val) . "%'";
				else if ($oper=='ew' || $oper=='en') return "'%" . addcslashes($val) . "'";
				else if ($oper=='cn' || $oper=='nc') return "'%" . addslashes($val) . "%'";
				else return "'" . addslashes($val) . "'";
		}
	}
	
	###For Single Searching###
	
	//array to translate the search type
	$ops = array(
            'eq'=>'=', //equal
            'ne'=>'<>',//not equal
            'lt'=>'<', //less than
            'le'=>'<=',//less than or equal
            'gt'=>'>', //greater than
            'ge'=>'>=',//greater than or equal
            'bw'=>'LIKE', //begins with
            'bn'=>'NOT LIKE', //doesn't begin with
            'in'=>'LIKE', //is in
            'ni'=>'NOT LIKE', //is not in
            'ew'=>'LIKE', //ends with
            'en'=>'NOT LIKE', //doesn't end with
            'cn'=>'LIKE', // contains
            'nc'=>'NOT LIKE'  //doesn't contain
	);
	
	function getWhereClause($col, $oper, $val){
            global $ops;
            if($oper == 'bw' || $oper == 'bn') $val .= '%';
            if($oper == 'ew' || $oper == 'en' ) $val = '%'.$val;
            if($oper == 'cn' || $oper == 'nc' || $oper == 'in' || $oper == 'ni') $val = '%'.$val.'%';
            return " WHERE $col {$ops[$oper]} '$val' ";
	}
	
	$where = " WHERE a.nip = c.nip and 
				a.tahun = $tahun and a.bulan = '$bulan' and 
				c.tahun = a.tahun and
				c.bulan = a.bulan and kd_organisasi = '$kd_program_studi'"; //if there is no search request sent by jqgrid, $where should be empty
	$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
	$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
	$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
	if ($_GET['_search'] == 'true') {
		$where = getWhereClause($searchField,$searchOper,$searchString);
	}
        	
	$data = mysql_query("SELECT COUNT(a.nip) as count FROM  bimbingan a, pengajar c".$where);
	$row  = mysql_fetch_array($data);
	$count = $row["count"];
	//die($count);
	
	$count > 0 ? $total_pages = ceil($count/$limit) : $total_pages = 0;
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit;
	if($start <0) $start = 0;
	
	$query = "SELECT a.id, nama_pengajar, jenis_bimbingan, jml_mhs, harga_satuan, honor, trans
			  FROM bimbingan a, master_pengajar c
			  WHERE 
				a.nip = c.nip and 
				a.tahun = $tahun and a.bulan = '$bulan' and 
				kd_organisasi = '$kd_program_studi'
			  ORDER BY $sidx $sord LIMIT $start, $limit";
			  
	$data1 = mysql_query($query);
	
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	$honor = 0;
	$honor2 = 0;
	while($line = mysql_fetch_array($data1)){
		if ($line["trans"] == 0){
			$edit='<a href="bimbingan_edit.php?id='.$line["id"].'" class="add"><span class="ui-icon ui-icon-pencil"></span></a>';
			$delete='<a href="bimbingan_delete.php?id='.$line["id"].'" class="add"><span class="ui-icon ui-icon-trash"></span></a>';
			$honor = $honor + $line["honor"];
			$responce->rows[$i]['id'] = $line["id"];
			$responce->rows[$i]['cell'] = array($edit,$delete,$line["id"],$line["nama_pengajar"],$line["jenis_bimbingan"],$line["jml_mhs"],number_format($line["harga_satuan"]),number_format($line["honor"]));
			$i++;		
		} else {
			$edit='<a href="#'.$line["id"].'" class=""><span class="ui-icon ui-icon-locked"></span></a>';
			$delete='<a href="#'.$line["id"].'" class=""><span class="ui-icon ui-icon-locked"></span></a>';
			$honor = $honor + $line["honor"];
			$responce->rows[$i]['id'] = $line["id"];
			$responce->rows[$i]['cell'] = array($edit,$delete,$line["id"],$line["nama_pengajar"],$line["jenis_bimbingan"],$line["jml_mhs"],number_format($line["harga_satuan"]),number_format($line["honor"]));
			$i++;			
		}

	}
	$responce->userdata['honor'] = number_format($honor);
	echo json_encode($responce);
?>