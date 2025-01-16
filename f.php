<?php
// ver 1.2 - 01.07.20
// Serhii Halaktionoiv t.me/dmaSIIbiz
// upd - 08.11.21
// Petro Stoliarchuk t.me/mufik

ini_set('max_execution_time', '1700');
set_time_limit(1700);

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json');
http_response_code(200);

//date_default_timezone_set('Europe/Moscow');
//date_default_timezone_set('Europe/Kiev');

//*************************************
function getSetting($wfid){
global $global, $globals_settings, $p_vars;

    return $globals_settings;

}
//*************************************

function date2html($str){ /*Вывод даты по-русски*/
    static $month_rus=array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
    $str=strtotime($str);
    return date("j",$str).' '.$month_rus[intval(date("m",$str)-1)].' '.date("Y",$str);
}

function date2rus($str){ /*Вывод даты по-русски*/
$date_rus=[];
    static $month_rus=array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
    static $month_rus2=array('январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь');
    static $dn_rus=array("воскресенье","понедельник","вторник","среду","четверг","пятницу","субботу");
    static $dn_rus2=array("воскресенье","понедельник","вторник","среда","четверг","пятница","суббота");
    $str = strtotime($str);
    $date_rus['d_dt']=date("G:i:s  d.m.Y", $str);
    $date_rus['d_tz']=date("G:i:s T d.m.Y", $str);
    $date_rus['d_full']=$dn_rus[intval(date("w",$str))].', '.date("j",$str).' '.$month_rus[intval(date("m",$str)-1)].' '.date("Y",$str);
    $date_rus['d_dnm']=$dn_rus[intval(date("w",$str))].', '.date("j",$str).' '.$month_rus[intval(date("m",$str)-1)];
    $date_rus['d_dm']=date("j",$str).' '.$month_rus[intval(date("m",$str)-1)];
    $date_rus['d_dmy_dot']=date("d.m.Y",$str);
    $date_rus['d_dmy_tire']=date("d-m-Y",$str);
    $date_rus['d_ymd_dot']=date("Y.m.d",$str);
    $date_rus['d_ymd_tire']=date("Y-m-d",$str);
    $date_rus['d_y']=date("Y",$str);
    $date_rus['d_m']=date("m",$str);
    $date_rus['d_mn1']=$month_rus[intval(date("m",$str)-1)];
    $date_rus['d_mn2']=$month_rus2[intval(date("m",$str)-1)];
    $date_rus['d_d']=date("j",$str);
    $date_rus['d_dn1']=$dn_rus[intval(date("w",$str))];
    $date_rus['d_dn2']=$dn_rus2[intval(date("w",$str))];
    $date_rus['d_unix']=$str;
    $date_rus['d_calendar']=date("Ymd", $str);
    $date_rus["d_google_calendat"]=date("Y-m-d H:i:s", $str);
    $date_rus["iso_date"]=date("c", $str);
    if ($_REQUEST["format"] != NULL) {
        $date_rus["format"] = date($_REQUEST["format"], $str);
    }

    return $date_rus;
}

function date2lang($str, $lang){ /*Вывод даты по-русски*/
    $date_rus=[];
    if (file_exists($lang.".json") === true) {
        $langFile = json_decode(file_get_contents($lang.".json"), true);
        $month=$langFile["month"];
        $month2=$langFile["month2"];
        $dn=$langFile["dn"];
        $dn2=$langFile["dn2"];
        $str = strtotime($str);
        $date_rus['d_dt']=date("G:i:s  d.m.Y", $str);
        $date_rus['d_tz']=date("G:i:s T d.m.Y", $str);
        $date_rus['d_full']=$dn[intval(date("w",$str))].', '.date("j",$str).' '.$month[intval(date("m",$str)-1)].' '.date("Y",$str);
        $date_rus['d_dnm']=$dn[intval(date("w",$str))].', '.date("j",$str).' '.$month[intval(date("m",$str)-1)];
        $date_rus['d_dm']=date("j",$str).' '.$month[intval(date("m",$str)-1)];
        $date_rus['d_dmy_dot']=date("d.m.Y",$str);
        $date_rus['d_dmy_tire']=date("d-m-Y",$str);
        $date_rus['d_ymd_dot']=date("Y.m.d",$str);
        $date_rus['d_ymd_tire']=date("Y-m-d",$str);
        $date_rus['d_y']=date("Y",$str);
        $date_rus['d_m']=date("m",$str);
        $date_rus['d_mn1']=$month[intval(date("m",$str)-1)];
        $date_rus['d_mn2']=$month2[intval(date("m",$str)-1)];
        $date_rus['d_d']=date("j",$str);
        $date_rus['d_dn1']=$dn[intval(date("w",$str))];
        $date_rus['d_dn2']=$dn2[intval(date("w",$str))];
        $date_rus['d_unix']=$str;
        $date_rus['d_calendar']=date("Ymd", $str);
        $date_rus["d_google_calendat"]=date("Y-m-d H:i:s", $str);
        $date_rus["iso_date"]=date("c", $str);
        if ($_REQUEST["format"] != NULL) {
	    $date_rus["format"] = date($_REQUEST["format"], $str);
        }
    } else {
        $date_rus['error'] = "lang not found";
    }

    return $date_rus;
}


//*************************************
//*************************************

$reqv=$_REQUEST;

if (count($reqv)>0) {

if (array_key_exists('timezone', $reqv)){
    date_default_timezone_set($reqv['timezone']);
} else {
    date_default_timezone_set('Europe/Kiev');
}

if (array_key_exists('dater', $reqv)){
    $res=[];
    if (array_key_exists('lang', $reqv)) {
        $res = date2lang($reqv['dater'], $reqv['lang']);
    } else {
        $res = date2rus($reqv['dater']);
    }
    $res=json_encode($res);
  exit ($res);
}


if (array_key_exists('web_time', $reqv)){
 $res=[];
  $dw=strtotime(date("d.m.Y") . ' ' .  $reqv['web_time']);
  $dc=strtotime(date("d.m.Y G:i"));

    if ($dc<=$dw) {
    $test_date = date2rus(date("d.m.Y") . ' ' .  $reqv['web_time']);
	$res['web_day']="сегодня, " . $test_date['d_dm'] . " в " . $reqv['web_time'];
    } else {
	$dn=strtotime("+1 day");
	$test_date = date2rus($dn);
	$res['web_day']="завтра, " . date("j",$dn) . " " . $test_date['d_mn1']  . " в " . $reqv['web_time'];
    }
    $res['test'] = $test_date;
  $res=json_encode($res);
  exit ($res);
}


if (array_key_exists('diff_d', $reqv)){
  $res=[];
    $dates = str_replace('[','',$reqv['diff_d']);
    $dates = str_replace(']','',$dates);
    $diff = explode(";", $dates);

    $diff[0]=date2rus($diff[0])['d_dmy_dot'];
    $diff[1]=date2rus($diff[1])['d_dmy_dot'];
    $res['diff']=date_diff(new DateTime($diff[0]), new DateTime($diff[1]))->days;
    if (strtotime($diff[0]) < strtotime($diff[1])) {
	$res["diff"] = 0 - $res["diff"];
    }
  $res=json_encode($res);
  exit ($res);
}


if (array_key_exists('rnd', $reqv)){
 $res=[];
    $rnd = round($reqv['rnd'],2);
    $res['round']=$rnd;
    $res=json_encode($res);
 exit ($res);

}

}

?>
