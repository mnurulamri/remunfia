<?php
	include("../../remun/remun/conn.php");

	$page  = $_GET['page'];
	$limit = $_GET['rows'];
	$sidx  = $_GET['sidx'];
	$sord  = $_GET['sord'];
	
	if(!$sidx) $sidx=1;
	
	if(isset($_GET["tahun_akad"])){$tahun_akad = $_GET['tahun_akad'];} else	{$tahun_akad = date("Y");}
	
	if(isset($_GET["semester"]))
		{$semester = $_GET['semester'];}
	else
		{semester();} //coba dicari lagi bulan yang berjalan masuk ke semester gasal atau genap!...
	
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
	$where = " tahun_akad=$tahun_akad AND semester=$semester"; //if there is no search request sent by jqgrid, $where should be empty
	$searchField = isset($_GET['searchField']) ? $_GET['searchField'] : false;
	$searchOper = isset($_GET['searchOper']) ? $_GET['searchOper']: false;
	$searchString = isset($_GET['searchString']) ? $_GET['searchString'] : false;
	if ($_GET['_search'] == 'true') {
		$where = getWhereClause($searchField,$searchOper,$searchString);
	}
        
	$data = mysql_query("SELECT COUNT(*) as count FROM kalban".$where);
	$row  = mysql_fetch_array($data);
	$count = $row["count"];
	//die($count);
	
	$count > 0 ? $total_pages = ceil($count/$limit) : $total_pages = 0;
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit;
	if($start <0) $start = 0;
	
	$data1 = mysql_query("SELECT distinct tahun, bulan, sum(HonorXuSkemaInti) as XuSkemaInti, sum(HonorXfSkemaInti) as XfSkemaInti, sum(HonorXfSkemaLain) as XfSkemaLain, sum(HonorXfLintasFak) as XfLintasFak, sum(HonorPDPT) as pdpt, sum(TotalHonorFak) as HonorFak, sum(TotalHonor) as TotalHonor
						FROM kalban 
						WHERE tahun_akad=$tahun_akad AND semester=$semester
						GROUP BY tahun, bulan");
			  //ORDER BY $sidx $sord LIMIT $start, $limit");
	
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	$honor = 0;
	while($line = mysql_fetch_array($data1)){
		//$honor = $honor + $line["honor"];
		//$responce->rows[$i]['id']   = $line["id"];
		$responce->rows[$i]['cell'] = array($line["tahun"],$line["bulan"],number_format($line["XuSkemaInti"]),number_format($line["XfSkemaInti"]),number_format($line["XfSkemaLain"]),number_format($line["XfLintasFak"]),number_format($line["pdpt"]),number_format($line["HonorFak"]),number_format($line["TotalHonor"]));
		$i++;
	}
	//$responce->userdata['honor'] = number_format($honor);
	echo json_encode($responce);
	
	function semester(){
		$bulan = date("m");
		if ($bulan=="08" or $bulan=="09" or $bulan=="10" or $bulan=="11" or $bulan=="12" or $bulan=="01") {$semester=1;} else {$semester=2;}
		return $semester;
	}
?>