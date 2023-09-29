<?php

$dformat = "-";
$date_partsworkperiod1 = explode($dformat, $tanggal_asli);
$birth_num_year = $date_partsworkperiod1[0];
$birth_num_month = $date_partsworkperiod1[1];
$birth_num_day = $date_partsworkperiod1[2];
$cur_num_year = date('Y');
$cur_num_month = date('n');
$cur_num_day = date('j');
$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
$cur_num_month_days = date('t',$lastmonth);
$diffyear = $cur_num_year - $birth_num_year;
$diffmonth = $cur_num_month - $birth_num_month;
$diffday = $cur_num_day - $birth_num_day;

//menghitung tahun
	if($diffyear==0){
		$yy=0;
	}elseif($diffyear>0 && $diffmonth>0 && $diffday<0){
		$yy=$diffyear;
	}elseif($diffyear>0 && $diffmonth==0 && $diffday<0){
		$yy=$diffyear-1;	
	}elseif($diffyear>0 && $diffmonth<0 && $diffday>=0){
		$yy=$diffyear-1;
	}elseif($diffyear>0 && $diffmonth<0 && $diffday<0){
		$yy=$diffyear-1;
	}elseif($diffyear>0 && $diffmonth>=0 && $diffday>=0){
		$yy=$diffyear;
	}
    
//menghitung bulan
	if($diffmonth==0 && $diffday>=0){
		$mm=0;
	}elseif($diffmonth>0 && $diffday>0){
		$mm=$diffmonth;
	}elseif($diffmonth<0 && $diffday>0){
		$mm=12+$diffmonth;
	}elseif($diffmonth<0 && $diffday<0){
		$mm=11+$diffmonth;
	}elseif($diffmonth==0 && $diffday<0){
		$mm=11;
	}elseif($diffmonth>0 && $diffday<0){
		$mm=$diffmonth-1;
	}elseif($diffmonth>0 && $diffday==0){
		$mm=$diffmonth;
	}elseif($diffmonth<0 && $diffday==0){
		$mm=12+$diffmonth;
	}
	elseif($diffmonth==0 && $diffday==0){
		$mm=$cur_num_month;
	}
	
//menghitung hari
	if($diffday==0){
		$dd=0;
	}elseif($diffday>0){
		$dd=$diffday;
	}elseif($diffday<0){
		$dd=(($cur_num_month_days-$birth_num_day)+$cur_num_day);
	}

$tgl_diff_ctk = $yy.'-'.$mm;

?>